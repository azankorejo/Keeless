<?php

namespace App\Http\Controllers\Domain\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConsumerToken;
use App\Models\RedirectionInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): mixed
    {
        try {
            $ct = ConsumerToken::query()->with('consumer')->valid()->where('token', $request->get('k_t_access'))->first();
            if($ct) {
                $redirectionInfo = RedirectionInformation::query()->where('team_id', $ct->consumer->team_id)->first();
                DB::transaction(function () use ($ct) {
                    $ct->valid = false;
                    $ct->save();
                });
            } else {
                throw new \Exception('Customer token was not found when logging out ' .  $request->get('k_t_access'));
            }
        } catch (\Exception $e) {
            report($e);
            return response()->json(['logout_status' => false], 401);
        }
        return response()->json(['logout_status' => true, 'callback_url' => $redirectionInfo->logout]);
    }
}
