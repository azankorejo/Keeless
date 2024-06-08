<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;

class TemplateInfoStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $emailCodes = Email::query()->pluck('code')->toArray();
        if ($request->has('code') && in_array($request->get('code'), $emailCodes)) {
        \Log::info('Email', [
           $emailCodes,
           $request->get('code')
        ]);
            Email::query()->where('code', $request->get('code'))->update([
               'answers' => json_encode($request->all())
            ]);
        }
        return redirect()->back();
    }
}
