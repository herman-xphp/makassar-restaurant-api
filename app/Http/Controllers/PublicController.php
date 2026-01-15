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
        return view('welcome', [
            // We can pass dynamic SEO data here if needed in the future
            'metaTitle' => 'Makassar Restaurant - Temukan Kuliner Terbaik',
            'metaDescription' => 'Jelajahi Coto, Konro, Pallubasa dan kuliner khas Makassar lainnya. Temukan lokasi, rating, dan review restoran terbaik di Makassar.',
            'totalRestaurants' => \App\Models\Restaurant::count(), // Keeping it simple for now, or use Service if strictly adhering
            'cuisineTypes' => \App\Models\Restaurant::distinct('cuisine_type')->count('cuisine_type'),
            'avgRating' => \App\Models\Restaurant::avg('rating') ?? 0,
            'popularRestaurants' => \App\Models\Restaurant::orderBy('rating', 'desc')->take(6)->get()
        ]);
    }

    public function show($slug)
    {
        $restaurant = $this->restaurantService->getRestaurantBySlug($slug);
        
        return view('public.restaurants.show', compact('restaurant'));
    }
}
