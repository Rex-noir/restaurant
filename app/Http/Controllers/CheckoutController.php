<?php

namespace App\Http\Controllers;

use App\Data\CheckoutData;
use App\Http\Requests\CheckoutRequest;
use Cache;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;
use URL;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request)
    {
        $key = Str::uuid();

        $data = $request->validated();

        Cache::put("checkout:{$key}", $data, now()->addMinutes(30));

        $url = URL::signedRoute('menus.checkout.show', ['key' => $key]);

        return Inertia::location($url);
    }
    public function show(Request $request, $key)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $data = Cache::get("checkout:{$key}");


        return inertia('Checkout/CheckoutPage', [
            'checkout_data' => CheckoutData::fromArray($data),
        ]);
    }
}
