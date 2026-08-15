<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // FR009 + FR015: dashboard with basic stats/reports
    public function index()
    {
        $totals = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'rejected' => Complaint::where('status', 'rejected')->count(),
        ];

        $byCategory = Complaint::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Average resolution time in hours, for resolved complaints
        $avgResolutionHours = Complaint::whereNotNull('resolved_at')
            ->get()
            ->avg(fn ($c) => $c->created_at->diffInHours($c->resolved_at));

        $recentComplaints = Complaint::latest()->take(8)->get();

        return view('admin.dashboard', compact('totals', 'byCategory', 'avgResolutionHours', 'recentComplaints'));
    }
}
