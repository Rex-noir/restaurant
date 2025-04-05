<script setup lang="ts">
import env from '@/utils/env';
import { Head } from '@inertiajs/vue3';
</script>
<template>
    <Head>
        <title>Checkout</title>
    </Head>
    <header>
        <div class="navbar bg-primary text-primary-content">
            <button class="btn btn-ghost text-xl">{{ env('APP_NAME') }}</button>
        </div>
    </header>
    <main>
        <slot />
    </main>
</template>
