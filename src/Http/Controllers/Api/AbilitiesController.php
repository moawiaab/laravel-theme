<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Resources\Admin\AbilityResource;
use Moawiaab\LaravelTheme\Http\Resources\Admin\UserDataResource;
use Moawiaab\LaravelTheme\Models\Setting;

class AbilitiesController extends Controller
{
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
        $permissions = auth()->user()->role->permissions
            ->pluck('title')->toArray();
        if (auth()->user()->status == 0) {
            $permissions = ['user_locked', 'dashboard_access'];
        }
        if (auth()->user()->account->status == 0) {
            $permissions = ['account_locked', 'dashboard_access'];
        }
        return [
            'user' => new UserDataResource(auth()->user()),
            'data' => new AbilityResource($permissions),
        ];
    }
}
