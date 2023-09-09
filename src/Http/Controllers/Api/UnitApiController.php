<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\Admin\AbilityResource;
use App\Http\Resources\Admin\PermissionResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductsResource;
use App\Models\Category;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UnitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Unit::all();
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return AbilityResource::collection(
            Unit::advancedFilter()->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 20))
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return  response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return [
            'data' => new CategoryResource($category),
            'meta' => [
                'products' => ProductsResource::collection($category->products),
            ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new AbilityResource($unit),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        return  response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if (auth()->user()->account_id != $category->account_id)
            throw new Exception('ليس لك الحق في حذف هذا القسم');
        elseif ($category->status == 1)
            throw new Exception('هذا القسم عام لا يمكنك حذفه');
        else {
            if ($category->deleted_at) {
                $category->forceDelete();
            } else {
                $category->delete();
            }
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(Request $request)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Category::whereIn('id', $request->items)->where('status', 0)->onlyTrashed()->forceDelete();
        Category::whereIn('id', $request->items)->delete('status', 0);


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(Request $request)
    {
        // Category::insert($request[0]);
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        foreach ($request[0] as $value) {
            $perm = new Category();
            $perm->name = $value['name'];
            $perm->details = $value['details'];
            $perm->status = 0;
            $perm->account_id = auth()->user()->account_id;
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function restore(Category $item)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
