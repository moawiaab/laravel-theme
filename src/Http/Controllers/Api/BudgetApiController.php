<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\StoreBudgetRequest;
use Moawiaab\LaravelTheme\Http\Requests\UpdateBudgetRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Moawiaab\LaravelTheme\Http\Resources\BudgetResource;
use Moawiaab\LaravelTheme\Models\Budget;
use Moawiaab\LaravelTheme\Models\BudgetName;
use Moawiaab\LaravelTheme\Models\Stage;

class BudgetApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_unless(Gate::allows('budget_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return BudgetResource::collection(Budget::advancedFilter()->filter(Request::only('trashed'))->paginate(request('limit', 10)));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(Gate::allows('budget_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $stage = $this->createStage();
        return response([
            'meta' => [
                'budgets' => BudgetName::where('status', 1)->whereNotIn(
                    'id',
                    Budget::where('account_id', request('account',auth()->user()->account_id))->where('stage_id', $stage->id)
                        ->pluck('budget_id')
                )->where(function ($q) {
                    $q->where('type', 1)->orWhere('account_id', request('account',auth()->user()->account_id));
                })->get(['name', 'id']),
                // 'status' => BudgetName::STATUS_RADIO ?? [],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request)
    {
        abort_unless(Gate::allows('budget_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $stage = $this->createStage();

        $data = [
            'expense_amount' => 0,
            'status'         => 1,
            'account_id'     => auth()->user()->account_id,
            'user_id'        => auth()->id(),
            'stage_id'       => $stage->id
        ];
        $budget = Budget::create($request->validated() + $data);
        return (new BudgetResource($budget))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        return response([
            'data' => new BudgetResource($budget),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        return response([
            'data' => new BudgetResource($budget)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        $budget->update($request->validated());
        return (new BudgetResource($budget))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        abort_unless(Gate::allows('budget_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($budget->expanses->count() > 0) {
            return response([
                'message' => 'لا يمكنك حذف اسم الموازنة لان تم استخدامه'
            ], Response::HTTP_FAILED_DEPENDENCY);
        } else {

            if ($budget->deleted_at) {
                $budget->forceDelete();
            } else {
                $budget->delete();
            }
            return response(null, Response::HTTP_NO_CONTENT);
        }
    }

    public function restore(Budget $budget)
    {
        abort_unless(Gate::allows('budget_name_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $budget->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function createStage()
    {
        $stage = Stage::whereYear('start_date', date('Y'))->where('account_id', request('account',auth()->user()->account_id))->first();
        if (!$stage) {
            $years = Stage::where('account_id', request('account',auth()->user()->account_id))->get();
            foreach ($years as $y) {
                $y->status = 0;
                $y->save();
            }
            $newData =  date('Y', strtotime(date("Y-m-d") . ' + 1 years'));
            $stage = new Stage();
            $stage->name = " السنة المالية للعام " . date("Y");
            $stage->status = 1;
            $stage->start_date = date("Y-m-d");
            $stage->end_date = $newData . "-12-31";
            $stage->account_id = auth()->user()->account_id;
            $stage->user_id = auth()->id();
            $stage->save();
        }

        return $stage;
    }

    public function toggle(Budget $budget)
    {
        abort_unless(Gate::allows('budget_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $budget->status = !$budget->status;
        $budget->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
