<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use App\Models\Stage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateStageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stage_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'start_date' => [
                'date_format:' . config('project.date_format'),
                'required',
            ],
            'end_date' => [
                'date_format:' . config('project.date_format'),
                'required',
            ],
            'user_id' => [
                'integer',
                'exists:users,id',
                'nullable',
            ],
            'sh_id' => [
                'integer',
                'exists:shops,id',
                'nullable',
            ],
        ];
    }
}
