<?php

namespace Moawiaab\LaravelTheme\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Gate;
use Moawiaab\LaravelTheme\Models\Role;

class AuthGates
{
    public function handle($request, Closure $next)
    {

        // dd($next);
        $user = auth()->user();
        // Carbon::setLocale('ar');

        if (!$user) {
            return $next($request);
        }

        // $roles            = Role::with('permissions')->get();
        // $permissionsArray = [];

        // foreach ($roles as $role) {
        //     foreach ($role->permissions as $permissions) {
        //         $permissionsArray[$permissions->title][] = $role->id;
        //     }
        // }
        if ($user->account->status == 0) {
            return ['account_locked', 'dashboard_access'];
        } elseif ($user->status == 0) {
            return ['user_locked', 'dashboard_access'];
        } else {
            return  auth()->user()->getAllPermissions->pluck('name')->toArray();
        }

        return $next($request);
    }
}
