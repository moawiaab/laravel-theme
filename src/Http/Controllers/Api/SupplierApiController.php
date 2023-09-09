<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmountRequest;
use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Moawiaab\LaravelTheme\Http\Resources\Admin\AmountResources;
use Moawiaab\LaravelTheme\Http\Resources\SupplierResource;
use Moawiaab\LaravelTheme\Models\Check;
use Moawiaab\LaravelTheme\Models\FinancialSupplier;
use Moawiaab\LaravelTheme\Models\Supplier;
use Moawiaab\LaravelTheme\Services\LockerService;

class SupplierApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return SupplierResource::collection(
            Supplier::where('account_id', request('account',auth()->user()->account_id))->advancedFilter()->filter(Request::only('trashed'))
                ->paginate(
                    request('rowsPerPage', 20)
                )
        );
    }

    public function getAmount(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return AmountResources::collection(
            FinancialSupplier::advancedFilter()->where('supplier_id', $supplier->id)
                ->filter(Request::only('trashed'))->paginate(request('rowsPerPage', 20))
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('supplier_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $data = [
            'user_id'      => auth()->id(),
            'account_id'   => auth()->user()->account_id,
            'status'       => 1,
            'amount'       => request('amount', 0)
        ];
        $client = Supplier::create($request->validated() + $data);

        return (new SupplierResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        $items =  new AmountResources(FinancialSupplier::with(['user'])->advancedFilter()->supplier($supplier->id));
        return [
            'data' =>  new SupplierResource($supplier),
            'meta' => [
                'items'  => AmountResources::collection($supplier->items),
            ]


        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier $supplier)
    {
        abort_if(Gate::denies('supplier_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => $supplier,
            'meta' => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return (new SupplierResource($supplier))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($supplier->deleted_at) {
            $supplier->forceDelete();
        } else {
            $supplier->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(HttpRequest $request)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Supplier::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        Supplier::whereIn('id', $request->items)->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(HttpRequest $request)
    {
        abort_if(Gate::denies('supplier_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        foreach ($request[0] as $value) {
            $perm = new Supplier();
            $perm->user_id    = auth()->id();
            $perm->account_id = auth()->user()->account_id;
            $perm->status     = 1;
            $perm->name       = $value['name'];
            $perm->address    = $value['address'];
            $perm->phone      = $value['phone'];
            $perm->email      = $value['email'];
            $perm->amount     = $value['amount'] ?? 0;
            $perm->save();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function restore(SUpplier $supplier)
    {
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $supplier->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(Supplier $supplier)
    {
        abort_if(Gate::denies('supplier_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $supplier->status = !$supplier->status;
        $supplier->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function amount(AmountRequest $request, Supplier $supplier)
    {
        if (LockerService::check()) {
            return response([
                'message' => LockerService::$error
            ], 422);
        }
        $amount = new FinancialSupplier();
        $amount->supplier_id = $supplier->id;
        $amount->user_id = auth()->id();
        $amount->account_id = auth()->user()->account_id;
        $amount->amount  = $request->amount;
        $amount->details  = $request->details;
        $amount->status  = $request->status;
        $amount->type  = $request->type;

        if($request->type == 5){
            $check = new Check();
            $check->name        = $request->name;
            $check->num         = $request->num;
            $check->amount      = $request->amount;
            $check->bank        = $request->bank;
            $check->date        = $request->date;
            $check->status      = 1;
            $check->type        = $request->status;
            $check->supplier_id = $supplier->id;
            $check->user_id     = auth()->id();
            $check->account_id  = auth()->user()->account_id;
            $check->details     = $request->details;
            if ($check->save()) {
              
            }else{
                return response([
                    'message' => "لم تتم كتابة الشيك بنجاح"
                ], 422);  
            }
        }
        if ($amount->status == 1) {
            $amount->take = $amount->amount;
            auth()->user()->locker->amount -= $amount->amount;
            $amount->amount = $supplier->amount + $amount->amount;
            $amount->export = 0;
            $supplier->amount -=  $amount->amount;
            if ($amount->save()) {
                $supplier->save();
                auth()->user()->locker->save();
            }
        } else {
            $amount->take = 0;
            $amount->export = $amount->amount;
            auth()->user()->locker->amount += $amount->amount;
            $supplier->amount += $amount->amount;
            $amount->amount = $supplier->amount;
            if ($amount->save()) {
                auth()->user()->locker->save();
                $supplier->save();
            }
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
