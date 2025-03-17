<script setup lang="ts">
import { gsap } from 'gsap';
import { onMounted, ref } from 'vue';

const appName = import.meta.env.VITE_APP_NAME || 'The Restaurant Experience';
const containerRef = ref(null);
const logoRef = ref(null);
const welcomeRef = ref(null);

onMounted(() => {
    // Initialize GSAP animations
    gsap.from(containerRef.value, {
        opacity: 0,
        duration: 1,
        ease: 'power2.out',
    });

    gsap.from(logoRef.value, {
        y: -50,
        opacity: 0,
        duration: 1,
        ease: 'back.out(1.7)',
    });

    gsap.from(welcomeRef.value, {
        opacity: 0,
        duration: 1,
        delay: 0.3,
        ease: 'power2.out',
    });
});
</script>

<template>
    <div
        ref="containerRef"
        class="from-base-200 to-base-300 flex min-h-screen flex-col items-center justify-center bg-gradient-to-br p-4"
    >
        <div
            class="flex w-full max-w-4xl flex-col items-center gap-8 lg:flex-row"
        >
            <!-- Logo and Welcome Section -->
            <div class="flex-1 text-center lg:text-left">
                <div ref="logoRef" class="mb-6">
                    <h1
                        class="font-play-fair-display text-accent text-5xl font-bold"
                    >
                        {{ appName }}
                    </h1>
                </div>
                <div ref="welcomeRef" class="prose">
                    <h2 class="mb-4 text-2xl font-medium">Welcome Back</h2>
                    <p class="text-base-content/70">
                        Experience the finest dining with our carefully curated
                        menu and exceptional service. Log in to continue your
                        culinary journey.
                    </p>
                </div>
            </div>

            <!-- Login Form Container -->
            <div class="w-full max-w-lg flex-1">
                <main>
                    <slot></slot>
                </main>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-base-content/60 mt-16 text-center text-sm">
            <p>
                © {{ new Date().getFullYear() }} {{ appName }}. All rights
                reserved.
            </p>
        </div>
    </div>
</template>
