<?php

namespace App\Http\Controllers;

use App\Http\Resources\SetupIndexResource;
use App\Models\BusinessInformation;
use App\Models\Team;
use App\Models\TeamSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SetupIndexController extends Controller
{
    public function __invoke()
    {
        $teamSettingCount = TeamSetting::query()->where('team_id', auth()->user()->currentTeam->id)->where('key', TeamSetting::JWT_EXPIRATION_KEY)->count();
        $stepsDone =
            auth()->user()->currentTeam->businessInfo()->count() +
             auth()->user()->currentTeam->redirectionInfo()->count() +
            auth()->user()->currentTeam->emailInfo()->count() +
            $teamSettingCount;
        $data = Team::query()->with(['businessInfo', 'emailInfo', 'redirectionInfo', 'permittedDomains', 'jwtConfig'])->where('id', auth()->user()->currentTeam->id)->first();
        $data = new SetupIndexResource($data);
        return Inertia::render('Setup', compact('stepsDone', 'data'));
    }
}
