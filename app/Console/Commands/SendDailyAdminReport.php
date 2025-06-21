<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyAdminReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mail diário para o administrador com resumo de todas as vendas do dia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $totalSales = Sale::whereDate('date', $today)->count();
        $totalAmount = Sale::whereDate('date', $today)->sum('amount');

        $adminEmail = config('mail.admin_email', 'admin@seudominio.com');

        Mail::to($adminEmail)->send(new \App\Mail\DailyAdminReportMail(
            $totalSales, $totalAmount, $today
        ));

        $this->info('Relatório enviado para o administrador.');
    }
}
