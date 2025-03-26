<script setup lang="ts">
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
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

            <!-- <div class="divider">OR</div> -->

            <p class="mt-4 text-center">
                Don't have an account?
                <Link
                    replace
                    :href="route('register')"
                    class="link link-secondary"
                >
                    Register
                </Link>
            </p>
        </div>
    </div>
</template>
