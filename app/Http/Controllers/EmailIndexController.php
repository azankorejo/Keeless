<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmailIndexResource;
use App\Models\BusinessInformation;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmailIndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $emailTemplate = [];
        $emailCodes = Email::query()->pluck('code')->toArray();
        if($request->has('template') && in_array($request->get('template'), $emailCodes)) {
            $emailTemplate = Email::query()->where('code', $request->template)->firstOrFail();
            $answers = json_decode($this->getFormattedStrings($emailTemplate->answers), true);
            $logo = $this->getLogo();
            $emailTemplate = ['template' => view($emailTemplate->template_path, [
                'answers' => $answers,
                'otp' => 781283,
                'magicLink' => '#',
                'logo' => $logo
            ])->render(), 'code' => $emailTemplate->code];
        }

        $emails = EmailIndexResource::collection(Email::query()->latest()->get(['code', 'name', 'answers']));
        return Inertia::render('Email', compact('emails', 'emailTemplate'));
    }

    private function getFormattedStrings(string $answers): string
    {
        $result = $answers;
        $businessDetails = BusinessInformation::query()->first();
        if(str_contains($answers, '{{$')) {
            $result = str_replace('{{$appName}}', $businessDetails?->name ?? 'app', $result);
            $result = str_replace('{{$email}}', $businessDetails?->support_email ?? auth()->user()->email, $result);
            $result = str_replace('{{$website}}', $businessDetails?->web_url ?? 'website', $result);
        }
        return $result;
    }

    private function getLogo(): string|null
    {
        $branding = DB::table('brandings')->where('team_id', auth()->user()->currentTeam->id)->first();
        if($branding) {
            $url = route('uploads.show', ['filename' => $branding->logo]);
            // Remove any base URL prefix if present
            return preg_replace('/^(https?:\/\/[^\/]+)\//', '', $url);
        }
        return null;
    }
}
