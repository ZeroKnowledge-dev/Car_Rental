<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

const features = [
    {
        title: 'Wide Selection',
        description: 'Choose from our extensive fleet of vehicles, from economy cars to luxury vehicles.',
        icon: 'M12 4v16m8-8H4', // Icon path for wide selection
    },
    {
        title: 'Fast & Easy Booking',
        description: 'Book your car in minutes with our simple online booking system.',
        icon: 'M13 10V3L4 14h7v7l9-11h-7z', // Icon path for fast booking
    },
    {
        title: 'Secure & Reliable',
        description: 'All our cars are regularly maintained and thoroughly cleaned for your safety.',
        icon: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', // Icon path for secure cars
    },
    {
        title: '24/7 Support',
        description: 'Our customer support team is always ready to help you with any questions.',
        icon: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z', // Icon path for support
    },
];
</script>

<template>

    <Head title="About" />
    <header class="bg-[#66abb8] dark:bg-gray-900">
        <nav v-if="canLogin" class=" py-2 px-20">
            <template v-if="$page.props.auth.user">
                <div class="flex justify-between items-center px-4 py-2">
                    <!-- Left side (Dashboard link) -->
                    <div class="flex items-center">
                        <Link :href="route('dashboard')"
                            class="text-black dark:text-white px-3 py-2 rounded-md text-lg font-semibold ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>
                    </div>

                    <!-- Right side (Home, Cars, About, Contact links) -->
                    <div class="flex space-x-4">
                        <Link :href="route('welcome')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Home
                        </Link>
                        <Link :href="route('cars')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Cars
                        </Link>
                        <Link :href="route('about')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        About
                        </Link>
                        <Link :href="route('contact')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Contact
                        </Link>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex justify-end items-center px-4 py-2">
                    <!-- Login/Register links -->
                    <div class="flex space-x-4">
                        <Link :href="route('welcome')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Home
                        </Link>
                        <Link :href="route('cars')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Cars
                        </Link>
                        <Link :href="route('about')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        About
                        </Link>
                        <Link :href="route('contact')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Contact
                        </Link>
                        <Link :href="route('login')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                        </Link>

                        <Link v-if="canRegister" :href="route('register')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register
                        </Link>
                    </div>
                </div>
            </template>
        </nav>
    </header>


    <main class="mt-6">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="lg:text-center mb-12">
                            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Our Story</h2>
                            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                Your Trusted Car Rental Partner
                            </p>
                            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                                We've been providing quality car rental services since 2024, making your journeys
                                comfortable and memorable.
                            </p>
                        </div>

                        <div class="mt-10">
                            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                                <div class="relative" v-for="(feature, index) in features" :key="index">
                                    <dt>
                                        <div
                                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path :d="feature.icon" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" />
                                            </svg>
                                        </div>
                                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{ feature.title }}
                                        </p>
                                    </dt>
                                    <dd class="mt-2 ml-16 text-base text-gray-500">
                                        {{ feature.description }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-16 text-center">
                            <Link :href="route('contact')"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Contact Us
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
