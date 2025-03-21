declare namespace App.Data {
    export type CategoryData = {
        name: string;
        description: string | null;
        image: string | null;
    };
    export type ImageData = {
        url: string;
        order: number;
    };
    export type MenuItemData = {
        name: string;
        description: string | null;
        price: number;
        preparation_time: number | null;
        slug: string;
        is_available: boolean;
        primary_image: App.Data.ImageData;
        tags?: Array<App.Data.TagData>;
        images?: Array<App.Data.ImageData>;
    };
    export type TagData = {
        name: string;
    };
}
declare namespace App.enums {
    export enum GenderEnums {
        'Male' = 'male',
        'Female' = 'female',
        'Other' = 'other',
    }
    export enum OrderStatusEnum {
        'Pending' = 'pending',
        'Completed' = 'completed',
        'Cancelled' = 'cancelled',
        'Failed' = 'failed',
        'Refunded' = 'refunded',
        'RefundFailed' = 'refund_failed',
        'RefundPending' = 'refund_pending',
        'RefundCompleted' = 'refund_completed',
        'RefundCancelled' = 'refund_cancelled',
        'Confirmed' = 'confirmed',
    }
    export enum OrderTypesEnum {
        'DELIVERY' = 'delivery',
        'DINE_IN' = 'dine_in',
        'CATERING' = 'catering',
    }
    export enum PaymentMethodsEnum {
        'Cash' = 'cash',
        'CreditCard' = 'credit_card',
        'DebitCard' = 'debit_card',
        'Paypal' = 'paypal',
        'BankTransfer' = 'bank_transfer',
        'UPI' = 'upi',
        'GooglePay' = 'google_pay',
        'ApplePay' = 'apple_pay',
        'SamsungPay' = 'samsung_pay',
        'Alipay' = 'alipay',
    }
    export enum PaymentStatusEnum {
        'Pending' = 'pending',
        'Paid' = 'paid',
        'Failed' = 'failed',
    }
    export enum ReservationStatusEnum {
        'Pending' = 'pending',
        'Confirmed' = 'confirmed',
        'Cancelled' = 'cancelled',
    }
    export enum TableStatusEnum {
        'Available' = 'available',
        'Unavailable' = 'unavailable',
    }
}
