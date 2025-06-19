<?php

namespace App\Actions\Sellers;

use App\Models\Seller;

class CreateSellerAction
{
    public function execute(array $data): Seller
    {
        return Seller::create($data);
    }
}
