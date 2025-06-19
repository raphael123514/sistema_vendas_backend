<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        if (Seller::count() === 0) {
            Seller::factory()->create();
        }

        // Criar 50 vendas adicionais distribuídas aleatoriamente entre os vendedores existentes
        Sale::factory()
            ->count(50)
            ->create();
    }
}
