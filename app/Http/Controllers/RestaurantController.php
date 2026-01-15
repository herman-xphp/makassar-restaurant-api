<?php

namespace App\Http\Controllers;

use App\Interfaces\RestaurantServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRestaurantRequest;

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

    public function store(StoreRestaurantRequest $request)
    {
        $validated = $request->validated();

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

    public function update(StoreRestaurantRequest $request, $id)
    {
        $validated = $request->validated();
        
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
