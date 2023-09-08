<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordsRequest extends FormRequest
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
            'current_password' => ['required', 'min:5'],
            'password' => ['required', 'confirmed', 'min:5'],
        ];
    }
    public function messages()
    {
        return [

            'password.required' => 'ادخل كلمة السر من فضلك',
            'newPassword.confirmed' => 'ادخل تأكيد كلمة السر من فضلك',
            'password.min' => ' كلمة السر قصير جداً',
            'newPassword.min' => ' كلمة السر قصير جداً',
            'confirmation.required' => 'أكد كلمة السر من فضلك'
        ];
    }
}
