<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'photo',
        'address',
        'latitude',
        'longitude',
        'status',
        'priority_score',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'priority_score' => 'integer',
        ];
    }

    // Report belongsTo User (pelapor/warga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-Many: Report belongsToMany Category (via report_category)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'report_category');
    }

    // 1-to-Many (composition): Report hasMany StatusHistory
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class);
    }

    /**
     * Get priority badge info based on score
     */
    public function getPriorityBadgeAttribute(): array
    {
        if ($this->priority_score >= 70) {
            return ['label' => 'Tinggi', 'color' => 'red'];
        } elseif ($this->priority_score >= 40) {
            return ['label' => 'Sedang', 'color' => 'yellow'];
        } else {
            return ['label' => 'Rendah', 'color' => 'green'];
        }
    }

    /**
     * Get status badge info
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'diterima' => ['label' => 'Diterima', 'color' => 'blue'],
            'diproses' => ['label' => 'Diproses', 'color' => 'yellow'],
            'selesai'  => ['label' => 'Selesai', 'color' => 'green'],
            default    => ['label' => $this->status, 'color' => 'gray'],
        };
    }

    /**
     * Calculate priority score using Haversine formula for nearby similar reports
     */
    public static function calculatePriorityScore(Report $report): int
    {
        // Part 1: Sum of priority_weight from all selected categories
        $categoryWeightSum = $report->categories()->sum('priority_weight');

        // Part 2: Count of similar reports (same category + within 500m radius)
        $categoryIds = $report->categories()->pluck('categories.id')->toArray();

        if (empty($categoryIds)) {
            $report->priority_score = $categoryWeightSum;
            $report->save();
            return $categoryWeightSum;
        }

        // Find reports that share at least 1 category (excluding current report)
        $similarReportIds = \DB::table('report_category')
            ->whereIn('category_id', $categoryIds)
            ->where('report_id', '!=', $report->id)
            ->distinct()
            ->pluck('report_id');

        // Filter by 500m radius using Haversine in PHP (compatible with SQLite)
        $nearbyCount = 0;
        if ($similarReportIds->isNotEmpty()) {
            $candidates = Report::whereIn('id', $similarReportIds)->get(['id', 'latitude', 'longitude']);

            foreach ($candidates as $candidate) {
                $distance = self::haversineDistance(
                    $report->latitude, $report->longitude,
                    $candidate->latitude, $candidate->longitude
                );
                if ($distance <= 500) {
                    $nearbyCount++;
                }
            }
        }

        $score = $categoryWeightSum + ($nearbyCount * 10);
        $report->priority_score = $score;
        $report->save();

        return $score;
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     * @return float Distance in meters
     */
    public static function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
