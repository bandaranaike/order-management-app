<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Jobs\SendOrderToBeeceptor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the create order method.
     *
     * @return void
     */
    public function testCreateOrder()
    {
        // Fake the job queue
        Queue::fake();

        // Create a test user
        $user = User::factory()->create();

        // Mock request data
        $data = [
            'customer_name' => 'Saman Kumara',
            'order_value' => 100,
        ];

        // Mock the HTTP request to Beeceptor
        Http::fake([
            'https://beeceptor.com/*' => Http::response(['success' => true]),
        ]);

        // Call the create method with authentication
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/order', $data);

        // Assert the order was created
        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Saman Kumara',
            'order_value' => 100,
            'order_status' => 'Processing'
        ]);

        // Assert the job was dispatched
        Queue::assertPushed(SendOrderToBeeceptor::class);

        // Assert the response structure
        $response->assertJsonStructure([
            'Order_ID',
            'Process_ID',
            'Status',
        ]);
    }
}
