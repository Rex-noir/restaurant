<script setup lang="ts">
import MenuItem from '@/Components/menu-item.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps, PaginatedResponse } from '@/types';
import deepDiff from '@/utils/object-diff';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import { computed, onMounted, ref } from 'vue';

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

const reviewForm = useForm<Omit<App.Data.MenuItemReviewData, 'user_id' | 'id'>>(
    {
        stars: 0,
        review_text: '',
    },
);

const initialFormData = {
    stars: 0,
    review_text: '',
};

const uniqueId = Math.random().toString(36).substring(2, 15);
const totalStars = 5;
const quantity = ref(1);
const reviewsContainer = ref(null);

const setRating = (rating: number) => {
    reviewForm.stars = rating;
};

const onSubmitReiview = async () => {
    reviewForm
        .transform((data) => deepDiff(initialFormData, data as any))
        .post(route('menus.reviews.store', { menu: item.value.id }), {
            preserveScroll: true,
            only: ['reviews'],
            onSuccess: () => {
                // Animate the new review being added
                if (reviews.value.data.length > 0) {
                    setTimeout(() => {
                        const newReview = document.querySelector(
                            '.review-card:last-child',
                        );
                        if (newReview) {
                            gsap.fromTo(
                                newReview,
                                { opacity: 0, y: -20 },
                                { opacity: 1, y: 0, duration: 0.5 },
                            );
                        }
                    }, 100);
                }

                // Clear form
                reviewForm.stars = 0;
                reviewForm.review_text = '';
            },
        });
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
    gsap.from(reviewCards, {
        opacity: 0,
        y: 20,
        stagger: 0.1,
        duration: 0.5,
        ease: 'power1.out',
        delay: 0.3,
    });
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
                class="main-image bg-base-100 overflow-hidden rounded-lg shadow-md"
            >
                <img
                    class="h-auto w-full object-cover"
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

                <!-- Description -->
                <p class="text-base-content/80">{{ item.description }}</p>

                <!-- Price and preparation time -->
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-2xl font-medium">${{ item.price }}</span>
                    <span class="badge" v-if="item.preparation_time">
                        {{ item.preparation_time }} min prep time
                    </span>
                </div>

                <!-- Note -->
                <div class="text-base-content/70 text-sm">
                    Note: Online ordering available only in Aizawl City
                </div>

                <!-- Add to cart -->
                <div class="flex justify-between gap-3">
                    <div class="join">
                        <button
                            class="btn btn-sm join-item"
                            @click="quantity > 1 ? quantity-- : null"
                        >
                            -
                        </button>
                        <input
                            type="number"
                            v-model.number="quantity"
                            disabled
                            class="input input-sm join-item w-16 appearance-none text-center !ring focus-within:outline-none disabled:cursor-text"
                            min="1"
                        />
                        <button
                            class="btn btn-sm join-item"
                            @click="quantity++"
                        >
                            +
                        </button>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-primary">Add to Cart</button>
                        <button class="btn btn-outline">Checkout</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product gallery -->
        <div class="my-12" v-if="item.images && item.images.length">
            <h2 class="mb-4 text-lg font-medium">Gallery</h2>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                <div
                    v-for="image in item.images"
                    :key="image.url"
                    class="gallery-image bg-base-100 aspect-square overflow-hidden rounded-lg shadow-sm"
                >
                    <img
                        :src="image.url"
                        class="h-full w-full object-cover transition hover:scale-105"
                        :alt="item.name"
                    />
                </div>
            </div>
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

            <!-- Review form for logged in users -->
            <form @submit.prevent="onSubmitReiview" v-if="user" class="mb-8">
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-body">
                        <textarea
                            class="textarea textarea-bordered w-full resize-none focus-within:outline-0"
                            :class="{
                                'textarea-error': reviewForm.errors.review_text,
                            }"
                            placeholder="Share your experience..."
                            v-model="reviewForm.review_text"
                            rows="3"
                        ></textarea>
                        <div
                            class="flex flex-wrap items-center justify-between gap-4"
                        >
                            <div class="rating rating-md">
                                <input
                                    type="radio"
                                    :name="`rating-${uniqueId}`"
                                    class="rating-hidden"
                                    aria-label="clear"
                                    :checked="reviewForm.stars === 0"
                                    @click="setRating(0)"
                                />
                                <input
                                    v-for="i in totalStars"
                                    :key="i"
                                    type="radio"
                                    :name="`rating-${uniqueId}`"
                                    class="mask mask-star-2 bg-primary"
                                    :aria-label="`${i} star${i > 1 ? 's' : ''}`"
                                    :checked="reviewForm.stars === i"
                                    @click="setRating(i)"
                                />
                            </div>
                            <span
                                v-if="
                                    reviewForm.errors.stars ||
                                    reviewForm.errors.review_text
                                "
                                class="text-error-content font-bold"
                                >{{
                                    reviewForm.errors.stars ||
                                    reviewForm.errors.review_text
                                }}</span
                            >
                            <button
                                type="submit"
                                class="btn btn-primary btn-sm"
                            >
                                Submit Review
                            </button>
                        </div>
                    </div>
                </div>
            </form>

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
            <div ref="reviewsContainer" class="mt-5 w-full space-y-4">
                <!-- No reviews message -->
                <div
                    v-if="!reviews.data.length"
                    class="text-base-content/70 py-8 text-center"
                >
                    No reviews yet. Be the first to share your experience!
                </div>

                <!-- Review cards -->
                <div class="space-y-2">
                    <div
                        v-for="review in reviews.data"
                        :key="review.id"
                        class="review-card card bg-base-100 overflow-hidden shadow-sm"
                    >
                        <div class="card-body p-4">
                            <div class="flex items-start gap-4">
                                <!-- User avatar -->
                                <div class="avatar">
                                    <div
                                        class="relative h-12 w-12 rounded-full"
                                    >
                                        <!-- Profile Image -->
                                        <img
                                            v-if="
                                                review.user?.profile
                                                    ?.profile_image?.url
                                            "
                                            :src="
                                                review.user.profile
                                                    .profile_image.url
                                            "
                                            :alt="`Review by ${review.user?.name}`"
                                            class="rounded-full"
                                        />
                                        <!-- Fallback Avatar -->
                                        <div
                                            v-else
                                            class="bg-neutral text-neutral-content flex h-full w-full items-center justify-center rounded-full font-bold uppercase"
                                        >
                                            {{
                                                review.user?.name?.charAt(0) ??
                                                '?'
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Review content -->
                                <div class="flex-1">
                                    <div
                                        class="mb-1 flex flex-wrap items-center justify-between gap-2"
                                    >
                                        <div class="font-medium">
                                            {{ review.user?.name }}
                                        </div>
                                        <!-- <time class="text-xs text-base-content/60">
                                            {{ formatRelativeTime(review.created_at) }}
                                        </time> -->
                                    </div>
                                    <!-- Star rating -->
                                    <div class="mb-2 flex items-center">
                                        <div class="rating rating-sm">
                                            <input
                                                v-for="i in totalStars"
                                                :key="i"
                                                type="radio"
                                                :name="`rating-readonly-${review.id}`"
                                                class="mask mask-star-2 bg-primary"
                                                :checked="review.stars === i"
                                                disabled
                                            />
                                        </div>
                                    </div>
                                    <!-- Review text -->
                                    <p class="text-base-content/80">
                                        {{ review.review_text }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination if needed -->
                <div
                    class="mt-10 flex justify-center"
                    v-if="reviews.links && reviews.links.length > 3"
                >
                    <div class="join">
                        <Link
                            v-for="link in reviews.links"
                            :key="link.label"
                            :href="link.url!"
                            :preserve-scroll="true"
                            :preserve-state="true"
                            :only="['reviews']"
                            :class="[
                                'join-item btn btn-sm',
                                link.active ? 'btn-active' : '',
                                !link.url ? 'btn-disabled' : '',
                            ]"
                            v-html="link.label"
                        ></Link>
                    </div>
                </div>
            </div>
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
