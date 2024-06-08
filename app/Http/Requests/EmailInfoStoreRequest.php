<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmailInfoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required_if:use_smtp,true",
            "server" => "required_if:use_smtp,true",
            "port" => "required_if:use_smtp,true",
            "username" => "required_if:use_smtp,true",
            "password" => "required_if:use_smtp,true",
        ];
    }

    public function messages()
    {
        return [
            "email.required_if" => "The email field is required when smtp is checked.",
            "server.required_if" => "The server field is required when smtp is checked.",
            "port.required_if" => "The port field is required when smtp is checked.",
            "username.required_if" => "The username field is required when smtp is checked.",
            "password.required_if" => "The password field is required when smtp is checked.",
        ];
        }
}
