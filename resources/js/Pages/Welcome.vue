<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import CarCard from '@/Components/CarCard.vue';

defineProps({
    featureCars: Array,
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>

    <Head title="Welcome" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-[#EAF9E7] to-[#C0E6BA] py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-[#013237] sm:text-5xl md:text-6xl">
                        Easy Car Rentals
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-xl text-[#4CA771] sm:text-2xl md:mt-5 md:max-w-3xl">
                        Rent your dream car at affordable prices
                    </p>
                    <div class="mt-10 flex justify-center">
                        <Link :href="route('cars')"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-[#4CA771] hover:bg-[#013237]">
                        Browse Cars
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Cars -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-[#013237] sm:text-4xl">
                        Featured Cars
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                        Check out our top picks for your next journey
                    </p>
                </div>

                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <CarCard v-for="car in featureCars" :key="car.id" :car="car" />
                </div>

                <div class="mt-10 text-center">
                    <Link :href="route('cars')"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-[#4CA771] bg-white hover:bg-gray-50 border-[#4CA771]">
                    View All Cars
                    </Link>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="py-12 bg-[#EAF9E7]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-[#013237] sm:text-4xl">
                        Why Choose Us
                    </h2>
                </div>

                <div class="mt-10 grid gap-8 md:grid-cols-3">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-[#4CA771] text-2xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#013237]">Quick & Easy Booking</h3>
                        <p class="mt-2 text-gray-600">Book your car in minutes with our simple booking process.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-[#4CA771] text-2xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#013237]">Best Price Guarantee</h3>
                        <p class="mt-2 text-gray-600">We offer competitive pricing without compromising on quality.</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-[#4CA771] text-2xl mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-[#013237]">Fully Insured Cars</h3>
                        <p class="mt-2 text-gray-600">All our vehicles come with comprehensive insurance for your peace
                            of mind.</p>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
