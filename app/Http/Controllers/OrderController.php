<?php

namespace App\Http\Controllers;

use App\Data\CheckoutData;
use Cache;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, string $key)
    {
        $rawData = Cache::get("checkout:{$key}");

        if (! $rawData) {
            return response()->json(['error' => 'Checkout data not found or expired'], 404);
        }

        $checkout = CheckoutData::fromArray($rawData);

        // Simulate or initiate payment request here...

        // For now, mark the payment as "pending"
        Cache::put("checkout:payment:status:{$key}", 'pending', now()->addMinutes(30));

        return response()->json([
            'status' => 'initiated',
            'poll_url' => route('checkout.payment.status', ['key' => $key]),
        ]);
    }

}
