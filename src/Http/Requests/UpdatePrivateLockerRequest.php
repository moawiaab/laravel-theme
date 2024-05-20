<?php

namespace Moawiaab\LaravelTheme\Http\Requests;

use App\Models\PrivateLocker;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePrivateLockerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => ['required'],
        ];
    }
}
