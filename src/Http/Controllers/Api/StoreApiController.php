<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\StoresRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\ProductStoreResource;
use Moawiaab\LaravelTheme\Http\Resources\StoreItemResource;
use Moawiaab\LaravelTheme\Http\Resources\StoresResource;
use Moawiaab\LaravelTheme\Models\OrderItem;
use Moawiaab\LaravelTheme\Models\Product;
use Moawiaab\LaravelTheme\Models\ProductStore;
use Moawiaab\LaravelTheme\Models\Store;
use Moawiaab\LaravelTheme\Models\SupplierOrderItem;

class StoreApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return StoresResource::collection(
            Store::advancedFilter()
                ->where('account_id', request('account', auth()->user()->account_id))
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 20))
        );
    }

    public function emport()
    {
        // return response(['data' => 'data']);
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return StoreItemResource::collection(
            SupplierOrderItem::advancedFilter()
                ->where('account_id', request('account', auth()->user()->account_id))
                ->filter(FacadesRequest::only(['trashed', 'type']))
                ->paginate(request('rowsPerPage', 20))
        );
    }
    public function export()
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return StoreItemResource::collection(
            OrderItem::advancedFilter()
                ->where('account_id', request('account', auth()->user()->account_id))
                ->filter(FacadesRequest::only(['trashed', 'type']))
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
        abort_if(Gate::denies('store_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'products' =>  Product::when(
                    auth()->user()->account_id != 1,
                    function ($q) {
                        $q->where('status', 1)->orWhere('account_id', request('account', auth()->user()->account_id));
                    }
                )->get(['id', 'name'])
            ],
        ]);
    }

    // public function getItem()
    // {
    //     return response([
    //         'meta' => [
    //             'drivers' => auth()->user()->account->type == 1 ?  Dirver::get() ?? [] : [],
    //             'stores' => Store::where('account_id', request('account',auth()->user()->account_id))->get(['id', 'name']) ?? []
    //         ],
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoresRequest $request)
    {
        $store = auth()->user()->account->stores()->create($request->validated());
        $store->save();
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
        return response([
            'data' => ProductStoreResource::collection(
                ProductStore::where('store_id', $id)->get()
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        return response([
            'data' => $store
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoresRequest $request, Store $store)
    {
        $store->update($request->validated());
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        abort_if(Gate::denies('store_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if ($store->deleted_at) {
            $store->forceDelete();
        } else {
            $store->delete();
        }
    }

    public function destroyAll(Request $request)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Store::whereIn('id', $request->items)->where('status', 1)->onlyTrashed()->forceDelete();
        Store::whereIn('id', $request->items)->delete('status', 1);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    // public function addAll(DriverRequest $request)
    // {
    //     Dirver::create($request->validated());
    //     return response([
    //         'drivers' => Dirver::get() ?? [],
    //     ]);
    // }

    // public function storeWeigth(WeightRequest $request)
    // {
    //     if ($request->status == 0) {
    //         // get Supplier Order Item
    //         $item = SupplierOrderItem::find($request->item);
    //         $my_type = 1;
    //     } else {
    //         // get Supplier Order Item
    //         $item = OrderItem::find($request->item);
    //         $my_type = 0;
    //     }
    //     // get Store
    //     $store = Store::find($request->store);
    //     //get Product
    //     $product = Product::find($item->product_id);
    //     //get StoreProductItem
    //     $storeProduct = StoreProduct::where('store_id', $request->store)->where('product_id', $item->product_id)->first();

    //     if ($storeProduct) {
    //         // form supplier ordres
    //         if ($request->status == 0) {
    //             // add gointaty to product Store
    //             $storeProduct->number     += $request->num;
    //             // remove expanses from product
    //             $product->number_in -= $request->num;
    //         }
    //         //from client orders
    //         else {
    //             $storeProduct->number     -= $request->num;
    //             $product->number_out -= $request->num;
    //         }
    //         // add expanses form product
    //         $item->last_num += $request->num;
    //         if ($item->last_num >= $item->num) $item->status = 0;
    //         $item->save();
    //         $storeProduct->save();
    //         $product->save();
    //     } else {
    //         $item->last_num += $request->num;
    //         if ($item->last_num >= $item->num) $item->status = 0;
    //         $item->save();
    //         $product->number_in -= $request->num;
    //         $product->save();

    //         $storeProduct = new StoreProduct();
    //         $storeProduct->user_id = auth()->id();
    //         $storeProduct->account_id = auth()->user()->account_id;
    //         $storeProduct->number = $request->num;
    //         $storeProduct->product_id = $request->item;
    //         $storeProduct->store_id = $request->store;
    //         $storeProduct->save();
    //     }

    //     if(auth()->user()->account->type === 2){
    //         $itemW = new ItemOrderWard();
    //         $itemW->user_id   = auth()->id();
    //         $itemW->num       = $request->num;
    //         $itemW->order_id  = $item->order_id;
    //         $itemW->store_id  = $request->store;
    //         $itemW->status    = $request->status;
    //         $itemW->details   = $request->details;
    //         $itemW->type      = $my_type;
    //         $itemW->save();
    //     }else{
    //         $wiegth = new Weight();
    //         $wiegth->dirver_id  = $request->dirver;
    //         $wiegth->store_id   = $request->store;
    //         $wiegth->account_id = auth()->user()->account_id;
    //         $wiegth->item_id    = $request->item;
    //         $wiegth->order_id   = $item->order_id;
    //         $wiegth->jawal      = $request->jawal;
    //         $wiegth->number     = $request->number;
    //         $wiegth->num        = $request->num;
    //         $wiegth->status     = $request->status;
    //         $wiegth->type       = $my_type;
    //         if ($wiegth->save()) {
    //             foreach ($request->weight as $v) {
    //                 $i = new WeightItem();
    //                 $i->weight_id = $wiegth->id;
    //                 $i->jawal = $v['jawal'];
    //                 $i->number = $v['weight'];
    //                 $i->num = $v['total'];
    //                 $i->save();
    //             }
    //         }
    //     }

    //     return response([
    //         'store'  => $store,
    //         // 'wiegth' => $wiegth,
    //         'item'   => $item,
    //         'storeProduct'   => $storeProduct,
    //     ]);
    // }
    public function restore(Store $item)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(Store $store)
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $store->status = !$store->status;
        $store->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
