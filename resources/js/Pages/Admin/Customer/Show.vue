<template>

    <Head :title="'Customer - ' + customer.name" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Customer Details
                    </h2>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <Link :href="route('admin.customers.edit', customer.id)"
                        class="ml-3 inline-flex items-center rounded-md bg-[#4CA771] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#013237] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#4CA771]">
                    Edit Customer
                    </Link>
                    <Link :href="route('admin.customers.index')"
                        class="ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Back to List
                    </Link>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Customer Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div
                                    class="h-20 w-20 rounded-full bg-[#4CA771] flex items-center justify-center text-white text-3xl font-semibold">
                                    {{ customer.name.charAt(0) }}
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ customer.name }}</h3>
                                    <p class="text-sm text-gray-500">Member since {{ formatDate(customer.created_at) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-6 border-t border-gray-100 pt-6">
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ customer.email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ customer.phone || 'Not provided' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Stats -->
                    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-1">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-[#4CA771]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                                            <dd class="text-lg font-semibold text-gray-900">${{
                                                totalSpent.toLocaleString() }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-[#4CA771]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Rentals</dt>
                                            <dd class="text-lg font-semibold text-gray-900">{{ rentals.length }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-[#4CA771]" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Active Rentals</dt>
                                            <dd class="text-lg font-semibold text-gray-900">{{ activeRentals.length }}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental History -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Rental History</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Detailed list of all rentals by this
                                customer.</p>
                        </div>
                        <div class="border-t border-gray-200">
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="rental in rentals" :key="rental.id" class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div v-for="car in cars" :key="car.id">
                                                    <img v-if="car.id === rental.car_id" :src="`/storage/${car.image}`"
                                                        :alt="car.name" class="h-12 w-12 rounded-lg object-cover" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div v-for="car in cars" :key="car.id">
                                                    <h4 v-if="car.id === rental.car_id"
                                                        class="text-sm font-medium text-gray-900">
                                                        {{ car.name }}
                                                    </h4>
                                                </div>
                                                <div class="mt-1 flex items-center">
                                                    <span
                                                        :class="[getStatusColor(rental.status), 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium']">
                                                        {{ rental.status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <p class="text-sm font-medium text-[#4CA771]">${{ rental.total_cost }}</p>
                                            <div class="mt-1 text-xs text-gray-500">
                                                {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    customer: Object,
    rentals: Array,
    cars: Array
});

const totalSpent = computed(() => {
    return props.rentals.reduce((sum, rental) => sum + parseFloat(rental.total_cost), 0);
});

const activeRentals = computed(() => {
    return props.rentals.filter(rental => rental.status === 'ongoing');
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
