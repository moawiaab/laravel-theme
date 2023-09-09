<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsRequest;
use App\Http\Resources\Admin\AbilityResource;
use App\Http\Resources\Admin\SettingsResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingApiController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $setting = Setting::where('account_id', request('account',auth()->user()->account_id))->first();
        if (!$setting) {
            Setting::create([
                'exp_roof' => 1,
                'exp_conf' => 1,
                'account_id' => auth()->user()->account_id
            ]);
        }
        return response(new SettingsResource(auth()->user()->account->setting()));
    }

    public function setData(SettingsRequest $request)
    {
        auth()->user()->account->setting()->update($request->validated());
        return response(null, Response::HTTP_ACCEPTED);
    }
}
