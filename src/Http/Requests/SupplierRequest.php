<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('supplier_create');
    }

    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'email' => ['nullable'],
            'phone' => ['string','required'],
            'address' => ['string','nullable'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'ادخل اسم العميل من فضلك',
            'name.string' => 'اسم العميل يجب أن يكون نصاً',
            'email.email' => 'ادخل  البريد حقيقي فضلك',
            'phone.required' => 'ادخل رقم الهاتف من فضلك',
            'phone.min' => 'رقم الهاتف قصير جداً',
        ];
    }
}
