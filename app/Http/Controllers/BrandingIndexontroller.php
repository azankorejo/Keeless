<?php

namespace App\Http\Controllers;

use App\Models\Branding;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BrandingIndexontroller extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $branding = Branding::query()->first();
        return Inertia::render('Branding', compact('branding'));
    }
}
