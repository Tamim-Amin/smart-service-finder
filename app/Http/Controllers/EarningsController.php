<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    public function index(Request $request)
    {
        $provider = Provider::where('user_id', Auth::id())->firstOrFail();
        
        // Get filter parameters
        $period = $request->get('period', 'all'); // all, today, week, month, year
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        // Base query for completed bookings with earnings
        $query = Booking::where('provider_id', $provider->id)
            ->where('status', 'completed')
            ->whereNotNull('total_amount');

        // Apply period filters
        switch ($period) {
            case 'today':
                $query->whereDate('updated_at', today());
                break;
            case 'week':
                $query->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereYear('updated_at', $year)
                      ->whereMonth('updated_at', $month);
                break;
            case 'year':
                $query->whereYear('updated_at', $year);
                break;
        }

        // Get earnings data
        $earnings = $query->orderBy('updated_at', 'desc')->paginate(15);
        
        // Calculate statistics
        $stats = [
            'total_earnings' => $provider->total_earnings,
            'period_earnings' => $query->sum('total_amount'),
            'total_hours' => $query->sum('total_hours'),
            'total_jobs' => $query->count(),
            'average_per_job' => $query->count() > 0 ? $query->avg('total_amount') : 0,
        ];

        // Monthly breakdown for current year
        $monthlyEarnings = Booking::where('provider_id', $provider->id)
            ->where('status', 'completed')
            ->whereNotNull('total_amount')
            ->whereYear('updated_at', $year)
            ->select(
                DB::raw('MONTH(updated_at) as month'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('SUM(total_hours) as hours'),
                DB::raw('COUNT(*) as jobs')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        // Fill in missing months with zeros
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = [
                'month' => $i,
                'month_name' => date('F', mktime(0, 0, 0, $i, 1)),
                'total' => $monthlyEarnings->has($i) ? $monthlyEarnings[$i]->total : 0,
                'hours' => $monthlyEarnings->has($i) ? $monthlyEarnings[$i]->hours : 0,
                'jobs' => $monthlyEarnings->has($i) ? $monthlyEarnings[$i]->jobs : 0,
            ];
        }

        // Category breakdown
        $categoryEarnings = Booking::where('provider_id', $provider->id)
            ->where('status', 'completed')
            ->whereNotNull('total_amount')
            ->select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as jobs')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('provider.earnings', compact(
            'provider',
            'earnings',
            'stats',
            'monthlyData',
            'categoryEarnings',
            'period',
            'year',
            'month'
        ));
    }
}