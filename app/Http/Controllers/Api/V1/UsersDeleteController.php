<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Consumer;
use Illuminate\Http\Request;

class UsersDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'uid' => 'required',
        ]);

        $consumer = Consumer::query()->where('id', '=', $request->uid)->first();
        $consumer?->delete();

        return redirect()->back();
    }
}
