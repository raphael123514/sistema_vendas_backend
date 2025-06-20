<?php

namespace App\Actions\Sellers;

use App\Models\Sale;
use Illuminate\Support\Collection;

class ListSellerSalesAction
{
    public function execute(int $sellerId): Collection
    {
        return Sale::with('seller')->where('seller_id', $sellerId)->get();
    }
}
