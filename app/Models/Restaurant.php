<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'cuisine_type',
        'rating',
        'review_count',
        'image_url',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
    ];

    /**
     * Scope to get restaurants near a specific location using Haversine formula
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $userLat User's latitude
     * @param float $userLon User's longitude
     * @param float|null $radius Radius in kilometers
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNear($query, $userLat, $userLon, $radius = null)
    {
        $haversine = "(6371 * acos(cos(radians($userLat)) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians($userLon)) +
                    sin(radians($userLat)) * sin(radians(latitude))))";

        $query->selectRaw("*, {$haversine} AS distance")
              ->orderByRaw("{$haversine}");

        if ($radius) {
            $query->whereRaw("{$haversine} < ?", [$radius]);
        }

        return $query;
    }

    /**
     * Calculate distance using Haversine formula for a single restaurant
     *
     * @param float $userLat User's latitude
     * @param float $userLon User's longitude
     * @return float Distance in kilometers
     */
    public function getDistanceFrom($userLat, $userLon)
    {
        $lat1 = deg2rad($this->latitude);
        $lon1 = deg2rad($this->longitude);
        $lat2 = deg2rad($userLat);
        $lon2 = deg2rad($userLon);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($lat1) * cos($lat2) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round(6371 * $c, 2); // Earth radius in km
    }
}
