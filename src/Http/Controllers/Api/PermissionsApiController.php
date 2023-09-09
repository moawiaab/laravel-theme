<?php

namespace App\Http\Controllers\Api;

use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use PDF;

class PermissionsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return PermissionResource::collection(Permission::advancedFilter()
            ->filter(FacadesRequest::only('trashed'))
            ->paginate(request('rowsPerPage', 20)));
    }

    public function store(StorePermissionRequest $request)
    {
        $data = [
            ['details' => " عرض " .   $request->details, 'title' => $request->title . "_access"],
            ['details' => " إنشاء " .  $request->details, 'title' => $request->title . "_create"],
            ['details' => " تعديل " .  $request->details, 'title' => $request->title . "_edit"],
            ['details' => " حذف " .    $request->details, 'title' => $request->title . "_delete"]
        ];


        $permission = Permission::insert($data);
        return response(null, Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [],
        ]);
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return new PermissionResource($permission);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return (new PermissionResource($permission))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new PermissionResource($permission),
            'meta' => [],
        ]);
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        $permission->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function destroyAll(Request $request)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        Permission::whereIn('id', $request->items)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(Request $request)
    {
        // Permission::insert($request[0]);
        foreach ($request[0] as $value) {
            $perm = new Permission();
            $perm->title = $value['title'];
            $perm->details = $value['details'];
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteRestore(Permission $item)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->forceDelete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restore(Permission $item)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
