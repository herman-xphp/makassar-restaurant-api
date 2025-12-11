<?php

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RestaurantRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $restaurantRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->restaurantRepository = new RestaurantRepository();
    }

    public function test_get_all_restaurants(): void
    {
        // Arrange
        Restaurant::factory()->count(3)->create();

        // Act
        $result = $this->restaurantRepository->getAllRestaurants();

        // Assert
        $this->assertCount(3, $result);
    }

    public function test_get_restaurants_near_location_with_radius(): void
    {
        // Arrange
        $testRestaurant = Restaurant::factory()->create([
            'name' => 'Test Restaurant',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
        ]);

        Restaurant::factory()->create([
            'name' => 'Far Restaurant',
            'latitude' => -0.523558,  // Jakarta coordinates
            'longitude' => 106.702836,
        ]);

        // Act
        $result = $this->restaurantRepository->getRestaurantsNearLocation(
            -5.1544064,  // User's lat close to test restaurant
            119.455744,  // User's lon close to test restaurant
            10.0  // 10km radius
        );

        // Assert
        $this->assertGreaterThanOrEqual(1, $result->count());
        $this->assertTrue($result->contains('id', $testRestaurant->id));
    }

    public function test_get_restaurants_near_location_without_radius(): void
    {
        // Arrange
        $testRestaurant = Restaurant::factory()->create([
            'name' => 'Test Restaurant',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
        ]);

        // Act
        $result = $this->restaurantRepository->getRestaurantsNearLocation(
            -5.1544064,  // User's lat
            119.455744   // User's lon
        );

        // Assert
        $this->assertGreaterThanOrEqual(1, $result->count());
        $this->assertTrue($result->contains('id', $testRestaurant->id));
    }

    public function test_find_restaurant_by_id_found(): void
    {
        // Arrange
        $restaurant = Restaurant::factory()->create();

        // Act
        $result = $this->restaurantRepository->findRestaurantById($restaurant->id);

        // Assert
        $this->assertInstanceOf(Restaurant::class, $result);
        $this->assertEquals($restaurant->id, $result->id);
    }

    public function test_find_restaurant_by_id_not_found(): void
    {
        // Act
        $result = $this->restaurantRepository->findRestaurantById(99999);

        // Assert
        $this->assertNull($result);
    }

    public function test_create_restaurant(): void
    {
        // Arrange
        $data = [
            'name' => 'New Test Restaurant',
            'description' => 'Test description',
            'address' => 'Test Address, Makassar',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
            'phone' => '+621234567890',
            'cuisine_type' => 'Indonesian',
            'rating' => 4.5,
            'review_count' => 10,
            'image_url' => 'https://example.com/image.jpg'
        ];

        // Act
        $result = $this->restaurantRepository->createRestaurant($data);

        // Assert
        $this->assertInstanceOf(Restaurant::class, $result);
        $this->assertEquals('New Test Restaurant', $result->name);
        $this->assertEquals('Test Address, Makassar', $result->address);
        $this->assertEquals(-5.147754, $result->latitude);
        $this->assertEquals(119.432711, $result->longitude);
    }

    public function test_update_restaurant_found(): void
    {
        // Arrange
        $restaurant = Restaurant::factory()->create([
            'name' => 'Original Name',
        ]);

        $newData = [
            'name' => 'Updated Name',
            'rating' => 4.8
        ];

        // Act
        $result = $this->restaurantRepository->updateRestaurant($restaurant->id, $newData);

        // Assert
        $this->assertInstanceOf(Restaurant::class, $result);
        $this->assertEquals('Updated Name', $result->name);
        $this->assertEquals(4.8, $result->rating);
    }

    public function test_update_restaurant_not_found(): void
    {
        // Act
        $result = $this->restaurantRepository->updateRestaurant(99999, [
            'name' => 'Updated Name'
        ]);

        // Assert
        $this->assertNull($result);
    }

    public function test_delete_restaurant_found(): void
    {
        // Arrange
        $restaurant = Restaurant::factory()->create();

        // Act
        $result = $this->restaurantRepository->deleteRestaurant($restaurant->id);

        // Assert
        $this->assertTrue($result);
        $this->assertNull(Restaurant::find($restaurant->id));
    }

    public function test_delete_restaurant_not_found(): void
    {
        // Act
        $result = $this->restaurantRepository->deleteRestaurant(99999);

        // Assert
        $this->assertFalse($result);
    }
}