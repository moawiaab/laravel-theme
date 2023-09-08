<?php

namespace App\Http\Requests;

use App\Models\Stage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate as FacadesGate;

class StoreStageRequest extends FormRequest
{
    public function authorize()
    {
        return FacadesGate::allows('stage_create');
    }
    public function rules()
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'start_date'   => ['required', 'date'],
            'end_date'   => ['required', 'date'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ادخل اسم المرحلة من فضلك',
            'name.string' => 'اسم المرحلة يجب أن يكون نصاً',
            'start_date.date' => 'تاريخ البداية غير صحيح',
            'start_date.required' => 'ادخل تاريخ البداية من فضلك ',
            'end_date.date' => 'تاريخ النهاية غير صحيح',
            'end_date.required' => 'ادخل تاريخ النهاية من فضلك ',
        ];
    }
}
