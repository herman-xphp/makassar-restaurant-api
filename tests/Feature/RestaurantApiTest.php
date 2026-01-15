<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestaurantApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_restaurants()
    {
        Restaurant::factory()->count(3)->create();

        $response = $this->getJson('/api/restaurants');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'name', 'slug', 'latitude', 'longitude']
                ],
                'count'
            ]);
    }

    /** @test */
    public function it_can_get_restaurant_by_id()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/restaurants/{$restaurant->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                     'id' => $restaurant->id,
                     'name' => $restaurant->name
                ]
            ]);
    }

    /** @test */
    public function it_can_get_restaurant_by_slug()
    {
        $restaurant = Restaurant::factory()->create(['name' => 'Unique Resto']);
        
        // Slug should be 'unique-resto'
        $response = $this->getJson("/api/restaurants/{$restaurant->slug}");

        $response->assertStatus(200)
             ->assertJson([
                'success' => true,
                'data' => [
                     'id' => $restaurant->id,
                     'name' => 'Unique Resto',
                     'slug' => 'unique-resto'
                ]
            ]);
    }

    /** @test */
    public function it_returns_404_if_restaurant_not_found()
    {
        $response = $this->getJson('/api/restaurants/99999');
        $response->assertStatus(404);
        
        $response = $this->getJson('/api/restaurants/non-existent-slug');
        $response->assertStatus(404);
    }
}
