<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'report_id',
        'updated_by',
        'status',
        'note',
    ];

    // StatusHistory belongsTo Report
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // StatusHistory belongsTo User (sebagai updater/petugas)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
