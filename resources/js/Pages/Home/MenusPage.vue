<script setup lang="ts">
import HomeLayout from '@/Layouts/HomeLayout.vue';

defineOptions({
    layout: HomeLayout,
});
</script>

<template>
    <div class="bg-base-200 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Added Header Section -->
            <div class="mb-12 flex items-center justify-between">
                <div>
                    <h1 class="mb-2 text-4xl font-bold">Our Menu</h1>
                    <p class="text-gray-600">
                        Discover our delicious appetizers and specialties
                    </p>
                </div>
                <div>
                    <label class="input flex items-center gap-2 border-none">
                        <input
                            type="text"
                            class="input-sm grow focus-visible:ring-0"
                            placeholder="Search"
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 16 16"
                            fill="currentColor"
                            class="h-4 w-4 opacity-70"
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

            <!-- Menu Items Container -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- Menu Card -->
                <div
                    v-for="i in 5"
                    class="card glass transition-shadow duration-300 hover:shadow-xl"
                >
                    <!-- Image Container with Fixed Aspect Ratio -->
                    <figure class="relative pt-[75%]">
                        <img
                            src="https://food.fnr.sndimg.com/content/dam/images/food/fullset/2022/10/24/FNK_CLAM_DIP_H_f.jpg.rend.hgtvcom.791.633.85.suffix/1666710963839.webp"
                            alt="Clam Dip"
                            class="absolute top-0 left-0 h-full w-full object-cover"
                        />
                    </figure>

                    <div class="card-body">
                        <h2 class="card-title text-xl font-semibold">
                            Clam Dip
                        </h2>
                        <p class="text-gray-600">
                            Clam dip is one of those old-timey New England
                            dishes that is popular up and down the coast, often
                            made for family gatherings like barbecues or
                            holidays.
                        </p>
                        <div
                            class="card-actions mt-4 items-center justify-between"
                        >
                            <div class="flex gap-2">
                                <div class="badge badge-outline">Appetizer</div>
                                <div class="badge badge-outline">Seafood</div>
                            </div>
                            <div class="text-lg font-bold">$1.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
