<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'use_smtp',
        'use_otp',
        'email',
        'server',
        'port',
        'username',
        'password',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }
}
