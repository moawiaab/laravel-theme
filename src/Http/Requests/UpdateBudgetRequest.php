<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateBudgetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('budget_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'amount'  => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' =>'ادخل  المبلغ من فضلك',
            'amount.numeric' =>' المبلغ يجب عن يكون رقما ',
        ];
    }
}
