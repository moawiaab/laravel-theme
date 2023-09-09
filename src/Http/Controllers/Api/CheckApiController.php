<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Moawiaab\LaravelTheme\Http\Resources\Admin\CheckResource;
use Moawiaab\LaravelTheme\Models\Check;

class CheckApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CheckResource::collection(
            Check::advancedFilter()
                ->where('account_id', request('account', auth()->user()->account_id))
                ->filter(Request::only('trashed'))
                ->paginate(request('limit', 10))
        );
    }

    public function done(Check $item)
    {
        if ($item->status == 1) {
            // $item->user_check_id      = auth()->id();
            $item->status             = 0;
            if ($item->save()) {
                return response(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return response([
                'message' => "تم اسلاتم الصنف مسبقا"
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Check $check)
    {
        //
    }
}
