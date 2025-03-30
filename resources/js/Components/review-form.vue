<script setup lang="ts">
import { PaginatedResponse } from '@/types';
import deepDiff from '@/utils/object-diff';
import { useForm } from '@inertiajs/vue3';
import gsap from 'gsap';

const props = defineProps<{
    item: App.Data.MenuItemData;
    reviews: PaginatedResponse<App.Data.MenuItemReviewData>;
    user: App.Data.UserData | null;
}>();

const initialFormData = {
    stars: 0,
    review_text: '',
};

const reviewForm = useForm<Omit<App.Data.MenuItemReviewData, 'user_id' | 'id'>>(
    {
        stars: 0,
        review_text: '',
    },
);

const setRating = (rating: number) => {
    reviewForm.stars = rating;
};

const totalStars = 5;
const uniqueId = Math.random().toString(36).substring(2, 15);

const onSubmitReview = async () => {
    reviewForm
        .transform((data) => deepDiff(initialFormData, data as any))
        .post(route('menus.reviews.store', { menu: props.item.id }), {
            preserveScroll: true,
            only: ['reviews'],
            onSuccess: () => {
                // Animate the new review being added
                if (props.reviews.data.length > 0) {
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
</script>
<template>
    <!-- Review form for logged in users -->
    <form @submit.prevent="onSubmitReview" v-if="user" class="mb-8">
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
                <div class="flex flex-wrap items-center justify-between gap-4">
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
                    <button type="submit" class="btn btn-primary btn-sm">
                        Submit Review
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
