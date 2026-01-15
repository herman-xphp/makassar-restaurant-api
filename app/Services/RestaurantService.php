<?php

namespace App\Services;

use App\Interfaces\RestaurantRepositoryInterface;
use App\Interfaces\RestaurantServiceInterface;

class RestaurantService implements RestaurantServiceInterface
{
    private RestaurantRepositoryInterface $restaurantRepository;

    public function __construct(RestaurantRepositoryInterface $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * Get restaurant recommendations based on user's location
     */
    public function getRestaurantRecommendations($userLat, $userLon, $limit = 10, $radius = null, $offset = 0)
    {
        // Business logic: Validate coordinates?
        // For now, pass to repository
        return $this->restaurantRepository->getRestaurantsNearLocation($userLat, $userLon, $radius, $limit, $offset);
    }

    /**
     * Get a single restaurant by ID
     */
    public function getRestaurantById($id)
    {
        return $this->restaurantRepository->findRestaurantById($id);
    }

    /**
     * Get a single restaurant by Slug
     */
    public function getRestaurantBySlug($slug)
    {
        return $this->restaurantRepository->findRestaurantBySlug($slug);
    }

    /**
     * Create a new restaurant
     */
    public function createRestaurant(array $data)
    {
        // Business logic: Validation?
        return $this->restaurantRepository->createRestaurant($data);
    }

    /**
     * Update an existing restaurant
     */
    public function updateRestaurant($id, array $data)
    {
        return $this->restaurantRepository->updateRestaurant($id, $data);
    }

    /**
     * Delete a restaurant
     */
    public function deleteRestaurant($id)
    {
        return $this->restaurantRepository->deleteRestaurant($id);
    }

    /**
     * Search restaurants by query
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0)
    {
        return $this->restaurantRepository->searchRestaurants($query, $filters, $limit, $userLat, $userLon, $offset);
    }
}
