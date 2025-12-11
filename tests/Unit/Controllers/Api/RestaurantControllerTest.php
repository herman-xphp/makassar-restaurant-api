<?php

namespace Tests\Unit\Controllers\Api;

use Tests\TestCase;
use App\Models\Restaurant;
use App\Interfaces\RestaurantServiceInterface;
use Mockery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RestaurantControllerTest extends TestCase
{
    protected $restaurantService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->restaurantService = Mockery::mock(RestaurantServiceInterface::class);
        $this->controller = new \App\Http\Controllers\Api\RestaurantController($this->restaurantService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_recommendations_success(): void
    {
        // Arrange
        $request = new Request([
            'user_lat' => -5.147754,
            'user_lon' => 119.432711,
            'limit' => 10,
            'radius' => 5.0
        ]);

        $expectedResult = [
            'success' => true,
            'message' => 'Restaurant recommendations retrieved successfully',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Sop Saudara',
                    'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
                    'latitude' => -5.147754,
                    'longitude' => 119.432711,
                    'distance' => 0.0,
                ]
            ],
            'count' => 1
        ];

        $this->restaurantService
            ->shouldReceive('getRestaurantRecommendations')
            ->with(-5.147754, 119.432711, 10, 5.0)
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->getRecommendations($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertArrayHasKey('count', $responseData);
    }

    public function test_get_recommendations_with_validation_error(): void
    {
        // Arrange
        $request = new Request([
            'user_lat' => 'invalid_lat', // Invalid latitude
            'user_lon' => 'invalid_lon', // Invalid longitude
        ]);

        // Act & Assert
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        
        $response = $this->controller->getRecommendations($request);
    }

    public function test_show_success(): void
    {
        // Arrange
        $restaurantId = 1;
        $expectedResult = [
            'success' => true,
            'message' => 'Restaurant retrieved successfully',
            'data' => [
                'id' => 1,
                'name' => 'Sop Saudara',
                'address' => 'Jl. Sultan Hasanuddin No. 85, Makassar',
                'latitude' => -5.147754,
                'longitude' => 119.432711,
            ]
        ];

        $this->restaurantService
            ->shouldReceive('getRestaurantById')
            ->with($restaurantId)
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->show($restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('data', $responseData);
    }

    public function test_show_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID
        $expectedResult = [
            'success' => false,
            'message' => 'Restaurant not found',
            'data' => null
        ];

        $this->restaurantService
            ->shouldReceive('getRestaurantById')
            ->with($restaurantId)
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->show($restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertFalse($responseData['success']);
        $this->assertNull($responseData['data']);
    }

    public function test_store_success(): void
    {
        // Arrange
        $request = new Request([
            'name' => 'New Restaurant',
            'description' => 'A new restaurant in Makassar',
            'address' => 'Jl. Example No. 123, Makassar',
            'latitude' => -5.147754,
            'longitude' => 119.432711,
            'phone' => '+62411-123456',
            'cuisine_type' => 'Indonesian',
            'rating' => 4.5,
            'review_count' => 10,
            'image_url' => 'https://example.com/images/restaurant.jpg'
        ]);

        $expectedResult = [
            'success' => true,
            'message' => 'Restaurant created successfully',
            'data' => [
                'id' => 21,
                'name' => 'New Restaurant',
                'description' => 'A new restaurant in Makassar',
                'address' => 'Jl. Example No. 123, Makassar',
                'latitude' => -5.147754,
                'longitude' => 119.432711,
                'phone' => '+62411-123456',
                'cuisine_type' => 'Indonesian',
                'rating' => 4.5,
                'review_count' => 10,
                'image_url' => 'https://example.com/images/restaurant.jpg'
            ]
        ];

        $this->restaurantService
            ->shouldReceive('createRestaurant')
            ->with(Mockery::on(function ($data) {
                return $data['name'] === 'New Restaurant' &&
                       $data['latitude'] === -5.147754 &&
                       $data['longitude'] === 119.432711;
            }))
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->store($request);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
        $this->assertArrayHasKey('data', $responseData);
    }

    public function test_store_validation_error(): void
    {
        // Arrange
        $request = new Request([
            'name' => '', // Required field empty
            'latitude' => 'invalid_lat', // Invalid latitude format
            'longitude' => 'invalid_lon', // Invalid longitude format
        ]);

        // Act & Assert
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        
        $response = $this->controller->store($request);
    }

    public function test_update_success(): void
    {
        // Arrange
        $restaurantId = 1;
        $request = new Request([
            'name' => 'Updated Restaurant Name',
            'rating' => 4.8
        ]);

        $expectedResult = [
            'success' => true,
            'message' => 'Restaurant updated successfully',
            'data' => [
                'id' => 1,
                'name' => 'Updated Restaurant Name',
                'rating' => 4.8
            ]
        ];

        $this->restaurantService
            ->shouldReceive('updateRestaurant')
            ->with($restaurantId, Mockery::on(function ($data) {
                return $data['name'] === 'Updated Restaurant Name' &&
                       $data['rating'] === 4.8;
            }))
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->update($request, $restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
    }

    public function test_update_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID
        $request = new Request([
            'name' => 'Updated Restaurant Name'
        ]);

        $expectedResult = [
            'success' => false,
            'message' => 'Restaurant not found',
            'data' => null
        ];

        $this->restaurantService
            ->shouldReceive('updateRestaurant')
            ->with($restaurantId, Mockery::on(function ($data) {
                return $data['name'] === 'Updated Restaurant Name';
            }))
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->update($request, $restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertFalse($responseData['success']);
    }

    public function test_destroy_success(): void
    {
        // Arrange
        $restaurantId = 1;
        $expectedResult = [
            'success' => true,
            'message' => 'Restaurant deleted successfully',
            'data' => null
        ];

        $this->restaurantService
            ->shouldReceive('deleteRestaurant')
            ->with($restaurantId)
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->destroy($restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
    }

    public function test_destroy_not_found(): void
    {
        // Arrange
        $restaurantId = 999; // Non-existing restaurant ID
        $expectedResult = [
            'success' => false,
            'message' => 'Restaurant not found',
            'data' => null
        ];

        $this->restaurantService
            ->shouldReceive('deleteRestaurant')
            ->with($restaurantId)
            ->andReturn($expectedResult);

        // Act
        $response = $this->controller->destroy($restaurantId);

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertFalse($responseData['success']);
    }
}