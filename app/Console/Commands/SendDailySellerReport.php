<?php

namespace App\Console\Commands;

use App\Models\Seller;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailySellerReport extends Command
{
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
                $sales = $seller->sales;
                $totalSales = $sales->count();
                $totalAmount = $sales->sum('amount');
                $totalCommission = $sales->sum(fn ($sale) => $sale->amount * 0.085);

                if ($totalSales > 0) {
                    Mail::to($seller->email)->send(new \App\Mail\DailySellerReportMail(
                        $seller, $totalSales, $totalAmount, $totalCommission, $today
                    ));
                }
            }
        });

        $this->info('Relatórios enviados para os vendedores.');
    }
}
