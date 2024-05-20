<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate as FacadesGate;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return FacadesGate::allows('user_create');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:5'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'role_id'  => ['integer', 'required', 'exists:roles,id',],
            'phone' => ['nullable', 'string', 'max:30'],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'ادخل اسم المستخدم من فضلك',
            'email.required' => 'ادخل  البريد من فضلك',
            'role_id.required' => 'اختر الصلاحية من فضلك',
            'role_id.integer' => 'لم تختر صلاحية صالحة',
            'email.email' => 'ادخل  البريد حقيقي فضلك',
            'email.unique' => 'هذا  البريد مسجل من قبل ادخل بريد اخر لو سمحت',
            'password.required' => 'ادخل كلمة السر من فضلك',
            'password.confirmed' => 'ادخل تأكيد كلمة السر من فضلك',
            'name.string' => 'اسم المستخدم يجب أن يكون نصاً',
            'confirmation.required' => 'أكد كلمة السر من فضلك'
        ];
    }
}
