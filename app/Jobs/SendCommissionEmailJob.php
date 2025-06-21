<?php

namespace App\Jobs;

use App\Models\Seller;
use App\Traits\CalculateValuesReport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCommissionEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CalculateValuesReport;

    public function __construct(public Seller $seller) {}
    const COMMISSION_EMAIL_SUBJECT = 'Reenvio do Relatório Diário de Vendas';
    public function handle()
    {
        $reportData = $this->calculateValues($this->seller);
        $today = now()->toDateString();

        if ($reportData['totalSales'] > 0) {
            Mail::to($this->seller->email)->send(new \App\Mail\DailySellerReportMail(
                $this->seller, $reportData['totalSales'], $reportData['totalAmount'], $reportData['totalCommission'], $today, self::COMMISSION_EMAIL_SUBJECT
            ));
        }
    }
}

