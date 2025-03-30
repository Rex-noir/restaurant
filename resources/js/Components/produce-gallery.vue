<script setup lang="ts">
const props = defineProps<{ images: App.Data.ImageData[] }>();
</script>
<template>
    <h2 class="mb-4 text-lg font-medium">Gallery</h2>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <div
            v-for="image in images"
            :key="image.url"
            class="gallery-image bg-base-100 aspect-square overflow-hidden rounded-lg shadow-sm"
        >
            <img
                :src="image.url"
                class="h-full w-full object-cover transition hover:scale-105"
                :alt="image.url"
            />
        </div>
    </div>
</template>
