<?php

namespace App\Interfaces;

interface RestaurantServiceInterface
{
    /**
     * Get restaurant recommendations based on user's location
     *
     * @param float $userLat User's latitude
     * @param float $userLon User's longitude
     * @param int $limit Number of restaurants to return
     * @param float|null $radius Radius in kilometers
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getRestaurantRecommendations($userLat, $userLon, $limit = 10, $radius = null, $offset = 0);

    /**
     * Get a single restaurant by ID
     *
     * @param int $id
     * @return array
     */
    public function getRestaurantById($id);

    /**
     * Get a single restaurant by Slug
     *
     * @param string $slug
     * @return array
     */
    public function getRestaurantBySlug($slug);

    /**
     * Create a new restaurant
     *
     * @param array $data
     * @return array
     */
    public function createRestaurant(array $data);

    /**
     * Update an existing restaurant
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updateRestaurant($id, array $data);

    /**
     * Delete a restaurant
     *
     * @param int $id
     * @return array
     */
    public function deleteRestaurant($id);

    /**
     * Search restaurants by query
     *
     * @param string $query Search query
     * @param array $filters Optional filters
     * @param int $limit Number of results to return
     * @param float|null $userLat User's latitude
     * @param float|null $userLon User's longitude
     * @param int $offset Offset for pagination
     * @return array
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0);

    /**
     * Get paginated restaurants (for Admin Dashboard)
     *
     * @param int $perPage
     * @param string|null $search
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedRestaurants($perPage = 10, $search = null);
}
