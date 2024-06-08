<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermittedDomains extends Model
{
    use HasFactory;

    protected $fillable = [
      'team_id',
      'domain',
      'is_internal'
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }
}
