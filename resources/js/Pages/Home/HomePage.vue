<script setup lang="ts">
import HomeLayout from '@/Layouts/HomeLayout.vue';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';
import { onMounted } from 'vue';

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger);

defineOptions({
    layout: HomeLayout,
});

onMounted(() => {
    // Hero Section Timeline
    const heroTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: '.hero-section',
            start: 'top 80%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse',
        },
    });

    heroTimeline
        .from('.hero-content', {
            y: -50,
            opacity: 0,
            duration: 1,
            ease: 'power3.out',
        })
        .from(
            '.hero-image',
            {
                x: 50,
                opacity: 0,
                duration: 1,
                ease: 'power3.out',
            },
            '-=0.5', // Overlap with the previous animation by 0.5 seconds
        );

    // Stats Card Timeline
    const statsTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: '.stats-container',
            start: 'top 80%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse',
        },
    });

    statsTimeline.from('.stat', {
        y: 20,
        opacity: 0,
        duration: 0.8,
        ease: 'back.out(1.7)',
        stagger: 0.2,
    });

    // Featured Section Timeline
    const featuredTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: '.featured-section',
            start: 'top 80%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse',
        },
    });

    featuredTimeline.from('.featured-card', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power2.out',
        stagger: 0.2,
    });

    // Reservation Card Timeline
    const reservationTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: '.reservation-card',
            start: 'top 80%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse',
        },
    });

    reservationTimeline.from('.reservation-card', {
        scale: 0.8,
        opacity: 0,
        duration: 0.8,
        ease: 'elastic.out(1, 0.7)',
    });

    // Footer Cards Timeline
    const footerTimeline = gsap.timeline({
        scrollTrigger: {
            trigger: '.footer-cards',
            start: 'top 80%',
            end: 'bottom 60%',
            toggleActions: 'play none none reverse',
        },
    });

    footerTimeline.from('.footer-card', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power2.out',
        stagger: 0.2,
    });
});
</script>

<template>
    <div class="bg-base-200">
        <div class="container mx-auto px-4">
            <!-- Hero Section -->
            <div
                class="hero-section grid min-h-screen items-center gap-8 lg:grid-cols-2"
            >
                <!-- Left Content -->
                <div
                    class="hero-content flex flex-col justify-center space-y-6"
                >
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
                        <button class="btn btn-outline">
                            View Menus or Order Directly Online
                        </button>
                    </div>
                </div>
                <!-- Right Image -->
                <div
                    class="hero-image relative self-center overflow-hidden rounded-xl"
                >
                    <img
                        src="https://images.pexels.com/photos/67468/pexels-photo-67468.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                        alt="Restaurant ambiance"
                        class="h-full w-full object-cover"
                    />
                </div>
            </div>
            <!-- Stats Card -->
            <div class="stats-container mt-12">
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
            <div class="featured-section mt-12 grid gap-8 lg:grid-cols-3">
                <div class="featured-card card bg-base-200">
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
                <div class="featured-card card bg-base-200">
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
                <div class="featured-card card bg-base-200">
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
                <div
                    class="reservation-card card bg-primary text-primary-content"
                >
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
            <div class="footer-cards container mx-auto px-4">
                <div class="grid gap-8 lg:grid-cols-3">
                    <!-- Hours Card -->
                    <div class="footer-card card bg-base-100 shadow-xl">
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
                    <div class="footer-card card bg-base-100 shadow-xl">
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
                    <div class="footer-card card bg-base-100 shadow-xl">
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
