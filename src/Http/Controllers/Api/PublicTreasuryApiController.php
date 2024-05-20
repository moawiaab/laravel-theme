<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\ExpanseItemsResources;
use Moawiaab\LaravelTheme\Http\Resources\Admin\OpenDaysResources;
use Moawiaab\LaravelTheme\Http\Resources\Admin\PublicTreasuryResource;
use Moawiaab\LaravelTheme\Models\ExpanseItem;
use Moawiaab\LaravelTheme\Models\OpenDay;
use Moawiaab\LaravelTheme\Models\PrivateLocker;
use Moawiaab\LaravelTheme\Models\PublicTreasury;

class PublicTreasuryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('public_treasury_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return OpenDaysResources::collection(
            OpenDay::advancedFilter()
                ->where('account_id', request('account',auth()->user()->account_id))
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('limit', 10))
        );
    }

    // public function store(StorePublicTreasuryRequest $request)
    // {
    //     $publicTreasury = PublicTreasury::create($request->validated());

    //     return (new PublicTreasuryResource($publicTreasury))
    //         ->response()
    //         ->setStatusCode(Response::HTTP_CREATED);
    // }

    public function create()
    {
        // abort_if(Gate::denies('public_treasury_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'meta' => [],
        ]);
    }

    public function show($id)
    {
        $publicTreasury = PublicTreasury::where('account_id', request('account',auth()->user()->account_id))->first();
        // abort_if(Gate::denies('public_treasury_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (!$publicTreasury) {
            $pub = new PublicTreasury();
            $pub->name   =  'خزنة الرئيسية';
            $pub->amount = 0;
            $pub->take_amount = 0;
            $pub->add_amount = 0;
            $pub->status = 1;
            $pub->user_id = auth()->id();
            $pub->account_id = auth()->user()->account_id;
            $pub->save();
        }
        return [
            'pub' => new PublicTreasuryResource(auth()->user()->account->locker),
            'expanses'  => ExpanseItemsResources::collection(ExpanseItem::where('status', 1)->get()),
            'pubItems' => OpenDaysResources::collection(OpenDay::onlyTrashed()->get()),
        ];
    }

    // public function update(UpdatePublicTreasuryRequest $request, PublicTreasury $publicTreasury)
    // {
    //     $publicTreasury->update($request->validated());

    //     return (new PublicTreasuryResource($publicTreasury))
    //         ->response()
    //         ->setStatusCode(Response::HTTP_ACCEPTED);
    // }

    public function edit(PublicTreasury $publicTreasury)
    {
        abort_if(Gate::denies('public_treasury_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response([
            'data' => new PublicTreasuryResource($publicTreasury),
            'meta' => [],
        ]);
    }

    public function destroy(OpenDay $publicTreasury)
    {
        abort_if(Gate::denies('public_treasury_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $publicTreasury->details = request('details', '');
        $publicTreasury->user_updated_id = auth()->id();
        $publicTreasury->save();
        if ($publicTreasury->delete()) {
            $priv = PrivateLocker::find($publicTreasury->locker_id);
            $priv->amount += $publicTreasury->amount;
            if ($priv->save()) {
                return response(null, Response::HTTP_NO_CONTENT);
            }
        }
    }

    public function done(OpenDay $item)
    {
        if ($item->status === 0) {
            return response([
                'message' => "تم استلام هذا المبلغ من قبل"
            ], 422);
        }

        $item->status = 0;
        $item->user_updated_id = auth()->id();
        $pub = PublicTreasury::where('account_id', request('account',auth()->user()->account_id))->first();
        $pub->amount  += $item->amount;
        $item->amount < 0 ?  $pub->take_amount += (float)trim($item->amount, '-') :  $pub->add_amount += $item->amount;
        if ($pub->save()) {
            $item->save();
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response([
                'message' => "لم يتم الاستلام بنجاح حاول مرة اخرة لاحقا"
            ], 422);
        }
    }
}
