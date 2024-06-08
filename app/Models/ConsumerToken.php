<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ConsumerToken extends Model
{
    use HasFactory;

    protected $fillable = ['consumer_id', 'token', 'signing_key', 'valid'];

    protected $hidden = ['signing_key'];

    /**
     * Scope a query to only include active users.
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid', true);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
