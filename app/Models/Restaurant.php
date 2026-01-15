<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($restaurant) {
            if (empty($restaurant->slug)) {
                $restaurant->slug = \Illuminate\Support\Str::slug($restaurant->name);
            }
        });

        static::updating(function ($restaurant) {
            if ($restaurant->isDirty('name') && !$restaurant->isDirty('slug')) {
                $restaurant->slug = \Illuminate\Support\Str::slug($restaurant->name);
            }
        });
    }

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
        $haversine = \App\Helpers\HaversineHelper::getSql($userLat, $userLon);

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
    /**
     * Get the restaurant's image URL.
     *
     * @param  string|null  $value
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        return $value ?: '/images/default-restaurant.png';
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
