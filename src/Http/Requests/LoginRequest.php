<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'ادخل  البريد من فضلك',
            'email.email' => 'البريد غير صالح',
            'password.required' => 'ادخل كلمة السر من فضلك',
        ];
    }
}
