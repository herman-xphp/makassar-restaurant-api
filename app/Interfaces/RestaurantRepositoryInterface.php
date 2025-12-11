<?php

namespace App\Interfaces;

interface RestaurantRepositoryInterface
{
    /**
     * Get all restaurants
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRestaurants();

    /**
     * Get restaurants near a location
     *
     * @param  float  $userLat  User's latitude
     * @param  float  $userLon  User's longitude
     * @param  float|null  $radius  Radius in kilometers
     * @param  int  $limit  Number of results
     * @param  int  $offset  Offset for pagination
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRestaurantsNearLocation($userLat, $userLon, $radius = null, $limit = 10, $offset = 0);

    /**
     * Find a restaurant by ID
     *
     * @param  int  $id
     * @return \App\Models\Restaurant|null
     */
    public function findRestaurantById($id);

    /**
     * Create a new restaurant
     *
     * @return \App\Models\Restaurant
     */
    public function createRestaurant(array $data);

    /**
     * Update an existing restaurant
     *
     * @param  int  $id
     * @return \App\Models\Restaurant
     */
    public function updateRestaurant($id, array $data);

    /**
     * Delete a restaurant
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteRestaurant($id);

    /**
     * Search restaurants by query
     *
     * @param  string  $query  Search query
     * @param  array  $filters  Optional filters (cuisine_type, min_rating, etc.)
     * @param  int  $limit  Number of results to return
     * @param  float|null  $userLat  User's latitude
     * @param  float|null  $userLon  User's longitude
     * @param  int  $offset  Offset for pagination
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0);
}
