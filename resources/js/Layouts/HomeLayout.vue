<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { onMounted } from 'vue';

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

const page = usePage();

const user = page.props.auth.user;

const menuItems = [
    {
        label: 'Menus',
        name: 'menus.index',
        visible: true,
    },
    // {
    //     label: 'Reservations',
    //     name: '/reservations',
    //     visible: true,
    // },
    // {
    //     label: 'About Us',
    //     name: '/about',
    //     visible: true,
    // },
    // {
    //     label: 'Contact Us',
    //     name: '/contact',
    //     visible: true,
    // },
    {
        label: 'Login',
        name: 'login',
        visible: !user,
    },
    {
        label: 'Register',
        name: 'register',
        visible: !user,
    },
    {
        label: 'My Account',
        name: 'profile.edit',
        visible: user,
    },
];

onMounted(() => {
    // Navbar Animation
    gsap.from('.navbar', {
        y: -50,
        opacity: 0,
        duration: 1,
        ease: 'power3.out',
    });

    // Footer Animation - Fixed to ensure it shows up
    const footerTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: 'footer',
            start: 'top bottom', // Trigger when footer enters viewport
            toggleActions: 'play none none none',
            once: true, // Only trigger once
        },
    });

    footerTimeline
        .from('.footer-links a', {
            y: 20,
            opacity: 0,
            duration: 0.6,
            ease: 'power2.out',
            stagger: 0.1,
        })
        .from(
            '.social-icons a',
            {
                scale: 0.5,
                opacity: 0,
                duration: 0.4,
                ease: 'back.out(1.7)',
                stagger: 0.1,
            },
            '-=0.3',
        )
        .from(
            '.copyright',
            {
                y: 20,
                opacity: 0,
                duration: 0.6,
                ease: 'power2.out',
            },
            '-=0.2',
        );
});
</script>

<template>
    <Head>
        <title>The Restaurant Experience</title>
        <meta
            name="description"
            content="A cozy haven where flavor meets tradition since 2003"
        />
    </Head>
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex min-h-screen flex-col">
            <!-- Improved Navigation -->
            <div
                class="navbar bg-base-200 border-base-300 border-b py-3 shadow-sm"
            >
                <div
                    class="container mx-auto flex items-center justify-between px-4"
                >
                    <div class="flex-none lg:hidden">
                        <label
                            for="my-drawer-3"
                            class="btn btn-square btn-ghost"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                class="inline-block h-6 w-6 stroke-current"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </label>
                    </div>
                    <div class="mx-2 flex-1 px-2">
                        <Link
                            href="/"
                            class="text-primary hover:text-primary-focus font-serif text-2xl font-bold transition-colors"
                        >
                            The Restaurant Experience
                        </Link>
                    </div>
                    <div class="hidden flex-none lg:block">
                        <ul class="menu menu-horizontal">
                            <template v-for="item in menuItems">
                                <li v-if="item.visible" :key="item.label">
                                    <Link
                                        replace
                                        :href="route(item.name)"
                                        :class="{
                                            'text-accent font-semibold':
                                                route().current() === item.name,
                                        }"
                                    >
                                        {{ item.label }}
                                    </Link>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <main class="m-5 mx-auto w-full max-w-6xl grow p-5 md:p-0">
                <slot />
            </main>

            <!-- Improved Footer -->
            <footer class="bg-base-200 border-base-300 border-t py-10">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Links Section -->
                        <div
                            class="footer-links flex flex-col items-center space-y-3 md:items-start"
                        >
                            <h3 class="mb-2 text-lg font-bold">Explore</h3>
                            <a href="/about" class="link link-hover"
                                >About Us</a
                            >
                            <a href="/contact" class="link link-hover"
                                >Contact</a
                            >
                            <a href="/careers" class="link link-hover"
                                >Careers</a
                            >
                            <a href="/press" class="link link-hover"
                                >Press Kit</a
                            >
                        </div>

                        <!-- Hours & Location -->
                        <div class="text-center md:text-left">
                            <h3 class="mb-4 text-lg font-bold">
                                Hours & Location
                            </h3>
                            <p class="mb-2">123 Gourmet Street</p>
                            <p class="mb-2">Foodville, FC 12345</p>
                            <p class="mb-4">Phone: (555) 123-4567</p>
                            <p class="font-medium">Mon-Fri: 11am-10pm</p>
                            <p class="font-medium">Sat-Sun: 9am-11pm</p>
                        </div>

                        <!-- Social & Newsletter -->
                        <div class="flex flex-col items-center md:items-end">
                            <h3 class="mb-4 text-lg font-bold">
                                Connect With Us
                            </h3>
                            <div class="social-icons mb-6 flex gap-4">
                                <a
                                    href="#"
                                    class="hover:text-primary transition-colors"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        class="fill-current"
                                    >
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
                                        ></path>
                                    </svg>
                                </a>
                                <a
                                    href="#"
                                    class="hover:text-primary transition-colors"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        class="fill-current"
                                    >
                                        <path
                                            d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"
                                        ></path>
                                    </svg>
                                </a>
                                <a
                                    href="#"
                                    class="hover:text-primary transition-colors"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        class="fill-current"
                                    >
                                        <path
                                            d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
                                        ></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text"
                                        >Subscribe to our newsletter</span
                                    >
                                </label>
                                <div class="join">
                                    <input
                                        type="email"
                                        placeholder="Your email"
                                        class="input input-bordered join-item w-full"
                                    />
                                    <button class="btn btn-primary join-item">
                                        Subscribe
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div
                        class="copyright border-base-300 mt-10 border-t pt-6 text-center"
                    >
                        <p>
                            Copyright © {{ new Date().getFullYear() }} - All
                            rights reserved by The Restaurant Experience Ltd
                        </p>
                    </div>
                </div>
            </footer>
        </div>

        <div class="drawer-side">
            <label
                for="my-drawer-3"
                aria-label="close sidebar"
                class="drawer-overlay"
            ></label>
            <ul class="menu bg-base-200 w-full p-4">
                <!-- Sidebar content here -->
                <li><a>Sidebar Item 1</a></li>
                <li><a>Sidebar Item 2</a></li>
            </ul>
        </div>
    </div>
</template>
