<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_slug_automatically_when_creating_restaurant()
    {
        $restaurant = Restaurant::create([
            'name' => 'Coto Nusantara',
            'address' => 'Jl. Nusantara',
            'latitude' => -5.147665,
            'longitude' => 119.432731,
        ]);

        $this->assertEquals('coto-nusantara', $restaurant->slug);
    }

    /** @test */
    public function it_updates_slug_when_name_is_updated()
    {
        $restaurant = Restaurant::create([
            'name' => 'Coto Nusantara',
            'address' => 'Jl. Nusantara',
            'latitude' => -5.147665,
            'longitude' => 119.432731,
        ]);

        $restaurant->update(['name' => 'Coto Paraikatte']);

        $this->assertEquals('coto-paraikatte', $restaurant->fresh()->slug);
    }

    /** @test */
    public function it_does_not_update_slug_if_name_is_not_changed()
    {
        $restaurant = Restaurant::create([
            'name' => 'Coto Nusantara',
            'address' => 'Jl. Nusantara',
            'latitude' => -5.147665,
            'longitude' => 119.432731,
        ]);

        $originalSlug = $restaurant->slug; // coto-nusantara

        $restaurant->update(['description' => 'Best Coto in town']);

        $this->assertEquals($originalSlug, $restaurant->fresh()->slug);
    }
}
