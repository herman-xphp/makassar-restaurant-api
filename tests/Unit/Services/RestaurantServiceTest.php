<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Restaurant;
use App\Interfaces\RestaurantRepositoryInterface;
use App\Services\RestaurantService;
use Mockery;
use Illuminate\Support\Collection;

class RestaurantServiceTest extends TestCase
{
    protected $restaurantRepository;
    protected $restaurantService;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->restaurantRepository = Mockery::mock(RestaurantRepositoryInterface::class);
        $this->restaurantService = new RestaurantService($this->restaurantRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_restaurant_recommendations_success(): void
    {
        // Arrange
        $userLat = -5.147754;
        $userLon = 119.432711;
        $limit = 10;
        $radius = 5.0;

        $mockRestaurants = collect([
            new Restaurant([
                'id' => 1,
                'name' => 'Sop Saudara',
                'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
                'latitude' => -5.147754,
                'longitude' => 119.432711,
                'distance' => 0.0
            ])
        ]);

        $this->restaurantRepository
            ->shouldReceive('getRestaurantsNearLocation')
            ->with($userLat, $userLon, $radius)
            ->andReturn($mockRestaurants);

        // Act
        $result = $this->restaurantService->getRestaurantRecommendations($userLat, $userLon, $limit, $radius);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('count', $result);
        $this->assertEquals(1, $result['count']);
    }

    public function test_get_restaurant_recommendations_success_without_radius(): void
    {
        // Arrange
        $userLat = -5.147754;
        $userLon = 119.432711;
        $limit = 10;
        $radius = null;

        $mockRestaurants = collect([
            new Restaurant([
                'id' => 1,
                'name' => 'Sop Saudara',
                'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
                'latitude' => -5.147754,
                'longitude' => 119.432711,
            ])
        ]);

        $this->restaurantRepository
            ->shouldReceive('getRestaurantsNearLocation')
            ->with($userLat, $userLon, $radius)
            ->andReturn($mockRestaurants);

        // Act
        $result = $this->restaurantService->getRestaurantRecommendations($userLat, $userLon, $limit, $radius);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('count', $result);
    }

    public function test_get_restaurant_by_id_success(): void
    {
        // Arrange
        $restaurantId = 1;
        $mockRestaurant = new Restaurant([
            'id' => 1,
            'name' => 'Sop Saudara',
            'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
        ]);

        $this->restaurantRepository
            ->shouldReceive('findRestaurantById')
            ->with($restaurantId)
            ->andReturn($mockRestaurant);

        // Act
        $result = $this->restaurantService->getRestaurantById($restaurantId);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('Sop Saudara', $result['data']['name']);
    }

    public function test_get_restaurant_by_id_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID

        $this->restaurantRepository
            ->shouldReceive('findRestaurantById')
            ->with($restaurantId)
            ->andReturn(null);

        // Act
        $result = $this->restaurantService->getRestaurantById($restaurantId);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertEquals('Restaurant not found', $result['message']);
    }

    public function test_create_restaurant_success(): void
    {
        // Arrange
        $data = [
            'name' => 'New Restaurant',
            'address' => 'Jl. Example No. 123, Makassar',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
        ];

        $mockRestaurant = new Restaurant($data);
        $mockRestaurant->id = 21;

        $this->restaurantRepository
            ->shouldReceive('createRestaurant')
            ->with($data)
            ->andReturn($mockRestaurant);

        // Act
        $result = $this->restaurantService->createRestaurant($data);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('New Restaurant', $result['data']['name']);
    }

    public function test_create_restaurant_failure(): void
    {
        // Arrange
        $data = [
            'name' => 'New Restaurant',
            'address' => 'Jl. Example No. 123, Makassar',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
        ];

        $this->restaurantRepository
            ->shouldReceive('createRestaurant')
            ->with($data)
            ->andThrow(new \Exception('Database error'));

        // Act
        $result = $this->restaurantService->createRestaurant($data);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertStringContainsString('Failed to create restaurant', $result['message']);
    }

    public function test_update_restaurant_success(): void
    {
        // Arrange
        $restaurantId = 1;
        $data = [
            'name' => 'Updated Restaurant Name',
            'rating' => 4.8
        ];

        $mockRestaurant = new Restaurant([
            'id' => 1,
            'name' => 'Updated Restaurant Name',
            'rating' => 4.8
        ]);

        $this->restaurantRepository
            ->shouldReceive('updateRestaurant')
            ->with($restaurantId, $data)
            ->andReturn($mockRestaurant);

        // Act
        $result = $this->restaurantService->updateRestaurant($restaurantId, $data);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('Updated Restaurant Name', $result['data']['name']);
    }

    public function test_update_restaurant_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID
        $data = [
            'name' => 'Updated Restaurant Name'
        ];

        $this->restaurantRepository
            ->shouldReceive('updateRestaurant')
            ->with($restaurantId, $data)
            ->andReturn(null);

        // Act
        $result = $this->restaurantService->updateRestaurant($restaurantId, $data);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertEquals('Restaurant not found', $result['message']);
    }

    public function test_update_restaurant_failure(): void
    {
        // Arrange
        $restaurantId = 1;
        $data = [
            'name' => 'Updated Restaurant Name'
        ];

        $this->restaurantRepository
            ->shouldReceive('updateRestaurant')
            ->with($restaurantId, $data)
            ->andThrow(new \Exception('Database error'));

        // Act
        $result = $this->restaurantService->updateRestaurant($restaurantId, $data);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertStringContainsString('Failed to update restaurant', $result['message']);
    }

    public function test_delete_restaurant_success(): void
    {
        // Arrange
        $restaurantId = 1;

        $this->restaurantRepository
            ->shouldReceive('deleteRestaurant')
            ->with($restaurantId)
            ->andReturn(true);

        // Act
        $result = $this->restaurantService->deleteRestaurant($restaurantId);

        // Assert
        $this->assertTrue($result['success']);
        $this->assertNull($result['data']);
    }

    public function test_delete_restaurant_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID

        $this->restaurantRepository
            ->shouldReceive('deleteRestaurant')
            ->with($restaurantId)
            ->andReturn(false);

        // Act
        $result = $this->restaurantService->deleteRestaurant($restaurantId);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertEquals('Restaurant not found', $result['message']);
    }

    public function test_delete_restaurant_failure(): void
    {
        // Arrange
        $restaurantId = 1;

        $this->restaurantRepository
            ->shouldReceive('deleteRestaurant')
            ->with($restaurantId)
            ->andThrow(new \Exception('Database error'));

        // Act
        $result = $this->restaurantService->deleteRestaurant($restaurantId);

        // Assert
        $this->assertFalse($result['success']);
        $this->assertNull($result['data']);
        $this->assertStringContainsString('Failed to delete restaurant', $result['message']);
    }
}