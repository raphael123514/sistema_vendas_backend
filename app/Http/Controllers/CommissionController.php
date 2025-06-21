<?php

namespace App\Http\Controllers;

use App\Actions\Sellers\ShowSellerAction;
use App\Jobs\SendCommissionEmailJob;
use App\Http\Requests\ResendCommissionRequest;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function __construct(
        private ShowSellerAction $showSellerAction
    ) {}

    public function resend(ResendCommissionRequest $request)
    {
        $sellerId = $request->validated('seller_id');
        $seller = $this->showSellerAction->execute($sellerId);

        dispatch(new SendCommissionEmailJob($seller))->onQueue('commissions');

        return response()->json(['message' => 'Commission email enqueued successfully.']);
    }
}
