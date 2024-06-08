<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerAuthentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumer_id',
        'token',
        'otp',
        'expires_at'
    ];

    /**
     * Scope a query to only include active users.
     */
    public function scopeValid($query): void
    {
        $query->where('expires_at', '>', Carbon::now());
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
