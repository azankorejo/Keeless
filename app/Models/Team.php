<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use App\Observers\TeamObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }

    public function emailInfo(): HasOne
    {
        return $this->hasOne(EmailInformation::class);
    }

    public function consumers()
    {
        return $this->belongsToMany(Consumer::class, 'consumer_teams');
    }

    public function businessInfo(): HasOne
    {
        return $this->hasOne(BusinessInformation::class);
    }

    public function redirectionInfo(): HasOne
    {
        return $this->hasOne(RedirectionInformation::class);
    }

    public function permittedDomains(): HasMany
    {
        return $this->hasMany(permittedDomains::class);
    }

    public function apiKeys(): HasMany
    {
        return $this->hasMany(ApiKey::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(TeamSetting::class);
    }

    public function jwtConfig(): HasMany
    {
        return $this->hasMany(TeamSetting::class)->whereIn('key', [TeamSetting::JWT_EXPIRATION_KEY]);
    }
}
