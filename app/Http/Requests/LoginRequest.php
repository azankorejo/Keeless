<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use Laravel\Fortify\Fortify;

class LoginRequest extends FortifyLoginRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            Fortify::username() => 'required|string',
        ];
    }
}
