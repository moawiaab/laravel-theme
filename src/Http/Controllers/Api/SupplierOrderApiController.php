<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuppOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\ProductOrderResource;
use Moawiaab\LaravelTheme\Http\Resources\SupplierOrdersResource;
use Moawiaab\LaravelTheme\Models\Client;
use Moawiaab\LaravelTheme\Models\Product;
use Moawiaab\LaravelTheme\Models\Store;
use Moawiaab\LaravelTheme\Models\StoreProduct;
use Moawiaab\LaravelTheme\Models\Supplier;
use Moawiaab\LaravelTheme\Models\SupplierOrder;
use Moawiaab\LaravelTheme\Models\SupplierOrderItem;

class SupplierOrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('supplier_order_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return SupplierOrdersResource::collection(
            SupplierOrder::where('account_id', request('account',auth()->user()->account_id))->advancedFilter()->filter(FacadesRequest::only('trashed'))
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
        abort_if(Gate::denies('supplier_order_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'suppliers' => Supplier::get(['id', 'name']),
                'clients'   => Client::get(['id', 'name']),
                'products'  => ProductOrderResource::collection(auth()->user()->account->products()->get()),
                'stores'    => Store::get(['id', 'name']),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSuppOrderRequest $request)
    {
        $order = new SupplierOrder();
        $order->amount       = 0;
        $order->account_id   = auth()->user()->account_id;
        $order->details      = $request->details;
        $order->user_id      = auth()->id();
        $order->type         = request('orderType', 0);;
        $order->supplier_id  = request('supplier_id', null);
        $order->client_id    = request('client_id', null);
        $client = Client::find(request('client_id', null));
        $supplier = Supplier::find(request('supplier_id', null));
        if ($order->save()) {
            foreach ($request->products as $v) {
                $storeProduct = StoreProduct::where('store_id', $v['store_id'])->where('product_id', $v['id'])->first();
                $product = Product::find($v['id']);
                $item = new SupplierOrderItem();
                $item->type         = request('orderType', 0);
                $item->status       = 1;
                $item->account_id   = auth()->user()->account_id;
                $item->supplier_id  = request('supplier_id', null);
                $item->client_id    = request('client_id', null);
                $item->user_id     = auth()->id();
                $item->order_id    = $order->id;
                $item->num         = $v['number'];
                $item->amount      = $v['amount'];
                $item->price       = $v['price'];
                $item->store_id    = $v['store_id'];
                $item->product_id     = $v['id'];
                if (auth()->user()->account->setting()->order_sup_conf == 1) {
                    $item->status = 1;
                } else {
                    $item->status = 0;
                    $item->user_check_id     = auth()->id();
                }
                if ($item->save()) {
                    $order->amount += $item->amount * $item->num;
                    //$product->number_in += $v['number'];
                    if ($order->type == 0) {
                        $supplier->amount += $item->amount * $item->num;
                        $supplier->save();
                    } else {
                        $client->amount += $item->amount * $item->num;
                        $client->save();
                    }
                    if (!$storeProduct) {
                        $storeProduct = new StoreProduct();
                        $storeProduct->user_id         = auth()->id();
                        $storeProduct->account_id      = auth()->user()->account_id;
                        $storeProduct->number          = 0;
                        $storeProduct->number_in       = 0;
                        $storeProduct->product_id      = $v['id'];
                        $storeProduct->store_id        = $v['store_id'];
                    }

                    if (auth()->user()->account->setting()->order_sup_conf == 0) {
                        $storeProduct->number     += $v['number'];
                    } else {
                        $storeProduct->number_in  += $v['number'];
                    }
                    $storeProduct->save();
                    $order->save();
                    $product->save();
                }
            }
            return response(null, Response::HTTP_CREATED);
        } else {
            return response([
                'messages' => "ليتم حفظ الفاتورة بنجاح حاول مرة اخرة لاحقا"
            ], 422);
        }
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierOrder $supplierOrder)
    {

        $items = $supplierOrder->items->where('status', 1);
        foreach ($items as $i) {
            $product = StoreProduct::where('store_id', $i->store_id)->where('product_id', $i->product_id)->first();
            if ($i->status == 1) {
                $i->user_check_id      = auth()->id();
                $i->status               = 0;
                $product->number_in   -=  $i->num;
                $product->number      +=  $i->num;
                // $sup                   = Supplier::find($i->supplier_id);
                // $sup->amount          += $i->amount * $i->num;
                // $sup->save();
                $product->save();
                $i->save();
            }
        }
        if ($items->count() > 0) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response([
                'message' => "لايوجد اصناف غير مستلمة لاستلامه"
            ], 422);
        }
    }

    public function done(SupplierOrderItem $supplierOrder)
    {
        $product = StoreProduct::where('store_id', $supplierOrder->store_id)->where('product_id', $supplierOrder->product_id)->first();
        if ($supplierOrder->status == 1) {
            $supplierOrder->user_check_id      = auth()->id();
            $supplierOrder->status             = 0;
            $product->number_in   -=  $supplierOrder->num;
            $product->number      +=  $supplierOrder->num;
            // $sup                   = Supplier::find($supplierOrder->supplier_id);
            // $sup->amount          += $supplierOrder->amount * $supplierOrder->num;
            // $sup->save();
            $product->save();
            if ($supplierOrder->save()) {
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return response([
                'message' => "تم اسلاتم الصنف مسبقا"
            ], 422);
        }
    }
}
