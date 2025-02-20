<?php

namespace App\enums;

enum PaymentMethodsEnum: String
{
    case Cash = 'cash';
    case CreditCard = 'credit_card';
    case DebitCard = 'debit_card';
    case Paypal = 'paypal';
    case BankTransfer = 'bank_transfer';

    case UPI = 'upi';

    case GooglePay = 'google_pay';
    case ApplePay = 'apple_pay';
    case SamsungPay = 'samsung_pay';
    case Alipay = 'alipay';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
