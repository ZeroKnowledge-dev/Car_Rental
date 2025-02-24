<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    cars: {
        type: Object,
    }
});

</script>

<template>

    <Head title="Cars" />
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Cars Grid Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="car in cars" :key="car.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="relative pb-48">
                            <img :src="`/storage/${car.image}`" :alt="car.name"
                                class="absolute h-full w-full object-cover" />
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900">{{ car.name }}</h3>
                            <p class="mt-2 text-gray-600">{{ car.brand }} {{ car.model }}</p>
                            <p class="text-gray-600">{{ car.year }} · {{ car.car_type }}</p>

                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-2xl font-bold text-indigo-600">${{ car.daily_rent_price
                                    }}/day</span>
                                <template v-if="car.availability">
                                    <Link :href="`/cars/${car.id}`"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Details
                                    </Link>
                                </template>
                                <template v-else>
                                    <Link href="#"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Not Available
                                    </Link>
                                </template>

                            </div>
                        </div>
                    </div>
                    <div v-if="!cars.length" class="md:col-span-3 text-center py-12">
                        <h3 class="text-xl font-medium text-gray-900">No cars available</h3>
                        <p class="mt-2 text-gray-600">Try adjusting your filters to find available cars.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
