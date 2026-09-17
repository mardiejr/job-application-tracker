<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $total = JobApplication::where('user_id', $userId)->count();

        $statusCounts = JobApplication::where('user_id', $userId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $statuses = ['applied', 'interviewing', 'offer', 'rejected', 'withdrawn'];
        $chartData = [];
        foreach ($statuses as $status) {
            $chartData[$status] = $statusCounts[$status] ?? 0;
        }

        $recentCount = JobApplication::where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $recentApplications = JobApplication::where('user_id', $userId)
            ->with('company')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('total', 'chartData', 'recentCount', 'recentApplications'));
    }
}
