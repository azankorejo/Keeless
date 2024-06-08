<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'email', 'username', 'phone', 'active'];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'consumer_teams');
    }

    public function authTokens()
    {
        return $this->hasMany(ConsumerToken::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }

    public static function getMAU()
    {
        return self::query()->whereRaw('TO_CHAR(created_at::date, \'YYYY-MM\') = TO_CHAR(CURRENT_DATE, \'YYYY-MM\')')
            ->count();
    }

    public static function getLastMonthRetentionRate()
    {
        $lastMonthRetentionRate = self::query()->whereRaw('TO_CHAR(created_at::date, \'YYYY-MM\') = TO_CHAR((CURRENT_DATE - INTERVAL \'1 month\'), \'YYYY-MM\')')
            ->count();

        $previousMonthMAU = self::getMAU();
        if ($previousMonthMAU) {
            return ($lastMonthRetentionRate / $previousMonthMAU) * 100;
        }
        return 0;
    }

    public static function getAllUsersCount()
    {
        return self::query()->count();
    }


    public static function getAllTimeRetentionRate()
    {
        if(self::query()->count() > 0) {
            $allTimeRetentionRate = (self::query()->count() / self::query()->count()) * 100;
        } else {
            return 0;
        }

        return $allTimeRetentionRate ?? 0;
    }
}
