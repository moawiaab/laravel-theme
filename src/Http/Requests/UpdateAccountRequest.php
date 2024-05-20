<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('account_create');
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:5'],
            'phone' => ['required', 'string', 'max:30'],
            'details' => ['required', 'string', 'max:255', 'min:5'],
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'ادخل اسم الفرع من فضلك',
            'name.string' => 'اسم الفرع يجب أن يكون نصاً',
        ];
    }
}
