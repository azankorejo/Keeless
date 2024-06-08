<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessInfoStoreRequest;
use App\Models\BusinessInformation;
use App\Models\PermittedDomains;
use Illuminate\Support\Facades\DB;

class BusinessInfoStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BusinessInfoStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            BusinessInformation::query()->updateOrCreate([
                'team_id' => auth()->user()->currentTeam->id
            ], [
                'name' => $request->name,
                'domain' => strtolower($request->domain),
                'use_api' => $request->use_api,
                'use_email' => true,
                'use_phone' => in_array('Phone', $request->fields),
                'use_username' => $request->use_name,
                'use_email_for_login' => true,
                'use_phone_for_login' => in_array('Phone', $request->login_fields),
                'use_username_for_login' => in_array('Username', $request->login_fields),
                'terms_of_use' => $request->terms_of_use,
                'privacy_policy' => $request->privacy_policy,
                'support_email' => $request->support_email,
                'web_url' => $request->web_url,
            ]);

            if ($request->has('domain') && $request->filled('domain')) {
                $domain = 'https://'. $request->domain . '.' . config('app.url');
                PermittedDomains::query()->updateOrCreate(
                    [
                        'domain' => $domain
                    ],
                    [
                        'team_id' => auth()->user()->currentTeam->id,
                        'domain' => $domain
                    ]
                );
            }

            DB::commit();
        } catch (\Exception $e) {
            report($e);
            DB::rollback();
        }
        return redirect()->back()->with(['message' => 'Added business information']);
    }
}
