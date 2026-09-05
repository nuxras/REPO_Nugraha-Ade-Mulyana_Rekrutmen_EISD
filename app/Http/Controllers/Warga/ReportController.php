<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display form to create a new report
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('warga.reports.create', compact('categories'));
    }

    /**
     * Store a new report
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string|min:10',
            'photo'        => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'address'      => 'required|string|max:500',
            'latitude'     => 'required|numeric|between:-90,90',
            'longitude'    => 'required|numeric|between:-180,180',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ], [
            'title.required'       => 'Judul laporan wajib diisi.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
            'description.min'      => 'Deskripsi minimal 10 karakter.',
            'photo.required'       => 'Foto bukti wajib diunggah.',
            'photo.image'          => 'File harus berupa gambar.',
            'photo.max'            => 'Ukuran foto maksimal 5MB.',
            'address.required'     => 'Alamat lokasi wajib diisi.',
            'latitude.required'    => 'Silakan pilih titik lokasi di peta.',
            'longitude.required'   => 'Silakan pilih titik lokasi di peta.',
            'categories.required'  => 'Pilih minimal satu kategori masalah.',
        ]);

        // Upload photo
        $photoPath = $request->file('photo')->store('reports', 'public');

        // Create report
        $report = Report::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'photo'       => $photoPath,
            'address'     => $request->address,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => 'diterima',
            'priority_score' => 0,
        ]);

        // Attach categories (Many-to-Many)
        $report->categories()->attach($request->categories);

        // Calculate priority score
        Report::calculatePriorityScore($report);

        // Create initial status history
        $report->statusHistories()->create([
            'updated_by' => Auth::id(),
            'status'     => 'diterima',
            'note'       => 'Laporan berhasil dibuat dan diterima oleh sistem.',
        ]);

        return redirect()->route('warga.reports.show', $report)
            ->with('success', 'Laporan berhasil dibuat! Terima kasih atas partisipasi Anda.');
    }

    /**
     * Display list of user's reports (history)
     */
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with('categories')
            ->latest()
            ->paginate(10);

        return view('warga.reports.index', compact('reports'));
    }

    /**
     * Display a single report detail
     */
    public function show(Report $report)
    {
        // Ensure warga can only view their own reports
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $report->load(['categories', 'statusHistories.updater', 'user']);

        return view('warga.reports.show', compact('report'));
    }
}
