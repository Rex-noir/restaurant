<script setup lang="ts">
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue';
import { PageProps } from '@/types';
import { router, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import { onMounted, ref } from 'vue';

const pageProps = usePage<
    PageProps<{
        checkout_data: App.Data.CheckoutData[];
        signature_key: string;
    }>
>().props;
const checkoutData = pageProps.checkout_data;
const signatureKey = pageProps.signature_key;
const itemRefs = ref<HTMLElement[]>([]);
const paymentSection = ref(null);

defineOptions({
    layout: CheckoutLayout,
});

onMounted(() => {
    // Animate the order items
    gsap.from(itemRefs.value, {
        y: 30,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1,
        ease: 'power2.out',
    });

    // Animate the payment section
    gsap.from(paymentSection.value, {
        x: -20,
        opacity: 0,
        duration: 0.6,
        ease: 'power2.out',
    });
});

const setItemRef = (el: any) => {
    if (el) itemRefs.value.push(el);
};

const payOrder = () => {
    // Implement payment logic here
    router.post(
        route('menus.order.store', { key: signatureKey }),
        {},
        {
            onSuccess: (response) => {
                console.log(response);
            },
        },
    );
};
</script>

<template>
    <div class="container mx-auto p-4 lg:p-6">
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Left column - Payment options -->
            <div ref="paymentSection" class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title mb-6 text-2xl">Payment Details</h2>

                    <!-- Payment method selection -->
                    <div class="form-control mb-6">
                        <label class="label">
                            <span class="label-text text-lg font-medium"
                                >Payment Method</span
                            >
                        </label>
                        <div class="flex flex-col gap-3">
                            <label
                                class="hover:bg-base-200 flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition-colors"
                            >
                                <input
                                    type="radio"
                                    name="payment-method"
                                    class="radio radio-primary"
                                    checked
                                />
                                <div class="flex items-center gap-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="text-primary h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                        />
                                    </svg>
                                    <span>Credit Card</span>
                                </div>
                            </label>
                            <!--
                            <label
                                class="hover:bg-base-200 flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition-colors"
                            >
                                <input
                                    type="radio"
                                    name="payment-method"
                                    class="radio radio-primary"
                                />
                                <div class="flex items-center gap-2">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="text-primary h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span>Digital Wallet</span>
                                </div>
                            </label> -->
                        </div>
                    </div>

                    <!-- Card details form -->
                    <div class="space-y-4">
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Name</legend>
                            <input
                                type="text"
                                class="input w-full"
                                placeholder="Card Holder Nmae"
                            />
                        </fieldset>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Card Number</legend>
                            <input
                                type="text"
                                class="input w-full"
                                placeholder="Card Number"
                            />
                        </fieldset>

                        <div class="grid grid-cols-2 gap-4">
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">
                                    Expiration Date
                                </legend>
                                <input
                                    type="text"
                                    class="input"
                                    placeholder="MM/YY"
                                />
                            </fieldset>

                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">CVC</legend>
                                <input
                                    type="text"
                                    class="input"
                                    placeholder="CVC"
                                />
                            </fieldset>
                        </div>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">
                                Billing Address
                            </legend>
                            <textarea
                                class="textarea h-24 w-full resize-none focus-within:outline-none"
                                placeholder="Address"
                            ></textarea>
                        </fieldset>
                    </div>

                    <div class="mt-8">
                        <button
                            @click="payOrder"
                            class="btn btn-primary btn-lg w-full"
                        >
                            Pay
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right column - Order summary -->
            <div class="flex flex-col gap-4">
                <div class="mb-2 flex items-center justify-between">
                    <h2 class="text-2xl font-bold">Order Summary</h2>
                    <div class="badge badge-lg">
                        Items: {{ checkoutData.length }}
                    </div>
                </div>

                <div
                    class="flex max-h-screen flex-col gap-4 overflow-y-auto pr-2"
                >
                    <template
                        v-for="(data, index) in checkoutData"
                        :key="index"
                    >
                        <div
                            :ref="setItemRef"
                            class="card bg-base-100 shadow-md transition-shadow duration-300 hover:shadow-lg"
                        >
                            <div class="card-body p-4">
                                <div class="flex gap-4">
                                    <img
                                        class="h-24 w-24 rounded-lg object-cover object-center"
                                        :src="data.menu_item.primary_image.url"
                                        :alt="data.menu_item.name"
                                    />

                                    <div class="flex-1">
                                        <div
                                            class="flex items-start justify-between"
                                        >
                                            <h3 class="text-lg font-bold">
                                                {{ data.menu_item.name }}
                                            </h3>
                                            <span class="font-semibold"
                                                >$ {{ data.total }}</span
                                            >
                                        </div>

                                        <p
                                            class="text-base-content/70 mb-3 line-clamp-2 text-sm"
                                        >
                                            {{ data.menu_item.description }}
                                        </p>

                                        <!-- Options without collapse/checkbox -->
                                        <div
                                            v-for="(
                                                option, optIndex
                                            ) in data.options"
                                            :key="optIndex"
                                            class="mb-2"
                                        >
                                            <div>
                                                <div
                                                    class="mb-1 text-sm font-medium"
                                                >
                                                    {{ option.option.name }}
                                                </div>
                                                <div class="border-primary/30">
                                                    <div
                                                        v-for="(
                                                            value, valIndex
                                                        ) in option.selected_values"
                                                        :key="valIndex"
                                                        class="flex items-center justify-between py-1 text-sm"
                                                    >
                                                        <span
                                                            class="text-base-content/80"
                                                            >{{
                                                                value.value
                                                            }}</span
                                                        >
                                                        <span
                                                            class="badge badge-sm"
                                                            >$
                                                            {{
                                                                value.price_mod
                                                            }}</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div
                                            class="flex items-center justify-between text-lg font-bold"
                                        >
                                            <span>Total</span>
                                            <span
                                                >$
                                                {{
                                                    (
                                                        checkoutData.reduce(
                                                            (sum, item) =>
                                                                sum +
                                                                Number(
                                                                    item.total,
                                                                ),
                                                            0,
                                                        ) *
                                                            1.08 +
                                                        5.99
                                                    ).toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
