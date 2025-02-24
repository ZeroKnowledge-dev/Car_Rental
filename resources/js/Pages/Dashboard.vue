<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="About" />
    <header class="bg-[#66abb8] dark:bg-gray-900">
        <nav class=" py-2 px-20">
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
        </nav>
    </header>


    <main class="mt-6">
        <div class="flex justify-center">
            <p class="text-3xl text-[#264e69] font-bold mb-6 ">Customer Dashboard</p>
        </div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p>Car Rental App</p>
        </div>
    </main>
</template>
