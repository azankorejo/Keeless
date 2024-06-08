<?php

namespace App\Models;

use App\Models\Scopes\TeamScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Branding extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'favicon',
        'primary_color',
        'secondary_color',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new TeamScope);
    }

    public function getLogoAttribute(string|null $value)
    {
        if ($value) {
            $subdomain = request()->route('subdomain');
            $url = URL::temporarySignedRoute(
                'uploads.show',
                now()->addSeconds(20),
                ['filename' => $value, 'subdomain' => $subdomain]
            );
            if ($subdomain) {
                return str_replace($subdomain . '.', '', $url);
            }
            return $url;
        }

        return null;
    }

    public function getFaviconAttribute(string|null $value)
    {
        if ($value) {
            $subdomain = request()->route('subdomain');
            $url = URL::temporarySignedRoute(
                'uploads.show',
                now()->addSeconds(20),
                ['filename' => $value, 'subdomain' => $subdomain]
            );
            if ($subdomain) {
                return str_replace($subdomain . '.', '', $url);
            }
            return $url;
        }

        return null;
    }

}
