<script setup lang="ts">
import { PaginatedResponse } from '@/types';

const props = defineProps<{
    reviews: PaginatedResponse<App.Data.MenuItemReviewData>;
}>();
</script>

<template>
    <div class="mt-5 w-full space-y-4">
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
                            <div class="relative h-12 w-12 rounded-full">
                                <!-- Profile Image -->
                                <img
                                    v-if="
                                        review.user?.profile?.profile_image?.url
                                    "
                                    :src="review.user.profile.profile_image.url"
                                    :alt="`Review by ${review.user?.name}`"
                                    class="rounded-full"
                                />
                                <!-- Fallback Avatar -->
                                <div
                                    v-else
                                    class="bg-neutral text-neutral-content flex h-full w-full items-center justify-center rounded-full font-bold uppercase"
                                >
                                    {{ review.user?.name?.charAt(0) ?? '?' }}
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
                                        v-for="i in 5"
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
</template>
