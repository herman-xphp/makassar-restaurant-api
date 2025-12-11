<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\RestaurantServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantServiceInterface $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function proxyImage(string $path)
    {
        $path = storage_path('app/public/' . $path);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = file_get_contents($path);
        $type = mime_content_type($path);

        return response($file, 200)->header("Content-Type", $type);
    }

    /**
     * Get restaurant recommendations based on user's location
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        // Validate required parameters
        $request->validate([
            'user_lat' => 'required|numeric|between:-90,90',
            'user_lon' => 'required|numeric|between:-180,180',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
            'radius' => 'nullable|numeric|min:0.1',
        ]);

        $userLat = (float) $request->input('user_lat');
        $userLon = (float) $request->input('user_lon');
        $limit = (int) $request->input('limit', 10);
        $offset = (int) $request->input('offset', 0);
        $radius = $request->input('radius') ? (float) $request->input('radius') : null;

        $result = $this->restaurantService->getRestaurantRecommendations(
            $userLat,
            $userLon,
            $limit,
            $radius,
            $offset
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurant recommendations retrieved successfully',
                'data' => $result['data'],
                'count' => $result['count'],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'],
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Search restaurants by query
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1|max:255',
            'cuisine_type' => 'nullable|string|max:100',
            'min_rating' => 'nullable|numeric|min:0|max:5',
            'max_rating' => 'nullable|numeric|min:0|max:5',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
            'user_lat' => 'nullable|numeric|between:-90,90',
            'user_lon' => 'nullable|numeric|between:-180,180',
        ]);

        $query = $request->input('q');
        $filters = $request->only(['cuisine_type', 'min_rating', 'max_rating']);
        $limit = (int) $request->input('limit', 20);
        $offset = (int) $request->input('offset', 0);
        $userLat = $request->input('user_lat') ? (float) $request->input('user_lat') : null;
        $userLon = $request->input('user_lon') ? (float) $request->input('user_lon') : null;

        $result = $this->restaurantService->searchRestaurants($query, $filters, $limit, $userLat, $userLon, $offset);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Search completed successfully',
                'data' => $result['data'],
                'count' => $result['count']
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Search failed',
            'data' => []
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display a single restaurant
     */
    public function show(int $id): JsonResponse
    {
        $result = $this->restaurantService->getRestaurantById($id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data'],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'],
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * Create a new restaurant
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'cuisine_type' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        $data = $request->only([
            'name', 'description', 'address', 'latitude', 'longitude',
            'phone', 'cuisine_type', 'rating', 'review_count', 'image_url',
        ]);

        $result = $this->restaurantService->createRestaurant($data);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data'],
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'],
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Update an existing restaurant
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'sometimes|required|string|max:500',
            'latitude' => 'sometimes|required|numeric|between:-90,90',
            'longitude' => 'sometimes|required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'cuisine_type' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'review_count' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
        ]);

        $data = $request->only([
            'name', 'description', 'address', 'latitude', 'longitude',
            'phone', 'cuisine_type', 'rating', 'review_count', 'image_url',
        ]);

        $result = $this->restaurantService->updateRestaurant($id, $data);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data'],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'],
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Delete a restaurant
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->restaurantService->deleteRestaurant($id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data'],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
            'data' => $result['data'],
        ], Response::HTTP_BAD_REQUEST);
    }
}
