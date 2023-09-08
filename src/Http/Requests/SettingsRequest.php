<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'exp_roof'  => ['required', 'boolean'],
            'exp_conf' => ['required', 'boolean'],
            'order_conf' => ['required', 'boolean'],
            'order_sup_conf' => ['required', 'boolean'],
            'order_back_conf' => ['required', 'boolean'],
            'locker_conf' => ['required', 'boolean'],
        ];
    }
}
