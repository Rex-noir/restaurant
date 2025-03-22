<script setup lang="ts">
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, useTemplateRef } from 'vue';

const pageProps = usePage().props;

const form = useForm({
    image: null as File | null,
    gender: '',
    date_of_birth: '',
    phone: '',
});

const previewImage = ref<string | null>(null);
const fileInput = useTemplateRef<HTMLInputElement | null>('fileInput');

const handleImageSelect = () => {
    fileInput.value?.click();
};

const onFileChange = (event: Event) => {
    const input = event.target as HTMLInputElement;
    form.image = input.files![0];
    const reader = new FileReader();
    reader.onload = (e) => {
        previewImage.value = e.target?.result as string;
    };
    reader.readAsDataURL(form.image);
};

const submit = () => {
    form.post(route('profile.setup.store'), {
        onError: () => {
            // Handle errors if needed
        },
    });
};

defineOptions({
    layout: AuthLayout,
});
</script>

<template>
    <Head>
        <title>Complete Profile</title>
    </Head>
    <div class="card bg-base-200 w-full max-w-lg shadow-xl">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center text-2xl font-bold">
                Complete Your Profile
            </h2>

            <div class="form-control">
                <div class="flex flex-col items-center space-y-4">
                    <div class="avatar" v-if="previewImage">
                        <div
                            class="ring-primary ring-offset-base-100 relative h-48 w-48 overflow-hidden rounded-full ring ring-offset-2"
                        >
                            <img
                                :src="previewImage"
                                alt="Profile image"
                                class="h-full w-full object-cover"
                            />
                            <div
                                class="bg-opacity-0 hover:bg-opacity-40 absolute inset-0 flex items-center justify-center transition-all duration-300"
                            >
                                <button
                                    @click="handleImageSelect"
                                    class="btn btn-circle btn-ghost text-white opacity-0 hover:opacity-100"
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
                    <div v-if="!previewImage" class="avatar avatar-placeholder">
                        <div
                            class="bg-base-200 text-base-content h-48 w-48 rounded-full border"
                        >
                            <span class="text-3xl">{{
                                pageProps.auth.user.name[0]
                            }}</span>
                        </div>
                        <div
                            class="bg-opacity-0 hover:bg-opacity-40 absolute inset-0 flex items-center justify-center transition-all duration-300"
                        >
                            <button
                                @click="handleImageSelect"
                                class="btn btn-circle btn-ghost text-white opacity-0 hover:opacity-100"
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
                        Upload Photo
                    </button>
                </div>
                <span
                    v-if="pageProps.errors.image"
                    class="text-error mt-2 text-sm"
                >
                    {{ pageProps.errors.image }}
                </span>
            </div>

            <div class="form-field form-control w-full">
                <label class="label">
                    <span class="label-text">Gender</span>
                </label>
                <select
                    v-model="form.gender"
                    class="select w-full focus-within:outline-none"
                    :class="{
                        'select-error': form.errors.gender,
                    }"
                >
                    <option value="" disabled>Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    <option value="unknown">Prefer not to say</option>
                </select>
                <label v-if="form.errors.gender" class="label">
                    <span class="label-text-alt text-error">{{
                        form.errors.gender
                    }}</span>
                </label>
            </div>

            <div class="form-field form-control w-full">
                <label class="label">
                    <span class="label-text">Phone</span>
                </label>
                <input
                    v-model="form.phone"
                    type="tel"
                    placeholder="Your phone number"
                    class="input w-full focus-within:outline-none"
                    :class="{
                        'input-error': form.errors.phone,
                    }"
                />
                <label v-if="form.errors.phone" class="label">
                    <span class="label-text-alt text-error">
                        {{ form.errors.phone }}
                    </span>
                </label>
            </div>
            <div class="form-field form-control w-full">
                <label class="label">
                    <span class="label-text">Date of Birth</span>
                </label>
                <input
                    v-model="form.date_of_birth"
                    type="date"
                    @input="console.log($event.target)"
                    class="input w-full focus-within:outline-none"
                    :class="{
                        'input-error': form.errors.date_of_birth,
                    }"
                />
                <label v-if="form.errors.date_of_birth" class="label">
                    <span class="label-text-alt text-error">{{
                        form.errors.date_of_birth
                    }}</span>
                </label>
            </div>

            <div class="form-control mt-6">
                <button
                    class="btn btn-accent w-full"
                    :class="{ loading: form.processing }"
                    @click="submit"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
