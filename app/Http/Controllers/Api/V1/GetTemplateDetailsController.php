<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GetTemplateDetailsController extends Controller
{
    public function __invoke(Request $request, string $code)
    {
        $email = Email::query()->where('code', $code)->firstOrFail();
        return Inertia::render('Email', [
            'data' => view($email->template_path)->render()
        ]);
    }
}
