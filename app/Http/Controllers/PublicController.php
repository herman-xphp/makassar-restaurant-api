<?php

namespace App\Http\Controllers;

use App\Interfaces\RestaurantServiceInterface;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantServiceInterface $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index()
    {
        $stats = $this->restaurantService->getStats();
        $popularRestaurants = $this->restaurantService->getPopularRestaurants(6);

        return view('welcome', [
            // We can pass dynamic SEO data here if needed in the future
            'metaTitle' => 'Makassar Restaurant - Temukan Kuliner Terbaik',
            'metaDescription' => 'Jelajahi Coto, Konro, Pallubasa dan kuliner khas Makassar lainnya. Temukan lokasi, rating, dan review restoran terbaik di Makassar.',
            'totalRestaurants' => $stats['total'],
            'cuisineTypes' => $stats['cuisine_types'],
            'avgRating' => $stats['avg_rating'],
            'popularRestaurants' => $popularRestaurants
        ]);
    }

    public function show($slug)
    {
        $restaurant = $this->restaurantService->getRestaurantBySlug($slug);
        
        return view('public.restaurants.show', compact('restaurant'));
    }
}
