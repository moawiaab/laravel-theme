<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Http\Requests\LoginRequest;
use Moawiaab\LaravelTheme\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    public function store(RegisterRequest $data)
    {
        $user = User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'account_id' => 1,
            'role_id'    => 3,
            'phone'      => $data['phone'],
            'password'   => Hash::make($data['password']),
        ]);

        return [
            'user' => $user->only(['id','name', 'email', 'phone', 'created_at']),
            'token' => $user->createToken($data['device_name'])->plainTextToken
        ];
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['كلمة السر أو رقم الهاتف غير صحيحة .'],
            ]);
        }

        return [
            'user' => $user->only(['id','name', 'email', 'phone', 'created_at']),
            'token' => $user->createToken($request->device_name)->plainTextToken
        ];
    }
}
