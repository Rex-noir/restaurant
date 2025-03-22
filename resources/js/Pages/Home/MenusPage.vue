<script setup lang="ts">
import MenuItem from '@/Components/menu-item.vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { PageProps, PaginatedResponse } from '@/types';
import debounce from '@/utils/debounce';
import { router, usePage } from '@inertiajs/vue3';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { computed, nextTick, onMounted, ref, watch } from 'vue';

const page = usePage<
    PageProps<{
        categories: App.Data.CategoryData[];
        menuItems: PaginatedResponse<App.Data.MenuItemData>;
    }>
>();

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

defineOptions({
    layout: HomeLayout,
});

// Create refs for staggered animation
const headerRef = ref(null);
const searchRef = ref(null);
const menuItemsRef = ref(null);
const searching = ref(false);
// Get initial values from URL
const urlParams = new URLSearchParams(window.location.search);
const searchQuery = ref(urlParams.get('search') || '');
const currentPage = ref(parseInt(urlParams.get('page') || '1'));

// Get category directly from URL each time
const getSelectedCategory = () => {
    return new URLSearchParams(window.location.search).get('category') || '';
};

// Fetch menu items with current filters
const fetchMenuItems = (resetPage = false) => {
    const params: any = {
        page: resetPage ? 1 : currentPage.value,
    };

    if (getSelectedCategory()) {
        params['category'] = getSelectedCategory();
    }

    if (searchQuery.value.trim()) {
        params['search'] = searchQuery.value;
    }

    router.get(
        route('menus.index', params),
        {},
        { preserveScroll: true, only: ['menuItems'], preserveState: true },
    );

    searching.value = false;
};

const debounceFeatchItems = debounce(() => fetchMenuItems(true), 1000);

// Watch for search query changes and reset to page 1
watch(searchQuery, () => {
    searching.value = true;
    debounceFeatchItems();
});

// Watch for page changes
watch(currentPage, () => {
    fetchMenuItems(false);
});

const paginatedMenu = computed(() => page.props.menuItems);

// Pagination helpers
const goToPage = (page: number) => {
    currentPage.value = page;
};

// Helper to update category in URL
const updateCategory = (category: string) => {
    const params: any = {};

    if (category.trim()) {
        params['category'] = category;
        params['page'] = 1; // Reset to page 1 when changing category
    }

    if (searchQuery.value.trim()) {
        params['search'] = searchQuery.value;
    }

    router.get(
        route('menus.index', params),
        {},
        { preserveScroll: true, preserveState: true, showProgress: true },
    );
};

const resetFilters = () => {
    searchQuery.value = '';
    updateCategory('');
};

const hasItems = computed(() => paginatedMenu.value.data.length > 0);

onMounted(() => {
    // Initial animations when page loads
    const mainTimeline = gsap.timeline();

    // Header animation
    mainTimeline.from(headerRef.value, {
        y: -20,
        opacity: 0,
        duration: 0.1,
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

    // Only apply menu card animations if items exist
    if (hasItems.value) {
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
    }
});
</script>

<template>
    <div class="min-h-screen overflow-hidden py-12">
        <div class="container">
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
                <div ref="searchRef" class="w-full p-2 md:w-auto">
                    <label class="input input-ghost w-full">
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="grow ring-0"
                            placeholder="Search our menu..."
                        />
                        <span
                            v-if="searching"
                            class="loading loading-ring loading-xs absolute top-1/2 right-3 -translate-y-1/2"
                        ></span>
                        <svg
                            v-else
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
                    </label>
                </div>
            </div>

            <!-- Subtle Category Navigation -->
            <div class="mb-8 flex flex-wrap gap-2">
                <button
                    @click="updateCategory('')"
                    class="btn btn-sm"
                    :class="{ 'btn-primary': getSelectedCategory() === '' }"
                >
                    All
                </button>
                <button
                    v-for="category in page.props.categories"
                    :key="category.name"
                    @click="updateCategory(category.name)"
                    class="btn btn-sm"
                    :class="{
                        'btn-primary!': getSelectedCategory() === category.name,
                        'btn-ghost': getSelectedCategory() !== category.name,
                    }"
                >
                    {{ category.name }}
                </button>
            </div>

            <!-- Menu Items Container with Refined Design -->
            <div
                ref="menuItemsRef"
                class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                v-if="hasItems"
            >
                <!-- Menu Card with Modern Design -->
                <MenuItem
                    v-for="item in paginatedMenu.data"
                    :key="item.slug"
                    :item="item"
                />
            </div>

            <!-- Empty State -->
            <div v-if="!hasItems" class="py-12 text-center">
                <div class="mb-3 text-2xl">No menu items found</div>
                <p class="text-base-content/70">
                    Try adjusting your search criteria
                </p>
                <button @click="resetFilters" class="btn btn-primary mt-4">
                    Reset Search
                </button>
            </div>

            <!-- Pagination Component (DaisyUI) -->
            <div
                class="mt-12 flex justify-center"
                v-if="paginatedMenu.meta.last_page > 1"
            >
                <div class="join">
                    <!-- Previous page button -->
                    <button
                        class="join-item btn"
                        :class="{
                            'btn-disabled':
                                paginatedMenu.meta.current_page === 1,
                        }"
                        @click="goToPage(paginatedMenu.meta.current_page - 1)"
                        :disabled="paginatedMenu.meta.current_page === 1"
                    >
                        «
                    </button>

                    <!-- Page numbers -->
                    <template
                        v-for="page in paginatedMenu.meta.last_page"
                        :key="page"
                    >
                        <!-- Show first page, current page, last page, and pages adjacent to current -->
                        <button
                            v-if="
                                page === 1 ||
                                page === paginatedMenu.meta.last_page ||
                                (page >= paginatedMenu.meta.current_page - 1 &&
                                    page <= paginatedMenu.meta.current_page + 1)
                            "
                            class="join-item btn"
                            :class="{
                                'btn-active':
                                    page === paginatedMenu.meta.current_page,
                            }"
                            @click="goToPage(page)"
                        >
                            {{ page }}
                        </button>

                        <!-- Ellipsis for skipped pages -->
                        <button
                            v-else-if="
                                (page === 2 &&
                                    paginatedMenu.meta.current_page > 3) ||
                                (page === paginatedMenu.meta.last_page - 1 &&
                                    paginatedMenu.meta.current_page <
                                        paginatedMenu.meta.last_page - 2)
                            "
                            class="join-item btn btn-disabled"
                        >
                            ...
                        </button>
                    </template>

                    <!-- Next page button -->
                    <button
                        class="join-item btn"
                        :class="{
                            'btn-disabled':
                                paginatedMenu.meta.current_page ===
                                paginatedMenu.meta.last_page,
                        }"
                        @click="goToPage(paginatedMenu.meta.current_page + 1)"
                        :disabled="
                            paginatedMenu.meta.current_page ===
                            paginatedMenu.meta.last_page
                        "
                    >
                        »
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
