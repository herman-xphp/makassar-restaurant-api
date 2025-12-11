<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('cuisine_type', 'like', "%{$search}%");
            });
        }

        $restaurants = $query->latest()->paginate(10);

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

        Restaurant::create($validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil ditambahkan.');
    }

    public function show(Restaurant $restaurant)
    {
        return view('restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
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
            if ($restaurant->image_url) {
                $oldPath = str_replace('/storage/', '', $restaurant->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('restaurants', 'public');
            $validated['image_url'] = '/storage/'.$path;
        }

        unset($validated['image']);

        $restaurant->update($validated);

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil diperbarui.');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->image_url) {
            $oldPath = str_replace('/storage/', '', $restaurant->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $restaurant->delete();

        return redirect()->route('restaurants.index')
            ->with('success', 'Restoran berhasil dihapus.');
    }
}
