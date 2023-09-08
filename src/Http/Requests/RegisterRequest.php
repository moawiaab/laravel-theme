<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'        => ['required', 'string', 'min:5'],
            'phone'           => ['required'],
            'device_name'     => ['required'],
            'details'         => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'            => 'ادخل اسم المستخدم لو سمحت',
            'name.string'              => 'اسم المستخدم يجب عن يكون من سلسلة نصية',
            'email.required'           => 'ادخل البريد من فضلك',
            'email.email'              => 'البريد غير صالح ادخل بريد صالح',
            'email.unique'             => 'هذا البريد مسجل مسبقا',
            'password.required'        => 'ادخل كلمة السر من فضلك',
            'password.min'             => 'كلمة السر يجب عن  يكون اكثر من 5 احرف',
            'phone.required'           => 'ادخل رقم الهاتف لو سمحت',

        ];
    }
}
