<?php

namespace Tests\App\Traits;

use Tests\TestCase;
use App\Traits\CalculateValuesReport;
use App\Models\Seller;
use App\Models\Sale;

class CalculateValuesReportTest extends TestCase
{
    use CalculateValuesReport;

    public function testCalculateValuesWithSales()
    {
        $seller = Seller::factory()->create();
        $sales = Sale::factory()->count(3)->sequence(
            ['amount' => 100.00],
            ['amount' => 200.00],
            ['amount' => 50.00],
        )->create(['seller_id' => $seller->id]);

        $seller->load('sales');

        $result = $this->calculateValues($seller);

        $this->assertSame($seller->id, $result['seller']->id);
        $this->assertEquals(3, $result['totalSales']);
        $this->assertEquals(350.00, $result['totalAmount']);
        $this->assertEquals(29.75, $result['totalCommission']); // 350 * 0.085
    }

    public function testCalculateValuesWithNoSales()
    {
        $seller = Seller::factory()->create();
        $seller->load('sales'); // Nenhuma venda

        $result = $this->calculateValues($seller);

        $this->assertSame($seller->id, $result['seller']->id);
        $this->assertEquals(0, $result['totalSales']);
        $this->assertEquals(0, $result['totalAmount']);
        $this->assertEquals(0, $result['totalCommission']);
    }
}