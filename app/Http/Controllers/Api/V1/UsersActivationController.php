<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Consumer;
use Illuminate\Http\Request;

class UsersActivationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'active' => 'required',
            'uid' => 'required',
        ]);

        $consumer = Consumer::query()->where('id', '=', $request->uid)->first();

        if ($consumer) {
            Consumer::query()->where('id', $request->uid)->update([
                'active' => $request->active
            ]);
        }

        return redirect()->back();
    }
}
