<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Http\Resources\Admin\StageResource;
use App\Models\Account;
use App\Models\Shop;
use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('stage_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return  StageResource::collection(auth()->user()->account->stages()->get());
    }

    public function store(StoreStageRequest $request)
    {
        $stage = auth()->user()->account->stages()->create($request->validated() + ['status' => 1, 'user_id' => auth()->id()]);
        return (new StageResource($stage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function create()
    {
        abort_if(Gate::denies('stage_create'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'meta' => [
                'user' => User::get(['id', 'name']),
                'account'   => Account::get(['id', 'name']),
            ],
        ]);
    }

    public function show(Stage $stage)
    {
        abort_if(Gate::denies('stage_show'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return new StageResource($stage->load(['user', 'sh']));
    }

    public function update(UpdateStageRequest $request, Stage $stage)
    {
        $stage->update($request->validated());
        return (new StageResource($stage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function edit(Stage $stage)
    {
        abort_if(Gate::denies('stage_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return response([
            'data' => new StageResource($stage),
            'meta' => [

            ],
        ]);
    }

    public function destroy(Stage $stage)
    {
        abort_if(Gate::denies('stage_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $stage->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function toggle(Stage $stage)
    {
        abort_if(Gate::denies('stage_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $stage->status = !$stage->status;
        $stage->save();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
