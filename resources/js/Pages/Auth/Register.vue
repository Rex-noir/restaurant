<script setup lang="ts">
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const pageProps = usePage().props;

const form = useForm({
    name: '',
    email: '',
    password: '',
});

const handleRegister = () => {
    form.post(route('register'), {
        showProgress: true,
    });
};

defineOptions({
    layout: AuthLayout,
});
</script>
<template>
    <Head>
        <title>Register</title>
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
                Register an account
            </h2>

            <div class="form-control">
                <label class="label w-full justify-between">
                    <span class="label-text">Name</span>
                    <span class="text-sm">{{ form.errors.name }}</span>
                </label>
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Your Name"
                    :class="{
                        'input-error': form.errors.name,
                        'input-accent': !form.errors.name,
                    }"
                    class="input focus:input-accent w-full focus-within:outline-none"
                />
            </div>

            <div class="form-control">
                <label class="label w-full justify-between">
                    <span class="label-text">Email </span>
                    <span class="text-sm">{{ form.errors.email }}</span>
                </label>
                <input
                    v-model="form.email"
                    type="email"
                    @keydown.prevent.enter="handleRegister"
                    placeholder="your@email.com"
                    :class="{
                        'input-error': form.errors.email,
                        'input-accent': !form.errors.email,
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
                    v-model="form.password"
                    type="password"
                    @keydown.prevent.enter="handleRegister"
                    placeholder="••••••••"
                    :class="{
                        'input-error': form.errors.password,
                        'input-accent': !form.errors.password,
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
                    :class="{ loading: form.processing }"
                    @click="handleRegister"
                >
                    Next
                </button>
            </div>

            <!-- <div class="divider">OR</div> -->

            <p class="mt-4 text-center">
                Don't have an account?
                <Link
                    replace
                    :href="route('login')"
                    class="link link-secondary"
                >
                    Login
                </Link>
            </p>
        </div>
    </div>
</template>
