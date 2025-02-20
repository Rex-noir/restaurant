<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\enums\OrderStatusEnum;
use App\enums\OrderTypesEnum;
use App\enums\PaymentMethodsEnum;
use App\enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_type',
        'status',
        'total_amount',
        'payment_status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'order_type' => OrderTypesEnum::class,
        'status' => OrderStatusEnum::class,
        'payment_status' => PaymentStatusEnum::class,
        'payment_method' => PaymentMethodsEnum::class,
        'total_amount' => MoneyCast::class,

    ];
}
