<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TeamSetting;
use Illuminate\Http\Request;

class JWTConfigStoreController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->has('jwt_expiration') && $request->filled('jwt_expiration')) {
            $jwtExpiration = $request->get('jwt_expiration') == 0 ? 1 : $request->get('jwt_expiration');
            TeamSetting::query()
                ->where('team_id', auth()->user()->currentTeam->id)
                ->where('key', TeamSetting::JWT_EXPIRATION_KEY)
                ->update(['value' => $jwtExpiration]);
        }
        return redirect()->back();
    }
}
