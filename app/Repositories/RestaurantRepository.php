<?php

namespace App\Repositories;

use App\Interfaces\RestaurantRepositoryInterface;
use App\Models\Restaurant;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    /**
     * Get all restaurants
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRestaurants()
    {
        return Restaurant::all();
    }

    /**
     * Get restaurants near a location
     *
     * @param float $userLat User's latitude
     * @param float $userLon User's longitude
     * @param float|null $radius Radius in kilometers
     * @param int $limit Number of results
     * @param int $offset Offset for pagination
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRestaurantsNearLocation($userLat, $userLon, $radius = null, $limit = 10, $offset = 0)
    {
        $query = Restaurant::query();

        if ($radius !== null) {
            $query = $query->near($userLat, $userLon, $radius);
        } else {
            $query = $query->near($userLat, $userLon);
        }

        return $query->offset($offset)->limit($limit)->get();
    }

    /**
     * Find a restaurant by ID
     *
     * @param int $id
     * @return \App\Models\Restaurant|null
     */
    public function findRestaurantById($id)
    {
        return Restaurant::find($id);
    }

    /**
     * Create a new restaurant
     *
     * @param array $data
     * @return \App\Models\Restaurant
     */
    public function createRestaurant(array $data)
    {
        return Restaurant::create($data);
    }

    /**
     * Update an existing restaurant
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Restaurant
     */
    public function updateRestaurant($id, array $data)
    {
        $restaurant = $this->findRestaurantById($id);

        if ($restaurant) {
            $restaurant->update($data);
            return $restaurant;
        }

        return null;
    }

    /**
     * Delete a restaurant
     *
     * @param int $id
     * @return bool
     */
    public function deleteRestaurant($id)
    {
        $restaurant = $this->findRestaurantById($id);

        if ($restaurant) {
            return $restaurant->delete();
        }

        return false;
    }

    /**
     * Search restaurants by query
     *
     * @param string $query Search query
     * @param array $filters Optional filters (cuisine_type, min_rating, etc.)
     * @param int $limit Number of results to return
     * @param float|null $userLat User's latitude
     * @param float|null $userLon User's longitude
     * @param int $offset Offset for pagination
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0)
    {
        $searchQuery = Restaurant::query();

        // Add distance calculation if location is provided
        if ($userLat !== null && $userLon !== null) {
            $searchQuery->selectRaw(
                "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
                [$userLat, $userLon, $userLat]
            );
        }

        // Search in name, description, address, and cuisine_type
        if (!empty($query)) {
            $searchQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('address', 'LIKE', "%{$query}%")
                  ->orWhere('cuisine_type', 'LIKE', "%{$query}%");
            });
        }

        // Apply optional filters
        if (!empty($filters['cuisine_type'])) {
            $searchQuery->where('cuisine_type', 'LIKE', "%{$filters['cuisine_type']}%");
        }

        if (!empty($filters['min_rating'])) {
            $searchQuery->where('rating', '>=', (float) $filters['min_rating']);
        }

        if (!empty($filters['max_rating'])) {
            $searchQuery->where('rating', '<=', (float) $filters['max_rating']);
        }

        // Order by distance if location provided, otherwise by rating
        if ($userLat !== null && $userLon !== null) {
            $searchQuery->orderBy('distance', 'asc');
        } else {
            $searchQuery->orderBy('rating', 'desc')
                        ->orderBy('name', 'asc');
        }

        return $searchQuery->offset($offset)->limit($limit)->get();
    }
}
