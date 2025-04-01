<script setup lang="ts">
import MenuItem from '@/Components/menu-item.vue';
import OptionCheckbox from '@/Components/option-checkbox.vue';
import OptionRadio from '@/Components/option-radio.vue';
import OptionSelect from '@/Components/option-select.vue';
import ProduceGallery from '@/Components/produce-gallery.vue';
import ProductReviews from '@/Components/product-reviews.vue';
import ReviewForm from '@/Components/review-form.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps, PaginatedResponse } from '@/types';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import { computed, onMounted } from 'vue';

const page = usePage<
    PageProps<{
        menu_item: App.Data.MenuItemData;
        related_items: App.Data.MenuItemData[];
        reviews: PaginatedResponse<App.Data.MenuItemReviewData>;
    }>
>();

const item = computed(() => page.props.menu_item);
const relatedItems = computed(() => page.props.related_items);
const user = computed(() => page.props.auth.user);
const reviews = computed(() => page.props.reviews);

const orderForm = useForm({
    quantity: 1,
    options: item.value.options?.map((option) => {
        console.log(option);
        return {
            id: option.id,
            value: [
                option.values?.find((value) => value.is_default)?.id ?? null,
            ],
        };
    }),
});

const onSubmit = () => {
    // TODO: Submit order form

    console.log(orderForm.data());
    console.log(
        orderForm
            .transform((data) => ({
                items: [
                    {
                        quantity: data.quantity,
                        options: data.options?.map((option) => {
                            return {
                                id: option.id,
                                value: option.value,
                            };
                        }),
                        menu_item_id: item.value.id,
                    },
                ],
            }))
            .post(route('menus.checkout.store')),
    );
};

// GSAP animations
onMounted(() => {
    // Animate product details
    const mainImage = document.querySelector('.main-image');
    const productDetails = document.querySelector('.product-details');

    gsap.from(mainImage, {
        opacity: 0,
        x: -50,
        duration: 0.8,
        ease: 'power2.out',
    });

    gsap.from(productDetails, {
        opacity: 0,
        x: 50,
        duration: 0.8,
        ease: 'power2.out',
        delay: 0.2,
    });

    // Animate gallery images
    const galleryImages = document.querySelectorAll('.gallery-image');
    gsap.from(galleryImages, {
        opacity: 0,
        y: 30,
        stagger: 0.1,
        duration: 0.5,
        ease: 'power1.out',
        delay: 0.5,
    });

    // Animate review cards
    const reviewCards = document.querySelectorAll('.review-card');
    if (reviewCards.values.length > 0) {
        gsap.from(reviewCards, {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.5,
            ease: 'power1.out',
            delay: 0.3,
        });
    }
});

defineOptions({
    layout: HomeLayout,
});
</script>

<template>
    <div class="container mx-auto px-4 py-8">
        <!-- Back navigation and title -->
        <div class="mb-8 flex items-center gap-2">
            <Link :href="route('menus.index')" class="btn btn-ghost btn-circle">
                <ArrowLeftIcon class="size-5" />
            </Link>
            <h1 class="text-2xl font-medium">{{ item.name }}</h1>
        </div>

        <!-- Main product section -->
        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Main image -->
            <div
                class="main-image bg-base-100 flex items-center overflow-hidden rounded-lg shadow-md"
            >
                <img
                    class="h-full w-full object-cover object-center"
                    :src="item.primary_image.url"
                    alt="Main Image"
                />
            </div>

            <!-- Product details -->
            <div class="product-details flex flex-col gap-6">
                <!-- Tags -->
                <div class="flex flex-wrap gap-2" v-if="item.tags!.length">
                    <div
                        v-for="tag in item.tags"
                        :key="tag.name"
                        class="badge badge-outline"
                    >
                        {{ tag.name }}
                    </div>
                </div>

                <!-- Price and preparation time -->
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-2xl font-medium">$ {{ item.price }}</span>
                    <span class="badge" v-if="item.preparation_time">
                        {{ item.preparation_time }} min prep time
                    </span>
                </div>

                <!-- Description -->
                <p class="text-base-content/80">{{ item.description }}</p>

                <!-- Note -->
                <div class="text-base-content/70 text-sm">
                    Note: Online ordering available only in Aizawl City
                </div>

                <div v-if="orderForm.options" class="flex flex-col gap-1">
                    <template
                        v-for="(option, index) in item.options"
                        :key="option.id"
                    >
                        <OptionSelect
                            v-if="option.type === 'select'"
                            :option="option"
                            v-model:value="orderForm.options[index].value"
                        />

                        <OptionRadio
                            v-if="option.type === 'radio'"
                            :option="option"
                            v-model:value="orderForm.options[index].value"
                        />

                        <OptionCheckbox
                            v-if="option.type === 'checkbox'"
                            :option="option"
                            v-model:value="orderForm.options[index].value"
                        />
                    </template>
                </div>

                <!-- Add to cart -->
                <div class="flex justify-between gap-3">
                    <div class="join">
                        <button
                            class="btn btn-sm join-item"
                            @click="
                                orderForm.quantity > 1
                                    ? orderForm.quantity--
                                    : null
                            "
                        >
                            -
                        </button>
                        <input
                            type="number"
                            v-model.number="orderForm.quantity"
                            disabled
                            class="input input-sm join-item w-16 appearance-none text-center !ring focus-within:outline-none disabled:cursor-text"
                            min="1"
                        />
                        <button
                            class="btn btn-sm join-item"
                            @click="orderForm.quantity++"
                        >
                            +
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-primary">Add to Cart</button>
                        <button @click="onSubmit" class="btn btn-outline">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product gallery -->
        <div class="my-12" v-if="item.images && item.images.length">
            <ProduceGallery :images="item.images" />
        </div>

        <!-- Related items -->
        <div class="my-12" v-if="relatedItems.length">
            <h2 class="mb-4 text-lg font-medium">You might also like</h2>
            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
                <MenuItem
                    v-for="item in relatedItems"
                    :key="item.name"
                    :item="item"
                />
            </div>
        </div>

        <!-- Reviews section -->
        <div class="my-12">
            <h2 class="mb-4 text-xl font-medium">Customer Reviews</h2>

            <ReviewForm
                v-if="user"
                :item="item"
                :reviews="reviews"
                :user="user"
            />

            <!-- Login reminder for guests -->
            <div v-else class="card bg-base-200 mb-8 p-6 text-center">
                <p class="mb-3">Login or Register to leave a review</p>
                <div class="flex justify-center gap-3">
                    <Link :href="route('login')" class="btn btn-primary btn-sm"
                        >Login</Link
                    >
                    <Link
                        :href="route('register')"
                        class="btn btn-outline btn-sm"
                        >Register</Link
                    >
                </div>
            </div>

            <!-- Reviews list -->
            <ProductReviews :reviews="reviews" />
        </div>
    </div>
</template>

<style scoped>
input[type='number'] {
    appearance: textfield;
}

.review-card {
    transition: transform 0.2s ease;
}

.review-card:hover {
    transform: translateY(-2px);
}
</style>
