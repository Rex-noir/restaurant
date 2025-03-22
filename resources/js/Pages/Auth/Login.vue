<script setup lang="ts">
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { gsap } from 'gsap';
import { computed, nextTick, onMounted, ref, useTemplateRef } from 'vue';

defineOptions({
    layout: AuthLayout,
});

const email = ref('');
const password = ref('');
const formRef = useTemplateRef('formRef');
const titleRef = ref(null);
const loginButtonRef = ref(null);
const isLoading = ref(false);

const pageProps = computed(() => usePage().props);

const handleLogin = () => {
    // Simulate API call
    router.post(
        route('login'),
        {
            email: email.value,
            password: password.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            onProgress: () => {
                isLoading.value = true;
            },
            onFinish: () => {
                isLoading.value = false;
            },
        },
    );
};

onMounted(async () => {
    const tl = gsap.timeline();

    await nextTick();

    // Animate form elements
    tl.from(titleRef.value, {
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out',
    })
        .from(
            formRef.value!.querySelectorAll('input'),
            {
                y: 20,
                opacity: 0,
                stagger: 0.2,
                duration: 0.6,
                ease: 'power2.out',
            },
            '-=0.4',
        )
        .from(
            loginButtonRef.value,
            {
                scale: 0.9,
                opacity: 0,
                duration: 0.6,
                ease: 'back.out(1.7)',
            },
            '-=0.2',
        );
});
</script>

<template>
    <Head>
        <title>Login</title>
        <meta
            name="description"
            content="A cozy haven where flavor meets tradition since 2003"
        />
    </Head>
    <div class="card bg-base-200 w-full max-w-lg shadow-xl" ref="formRef">
        <div class="card-body">
            <h2
                ref="titleRef"
                class="card-title mb-4 text-center text-2xl font-bold"
            >
                Sign In
            </h2>

            <div class="form-control">
                <label class="label w-full justify-between">
                    <span class="label-text">Email </span>
                    <span class="text-sm">{{ pageProps.errors.email }}</span>
                </label>
                <input
                    v-model="email"
                    type="email"
                    @keydown.prevent.enter="handleLogin"
                    placeholder="your@email.com"
                    :class="{
                        'input-error': pageProps.errors.email,
                        'input-accent': !pageProps.errors.email,
                    }"
                    class="input focus:input-accent w-full focus-within:outline-none"
                />
            </div>

            <div class="form-control mt-4">
                <label class="label w-full justify-between">
                    <span class="label-text">Password </span>
                    <span class="text-error text-sm">{{
                        pageProps.errors.password
                    }}</span>
                </label>
                <input
                    v-model="password"
                    type="password"
                    @keydown.prevent.enter="handleLogin"
                    placeholder="••••••••"
                    :class="{
                        'input-error': pageProps.errors.password,
                        'input-accent': !pageProps.errors.password,
                    }"
                    class="input focus:input-accent w-full focus-within:outline-none"
                />
                <label class="label">
                    <a href="#" class="label-text-alt link link-hover"
                        >Forgot password?</a
                    >
                </label>
            </div>

            <div class="form-control mt-6">
                <button
                    ref="loginButtonRef"
                    class="btn btn-accent w-full"
                    :class="{ loading: isLoading }"
                    @click="handleLogin"
                >
                    Login
                </button>
            </div>

            <div class="divider">OR</div>

            <div class="flex justify-center gap-4">
                <button class="btn btn-circle btn-outline">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"
                        />
                    </svg>
                </button>
                <button class="btn btn-circle btn-outline">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                        />
                    </svg>
                </button>
                <button class="btn btn-circle btn-outline">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"
                        />
                    </svg>
                </button>
            </div>

            <p class="mt-4 text-center">
                Don't have an account?
                <a href="#" class="link link-accent">Sign up</a>
            </p>
        </div>
    </div>
</template>
