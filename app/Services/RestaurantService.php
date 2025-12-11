<?php

namespace App\Services;

use App\Interfaces\RestaurantRepositoryInterface;
use App\Interfaces\RestaurantServiceInterface;

class RestaurantService implements RestaurantServiceInterface
{
    protected $restaurantRepository;

    public function __construct(RestaurantRepositoryInterface $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    /**
     * Get restaurant recommendations based on user's location
     *
     * @param  float  $userLat  User's latitude
     * @param  float  $userLon  User's longitude
     * @param  int  $limit  Number of restaurants to return
     * @param  float|null  $radius  Radius in kilometers
     * @param  int  $offset  Offset for pagination
     * @return array
     */
    public function getRestaurantRecommendations($userLat, $userLon, $limit = 10, $radius = null, $offset = 0)
    {
        $restaurants = $this->restaurantRepository->getRestaurantsNearLocation($userLat, $userLon, $radius, $limit, $offset);

        // Transform the data to ensure consistent format
        $result = [];
        foreach ($restaurants as $restaurant) {
            $restaurantData = $restaurant->toArray();

            // Make sure distance is properly formatted if available
            if (isset($restaurant->distance)) {
                $restaurantData['distance'] = round($restaurant->distance, 2);
            }

            $result[] = $restaurantData;
        }

        return [
            'success' => true,
            'data' => $result,
            'count' => count($result),
        ];
    }

    /**
     * Get a single restaurant by ID
     *
     * @param  int  $id
     * @return array
     */
    public function getRestaurantById($id)
    {
        $restaurant = $this->restaurantRepository->findRestaurantById($id);

        if (! $restaurant) {
            return [
                'success' => false,
                'message' => 'Restaurant not found',
                'data' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Restaurant retrieved successfully',
            'data' => $restaurant->toArray(),
        ];
    }

    /**
     * Create a new restaurant
     *
     * @return array
     */
    public function createRestaurant(array $data)
    {
        try {
            $restaurant = $this->restaurantRepository->createRestaurant($data);

            return [
                'success' => true,
                'message' => 'Restaurant created successfully',
                'data' => $restaurant->toArray(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to create restaurant: '.$e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Update an existing restaurant
     *
     * @param  int  $id
     * @return array
     */
    public function updateRestaurant($id, array $data)
    {
        try {
            $restaurant = $this->restaurantRepository->updateRestaurant($id, $data);

            if (! $restaurant) {
                return [
                    'success' => false,
                    'message' => 'Restaurant not found',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Restaurant updated successfully',
                'data' => $restaurant->toArray(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to update restaurant: '.$e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Delete a restaurant
     *
     * @param  int  $id
     * @return array
     */
    public function deleteRestaurant($id)
    {
        try {
            $deleted = $this->restaurantRepository->deleteRestaurant($id);

            if (! $deleted) {
                return [
                    'success' => false,
                    'message' => 'Restaurant not found',
                    'data' => null,
                ];
            }

            return [
                'success' => true,
                'message' => 'Restaurant deleted successfully',
                'data' => null,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete restaurant: '.$e->getMessage(),
                'data' => null,
            ];
        }
    }

    /**
     * Search restaurants by query
     *
     * @param  string  $query  Search query
     * @param  array  $filters  Optional filters
     * @param  int  $limit  Number of results to return
     * @param  float|null  $userLat  User's latitude
     * @param  float|null  $userLon  User's longitude
     * @param  int  $offset  Offset for pagination
     * @return array
     */
    public function searchRestaurants(string $query, array $filters = [], int $limit = 20, $userLat = null, $userLon = null, int $offset = 0)
    {
        try {
            $restaurants = $this->restaurantRepository->searchRestaurants($query, $filters, $limit, $userLat, $userLon, $offset);

            $result = [];
            foreach ($restaurants as $restaurant) {
                $restaurantData = $restaurant->toArray();

                // Add distance if it was calculated
                if (isset($restaurant->distance)) {
                    $restaurantData['distance'] = round($restaurant->distance, 2);
                }

                $result[] = $restaurantData;
            }

            return [
                'success' => true,
                'data' => $result,
                'count' => count($result),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Search failed: '.$e->getMessage(),
                'data' => [],
                'count' => 0,
            ];
        }
    }
}
