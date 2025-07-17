<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Requests\StoreRoleRequest;
use Moawiaab\LaravelTheme\Http\Requests\UpdateRoleRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\RoleResource;
use Moawiaab\LaravelTheme\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class RolesApiController extends Controller
{
    public function index()
    {
        abort_unless(Gate::allows('role_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return  RoleResource::collection(
            ModelsRole::paginate(request('rowsPerPage', 10))
        );
    }

    public function store(StoreRoleRequest $request)
    {
        $role =  ModelsRole::create($request->validated());
        $role->permissions()->sync($request->permissions);
        $role->permissions()->syncWithoutDetaching(1);

        return (new RoleResource($role))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_unless(Gate::allows('role_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [
                'permissions' => Permission::where('id', '>', 1)->get(['id as value', 'description as label']),
            ],
        ]);
    }

    public function show(Role $role)
    {
        abort_unless(Gate::allows('role_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

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

    public function update(UpdateRoleRequest $request, ModelsRole $role)
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

    public function edit(ModelsRole $role)
    {
        abort_unless(Gate::allows('role_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new RoleResource($role),
            'meta' => [
                'permissions' => Permission::get(['id as value', 'description as label']),
                'roles' => $role->permissions->transform(fn ($role) => $role->id),
            ],
        ]);
    }

    public function destroy(ModelsRole $role)
    {
        abort_unless(Gate::allows('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if ($role->deleted_at) {
            $role->forceDelete();
        } else {
            $role->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(Request $request)
    {
        abort_unless(Gate::allows('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        ModelsRole::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        ModelsRole::whereIn('id', $request->items)->delete();


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
    public function restore(ModelsRole $item)
    {
        abort_unless(Gate::allows('role_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
