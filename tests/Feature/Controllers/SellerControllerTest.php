<?php

namespace Tests\Feature\Controllers;

use App\Models\Sale;
use App\Models\Seller;
use App\Models\User;
use Tests\TestCase;

class SellerControllerTest extends TestCase
{
    public function test_can_list_sellers_with_pagination(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        Seller::factory()->count(20)->create();
        $response = $this->getJson('/api/sellers?page=2&per_page=10');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ])
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonCount(10, 'data');
    }

    public function test_can_create_seller(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Novo Vendedor',
            'email' => 'novo@email.com',
        ];
        $response = $this->postJson('/api/sellers', $data);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            ]);
        $this->assertDatabaseHas('sellers', $data);
    }

    public function test_cannot_create_seller_with_invalid_data(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => '',
            'email' => 'not-an-email',
        ];
        $response = $this->postJson('/api/sellers', $data);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email']);
    }

    public function test_can_show_seller(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        $response = $this->getJson("/api/sellers/{$seller->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            ])
            ->assertJsonPath('data.id', $seller->id);
    }

    public function test_can_list_sales_of_seller(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $seller = Seller::factory()->create();
        Sale::factory()->count(5)->create(['seller_id' => $seller->id]);
        $response = $this->getJson("/api/sellers/{$seller->id}/sales");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'seller_id', 'amount', 'date', 'created_at', 'updated_at'],
                ],
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_can_filter_sellers_by_name(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        Seller::factory()->create(['name' => 'João da Silva']);
        Seller::factory()->create(['name' => 'Maria Oliveira']);
        Seller::factory()->create(['name' => 'Joana Souza']);

        $response = $this->getJson('/api/sellers?name=jo');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ]);
        $names = array_column($response->json('data'), 'name');
        $this->assertContains('João da Silva', $names);
        $this->assertContains('Joana Souza', $names);
        $this->assertNotContains('Maria Oliveira', $names);
    }
}
