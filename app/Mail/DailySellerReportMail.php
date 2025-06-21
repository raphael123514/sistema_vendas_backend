<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailySellerReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $seller,
        public $totalSales,
        public $totalAmount,
        public $totalCommission,
        public $date, 
        public $subject
    ) {}

    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.daily_seller_report');
    }
}
