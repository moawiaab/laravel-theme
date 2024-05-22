<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate as FacadesGate;

class StoreBasicRequest extends FormRequest
{
    public function authorize()
    {
        // return FacadesGate::allows('user_create');
        return true;
    }

    public function rules()
    {
        return [
            'name' => [],
        ];
    }
}
