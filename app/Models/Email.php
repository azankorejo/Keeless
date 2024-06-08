<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    public const CODE_MAGIC = 'MAGIC';
    public const CODE_OTP = 'OTP';

    protected $fillable = [
        'team_id',
        'name',
        'code',
        'template_path',
        'answers'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }
}
