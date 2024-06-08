<?php

namespace App\Http\Requests;

use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Models\Consumer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ConsumerRegisterRequest extends FormRequest
{
    private $api = null;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $payload = request()->all();
        $this->api = ApiKey::query()->where('key', $payload['access_token'])->first();
        return !is_null($this->api);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $teamId = $this->api->team_id;
        $businessInfo = BusinessInformation::query()->where('team_id', $teamId)->firstOrFail();
        $rules = [
            'access_token' => ['required']
        ];

        if ($businessInfo->use_email) {
            $rules['email'] = ['required','email',
                function (string $attribute, mixed $value, Closure $fail) use($teamId) {
                    $consumerExists = Consumer::query()->where($attribute, $value)
                        ->where('team_id', $teamId)->exists();
                    if ($consumerExists) {
                        $fail("The {$attribute} already exists.");
                    }
                }
            ];
        }
        if ($businessInfo->use_username) {
            $rules['username'] = ['required', 'string', 'alpha_dash'];
        }
        if ($businessInfo->use_phone) {
            $rules['phone'] = ['required', 'numeric'];
        }
        return $rules;
    }
}
