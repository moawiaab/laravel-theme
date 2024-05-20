<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use App\Models\Expanse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateExpanseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('expanse_edit');
    }

    public function rules()
    {
        return [
            'amount'  => ['required', 'numeric'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'amount.required' =>'ادخل  المبلغ من فضلك',
            'name.required' =>'لا تترك هذا الحقل فارغا لو سمحت ',
            'name.string' =>' الاسم يجب عن يكون نصا ',
        ];
    }
}
