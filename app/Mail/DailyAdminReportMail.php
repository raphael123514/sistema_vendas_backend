<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyAdminReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $totalSales,
        public $totalAmount,
        public $date
    ) {}

    public function build()
    {
        return $this->subject('Relatório diário de vendas do sistema')
            ->view('emails.daily_admin_report');
    }
}
