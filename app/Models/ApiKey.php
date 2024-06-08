<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'team_id',
        'name',
        'last_used',
        'internal_key'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }

    protected function lastUsed(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('m/d/Y H:i:s'),
        );
    }
}
