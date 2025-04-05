<?php

namespace App\Services;

use App\Data\CheckoutData;

class PriceCalculatorService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function calculate(CheckoutData $checkoutData)
    {

        $total = 0;

        // foreach ($checkoutData->options as $option) {
        //     $total += $option->selected_values->each(function ($value))
        // }

    }
}

