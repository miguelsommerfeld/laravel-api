<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class DonationController extends Controller
{
    public function __construct(
        private PaymentService $payment
    ) {}

    public function donate(Request $request): JsonResponse
    {
        $response = $this->payment->donate($request->gateway);

        if (!empty($response['data'])) {
            return response()->json($response['data'], $response['status']);
        }

        return response()->json($response['message'], $response['status']);
    }
}
