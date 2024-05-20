<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\StoreRoleRequest;
use Moawiaab\LaravelTheme\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\RoleResource;
use Moawiaab\LaravelTheme\Models\Permission;
use Moawiaab\LaravelTheme\Models\Role;

class RolesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return  RoleResource::collection(
            Role::with(['permissions', 'users'])->advancedFilter()
                ->where('account_id', request('account',auth()->user()->account_id))
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 10))
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $role =  auth()
            ->user()
            ->account
            ->roles()->create($request->validated());
        $role->permissions()->sync($request->permissions);
        $role->permissions()->syncWithoutDetaching(1);

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [
                'permissions' => Permission::where('id', '>', 1)->when(auth()->user()->account_id != 1, function ($q) {
                    $q->where('status', 1);
                })->get(['id as value', 'details as label']),
            ],
        ]);
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return [
            'data' => new RoleResource($role),
            'meta' => [
                'permissions' => $role->permissions->transform(fn ($pram) => [
                    'id' => $pram->id,
                    'name' => $pram->details,
                ]),
                'users' => $role->users->transform(fn ($pram) => [
                    'id' => $pram->id,
                    'name' => $pram->name,
                ])
            ]
        ];
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        if (is_numeric($request->permissions[0]) != null) {
            $role->permissions()->sync($request->permissions);
            $role->permissions()->syncWithoutDetaching(1);
        }

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new RoleResource($role),
            'meta' => [
                'permissions' => Permission::where('id', '>', 1)->when(auth()->user()->account_id != 1, function ($q) {
                    $q->where('status', 1);
                })->get(['id as value', 'details as label']),
                'roles' => $role->permissions->transform(fn ($role) => $role->id),
            ],
        ]);
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if ($role->deleted_at) {
            $role->forceDelete();
        } else {
            $role->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(Request $request)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Role::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        Role::whereIn('id', $request->items)->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(Request $request)
    {
        // Role::insert($request[0]);
        foreach ($request[0] as $value) {
            $perm = new Role();
            $perm->title = $value['title'];
            $perm->details = $value['details'];
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function restore(Role $item)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
