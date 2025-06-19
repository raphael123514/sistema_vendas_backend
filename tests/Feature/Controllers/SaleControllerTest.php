<?php

namespace Tests\Feature\Controllers;

use App\Models\Sale;
use App\Models\Seller;
use App\Models\User;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    public function test_can_list_sales_with_pagination(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        $sales = Sale::factory()->count(20)->create([
            'seller_id' => $seller->id,
        ]);

        $response = $this->getJson('/api/sales?page=2&per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'seller_id',
                        'amount',
                        'date',
                        'seller' => [
                            'id',
                            'name',
                            'email',
                        ],
                    ],
                ],
                'links',
                'meta',
            ])
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonCount(10, 'data');
    }

    public function test_can_create_sale(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        $saleData = [
            'seller_id' => $seller->id,
            'amount' => 150.75,
            'date' => '2025-06-19',
        ];

        $response = $this->postJson('/api/sales', $saleData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'seller_id',
                    'amount',
                    'date',
                    'seller' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('sales', [
            'seller_id' => $seller->id,
            'amount' => 150.75,
            'date' => '2025-06-19',
        ]);
    }

    public function test_cannot_create_sale_with_invalid_data(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $invalidData = [
            'seller_id' => 999,
            'amount' => -100,
            'date' => 'invalid-date',
        ];

        $response = $this->postJson('/api/sales', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['seller_id', 'amount', 'date']);
    }

    public function test_pagination_defaults_to_fifteen_items(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        Sale::factory()->count(20)->create([
            'seller_id' => $seller->id,
        ]);

        $response = $this->getJson('/api/sales');

        $response->assertStatus(200)
            ->assertJsonPath('meta.per_page', 15)
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonCount(15, 'data');
    }

    public function test_can_specify_custom_per_page_value(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        Sale::factory()->count(20)->create([
            'seller_id' => $seller->id,
        ]);

        $response = $this->getJson('/api/sales?per_page=5');

        $response->assertStatus(200)
            ->assertJsonPath('meta.per_page', 5)
            ->assertJsonCount(5, 'data');
    }
}
