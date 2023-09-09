<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpanseRequest;
use App\Http\Requests\StoreExpanseRequest;
use App\Http\Requests\UpdateExpanseRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Moawiaab\LaravelTheme\Http\Resources\Admin\ExpanseResource;
use Moawiaab\LaravelTheme\Models\Budget;
use Moawiaab\LaravelTheme\Models\Expanse;
use Moawiaab\LaravelTheme\Models\ExpanseItem;
use Moawiaab\LaravelTheme\Models\PrivateLocker;
use Moawiaab\LaravelTheme\Models\Stage;
use Moawiaab\LaravelTheme\Services\LockerService;

class ExpanseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expanse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return ExpanseResource::collection(
            Expanse::advancedFilter()
                ->where('account_id', request('account',auth()->user()->account_id))
                ->filter(FacadesRequest::only('trashed'))
                ->paginate(request('limit', 10))
        );
    }

    public function store(StoreExpanseRequest $request)
    {
        // $ser = new LockService();
        if (LockerService::check()) {
            return response([
                'message' => LockerService::$error
            ], 422);
        }
        $data = [
            'user_id'  => auth()->id(),
            'stage_id' => $this->stageId()
        ];
        $bug = Budget::find($request->budget_id);
        if (auth()->user()->account->setting()->exp_roof == 0) {
            if ($request->amount + $bug->expense_amount > $bug->amount) {
                return response([
                    'message' => "لا يوجد مبلغ كافي من هذا البند"
                ], 422);
            }
        }

        if (auth()->user()->account->setting()->exp_conf == 1) {
            $status = ['status'   => 1];
        } else {
            $status = ['status'   => 0, 'administrative_id' => auth()->id()];
            $bug->expense_amount  += $request->amount;
            auth()->user()->locker->amount -= $request->amount;
        }
        $expanse = auth()->user()->account->expanses()->create($request->validated() + $data + $status);
        if ($expanse) {
            auth()->user()->locker->save();
            $bug->save();
        }
        return (new ExpanseResource($expanse))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('expanse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response([
            'meta' => [
                'budgets' => auth()->user()->account->budgets()
                    ->where('stage_id', $this->stageId())
                    ->get()->transform(fn ($e) =>
                    [
                        'id' => $e->id,
                        'name' => $e->budget->name,
                        'amount' => $e->amount,
                        'expense' => $e->expense_amount
                    ]),
                'roof' => auth()->user()->account->setting()->exp_roof
            ],
        ]);
    }

    public function show(Expanse $expanse)
    {
        abort_if(Gate::denies('expanse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return [
            'data' =>  new ExpanseResource($expanse),
        ];
    }

    public function update(UpdateExpanseRequest $request, Expanse $expanse)
    {
        $expanse->update($request->validated());
        return (new ExpanseResource($expanse))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Expanse $expanse)
    {
        abort_if(Gate::denies('expanse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response([
            'data' => $expanse,
            'meta' => ['stages' => auth()->user()->account->stages()->get(['id', 'name'])],
        ]);
    }

    public function destroy(Expanse $expanse)
    {
        abort_if(Gate::denies('expanse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $expanse->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function done(Expanse $expanse)
    {

        $bug = Budget::find($expanse->budget_id);
        $bug->expense_amount  += $expanse->amount;

        $expanse->user->locker->amount -= $expanse->amount;

        $expanse->status = 0;
        $expanse->administrative_id = auth()->id();

        if ($expanse->save()) {
            $expanse->user->locker->save();
            $bug->save();
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            return response([
                'message' =>  "لم يتم استلام المصروف بنجاح حاول مرة اخرى"
            ], 422);
        }
    }

    public function amount(ExpanseRequest $request, Expanse $expanse)
    {
        if (!auth()->user()->locker) {
            throw new Exception("افتح الخزينة الشخصية من فضلك", 1);
        }
        if (!$expanse->prive_id) {
            $privateLocker = PrivateLocker::where('user_id', $expanse->user_id)->first();
        } else {
            $privateLocker = PrivateLocker::find($expanse->prive_id);
        }
        $item = new ExpanseItem();
        $item->account_id   = auth()->user()->account_id;
        $item->user_id      = auth()->user()->id;
        $item->status       = 1;
        $item->locker_id     = auth()->user()->locker->id;
        $item->amount       = $request->amount;
        $item->details      = $request->details;
        $item->expanse_id   = $expanse->id;

        $privateLocker->amount -= $request->amount;
        $expanse->expanses += $request->amount;

        if ($item->save()) {
            $expanse->save();
            $privateLocker->save();
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            throw new Exception(" لم تتم العملية بنجاح حاول مرة اخرة لاحقا");
        }
    }

    public function toggle(Expanse $expanse)
    {
        $expanse->status = !$expanse->status;
        if ($expanse->save()) {
            return response(null, Response::HTTP_NO_CONTENT);
        } else {
            throw new Exception("لم يتم التراجع بنجاح حاول مرة اخرة لاحقا");
        }
    }

    public function stageId()
    {
        $stage = Stage::where('account_id', request('account',auth()->user()->account_id))->where('status', 1)->first();
        if ($stage)
            return $stage->id;
        else return 0;
    }
}
