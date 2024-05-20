<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreSuppOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('supplier_order_create');
    }

    public function rules()
    {
        return [
            'products'        => ['required', 'array'],
            'details'         => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'supp_id.required' => ' اختر المورد من فضلك',
            'products.required' => 'قائمة الاصناف فارغة',
        ];
    }
}
