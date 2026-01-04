<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function scopeMinSunlight($query, int $min)
    {
        return $query->where('sunlight_score', '>=', $min);
    }
}
