<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_corner',
        'distance_convenience_store',
        'sunlight_score',
        'noise_score',
    ];

    protected $casts = [
        'is_corner' => 'boolean',
    ];

    public function scopeCorner($query)
    {
        return $query->where('is_corner', true);
    }
}
