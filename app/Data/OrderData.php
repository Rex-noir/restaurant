<?php

namespace App\Data;

use App\enums\OrderStatusEnum;
use App\enums\OrderTypesEnum;
use App\enums\PaymentMethodsEnum;
use App\enums\PaymentStatusEnum;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public int $user_id,
        public OrderTypesEnum $order_type,
        public OrderStatusEnum $status,
        public float $total_amount,
        public PaymentStatusEnum $payment_status,
        public PaymentMethodsEnum $payment_method,
        public ?string $notes
    ) {
    }
}
