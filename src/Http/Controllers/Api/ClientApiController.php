<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\AmountRequest;
use Moawiaab\LaravelTheme\Http\Requests\ClientRequest;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Moawiaab\LaravelTheme\Http\Resources\Admin\AmountResources;
use Moawiaab\LaravelTheme\Http\Resources\ClientResource;
use Moawiaab\LaravelTheme\Models\Check;
use Moawiaab\LaravelTheme\Models\Client;
use Moawiaab\LaravelTheme\Models\FinancialClient;
use Moawiaab\LaravelTheme\Services\LockerService;

class ClientApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('client_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return ClientResource::collection(
            Client::advancedFilter()->where('account_id', request('account', auth()->user()->account_id))
                ->filter(Request::only('trashed'))->paginate(request('rowsPerPage', 20))
        );
    }

    public function getAmount(Client $client)
    {
        abort_unless(Gate::allows('client_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return AmountResources::collection(
            FinancialClient::advancedFilter()->where('client_id', $client->id)
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
        abort_unless(Gate::allows('client_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'meta' => [
                'type' => Client::TYPE_SELECT,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $data = [
            'user_id' => auth()->id(),
            'account_id'   => auth()->user()->account_id,
            'roof'    => 3000,
            'type'    => 1,
            'status'  => 1,
            'amount'  => request('amount', 0)
        ];
        $client = Client::create($request->validated() + $data);

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        abort_unless(Gate::allows('client_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        // $items =  new AmountResources(FinancialClient::with(['user'])->advancedFilter()->client($client->id));
        // $orders =  OrdersResource::collection(Order::with(['items'])->advancedFilter()->client($client->id));
        return [
            'data' =>  new ClientResource($client),
            'meta' => [
                'items'  => AmountResources::collection($client->items),
                'orders' => [] //$orders,
            ]


        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        abort_unless(Gate::allows('client_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => $client,
            'meta' => [
                'type' => Client::TYPE_SELECT,
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
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        abort_unless(Gate::allows('client_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($client->deleted_at) {
            $client->forceDelete();
        } else {
            $client->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(HttpRequest $request)
    {
        abort_unless(Gate::allows('client_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Client::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        Client::whereIn('id', $request->items)->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(HttpRequest $request)
    {
        abort_unless(Gate::allows('client_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        foreach ($request[0] as $value) {
            $perm = new Client();
            $perm->user_id    = auth()->id();
            $perm->account_id = auth()->user()->account_id;
            $perm->roof       = 3000;
            $perm->type       = 1;
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
    public function restore(Client $client)
    {
        abort_unless(Gate::allows('client_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $client->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(Client $client)
    {
        abort_unless(Gate::allows('client_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $client->status = !$client->status;
        $client->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function amount(AmountRequest $request, Client $client)
    {
        if (LockerService::check()) {
            return response([
                'message' => LockerService::$error
            ], 422);
        }
        $amount = new FinancialClient();
        $amount->client_id = $client->id;
        $amount->user_id = auth()->id();
        $amount->account_id = auth()->user()->account_id;
        $amount->amount  = $request->amount;
        $amount->details  = $request->details;
        $amount->status  = $request->status;
        $amount->type  = $request->type;

        if ($request->type == 5) {
            $check = new Check();
            $check->name        = $request->name;
            $check->num         = $request->num;
            $check->amount      = $request->amount;
            $check->bank        = $request->bank;
            $check->date        = $request->date;
            $check->status      = 1;
            $check->type        = $request->status;
            $check->client_id   = $client->id;
            $check->user_id     = auth()->id();
            $check->account_id  = auth()->user()->account_id;
            $check->details     = $request->details;
            // $check->save()
            if ($check->save()) {

            }else{
                return response([
                    'message' => "لم تتم كتابة الشيك بنجاح"
                ], 422);
            }
        }
        if ($amount->status == 1) {
            $amounts = ($amount->amount + $client->amount);
            if (
                $client->status == 0 ||
                ($client->type == 0 && $amounts > 0)
                || ($client->type == 1 && ($amounts > $client->roof))
            ) {
                return response([
                    'message' => "لم يمكنك السحب من هذا العميل " . $amounts
                ], 422);
            } else {
                $amount->take = $amount->amount;
                auth()->user()->locker->amount -= $amount->amount;
                $amount->amount = $amount->amount - $client->amount;
                $amount->export = 0;
                $client->amount -= $amount->take;
                if ($amount->save()) {
                    $client->save();
                    auth()->user()->locker->save();
                }
            }
        } else {
            $amount->take = 0;
            $amount->export = $amount->amount;
            auth()->user()->locker->amount += $amount->amount;
            $client->amount += $amount->export;
            $amount->amount = $client->amount;
            if ($amount->save()) {
                auth()->user()->locker->save();
                $client->save();
            }
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
