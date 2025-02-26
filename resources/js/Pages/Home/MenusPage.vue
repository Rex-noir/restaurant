<script setup lang="ts">
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps } from '@/types';
import { usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { nextTick, onMounted, ref } from 'vue';

const page = usePage<PageProps<{ categories: App.Data.CategoryData[] }>>();

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

defineOptions({
    layout: HomeLayout,
});

// Create refs for staggered animation
const headerRef = ref(null);
const searchRef = ref(null);
const menuItemsRef = ref(null);

// Menu data
const menuItems = [
    {
        id: 1,
        name: 'Clam Dip',
        description:
            'Clam dip is one of those old-timey New England dishes that is popular up and down the coast, often made for family gatherings like barbecues or holidays.',
        image: 'https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp',
        price: '$12.00',
        tags: ['Appetizer', 'Seafood'],
    },
    {
        id: 2,
        name: 'Wild Mushroom Risotto',
        description:
            'Creamy arborio rice slow-cooked with a medley of wild mushrooms, finished with truffle oil and aged parmesan.',
        image: 'https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp',
        price: '$18.50',
        tags: ['Main', 'Vegetarian'],
    },
    {
        id: 3,
        name: 'Seared Scallops',
        description:
            'Pan-seared scallops with cauliflower puree, crispy pancetta, and micro greens drizzled with brown butter sauce.',
        image: 'https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp',
        price: '$23.00',
        tags: ['Seafood', 'Gluten-Free'],
    },
    {
        id: 4,
        name: 'Braised Short Ribs',
        description:
            'Slow-braised beef short ribs with red wine reduction, served with creamy polenta and roasted seasonal vegetables.',
        image: 'https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp',
        price: '$28.00',
        tags: ['Main', 'Signature'],
    },
    {
        id: 5,
        name: 'Tiramisu',
        description:
            'Classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone cream, dusted with cocoa powder.',
        image: 'https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp',
        price: '$10.00',
        tags: ['Dessert', 'Sweet'],
    },
];

// Filter state
const searchQuery = ref('');
const filteredItems = ref(menuItems);

// Filter function
const filterMenu = () => {
    if (!searchQuery.value) {
        filteredItems.value = menuItems;
        return;
    }

    const query = searchQuery.value.toLowerCase();
    filteredItems.value = menuItems.filter(
        (item) =>
            item.name.toLowerCase().includes(query) ||
            item.description.toLowerCase().includes(query) ||
            item.tags.some((tag) => tag.toLowerCase().includes(query)),
    );
};

onMounted(() => {
    // Initial animations when page loads
    const mainTimeline = gsap.timeline();

    // Header animation
    mainTimeline.from(headerRef.value, {
        y: -20,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out',
    });

    // Search bar animation
    mainTimeline.from(
        searchRef.value,
        {
            x: 20,
            opacity: 0,
            duration: 0.6,
            ease: 'power2.out',
        },
        '-=0.4',
    );

    // Menu cards staggered animation
    nextTick(() => {
        mainTimeline.from(
            '.menu-card',
            {
                y: 30,
                opacity: 0,
                duration: 0.7,
                stagger: 0.1,
                ease: 'power2.out',
            },
            '-=0.2',
        );
    });
    // Scroll animations for cards that come into view later
    gsap.from('.card-image', {
        scale: 1.05,
        opacity: 0.8,
        duration: 0.8,
        ease: 'power1.out',
        scrollTrigger: {
            trigger: menuItemsRef.value,
            start: 'top 80%',
            toggleActions: 'play none none none',
            once: true,
        },
    });

    // Badge animation on scroll
    gsap.from('.badge', {
        scale: 0.8,
        opacity: 0,
        duration: 0.4,
        stagger: 0.05,
        ease: 'back.out(1.7)',
        scrollTrigger: {
            trigger: menuItemsRef.value,
            start: 'top 70%',
            toggleActions: 'play none none none',
            once: true,
        },
    });

    // Card hover animations
    const cards = document.querySelectorAll('.menu-card');
    cards.forEach((card) => {
        card.addEventListener('mouseenter', () => {
            gsap.to(card.querySelector('.card-image'), {
                scale: 1.05,
                duration: 0.4,
                ease: 'power1.out',
            });

            gsap.to(card.querySelector('.card-body'), {
                y: -5,
                duration: 0.3,
                ease: 'power1.out',
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card.querySelector('.card-image'), {
                scale: 1,
                duration: 0.4,
                ease: 'power1.out',
            });

            gsap.to(card.querySelector('.card-body'), {
                y: 0,
                duration: 0.3,
                ease: 'power1.out',
            });
        });
    });
});
</script>

<template>
    <div class="bg-base-100 min-h-screen overflow-hidden py-12">
        <div class="container mx-auto max-w-6xl px-4">
            <!-- Header Section with Subtle Design -->
            <div
                ref="headerRef"
                class="mb-12 flex flex-col gap-6 md:flex-row md:items-center md:justify-between"
            >
                <div class="max-w-lg">
                    <h1
                        class="text-base-content relative mb-3 inline-block text-4xl font-bold"
                    >
                        Our Menu
                        <span
                            class="bg-primary absolute -bottom-1 left-0 h-1 w-1/3 rounded-full"
                        ></span>
                    </h1>
                    <p class="text-base-content/70 text-lg">
                        Discover our carefully crafted selections of seasonal
                        specialties
                    </p>
                </div>
                <div ref="searchRef" class="w-full md:w-auto">
                    <div class="relative">
                        <input
                            v-model="searchQuery"
                            @input="filterMenu"
                            type="text"
                            class="input input-bordered bg-base-200/50 border-base-300 focus:border-primary placeholder:text-base-content/50 w-full pr-10 transition-all duration-300 md:w-64"
                            placeholder="Search our menu..."
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="absolute top-1/2 right-3 h-4 w-4 -translate-y-1/2 transform opacity-70"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Subtle Category Navigation -->
            <div class="mb-8 flex flex-wrap gap-2">
                <button class="btn btn-sm btn-primary">All Items</button>
                <button class="btn btn-sm btn-ghost hover:bg-base-200">
                    Appetizers
                </button>
                <button class="btn btn-sm btn-ghost hover:bg-base-200">
                    Main Courses
                </button>
                <button class="btn btn-sm btn-ghost hover:bg-base-200">
                    Seafood
                </button>
                <button class="btn btn-sm btn-ghost hover:bg-base-200">
                    Desserts
                </button>
            </div>

            <!-- Menu Items Container with Refined Design -->
            <div
                ref="menuItemsRef"
                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
            >
                <!-- Menu Card with Modern Design -->
                <div
                    v-for="item in filteredItems"
                    :key="item.id"
                    class="menu-card card bg-base-100 border-base-200 overflow-hidden border shadow-md hover:shadow-lg"
                >
                    <!-- Image Container with Fixed Aspect Ratio -->
                    <figure class="relative overflow-hidden pt-[66%]">
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="card-image absolute top-0 left-0 h-full w-full object-cover transition-all duration-500"
                        />
                        <div
                            class="bg-primary text-primary-content absolute top-3 right-3 rounded-full px-3 py-1 text-sm font-medium"
                        >
                            {{ item.price }}
                        </div>
                    </figure>

                    <div class="card-body p-6">
                        <h2 class="card-title mb-2 text-xl font-semibold">
                            {{ item.name }}
                        </h2>
                        <p class="text-base-content/70 mb-4 text-sm">
                            {{ item.description }}
                        </p>
                        <div class="mt-auto flex flex-wrap gap-2">
                            <div
                                v-for="(tag, index) in item.tags"
                                :key="index"
                                class="badge badge-outline px-2 py-1 text-xs"
                            >
                                {{ tag }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredItems.length === 0" class="py-12 text-center">
                <div class="mb-3 text-2xl">No menu items found</div>
                <p class="text-base-content/70">
                    Try adjusting your search criteria
                </p>
                <button
                    @click="
                        searchQuery = '';
                        filterMenu();
                    "
                    class="btn btn-primary mt-4"
                >
                    Reset Search
                </button>
            </div>
        </div>
    </div>
</template>
