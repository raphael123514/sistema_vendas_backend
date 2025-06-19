<?php

namespace App\Actions\Sales;

use App\Models\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

class ListSalesAction
{
    public function execute(int $page = 1, int $perPage = 15): LengthAwarePaginator
    {
        return Sale::with('seller')
            ->latest()
            ->paginate(
                perPage: $perPage,
                page: $page
            );
    }
}
