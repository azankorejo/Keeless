<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'name',
        'domain',
        'use_api',
        'use_email',
        'use_phone',
        'use_username',
        'terms_of_use',
        'privacy_policy',
        'web_url',
        'support_email',
        'use_email_for_login',
        'use_phone_for_login',
        'use_username_for_login',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }
}
