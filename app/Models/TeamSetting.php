<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'key',
        'value'
    ];

    public const JWT_EXPIRATION_KEY = 'jwt_expiration_duration';
}
