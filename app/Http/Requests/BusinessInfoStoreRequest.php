<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BusinessInfoStoreRequest extends FormRequest
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
        $domainValidation = "";
        if($this->id) {
            $domainValidation = ", $this->id";
        }
        return [
            'name' => 'required',
            'domain' => 'required|regex:/^[a-zA-Z0-9\-_]+$/|unique:business_information,domain' . $domainValidation,
            'fields' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
        return [
          'domain.regex' => 'Domain name invalid. Domain should only have letters, numbers, dashes and underscores.'
        ];
    }
}
