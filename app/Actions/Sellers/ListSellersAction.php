<?php

namespace App\Actions\Sellers;

use App\Models\Seller;
use Illuminate\Pagination\LengthAwarePaginator;

class ListSellersAction
{
    public function execute(int $page = 1, int $perPage = 15, ?string $name = null): LengthAwarePaginator
    {
        $query = Seller::query();
        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }
        return $query->latest()->paginate($perPage, ['*'], 'page', $page);
    }
}
