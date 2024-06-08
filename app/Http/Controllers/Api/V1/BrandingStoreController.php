<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandingStoreRequest;
use App\Models\Branding;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandingStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BrandingStoreRequest $request): RedirectResponse
    {
        $teamId = auth()->user()->currentTeam->id;
        $logo = $request->file('data.logo');
        $favicon = $request->file('data.favicon');
        $payload = $request->get('data');
        $data = [
            'primary_color' => $payload['primaryColor'],
            'secondary_color' => $payload['secondaryColor'],
        ];
        if ($logo) {
            $logoPath = $logo?->storeAs('', "logo-" . $teamId . '.' . $logo->extension(), 'public');
            $data['logo'] = $logoPath;
        }
        if ($favicon) {
            $faviconPath = $favicon?->storeAs('', "favicon-" . $teamId . '.' . $favicon->extension(), 'public');
            $data['favicon'] = $faviconPath;
        }

        Branding::query()->where('team_id', $teamId)->update($data);

        return redirect()->back()->with(['message' => 'Saved.']);
    }
}
