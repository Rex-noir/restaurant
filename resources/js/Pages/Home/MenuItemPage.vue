<script setup lang="ts">
import MenuItem from '@/Components/menu-item.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps } from '@/types';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage<
    PageProps<{
        menu_item: App.Data.MenuItemData;
        related_items: App.Data.MenuItemData[];
    }>
>();

const item = computed(() => page.props.menu_item);
const relatedItems = computed(() => page.props.related_items);

const uniqueId = Math.random().toString(36).substring(2, 15);
const totalStars = 5;
const selectedRating = ref(0);
const quantity = ref(1);

const setRating = (rating: number) => {
    selectedRating.value = rating;
};

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
            <div class="bg-base-100 overflow-hidden rounded-lg">
                <img
                    class="h-auto w-full object-cover"
                    :src="item.primary_image.url"
                    alt="Main Image"
                />
            </div>

            <!-- Product details -->
            <div class="flex flex-col gap-6">
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
                <div class="flex items-center gap-3">
                    <div class="join">
                        <button
                            class="btn btn-sm join-item"
                            @click="quantity > 1 ? quantity-- : null"
                        >
                            -
                        </button>
                        <input
                            type="number"
                            v-model="quantity"
                            class="input input-bordered join-item w-16 text-center"
                            min="1"
                        />
                        <button
                            class="btn btn-sm join-item"
                            @click="quantity++"
                        >
                            +
                        </button>
                    </div>
                    <button class="btn btn-primary">Add to Cart</button>
                    <button class="btn btn-outline">Checkout</button>
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
                    class="bg-base-100 aspect-square overflow-hidden rounded-lg"
                >
                    <img
                        :src="image.url"
                        class="h-full w-full object-cover transition hover:scale-105"
                        :alt="item.name"
                    />
                </div>
            </div>
        </div>

        <!-- Reviews section -->
        <div class="my-12">
            <div class="card bg-base-100 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Customer Reviews</h2>
                    <textarea
                        class="textarea textarea-bordered w-full resize-none focus-within:outline-0"
                        placeholder="Share your experience..."
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
                                :checked="selectedRating === 0"
                                @click="setRating(0)"
                            />
                            <input
                                v-for="i in totalStars"
                                :key="i"
                                type="radio"
                                :name="`rating-${uniqueId}`"
                                class="mask mask-star-2 bg-primary"
                                :aria-label="`${i} star${i > 1 ? 's' : ''}`"
                                :checked="selectedRating === i"
                                @click="setRating(i)"
                            />
                        </div>
                        <button class="btn btn-primary btn-sm">
                            Submit Review
                        </button>
                    </div>
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
    </div>
</template>
