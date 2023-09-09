<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordsRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use Moawiaab\LaravelTheme\Http\Resources\Admin\UserResource;
use Moawiaab\LaravelTheme\Models\PrivateLocker;

class UsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return UserResource::collection(
            User::advancedFilter()
                ->when(auth()->user()->account_id != 1, function ($i) {
                    $i->where('account_id', request('account',auth()->user()->account_id));
                })
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 20))
        );
    }

    public function store(StoreUserRequest $request)
    {
        $user = auth()->user()->account->users()->create($request->validated());
        // $user->roles()->sync($request->input('roles.*.id', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [
                'roles' =>
                auth()
                    ->user()
                    ->account
                    ->roles()->get(['id', 'title']),
            ],
        ]);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new UserResource($user->load(['role', 'account'])),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new UserResource($user),
            'meta' => [
                'roles' => auth()
                    ->user()
                    ->account
                    ->roles()->get(['id', 'title']),
            ],
        ]);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if($user->id == 1 && $user->id == auth()->id()){
            throw ValidationException::withMessages([
                'password' => ["لم تتم تغيير كلمة السر بنجاح حاولة مرة اخرى"],
            ]);
        }else{
            if ($user->deleted_at) {
                $user->forceDelete();
            } else {
                $user->delete();
            }
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $user->status = !$user->status;
        if (auth()->id() == $user->id)
            throw new Exception('لا يمكنك قفل حسابك');
        elseif (auth()->user()->role->id > 2)
            throw new Exception('هذا الحاسب مدير لفرع لا يمكنك قفله');
        else
            $user->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function password(PasswordsRequest $request)
    {

        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ["كلمة المرور غير متطابقة حاولة مرة اخرى من فضلك"],
            ]);
        }
        $user->password = Hash::make($request->password);
        if ($user->save()) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            throw ValidationException::withMessages([
                'password' => ["لم تتم تغيير كلمة السر بنجاح حاولة مرة اخرى"],
            ]);
        }
    }



    public function destroyAll(Request $request)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        User::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        User::whereIn('id', $request->items)->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(Request $request)
    {
        // User::insert($request[0]);
        foreach ($request[0] as $value) {
            $perm = new User();
            $perm->title = $value['title'];
            $perm->details = $value['details'];
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function restore(User $item)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function storeMedia(Request $request)
    {
        $model         = new User();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        if (!$media) {
            $this->validate($request, [
                'userPhoto' => 'required',
            ]);
        }
        return response()->json($media, Response::HTTP_CREATED);
    }

    public function locker(Request $request, User $user)
    {
        abort_if(Gate::denies('private_locker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $safe = new PrivateLocker();
        $safe->amount = $request->amount ?? 0;
        $safe->on_open = $request->amount ?? 0;
        $safe->problem = 0;
        $safe->status  = 1;
        $safe->admin_id = auth()->id();
        $safe->user_id = $user->id;
        $safe->account_id = auth()->user()->account_id;
        $safe->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
