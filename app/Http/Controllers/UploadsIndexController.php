<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UploadsIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $filename)
    {
        if (!URL::signatureHasNotExpired($request)) {
            return abort(404);
        }
        return response()->file(storage_path('app/public/' . $filename));
    }
}
