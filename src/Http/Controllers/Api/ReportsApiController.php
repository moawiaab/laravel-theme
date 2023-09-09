<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Moawiaab\LaravelTheme\Http\Resources\Admin\AmountResources;
use Moawiaab\LaravelTheme\Http\Resources\Admin\BackOrderResource;
use Moawiaab\LaravelTheme\Http\Resources\Admin\ExpanseItemsResources;
use Moawiaab\LaravelTheme\Http\Resources\ItemResource;
use Moawiaab\LaravelTheme\Http\Resources\OrdersResource;
use Moawiaab\LaravelTheme\Http\Resources\ProductStoreShowResource;
use Moawiaab\LaravelTheme\Models\Account;
use Moawiaab\LaravelTheme\Models\Back;
use Moawiaab\LaravelTheme\Models\Client;
use Moawiaab\LaravelTheme\Models\Expanse;
use Moawiaab\LaravelTheme\Models\FinancialClient;
use Moawiaab\LaravelTheme\Models\FinancialSupplier;
use Moawiaab\LaravelTheme\Models\Order;
use Moawiaab\LaravelTheme\Models\OrderItem;
use Moawiaab\LaravelTheme\Models\ProductStore;
use Moawiaab\LaravelTheme\Models\Supplier;

class ReportsApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('stage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $orders = OrdersResource::collection(Order::where('user_id', request('user_id', auth()->id()))->whereDate('created_at', request('date', date('Y-m-d')))->get());
        $clientAmount = AmountResources::collection(FinancialClient::where('user_id', request('user_id', auth()->id()))->whereDate('created_at', request('date', date('Y-m-d')))->get());
        $suppAmount = AmountResources::collection(FinancialSupplier::where('user_id', request('user_id', auth()->id()))->whereDate('created_at', request('date', date('Y-m-d')))->get());
        $backs = BackOrderResource::collection(Back::where('user_id', request('user_id', auth()->id()))->whereDate('created_at', request('date', date('Y-m-d')))->get());
        $allAmount = $orders->sum('amount') - $backs->sum('amount');
        $expanse = ExpanseItemsResources::collection(Expanse::where('user_id', auth()->id())->whereDate('created_at', request('date', date('Y-m-d')))->get());
        return [
            'data'  => [
                'all_amount'   =>  $allAmount,
                'cl_teg'       =>  $clientAmount->sum('take'),
                'cl_add'       =>  $clientAmount->sum('export'),
                'supp_teg'     =>  $suppAmount->sum('take_amount'),
                'supp_add'     =>  $suppAmount->sum('add_amount'),
                'amount'       => ($suppAmount->sum('add_amount') +  $allAmount + $clientAmount->sum('export')) - ($clientAmount->sum('take') + $suppAmount->sum('take_amount')),

            ], 'meta' => [
                'users' => User::get(['name', 'id']),
                'orders' => $orders,
                'clientAmount' => $clientAmount,
                'suppAmount' => $suppAmount,
                'backs' => $backs,
                'expanse' => $expanse
            ]
        ];
    }

    public function show()
    {
        $client = Client::where('account_id', request('account', auth()->user()->account_id))->get();
        $supplier = Supplier::where('account_id', request('account', auth()->user()->account_id))->get();
        $prod = ProductStoreShowResource::collection(ProductStore::get());
        $clinin = $client->where('amount', '>', 0)->sum('amount');
        $clinout = $client->where('amount', '<', 0)->sum('amount');
        $clin = $client->sum('amount');

        $suppin = $supplier->where('amount', '>', 0)->sum('amount');
        $suppout = $supplier->where('amount', '<', 0)->sum('amount');
        $supp = $supplier->sum('amount');

        $data = [
            'clinin' => $clinin,
            'clinout' => $clinout * -1,
            'clin'  => $clin * -1,
            'suppin' => $suppin,
            'suppout' => $suppout * -1,
            'supp'  => $supp * -1,
            'expenses' => 0
        ];

        $data['expenses'] = Expanse::where('account_id', request('account', auth()->user()->account_id))
            ->whereBetween('created_at', [
                request('startDay', date('Y-m-d')),
                request('endDay', date('Y-m-d'))
            ])->sum('amount');
        $items = ItemResource::collection(OrderItem::where('account_id', request('account', auth()->user()->account_id))
            ->whereBetween('created_at', [
                request('startDay', date('Y-m-d')),
                request('endDay', date('Y-m-d'))
            ])->get());
        return [
            'data' => $data,
            'meta' => [
                'accounts' => Account::get(['name', 'id']),
                'products'  => $prod,
                'items'     => $items,
            ],
        ];
    }
}
