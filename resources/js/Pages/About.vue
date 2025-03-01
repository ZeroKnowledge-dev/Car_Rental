<script setup>
import { Head, Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});

const features = [
    {
        title: 'Wide Selection',
        description: 'Choose from our extensive fleet of vehicles, from economy cars to luxury vehicles.',
        icon: 'M3 3h18v18H3V3zm4 10h10M7 7h10',
    },
    {
        title: 'Fast & Easy Booking',
        description: 'Book your car in minutes with our simple online booking system.',
        icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    },
    {
        title: 'Secure & Reliable',
        description: 'All our cars are regularly maintained and thoroughly cleaned for your safety.',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    },
    {
        title: '24/7 Support',
        description: 'Our customer support team is always ready to help you with any questions.',
        icon: 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    },
];

const stats = [
    { number: '1000+', label: 'Happy Customers' },
    { number: '150+', label: 'Premium Cars' },
    { number: '50+', label: 'Pickup Locations' },
    { number: '24/7', label: 'Customer Support' },
];

const team = [
    {
        name: 'John Smith',
        role: 'CEO & Founder',
        image: '/images/team/john.jpg',
    },
    {
        name: 'Sarah Johnson',
        role: 'Operations Manager',
        image: '/images/team/sarah.jpg',
    },
    {
        name: 'Michael Brown',
        role: 'Fleet Manager',
        image: '/images/team/michael.jpg',
    },
];
</script>

<template>

    <Head title="About Us" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative bg-[#EAF9E7] py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-[#013237] sm:text-5xl md:text-6xl">
                        About Our Company
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-600 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Providing quality car rental services since 2024. Making your journeys comfortable and
                        memorable.
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <div v-for="stat in stats" :key="stat.label" class="text-center">
                        <div class="text-4xl font-bold text-[#4CA771]">{{ stat.number }}</div>
                        <div class="mt-2 text-sm text-gray-600">{{ stat.label }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#013237]">Why Choose Us</h2>
                    <p class="mt-4 text-gray-600">Experience the best car rental service in the industry</p>
                </div>
                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    <div v-for="feature in features" :key="feature.title"
                        class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-md bg-[#4CA771] text-white flex items-center justify-center mb-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path :d="feature.icon" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-[#013237]">{{ feature.title }}</h3>
                        <p class="mt-2 text-gray-600">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="bg-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-3xl font-bold text-[#013237]">Our Mission</h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                        To provide our customers with the most reliable, convenient, and affordable car rental
                        experience
                        while maintaining the highest standards of customer service and vehicle quality.
                    </p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-[#013237] py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-white">Ready to Start Your Journey?</h2>
                    <p class="mt-4 text-xl text-gray-300">
                        Browse our selection of premium vehicles and book your next adventure today.
                    </p>
                    <div class="mt-8">
                        <Link :href="route('cars')"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-[#013237] bg-white hover:bg-gray-50">
                        View Our Cars
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
