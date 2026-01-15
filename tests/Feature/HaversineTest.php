<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HaversineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_distance_and_sorts_by_nearest()
    {
        // Reference Point: Monas, Jakarta (-6.175392, 106.827153)
        $userLat = -6.175392;
        $userLon = 106.827153;

        // Restaurant A: Near (Grand Indonesia - ~1km away)
        $nearRestaurant = Restaurant::factory()->create([
            'name' => 'Near Resto',
            'latitude' => -6.195392, // Approx 2km south (simple shift)
            'longitude' => 106.827153,
        ]);

        // Restaurant B: Far (Bandung - ~120km away)
        $farRestaurant = Restaurant::factory()->create([
            'name' => 'Far Resto',
            'latitude' => -6.917464,
            'longitude' => 107.619122,
        ]);

        // Call the scope
        $results = Restaurant::near($userLat, $userLon)->get();

        // 1. Assert Sorting
        $this->assertEquals('Near Resto', $results->first()->name);
        $this->assertEquals('Far Resto', $results->last()->name);

        // 2. Assert Distance Attribute Exists (Added by Scope)
        $this->assertNotNull($results->first()->distance);
        
        // 3. Assert Distance Value Logic (Roughly)
        // Distance difference should be significant (Near < 5km, Far > 100km)
        $this->assertTrue($results->first()->distance < 10);
        $this->assertTrue($results->last()->distance > 100);
    }
}
