<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AmountRequest extends FormRequest
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
            'status'  => ['required'],
            'type'    => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' =>'ادخل  المبلغ من فضلك',
            'details.required' =>'ادخل  التفاصيل من فضلك',
            'amount.numeric' =>' المبلغ يجب عن يكون نصا ',
            'status.required' =>'حدد نوع المعاملة من فضلك',
            'status.required' =>'حدد طريق الاستلام  من فضلك',
        ];
    }
}
