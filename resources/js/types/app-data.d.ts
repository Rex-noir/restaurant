declare namespace App.Data {
    export type CategoryData = {
        name: string;
        description: string | null;
        image: string | null;
    };
    export type CheckoutData = {
        quantity: number;
        total: number;
        menu_item: App.Data.MenuItemData;
        options: Array<App.Data.CheckoutOption>;
    };
    export type CheckoutOption = {
        option: App.Data.MenuItemOptionData;
        selected_values: Array<App.Data.MenuItemOptionValueData>;
        total: number;
    };
    export type ImageData = {
        url: string;
        order: number;
    };
    export type MenuItemData = {
        id: number;
        name: string;
        description: string | null;
        price: number;
        preparation_time: number | null;
        slug: string;
        is_available: boolean;
        primary_image: App.Data.ImageData;
        tags?: Array<App.Data.TagData>;
        images?: Array<App.Data.ImageData>;
        options?: Array<App.Data.MenuItemOptionData>;
    };
    export type MenuItemOptionData = {
        id: number;
        name: string;
        type: App.enums.MenuOptionTypesEnum;
        values?: Array<App.Data.MenuItemOptionValueData>;
    };
    export type MenuItemOptionValueData = {
        value: string;
        price_mod: number;
        is_default: boolean;
        id: number;
    };
    export type MenuItemReviewData = {
        user_id: number;
        id: number;
        stars: number | null;
        review_text: string | null;
        user?: App.Data.UserData;
    };
    export type TagData = {
        name: string;
    };
    export type UserData = {
        id?: number;
        name: string;
        email: string;
        profile?: App.Data.UserProfileData;
    };
    export type UserProfileData = {
        gender: App.enums.GenderEnums;
        phone: string;
        date_of_birth: string | null;
        user_id?: number;
        profile_image: App.Data.ImageData | null;
    };
}
declare namespace App.enums {
    export enum GenderEnums {
        'Male' = 'male',
        'Female' = 'female',
        'Other' = 'other',
        'Unknown' = 'unknown',
    }
    export enum MenuOptionTypesEnum {
        'SELECT' = 'select',
        'CHECKBOX' = 'checkbox',
        'RADIO' = 'radio',
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
