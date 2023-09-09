<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuppOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\BackOrderResource;
use Moawiaab\LaravelTheme\Http\Resources\Admin\ProductClientOrderResource;
use Moawiaab\LaravelTheme\Http\Resources\OrdersResource;
use Moawiaab\LaravelTheme\Models\Back;
use Moawiaab\LaravelTheme\Models\Client;
use Moawiaab\LaravelTheme\Models\FinancialClient;
use Moawiaab\LaravelTheme\Models\Order;
use Moawiaab\LaravelTheme\Models\OrderItem;
use Moawiaab\LaravelTheme\Models\PrivateLocker;
use Moawiaab\LaravelTheme\Models\Store;
use Moawiaab\LaravelTheme\Models\StoreProduct;
use Moawiaab\LaravelTheme\Services\LockerService;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return OrdersResource::collection(
            Order::where('account_id', request('account', auth()->user()->account_id))->advancedFilter()
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(
                    request('rowsPerPage', 20)
                )
        );
    }

    public function getBack()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return BackOrderResource::collection(
            Back::where('account_id', request('account', auth()->user()->account_id))
                ->where('status', request('type', 1))
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('limit', 10))
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'clients' => Client::get(['id', 'name']),
                'products' => ProductClientOrderResource::collection(auth()->user()->account->products()->get()),
                'stores'    => Store::with('products')->get(['id', 'name']),
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
        if (LockerService::check()) {
            return response([
                'message' => LockerService::$error
            ], 422);
        }
        // if (!auth()->user()->locker) {
        //     return response([
        //         'message' => LockerService::$error
        //     ], 422);
        // }
        $order = new Order();
        $order->amount       = 0;
        $order->type         = request('orderType', 0);
        $order->account_id   = auth()->user()->account_id;
        $order->details      = $request->details;
        $order->user_id      = auth()->id();
        $order->client_id    = request('client_id', null);
        $order->discount     = request('discount', 0);
        $client = Client::find(request('client_id', null));
        if ($client)
            $client->payment  = request('payment', null);
        if ($order->save()) {
            $my_amount = 0;
            foreach ($request->products as $v) {
                $storeProduct = StoreProduct::find($v['store_id']);
                $item = new OrderItem();
                $item->type         = request('orderType', 0);
                $item->status       = 1;
                $item->account_id   = auth()->user()->account_id;
                $item->client_id    = request('client_id', null);
                $item->user_id     = auth()->id();
                $item->order_id    = $order->id;
                $item->num         = $v['number'];
                $item->store_id    = $v['store_id'];
                $item->amount      = $v['amount'];
                $item->price       = $v['price'];
                $item->product_id     = $v['id'];
                // $item->status = 0;
                if (auth()->user()->account->setting()->order_conf == 1) {
                    $item->status = 1;
                } else {
                    $item->status = 0;
                    $item->user_check_id     = auth()->id();
                }
                if ($item->save()) {
                    $order->amount += $item->price * $item->num;
                    $my_amount += $item->price * $item->num;
                    if ($storeProduct) {
                        if (auth()->user()->account->setting()->order_conf == 0) {
                            $storeProduct->number     -= $v['number'];
                        } else {
                            $storeProduct->number_out += $v['number'];
                        }
                        $storeProduct->save();
                    }
                    $order->save();
                }
            }
            if (request('orderType', 0) == 1) {
                if ($request->amount > 0) {
                    $amount = new FinancialClient();
                    $amount->client_id  = $client->id;
                    $amount->user_id    = auth()->id();
                    $amount->account_id = auth()->user()->account_id;
                    $amount->details    = "مبلغ الفاتورة رقم $order->id";
                    $amount->status     = 1;
                    $amount->type       = 4;
                    $client->amount    -= ($my_amount - $request->discount) - $request->amount;
                    $amount->amount     = $client->amount;
                    $amount->take       = ($my_amount - $request->discount) - $request->amount;
                    $amount->export     = 0;
                    $amount->payment    = request('payment', null);
                    $client->save();
                    $amount->save();
                    auth()->user()->locker->amount += $request->amount;
                    auth()->user()->locker->save();
                } else {
                    $amount = new FinancialClient();
                    $amount->client_id  = $client->id;
                    $amount->user_id    = auth()->id();
                    $amount->account_id = auth()->user()->account_id;
                    $amount->details    = "مبلغ الفاتورة رقم $order->id";
                    $amount->status     = 1;
                    $amount->type       = 4;
                    $amount->payment    = request('payment', null);
                    $client->amount    -= ($my_amount - $request->discount);
                    $amount->amount     = $client->amount;
                    $amount->take       = ($my_amount - $request->discount);
                    $amount->export     = 0;
                    $client->save();
                    $amount->save();
                }
            } else {
                auth()->user()->locker->amount += ($my_amount - $request->discount);
                auth()->user()->locker->save();
            }
            return response(null, Response::HTTP_CREATED);
        } else {
            return response([
                'messages' => "ليتم حفظ الفاتورة بنجاح حاول مرة اخرة لاحقا"
            ], 422);
        }
    }

    public function back(OrderItem $item, Request $request)
    {
        $pro = StoreProduct::find($item->store_id);
        $back = new Back();
        $back->pro_id      = $item->product_id;
        $back->item_id     = $item->id;
        $back->order_id    = $item->order_id;
        $back->store_id    = $item->store_id;
        $back->amount      = $item->price * $item->num;
        $back->num         = $item->num;
        $back->details     = "تم ارجاعه";
        $back->user_id     = auth()->id();
        $back->account_id  = auth()->user()->account_id;
        if (auth()->user()->account->setting()->order_conf == 0) {
            $back->status      = 0;
            $pro->number += $item->num;
            auth()->user()->locker->amount -= $back->amount;
            $back->updated_id = auth()->id();
        } else {
            $back->status      = 1;
        }

        if ($back->save()) {
            $item->back += $back->num;
            $item->num  -= $back->num;
            if ($item->save()) {
                $pro->save();
                auth()->user()->locker->save();
                return response($item->order_id, Response::HTTP_CREATED);
            } else {
                $back->delete();
            }
        }
        return response(['error' => "لم يتم إضافة المرتجع بنجاح حاول مرة اخرة لاحقا"], Response::HTTP_NOT_FOUND);
    }

    public function backDone(Back $back, Request $request)
    {
        $privateLocker = PrivateLocker::where('user_id', $back->user_id)->first();
        if ($back->status == 1) {
            $back->updated_id = auth()->id();
            $back->status = 0;
            if ($back->save()) {
                $privateLocker->amount -= $back->amount;
                $privateLocker->save();
                $pro = StoreProduct::find($back->store_id);
                if ($pro) {
                    $pro->number += $back->num;
                }
                $pro->save();
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return response(null, Response::HTTP_NO_CONTENT);
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
    public function destroy(Order $order)
    {
        $items = $order->items->where('status', 1);
        foreach ($items as $i) {
            $product = StoreProduct::find($i->store_id);
            if ($i->status == 1) {
                $i->user_check_id      = auth()->id();
                $i->status               = 0;
                $product->number_out   -=  $i->num;
                $product->number       -=  $i->num;
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


    public function backAll(Order $order)
    {
        $items = $order->items->where('status', 0);
        foreach ($items as $i) {
            $back = new Back();
            $back->pro_id      = $i->product_id;
            $back->order_id    = $order->id;
            $back->item_id     = $i->id;
            $back->amount      = $i->price * $i->num;
            $back->status      = 1;
            $back->num         = $i->num;
            $back->details     = "تم ارجاع كل الفاتورة";
            $back->user_id     = auth()->id();
            $back->account_id  = auth()->user()->account_id;

            if ($back->save()) {
                $i->back += $back->num;
                $i->num  -= $back->num;
                if (!$i->save()) {
                    $back->delete();
                }
            }
        }
        if ($items->count() > 0) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response([
                'message' => "لايوجد اصناف لارجاعها"
            ], 422);
        }
    }

    public function done(OrderItem $item)
    {
        $product = StoreProduct::find($item->store_id);
        if ($item->status == 1) {
            $item->user_check_id      = auth()->id();
            $item->status             = 0;
            $product->number         -=  $item->num;
            $product->number_out     -=  $item->num;
            $product->save();
            if ($item->save()) {
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return response([
                'message' => "تم اسلاتم الصنف مسبقا"
            ], 422);
        }
    }
}
