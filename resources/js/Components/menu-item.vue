<script setup lang="ts">
import { Link } from '@inertiajs/vue3'; // Import if using Inertia.js

const props = defineProps<{
    item: App.Data.MenuItemData;
}>();

const emit = defineEmits<{
    (e: 'add-to-cart', item: App.Data.MenuItemData): void;
}>();
</script>

<template>
    <div
        class="menu-card card bg-base-100 border-base-200 overflow-hidden border shadow-md hover:shadow-lg"
    >
        <!-- Image Container -->
        <figure class="relative overflow-hidden pt-[66%]">
            <img
                :src="item.primary_image.url || '/default-image.jpg'"
                :alt="item.name"
                class="card-image absolute top-0 left-0 h-full w-full object-cover transition-all duration-500"
            />
            <div
                class="bg-primary text-primary-content absolute top-3 right-3 rounded-full px-3 py-1 text-sm font-medium"
            >
                ${{ item.price }}
            </div>
        </figure>

        <!-- Content Section -->
        <div class="card-body p-6">
            <h2 class="card-title mb-2 text-xl font-semibold">
                {{ item.name }}
            </h2>
            <p class="text-base-content/70 mb-4 text-sm">
                {{ item.description }}
            </p>

            <!-- Tags and Actions -->
            <div class="mt-auto flex flex-wrap justify-between gap-2">
                <!-- Tags -->
                <div class="flex flex-wrap gap-2">
                    <div
                        v-for="(tag, index) in item.tags"
                        :key="index"
                        class="badge badge-outline px-2 py-1 text-xs"
                    >
                        {{ tag.name }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button
                        class="btn btn-xs btn-secondary"
                        @click="emit('add-to-cart', item)"
                    >
                        Add to Cart
                    </button>
                    <Link
                        :href="route('menus.show', { slug: item.slug })"
                        class="btn btn-xs btn-primary"
                    >
                        View
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
