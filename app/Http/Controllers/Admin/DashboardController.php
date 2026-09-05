<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReports   = Report::count();
        $reportDiterima = Report::where('status', 'diterima')->count();
        $reportDiproses = Report::where('status', 'diproses')->count();
        $reportSelesai  = Report::where('status', 'selesai')->count();
        $totalUsers     = User::count();
        $totalCategories = Category::count();

        // Reports per category for chart
        $categoriesWithCount = Category::withCount('reports')->orderBy('name')->get();

        return view('admin.dashboard', compact(
            'totalReports',
            'reportDiterima',
            'reportDiproses',
            'reportSelesai',
            'totalUsers',
            'totalCategories',
            'categoriesWithCount'
        ));
    }
}
