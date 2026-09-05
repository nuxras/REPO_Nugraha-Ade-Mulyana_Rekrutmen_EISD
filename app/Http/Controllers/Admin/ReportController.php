<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['categories', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['categories', 'statusHistories.updater', 'user']);

        return view('admin.reports.show', compact('report'));
    }
}
