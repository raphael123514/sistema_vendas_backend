<?php

namespace App\Http\Controllers;

use App\Actions\Sellers\ShowSellerAction;
use App\Jobs\SendCommissionEmailJob;
use App\Http\Requests\ResendCommissionRequest;
use Illuminate\Http\Request;
use App\Models\Seller;

class CommissionController extends Controller
{
    public function __construct(
        private ShowSellerAction $showSellerAction
    ) {}

    public function resend(Seller $seller)
    {
        dispatch(new SendCommissionEmailJob($seller))->onQueue('commissions');

        return response()->json(['message' => 'Commission email enqueued successfully.']);
    }
}
