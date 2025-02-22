<script setup lang="ts">
import HomeLayout from '@/Layouts/HomeLayout.vue';

defineOptions({
    layout: HomeLayout,
});
</script>

<template>
    <div class="bg-base-200 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Hero Section -->
            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Left Content -->
                <div class="flex flex-col justify-center space-y-6">
                    <h1 class="text-primary font-serif text-4xl font-bold">
                        The Restaurant Experience
                    </h1>
                    <p class="text-base-content/80 text-lg">
                        A cozy haven where flavor meets tradition. Since 2003,
                        we've been crafting culinary memories through our
                        extensive selection of mouth-watering dishes and
                        refreshing drinks.
                    </p>
                    <div class="flex gap-4">
                        <button class="btn btn-primary">Reserve a Table</button>
                        <button class="btn btn-outline">View Menu</button>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative h-[400px] overflow-hidden rounded-xl">
                    <img
                        src="https://images.pexels.com/photos/67468/pexels-photo-67468.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                        alt="Restaurant ambiance"
                        class="h-full w-full object-cover"
                    />
                </div>
            </div>

            <!-- Stats Card -->
            <div class="mt-12">
                <div
                    class="stats stats-vertical bg-base-200 lg:stats-horizontal w-full shadow-xl"
                >
                    <div class="stat">
                        <div class="stat-title">Daily Visitors</div>
                        <div class="stat-value">500+</div>
                        <div class="stat-desc">
                            ↗︎ 23% more than last month
                        </div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Menu Items</div>
                        <div class="stat-value">89,400</div>
                        <div class="stat-desc">
                            21% more variety in Macondo City
                        </div>
                    </div>

                    <div class="stat">
                        <div class="stat-title">Years of Service</div>
                        <div class="stat-value">20+</div>
                        <div class="stat-desc">Since 2003</div>
                    </div>
                </div>
            </div>

            <!-- Featured Section -->
            <div class="mt-12 grid gap-8 lg:grid-cols-3">
                <div class="card bg-base-200">
                    <figure class="px-4 pt-4">
                        <img
                            src="https://images.pexels.com/photos/262959/pexels-photo-262959.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Signature Dish"
                            class="rounded-xl"
                        />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">Signature Dishes</h2>
                        <p>
                            Discover our chef's special creations, crafted with
                            passion.
                        </p>
                    </div>
                </div>

                <div class="card bg-base-200">
                    <figure class="px-4 pt-4">
                        <img
                            src="https://images.pexels.com/photos/2306281/pexels-photo-2306281.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Private Events"
                            class="rounded-xl"
                        />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">Private Events</h2>
                        <p>
                            Perfect venue for your special occasions and
                            celebrations.
                        </p>
                    </div>
                </div>

                <div class="card bg-base-200">
                    <figure class="px-4 pt-4">
                        <img
                            src="https://images.pexels.com/photos/8942305/pexels-photo-8942305.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            alt="Wine Collection"
                            class="rounded-xl"
                        />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">Wine Collection</h2>
                        <p>
                            Extensive selection of fine wines from around the
                            world.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Reservation Card -->
            <div class="mt-12">
                <div class="card bg-primary text-primary-content">
                    <div class="card-body items-center text-center">
                        <h2 class="card-title text-2xl">
                            Book Your Experience
                        </h2>
                        <p>
                            Reserve your table for special occasions or casual
                            dining.
                        </p>
                        <div class="card-actions justify-end">
                            <button class="btn btn-secondary">
                                Make Reservation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-base-200 py-16">
            <div class="container mx-auto px-4">
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Hours Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title font-serif">Opening Hours</h2>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Monday - Thursday</span>
                                    <span>11:00 AM - 10:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Friday - Saturday</span>
                                    <span>11:00 AM - 11:00 PM</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Sunday</span>
                                    <span>10:00 AM - 9:00 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reservations Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title font-serif">Reservations</h2>
                            <p>
                                We accept reservations up to 30 days in advance.
                                For groups of 8 or more, please contact us
                                directly.
                            </p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- General Info Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title font-serif">
                                Location & Contact
                            </h2>
                            <div class="space-y-2">
                                <p>123 Culinary Street</p>
                                <p>Macondo City, MC 12345</p>
                                <p>Phone: (555) 123-4567</p>
                                <p>Email: info@restaurantexperience.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
