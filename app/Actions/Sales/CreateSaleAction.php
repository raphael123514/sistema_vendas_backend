<?php

namespace App\Actions\Sales;

use App\Models\Sale;

class CreateSaleAction
{
    public function execute(array $data): Sale
    {
        return Sale::create($data);
    }
}
