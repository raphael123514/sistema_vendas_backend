<?php

namespace App\Actions\Sellers;

use App\Models\Seller;
use Illuminate\Pagination\LengthAwarePaginator;

class ListSellersAction
{
    public function execute(int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        return Seller::query()->latest()->paginate($perPage, ['*'], 'page', $page);
    }
}
