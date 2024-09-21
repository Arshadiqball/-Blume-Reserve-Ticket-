<?php

namespace App\Http\Controllers;

use App\Models\BRT;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class BRTAnalyticsController extends Controller
{
    public function getTotalAnalytics(): JsonResponse
    {
        $totalBrts = BRT::count();
        $activeBrts = BRT::where('status', 'active')->count();
        $expiredBrts = BRT::where('status', 'expired')->count();
        $totalReservedAmount = BRT::sum('reserved_amount');

        return response()->json([
            'totalBrts' => $totalBrts,
            'activeBrts' => $activeBrts,
            'expiredBrts' => $expiredBrts,
            'totalReservedAmount' => $totalReservedAmount,
        ]);
    }

    public function getTrendsAnalytics(): JsonResponse
    {
        $today = Carbon::today();
        
        // BRTs per day (works for SQLite)
        $brtsPerDay = BRT::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->where('created_at', '>=', $today->subDays(7))
            ->get();
        
        // BRTs per week (using SQLite's strftime to extract the week)
        $brtsPerWeek = BRT::select(DB::raw('strftime("%W", created_at) as week'), DB::raw('count(*) as count'))
            ->groupBy('week')
            ->where('created_at', '>=', $today->startOfMonth())
            ->get();
        
        // BRTs per month (using strftime to extract the month)
        $brtsPerMonth = BRT::select(DB::raw('strftime("%m", created_at) as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->where('created_at', '>=', $today->startOfYear())
            ->get();

        return response()->json([
            'brtsPerDay' => $brtsPerDay,
            'brtsPerWeek' => $brtsPerWeek,
            'brtsPerMonth' => $brtsPerMonth,
        ]);
    }
}
