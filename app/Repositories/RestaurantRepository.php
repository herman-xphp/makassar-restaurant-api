<?php

namespace App\Repositories;

use App\Interfaces\RestaurantRepositoryInterface;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

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
     * Get restaurants near a location using Haversine
     *
     * @param  float  $userLat
     * @param  float  $userLon
     * @param  float|null  $radius
     * @param  int  $limit
     * @param  int  $offset
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRestaurantsNearLocation($userLat, $userLon, $radius = null, $limit = 10, $offset = 0)
    {
        return Restaurant::near($userLat, $userLon, $radius)
            ->skip($offset)
            ->take($limit)
            ->get();
    }

    /**
     * Find a restaurant by ID
     *
     * @param  int  $id
     * @return \App\Models\Restaurant|null
     */
    public function findRestaurantById($id)
    {
        return Restaurant::find($id);
    }
    
    /**
     * Find a restaurant by Slug
     *
     * @param  string  $slug
     * @return \App\Models\Restaurant|null
     */
    public function findRestaurantBySlug($slug)
    {
        return Restaurant::where('slug', $slug)->first();
    }

    /**
     * Create a new restaurant
     *
     * @param  array  $data
     * @return \App\Models\Restaurant
     */
    public function createRestaurant(array $data)
    {
        return Restaurant::create($data);
    }

    /**
     * Update an existing restaurant
     *
     * @param  int  $id
     * @param  array  $data
     * @return \App\Models\Restaurant
     */
    public function updateRestaurant($id, array $data)
    {
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->update($data);
            return $restaurant;
        }
        return null;
    }

    /**
     * Delete a restaurant
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteRestaurant($id)
    {
        return Restaurant::destroy($id);
    }

    /**
     * Search restaurants by query
     *
     * @param  string  $query
     * @param  array  $filters
     * @param  int  $limit
     * @param  float|null  $userLat
     * @param  float|null  $userLon
     * @param  int  $offset
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0)
    {
        $builder = Restaurant::query();

        $builder->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('cuisine_type', 'like', "%{$query}%");
        });

        // Apply filters
        if (!empty($filters['cuisine_type'])) {
            $builder->where('cuisine_type', $filters['cuisine_type']);
        }

        // Apply sorting
        if ($userLat && $userLon) {
             $builder->near($userLat, $userLon);
        } else {
             $builder->orderBy('rating', 'desc');
        }

        return $builder->skip($offset)->take($limit)->get();
    }
}
