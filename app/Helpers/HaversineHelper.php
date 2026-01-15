<?php

namespace App\Helpers;

class HaversineHelper
{
    /**
     * Calculate the distance between two points using the Haversine formula
     * 
     * @param float $lat1 Latitude of point 1
     * @param float $lon1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lon2 Longitude of point 2
     * @param string $unit Distance unit ('km', 'miles', 'm')
     * @return float Distance in specified unit
     */
    /**
     * Get the raw SQL for Haversine formula (for Database queries)
     *
     * @param float $userLat Latitude of the user
     * @param float $userLon Longitude of the user
     * @param string $latColumn Database column for latitude
     * @param string $lonColumn Database column for longitude
     * @return string Raw SQL string
     */
    public static function getSql($userLat, $userLon, $latColumn = 'latitude', $lonColumn = 'longitude')
    {
        return "(6371 * acos(cos(radians($userLat)) * cos(radians($latColumn)) *
                cos(radians($lonColumn) - radians($userLon)) +
                sin(radians($userLat)) * sin(radians($latColumn))))";
    }

    /**
     * Calculate the distance between two points using the Haversine formula (PHP Calculation)
     * 
     * @param float $lat1 Latitude of point 1
     * @param float $lon1 Longitude of point 1
     * @param float $lat2 Latitude of point 2
     * @param float $lon2 Longitude of point 2
     * @param string $unit Distance unit ('km', 'miles', 'm')
     * @return float Distance in specified unit
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = 'km')
    {
        // Convert latitude and longitude from degrees to radians
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Haversine formula
        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($lat1) * cos($lat2) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Earth's radius in different units
        $earthRadius = [
            'km' => 6371,
            'miles' => 3959,
            'm' => 6371000
        ];

        $distance = $earthRadius[$unit] * $c;

        return round($distance, 2);
    }

    /**
     * Calculate distances for multiple coordinates against a reference point
     * 
     * @param float $refLat Reference latitude
     * @param float $refLon Reference longitude
     * @param array $coordinates Array of coordinate pairs [[lat, lon], ...]
     * @param string $unit Distance unit
     * @return array Array of calculated distances
     */
    public static function calculateDistancesBatch($refLat, $refLon, $coordinates, $unit = 'km')
    {
        $distances = [];

        foreach ($coordinates as $index => $coord) {
            $distances[$index] = self::calculateDistance(
                $refLat,
                $refLon,
                $coord[0],
                $coord[1],
                $unit
            );
        }

        return $distances;
    }
}