<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Gate::allows('product_create') || !Gate::allows('product_edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'        => ['required', 'string', 'max:50'],
            'details'     => ['required', 'string'],
            'amount'      => ['required', 'numeric'],
            'price'       => ['required', 'numeric'],
            'gain'        => ['required', 'numeric'],
            'image'       => ['nullable'],
            'barcode'     => ['nullable', 'numeric'],
            'unit_id'     => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
        ];
    }
    public function messages() {
        return [
            'category_id.required' => 'اختر قسم المنتج من فضلك'
        ];
    }
}
