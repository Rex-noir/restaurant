<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';

const imageModel = defineModel('image', { required: true });
const preview = ref<string | null>(imageModel.value as string);

const fileInput = useTemplateRef<HTMLInputElement>('fileInput');

const handleImageSelect = () => {
    fileInput.value?.click();
};

const onFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;

    const file = input.files![0];

    if (file) {
        imageModel.value = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};
</script>

<template>
    <div class="flex flex-col items-center space-y-4">
        <div class="avatar" v-if="preview">
            <div class="relative h-48 w-48 rounded-full">
                <img
                    :src="preview"
                    alt="Profile"
                    class="h-full w-full object-cover"
                />
                <div class="absolute inset-0 flex items-center justify-center">
                    <button
                        @click="handleImageSelect"
                        class="btn btn-circle btn-ghost"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <input
            type="file"
            ref="fileInput"
            @change="onFileChange"
            accept="image/*"
            class="hidden"
        />
        <button
            type="button"
            @click="handleImageSelect"
            class="btn btn-primary btn-sm"
        >
            Change Photo
        </button>
    </div>
</template>
