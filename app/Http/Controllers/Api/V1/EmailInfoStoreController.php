<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailInfoStoreRequest;
use App\Models\EmailInformation;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmailInfoStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmailInfoStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            EmailInformation::query()->updateOrCreate([
                'team_id' => auth()->user()->currentTeam->id
            ], [
                "use_smtp" => $request->get('use_smtp'),
                "use_otp" => $request->get('use_otp'),
                "email" => $request->get('email'),
                "server" => $request->get('server'),
                "port" => $request->get('port'),
                "username" => $request->get('username'),
                "password" => $request->get('password'),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            report($e);
            DB::rollback();
        }
        return redirect()->back()->with(['message' => 'Added email information']);
    }
}
