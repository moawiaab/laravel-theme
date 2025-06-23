<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBasicRequest;
use App\Http\Requests\UpdateBasicRequest;
use App\Http\Resources\BasicResource;
use App\Models\Basic;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request as HttpRequest;
use Moawiaab\LaravelTheme\Services\DevelopmentService;

class BasicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Unit::all();
        abort_unless(Gate::allows('basic_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return BasicResource::collection(
            Basic::advancedFilter()->filter(FacadesRequest::only('trashed'))
                ->paginate(request('rowsPerPage', 20))
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return [
            'meta' => [
                //set resource
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBasicRequest $request)
    {
        $data = ['user_id' => auth()->id(), 'account_id' => auth()->user()->account_id];
        Basic::create($request->validated() + $data);
        return  response(null, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Basic $basic)
    {
        return [
            'data' => new BasicResource($basic),
            'meta' => [
                 //set_resource
            ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Basic $basic)
    {
        abort_unless(Gate::allows('basic_edit'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        return response([
            'data' => new BasicResource($basic),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBasicRequest $request, Basic $basic)
    {
        $basic->update($request->validated());
        return  response(null, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Basic $basic)
    {
        abort_unless(Gate::allows('basic_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        if ($basic->deleted_at) {
            $basic->forceDelete();
        } else {
            $basic->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroyAll(HttpRequest $request)
    {
        abort_unless(Gate::allows('basic_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        Basic::whereIn('id', $request->items)->onlyTrashed()->forceDelete();
        Basic::whereIn('id', $request->items)->delete();


        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function restore(Basic $item)
    {
        abort_unless(Gate::allows('basic_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addAll(HttpRequest $request)
    {
        $defaultValue = [
            'user_id'      => auth()->id(),
            'account_id'   => auth()->user()->account_id,
            //set default value here
        ];
        $skipKeys= ['account', 'user'];
        $fillable = DevelopmentService::check($request[0],$defaultValue, $skipKeys);

        Basic::insert($fillable);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
