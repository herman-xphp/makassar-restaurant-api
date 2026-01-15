<?php

namespace App\Http\Controllers;

use App\Interfaces\RestaurantServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantServiceInterface $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $restaurants = $this->restaurantService->getPaginatedRestaurants(10, $search);

        return view('restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        return view('restaurants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'cuisine_type' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('restaurants', 'public');
            $validated['image_url'] = '/storage/'.$path;
        }

        unset($validated['image']);

        $this->restaurantService->createRestaurant($validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Service returns array, but views expect object? 
        // Our Repository returns Model, so Service returning Model methods is fine.
        // But our API generic methods return Arrays?
        // Let's check Service implementation. 
        // Service methods: findRestaurantById returns Model if from Repository->findRestaurantById
        
        // Wait, original Service Interface had return type "array". 
        // Repository Interface has return type "Model".
        // Let's check RestaurantService actual implementation.
        // It calls $this->restaurantRepository->findRestaurantById($id); which returns Model.
        // So it returns Model. The docblock in Service said "array" but implementation returns what Repo returns.
        // I should probably fix the docblock later, but for now it works for View.
        
        $restaurant = $this->restaurantService->getRestaurantById($id);
        
        return view('restaurants.show', compact('restaurant'));
    }

    public function edit($id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);
        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'cuisine_type' => 'nullable|string|max:100',
            'rating' => 'nullable|numeric|between:0,5',
            'review_count' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // For image handling, we might need to fetch the restaurant first
        // Ideally this logic moves to Service, but for file handling in Controller it's often easier
        // to keep file upload here and pass string URL to Service.
        
        $restaurant = $this->restaurantService->getRestaurantById($id);

        if ($request->hasFile('image')) {
            if ($restaurant->image_url) {
                // Determine old path
                $oldPath = str_replace('/storage/', '', $restaurant->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('restaurants', 'public');
            $validated['image_url'] = '/storage/'.$path;
        }

        unset($validated['image']);

        $this->restaurantService->updateRestaurant($id, $validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);
        
        if ($restaurant->image_url) {
            $oldPath = str_replace('/storage/', '', $restaurant->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $this->restaurantService->deleteRestaurant($id);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil dihapus.');
    }
}
