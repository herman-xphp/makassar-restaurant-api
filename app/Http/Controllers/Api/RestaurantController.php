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

    /**
     * Get restaurant list (recommendations/search)
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'user_lat' => 'nullable|numeric|between:-90,90',
            'user_lon' => 'nullable|numeric|between:-180,180',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
            'radius' => 'nullable|numeric|min:0.1',
        ]);

        $userLat = $request->input('user_lat') ? (float) $request->input('user_lat') : null;
        $userLon = $request->input('user_lon') ? (float) $request->input('user_lon') : null;
        $limit = (int) $request->input('limit', 10);
        $offset = (int) $request->input('offset', 0);
        $radius = $request->input('radius') ? (float) $request->input('radius') : null;

        if ($userLat && $userLon) {
             $data = $this->restaurantService->getRestaurantRecommendations($userLat, $userLon, $limit, $radius, $offset);
        } else {
             // Fallback to simpler list if no location (could be refined)
             // Using search with empty query to verify behavior
             $data = $this->restaurantService->searchRestaurants('', [], $limit, null, null, $offset);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'count' => count($data)
        ], Response::HTTP_OK);
    }

    /**
     * Search restaurants by query
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:1|max:255',
            'cuisine_type' => 'nullable|string|max:100',
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

        $data = $this->restaurantService->searchRestaurants($query, $filters, $limit, $userLat, $userLon, $offset);

        return response()->json([
            'success' => true,
            'data' => $data,
            'count' => count($data)
        ], Response::HTTP_OK);
    }

    /**
     * Display a single restaurant by ID or Slug
     */
    public function show(string $idOrSlug): JsonResponse
    {
        if (is_numeric($idOrSlug)) {
            $restaurant = $this->restaurantService->getRestaurantById((int) $idOrSlug);
        } else {
            $restaurant = $this->restaurantService->getRestaurantBySlug($idOrSlug);
        }

        if ($restaurant) {
            return response()->json([
                'success' => true,
                'data' => $restaurant,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Restaurant not found',
        ], Response::HTTP_NOT_FOUND);
    }
    
    /**
     * Proxy image (Helper)
     */
    public function proxyImage(string $path)
    {
        // Prevent directory traversal
        if (str_contains($path, '..') || str_contains($path, '/') || str_contains($path, '\\')) {
             abort(400, 'Invalid path');
        }

        $filePath = storage_path('app/public/' . $path);

        if (!file_exists($filePath)) {
             abort(404);
        }

        return response()->file($filePath);
    }

    // Admin/Write methods (store, update, destroy) - keeping simple for now, can delegate to Service
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);
        
        // Add basic validation for others if needed

        $restaurant = $this->restaurantService->createRestaurant($request->all());

        return response()->json([
            'success' => true,
            'data' => $restaurant
        ], Response::HTTP_CREATED);
    }
}
