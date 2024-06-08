<?php

namespace App\Rules;

use App\Models\Consumer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ConsumerEmailExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $emailExists = Consumer::query()->where('team_id', auth()->user()->team_id)->where($attribute, $value)->exists();
    }
}
