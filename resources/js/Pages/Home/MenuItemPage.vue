<script setup lang="ts">
import MenuItem from '@/Components/menu-item.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps } from '@/types';
import { ArrowLeftIcon } from '@heroicons/vue/24/outline';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<
    PageProps<{
        menuItem: App.Data.MenuItemData;
        relatedItems: App.Data.MenuItemData[];
    }>
>();
console.log(page.props.relatedItems);

const item = computed(() => page.props.menuItem);
const relatedItems = computed(() => page.props.relatedItems);

defineOptions({
    layout: HomeLayout,
});
</script>
<template>
    <div class="bg-base-200 container min-h-screen w-full space-y-8">
        <!-- Back button and title -->
        <div class="flex w-full items-center gap-3 py-2">
            <Link
                :href="route('menus.index')"
                class="btn btn-sm btn-ghost text-accent-content"
            >
                <ArrowLeftIcon class="size-7" />
            </Link>
            <h1 class="text-4xl font-bold">{{ item.name }}</h1>
        </div>

        <!-- Main content grid -->
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
            <!-- Main image carousel -->
            <div class="carousel w-full overflow-hidden rounded-lg">
                <div id="slide1" class="carousel-item w-full">
                    <img
                        class="h-96 w-full object-cover"
                        :src="item.image!"
                        alt="Main Image"
                    />
                </div>
            </div>

            <!-- Product details -->
            <div class="flex flex-col justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <div
                        v-for="tag in item.tags"
                        :key="tag.name"
                        class="badge badge-outline"
                    >
                        {{ tag.name }}
                    </div>
                </div>
                <div class="text-lg">{{ item.description }}</div>
                <div class="flex flex-wrap gap-2">
                    <span class="badge badge-primary text-lg"
                        >${{ item.price }}</span
                    >
                    <span class="badge badge-accent text-lg"
                        >Preparation time :
                        {{ item.preparationTime ?? 0 }} m</span
                    >
                </div>
                <span class="badge badge-ghost text-info"
                    >Note : Online ordering is available only in Aizawl
                    CIty.</span
                >
                <div class="flex items-center gap-3">
                    <input
                        type="number"
                        class="input border-none ring-0 outline-none"
                        placeholder="Quantity"
                    />
                    <button class="btn btn-primary">Add to Cart</button>
                    <button class="btn btn-secondary">Checkout</button>
                </div>
            </div>
        </div>

        <!-- Responsive image grid -->
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
            <div v-for="i in 4" :key="i" class="overflow-hidden rounded-lg">
                <img
                    :src="`https://placehold.co/300x200?text=Image+${i}`"
                    class="h-48 w-full object-cover transition-transform duration-300 hover:scale-105"
                    alt="Gallery Image"
                />
            </div>
        </div>

        <div v-if="relatedItems.length > 0">
            <h2 class="text-2xl font-semibold">Related Items Section</h2>
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <MenuItem v-for="item in relatedItems" :item="item" />
            </div>
        </div>

        <!-- Reviews section -->
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold">Customer Reviews</h2>
            <!-- Review content here -->
        </div>
    </div>
</template>
