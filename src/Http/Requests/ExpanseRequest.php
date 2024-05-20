<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpanseRequest extends FormRequest
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
            'amount'  => ['required', 'numeric'],
            'details' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' =>'ادخل  المبلغ من فضلك',
            'details.required' =>'لا تترك هذا الحقل فارغا لو سمحت ',
            'amount.numeric' =>' المبلغ يجب عن يكون نصا ',
        ];
    }
}
