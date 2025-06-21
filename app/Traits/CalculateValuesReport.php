<?php

namespace App\Traits;

use App\Models\Seller;

trait CalculateValuesReport
{
    const COMMISSION_RATE = 0.085; // 8.5% commission rate
    public function calculateValues(Seller $seller)
    {
        $sales = $seller->sales;
        $totalSales = $sales->count();
        $totalAmount = $sales->sum('amount');
        $totalCommission = $sales->sum(fn ($sale) => $sale->amount * self::COMMISSION_RATE);

        return [
            'seller' => $seller,
            'totalSales' => $totalSales,
            'totalAmount' => $totalAmount,
            'totalCommission' => $totalCommission,
        ];
    }
}
