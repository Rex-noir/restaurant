<?php

namespace App\enums;

enum OrderStatusEnum: String
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Failed = 'failed';
    case Refunded = 'refunded';
    case RefundFailed = 'refund_failed';
    case RefundPending = 'refund_pending';
    case RefundCompleted = 'refund_completed';
    case RefundCancelled = 'refund_cancelled';
    case Confirmed = 'confirmed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
