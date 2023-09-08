<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreBudgetNameRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        return Gate::allows('budget_name_create');
    }
    public function rules()
    {
        return [
            'details' => ['required', 'string', 'max:255'],
            'name'  => ['required', 'string'],
            'status'  => ['nullable'],
            'type'    => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'details.required' => 'ادخل  التفاصيل من فضلك',
            'name.required' => 'ادخل اسم الموازنة من فضلك',
        ];
    }
}
