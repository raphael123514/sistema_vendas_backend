<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        Seller::factory()
            ->count(10)
            ->has(
                Sale::factory()
                    ->count(15)
                    ->state(function (array $attributes, Seller $seller) {
                        return [
                            'seller_id' => $seller->id
                        ];
                    })
            )
            ->create();
    }
}
