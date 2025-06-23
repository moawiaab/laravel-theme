<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\StoreBudgetNameRequest;
use Moawiaab\LaravelTheme\Http\Requests\UpdateBudgetNameRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Moawiaab\LaravelTheme\Http\Resources\BudgetNameResource;
use Moawiaab\LaravelTheme\Models\BudgetName;

class BudgetNameApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_unless(Gate::allows('budget_name_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return BudgetNameResource::collection(BudgetName::advancedFilter()->filter(Request::only('trashed'))->paginate(request('limit', 10)));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(Gate::allows('budget_name_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response([
            'meta' => [
                'type' => [
                    ['id' => 0, 'name' => 'اسم خاص بهذا الفرع'],
                    ['id' => 1, 'name' => ' اسم عام لكل الفروع'],
                ],
                // 'status' => BudgetName::STATUS_RADIO ?? [],
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetNameRequest $request)
    {
        abort_unless(Gate::allows('budget_name_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $budget = BudgetName::create($request->validated()+['account_id' => auth()->user()->account_id]);
        return (new BudgetNameResource($budget))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(BudgetName $budgetName)
    {
        return response([
            'data' => new BudgetNameResource($budgetName),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BudgetName $budgetName)
    {
        abort_unless(Gate::allows('budget_name_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response([
            'data' => $budgetName,
            'meta' => [
                'type' => [
                    ['id' => 0, 'name' => 'اسم خاص بهذا الفرع'],
                    ['id' => 1, 'name' => ' اسم عام لكل الفروع'],
                ],
                // 'status' => BudgetName::STATUS_RADIO ?? [],
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetNameRequest $request, BudgetName $budgetName)
    {
        $budgetName->update($request->validated());
        return (new BudgetNameResource($budgetName))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BudgetName $budgetName)
    {
        abort_unless(Gate::allows('budget_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($budgetName->budget->count() > 0) {
            return response([
                'message' => 'لا يمكنك حذف اسم الموازنة لان تم استخدامه'
            ], Response::HTTP_FAILED_DEPENDENCY);
        } else {

            if ($budgetName->deleted_at) {
                $budgetName->forceDelete();
            } else {
                $budgetName->delete();
            }
            return response(null, Response::HTTP_NO_CONTENT);
        }
    }

    public function restore(BudgetName $budgetName)
    {
        abort_unless(Gate::allows('budget_name_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $budgetName->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(BudgetName $budgetName)
    {
        abort_unless(Gate::allows('budget_name_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $budgetName->status = !$budgetName->status;
        if ($budgetName->type)
            return response([
                'message' => 'لا يمكنك قفل اسم الموازنة هذه لانها عامة قم بقفلها من الموازنة'
            ], Response::HTTP_FAILED_DEPENDENCY);
        else
            $budgetName->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
