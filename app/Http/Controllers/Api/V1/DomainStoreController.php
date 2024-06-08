<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PermittedDomains;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DomainStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'domains' => 'array|required'
        ]);
        DB::beginTransaction();
        try {
            if (is_array($request->domains)) {
                PermittedDomains::query()->where('team_id', auth()->user()->currentTeam->id)->delete();
                foreach ($request->domains as $domain) {
                    PermittedDomains::query()->create(['team_id' => auth()->user()->currentTeam->id, 'domain' => rtrim($domain, '/')]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            report($e);
            DB::rollback();
        }
        return redirect()->back();
    }
}
