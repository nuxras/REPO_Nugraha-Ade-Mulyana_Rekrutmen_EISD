<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with('categories')
            ->latest()
            ->paginate(10);

        return view('warga.dashboard', compact('reports'));
    }
}
