<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrivateLockerRequest;
use App\Http\Requests\UpdatePrivateLockerRequest;
use App\Http\Resources\Admin\AmountResources;
use App\Http\Resources\Admin\Lists\OpenDaysResources;
use App\Http\Resources\Admin\OpenDaysResources as AdminOpenDaysResources;
use App\Http\Resources\Admin\PrivateLockerResource;
use App\Models\OpenDay;
use App\Models\PrivateLocker;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class PrivateLockerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('private_locker_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return  PrivateLockerResource::collection(PrivateLocker::where('account_id', request('account',auth()->user()->account_id))->advancedFilter()->paginate(request('limit', 10)));
    }

    public function store(StorePrivateLockerRequest $request)
    {
        abort_if(Gate::denies('private_locker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $safe = new PrivateLocker();
        $safe->amount = $request->amount ?? 0;
        $safe->on_open = $request->amount ?? 0;
        $safe->problem = 0;
        $safe->status  = 1;
        $safe->admin_id = auth()->id();
        $safe->user_id = $request->user_id;
        $safe->account_id = auth()->user()->account_id;
        $safe->save();
        return (new PrivateLockerResource($safe))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        // abort_if(Gate::denies('private_locker_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [
                'users' => User::whereNotIn('id', PrivateLocker::pluck('user_id')->toArray())->get(['id', 'name']),
            ],
        ]);
    }

    public function show(PrivateLocker $privateLocker)
    {
        // abort_if(Gate::denies('safe_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $items =  new AmountResources(OpenDay::with(['user', 'admin'])->advancedFilter()->locker($privateLocker->id));
        return [
            'data' => new PrivateLockerResource($privateLocker->load(['user'])),
            // 'total' => $privateLocker->openDays->count(),
            'meta' => ['items' =>  $privateLocker->items->take(20)]

        ];
    }

    public function update(UpdatePrivateLockerRequest $request, PrivateLocker $privateLocker)
    {
        $privateLocker->update($request->validated());

        return (new PrivateLockerResource($privateLocker))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(PrivateLocker $privateLocker)
    {
        abort_if(Gate::denies('private_locker_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new PrivateLockerResource($privateLocker),
            'meta' => [],
        ]);
    }

    public function destroy(PrivateLocker $privateLocker)
    {
        // throw new Exception('PrivateLocker is not available');
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($privateLocker->amount != 0) {
            throw new Exception('لم يمكنك حذف هذه الخزنة لأن بها مبلغ من المال');
        }
        if ($privateLocker->delete()) {
            return response(null, Response::HTTP_NO_CONTENT);
        }

        throw new Exception("لم يتم الحذف بنجاح حاول مرة اخرة لاحقا");
    }

    public function toggle(PrivateLocker $privateLocker)
    {
        // dd($privateLocker);
        $privateLocker->status = !$privateLocker->status;
        if ($privateLocker->save()) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response([
                'message' => " فشلة العملية"
            ], 422);
        }
    }

    public function amount(UpdatePrivateLockerRequest $request, PrivateLocker $privateLocker)
    {
        $day = new OpenDay();
        $day->locker_id  = $privateLocker->id;
        $day->amount   = $request->amount;
        $day->details   = $request->details;
        $day->user_id  = auth()->id();
        $day->account_id    = auth()->user()->account_id;
        $day->on_open  = $privateLocker->amount;
        $day->problem  = $privateLocker->amount -  $request->amount;
        $day->status   = 1;
        if ($day->save()) {
            $privateLocker->amount  -= $request->amount;
            $privateLocker->on_open  = $privateLocker->amount;
            $privateLocker->problem  = $day->problem;
            if ($privateLocker->save()) {
                return response(null, Response::HTTP_NO_CONTENT);
            } else {
                $day->delete();
            }
        }
        return response([
            'message' => "لم يتم خصم المبلغ بنحاج حاولة مرة اخرى"
        ], 422);
    }
}
