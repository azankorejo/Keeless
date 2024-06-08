<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardIndexController extends Controller
{
    public function __invoke()
    {
        $mau = Consumer::getMAU();
        $rrLastMonth = Consumer::getLastMonthRetentionRate();

        $rrAllTime = Consumer::getAllTimeRetentionRate();
        $userCount = Consumer::getAllUsersCount();

        return Inertia::render('Dashboard', compact('userCount', 'rrLastMonth', 'rrAllTime', 'mau'));
    }
}
