<?php

namespace App\Console\Commands;

use App\Models\Seller;
use App\Traits\CalculateValuesReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySellerReport extends Command
{
    use CalculateValuesReport;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-seller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mail diário para cada vendedor com resumo de vendas do dia';
    const COMMISSION_EMAIL_SUBJECT = 'Relatório Diário de Vendas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        Seller::with(['sales' => function ($q) use ($today) {
            $q->whereDate('date', $today);
        }])->chunk(50, function ($sellers) use ($today) {
            foreach ($sellers as $seller) {
                $reportData = $this->calculateValues($seller);

                if ($reportData['totalSales'] > 0) {
                    Mail::to($seller->email)->send(new \App\Mail\DailySellerReportMail(
                        $seller, $reportData['totalSales'], $reportData['totalAmount'], $reportData['totalCommission'], $today, self::COMMISSION_EMAIL_SUBJECT
                    ));
                }
            }
        });

        $this->info('Relatórios enviados para os vendedores.');
    }
}
