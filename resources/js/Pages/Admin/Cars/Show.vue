<template>

    <Head :title="'Car Details - ' + car.name" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                        Car Details
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">View and manage car information</p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
                    <Link :href="route('admin.cars.edit', car)"
                        class="inline-flex items-center px-4 py-2 bg-[#4CA771] text-white rounded-md hover:bg-[#013237] transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Car
                    </Link>
                    <Link :href="route('admin.cars.index')"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#4CA771] transition-colors duration-150">
                    Back to List
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Car Image and Status -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
                        <div class="aspect-w-16 aspect-h-9">
                            <img :src="`/storage/${props.car.image}`" :alt="car.name"
                                class="object-cover w-full h-64" />
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-[#013237]">{{ car.name }}</h3>
                                    <p class="text-sm text-gray-600">{{ car.brand }} {{ car.model }}</p>
                                </div>
                                <span :class="[
                                    car.availability ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                                    'inline-flex rounded-full px-3 py-1 text-sm font-semibold'
                                ]">
                                    {{ car.availability ? 'Available' : 'Not Available' }}
                                </span>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-2xl font-bold text-[#4CA771]">${{ car.daily_rent_price }}/day</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Car Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-lg rounded-lg border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#013237] mb-4">Car Information</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Brand</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ car.brand }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Model</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ car.model }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Year</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ car.year }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Car Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900 capitalize">{{ car.car_type }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Rental History -->
                    <div class="mt-6 bg-white shadow-lg rounded-lg border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#013237] mb-4">Rental History</h3>
                            <div v-if="rentals && rentals.length > 0">
                                <ul class="divide-y divide-gray-200">
                                    <li v-for="rental in rentals" :key="rental.id" class="py-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-[#013237]">
                                                    {{ rental.customer_name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date)
                                                    }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-medium text-[#4CA771]">${{ rental.total_cost }}
                                                </p>
                                                <span
                                                    :class="[getStatusColor(rental.status), 'inline-flex rounded-full px-2 text-xs font-semibold leading-5']">
                                                    {{ rental.status }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div v-else class="text-center py-4 text-gray-500">
                                No rental history available
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    car: Object,
    rentals: Array
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const getStatusColor = (status) => {
    switch (status) {
        case 'completed':
            return 'bg-green-100 text-green-800';
        case 'ongoing':
            return 'bg-blue-100 text-blue-800';
        case 'canceled':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>
