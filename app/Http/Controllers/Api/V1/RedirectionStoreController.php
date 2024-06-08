<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedirectionStoreRequest;
use App\Models\RedirectionInformation;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RedirectionStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RedirectionStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            RedirectionInformation::query()->updateOrCreate([
                'team_id' => auth()->user()->currentTeam->id
            ], [
                "login" => $request->get('login'),
                "logout" => $request->get('logout'),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            report($e);
            DB::rollback();
        }
        return redirect()->back()->with(['message' => 'Added redirection information']);
    }
}
