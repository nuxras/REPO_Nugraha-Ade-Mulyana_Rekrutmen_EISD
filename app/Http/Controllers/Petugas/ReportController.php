<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display report detail for petugas
     */
    public function show(Report $report)
    {
        $report->load(['categories', 'statusHistories.updater', 'user']);

        return view('petugas.reports.show', compact('report'));
    }

    /**
     * Update report status with mandatory note
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:diterima,diproses,selesai',
            'note'   => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Status tidak valid.',
        ]);

        // Validate status transition: only forward progression allowed
        $statusOrder = ['diterima' => 1, 'diproses' => 2, 'selesai' => 3];
        $currentOrder = $statusOrder[$report->status] ?? 0;
        $newOrder = $statusOrder[$request->status] ?? 0;

        if ($newOrder <= $currentOrder) {
            return back()->with('error', 'Status hanya bisa dimajukan, tidak bisa dikembalikan.')
                ->withInput();
        }

        // Update report status
        $report->status = $request->status;
        $report->save();

        // Create status history entry
        StatusHistory::create([
            'report_id'  => $report->id,
            'updated_by' => Auth::id(),
            'status'     => $request->status,
            'note'       => $request->note,
        ]);

        return redirect()->route('petugas.reports.show', $report)
            ->with('success', 'Status laporan berhasil diperbarui menjadi "' . ucfirst($request->status) . '".');
    }
}
