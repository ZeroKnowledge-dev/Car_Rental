<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    featureCars: {
        type: Object,
    }
});
</script>

<template>

    <Head title="Welcome" />
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
                        <Link :href="route('logout')" method="post"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log Out
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
        <div>
            <!-- Hero Section -->
            <div class="relative bg-white overflow-hidden">
                <div class="max-w-7xl mx-auto">
                    <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                        <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20">
                            <div class="sm:text-center lg:text-left">
                                <h1
                                    class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                    <span class="block">Rent Your Dream Car</span>
                                    <span class="block text-indigo-600">Today</span>
                                </h1>
                                <p
                                    class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                    Choose from our wide selection of cars. From luxury to economy, we have the perfect
                                    car for your needs.
                                </p>
                                <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                    <div class="rounded-md shadow">
                                        <Link href="/cars"
                                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                        Browse Cars
                                        </Link>
                                    </div>
                                    <div class="mt-3 sm:mt-0 sm:ml-3">
                                        <Link href="/about"
                                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                        Learn More
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>

            <!-- Featured Cars Section -->
            <div class="bg-gray-100 py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Featured Cars</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            Our Latest Available Cars
                        </p>
                    </div>

                    <div class="mt-10">
                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="car in featureCars" :key="car.id"
                                class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="relative pb-48">
                                    <img :src="`storage/${car.image}`" :alt="car.name"
                                        class="absolute h-full w-full object-cover" />
                                </div>
                                <div class="px-4 py-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ car.name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ car.brand }} {{ car.model }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ car.year }} · {{ car.car_type }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-lg font-bold text-indigo-600">${{
                                            car.daily_rent_price }}/day</span>
                                        <Link :href="`/cars/${car.id}`"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Details
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 text-center">
                            <Link href="/cars"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            View All Cars
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
