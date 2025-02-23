<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const user = usePage().props.auth.user;

onMounted(() => {
    console.log(user);
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

    <div class="flex min-h-screen flex-col">
        <!-- Navigation -->
        <nav class="navbar bg-base-300 border-base-200 border-b">
            <div class="navbar-start">
                <div class="dropdown">
                    <div
                        tabindex="0"
                        role="button"
                        class="btn btn-ghost lg:hidden"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16"
                            />
                        </svg>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-sm dropdown-content rounded-box bg-base-100 z-50 mt-3 w-52 p-2 shadow"
                    >
                        <li><a>Menu</a></li>
                        <li><a>Reservations</a></li>
                        <li><a>About Us</a></li>
                    </ul>
                </div>
                <a class="btn btn-ghost">
                    <span class="text-primary font-serif text-xl font-bold">
                        <a href="/"> The Restaurant Experience</a>
                    </span>
                </a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a :href="route('menus')">Menu</a></li>
                    <li><a>Reservations</a></li>
                    <li><a>About Us</a></li>
                </ul>
            </div>

            <div class="navbar-end">
                <a v-if="user" class="btn btn-primary">Book a Table</a>
                <a v-else class="btn btn-sm btn-primary">Login / Signup</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <footer
            class="footer footer-center bg-base-200 text-base-content rounded p-10"
        >
            <nav class="grid grid-flow-col gap-4">
                <a class="link link-hover">About us</a>
                <a class="link link-hover">Contact</a>
                <a class="link link-hover">Jobs</a>
                <a class="link link-hover">Press kit</a>
            </nav>
            <nav>
                <div class="grid grid-flow-col gap-4">
                    <a>
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
                    <a>
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
                    <a>
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
            </nav>
            <aside>
                <p>
                    Copyright © {{ new Date().getFullYear() }} - All right
                    reserved by The Restaurant Experience Ltd
                </p>
            </aside>
        </footer>
    </div>
</template>
