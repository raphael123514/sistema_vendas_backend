<?php

namespace App\Actions\Sellers;

use App\Models\Seller;

class ShowSellerAction
{
    public function execute(int $id): Seller
    {
        return Seller::findOrFail($id);
    }
}
