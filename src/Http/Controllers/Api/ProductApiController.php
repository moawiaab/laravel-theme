<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\ProductRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\PermissionResource;
use Moawiaab\LaravelTheme\Http\Resources\ProductsResource;
use Moawiaab\LaravelTheme\Models\Category;
use Moawiaab\LaravelTheme\Models\Product;
use Moawiaab\LaravelTheme\Models\Unit;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('product_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return ProductsResource::collection(
            Product::advancedFilter()->where('account_id', request('account',auth()->user()->account_id))->filter(FacadesRequest::only('trashed'))
                ->paginate(
                    request('rowsPerPage', 20)
                )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('product_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'categories' => Category::get(['id', 'name']),
                'units' => Unit::get(['id', 'name', 'num'])
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'status'  => request('status', 0),
            'category_id'  => request('category_id', 1)
        ];
        $product = auth()->user()->account->products()->create($request->validated() + $data);
        if($request->hasFile('image')){
            $product->addMediaFromRequest('image')->toMediaCollection('product_photos');
        }
        return  response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        abort_unless(Gate::allows('product_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'data' => new PermissionResource($product),
            'meta' => [
                'categories' => Category::get(['id', 'name']),
                'units' => Unit::get(['id', 'name', 'num'])
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        if($request->hasFile('image')){
            $product->addMediaFromRequest('image')->toMediaCollection('product_photos');
        }

        return  response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        abort_unless(Gate::allows('product_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if (auth()->user()->account_id != $product->account_id)
            throw new Exception('ليس لك الحق في حذف هذا المنتج');
        elseif ($product->status == 1)
            throw new Exception('هذا المنتج عام لا يمكنك حذفه');

        else {
            if ($product->deleted_at) {
                $product->forceDelete();
            } else {
                $product->delete();
            }
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(Request $request)
    {
        abort_unless(Gate::allows('product_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Product::whereIn('id', $request->items)->where('status', 0)->onlyTrashed()->forceDelete();
        Product::whereIn('id', $request->items)->delete('status', 0);


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(Request $request)
    {
        abort_unless(Gate::allows('product_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        foreach ($request[0] as $value) {
            $perm = new Product();
            $perm->name = $value['name'];
            $perm->details = $value['details'];
            $perm->status = 0;
            $perm->account_id = auth()->user()->account_id;
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function restore(Product $item)
    {
        abort_unless(Gate::allows('product_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        $model         = new Product();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        if (!$media) {
            $this->validate($request, [
                'productPhoto' => 'required',
            ]);
        }
        return response()->json($media, Response::HTTP_CREATED);
    }

}
