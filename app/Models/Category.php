<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'priority_weight',
    ];

    // Many-to-Many: Category belongsToMany Report
    public function reports()
    {
        return $this->belongsToMany(Report::class, 'report_category');
    }
}
