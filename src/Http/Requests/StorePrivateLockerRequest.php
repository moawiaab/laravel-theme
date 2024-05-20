<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use App\Models\PrivateLocker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class StorePrivateLockerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('private_locker_create');
    }
    public function rules()
    {
        return [
            'user_id' => ['required', 'unique:private_lockers'],
            'amount' => ['numeric', 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'ادخل اسم المستخدم من فضلك',
            'user_id.unique' => ' تم إنشاء خزنة لهذا المستخدم من قبل ',
        ];
    }
}
