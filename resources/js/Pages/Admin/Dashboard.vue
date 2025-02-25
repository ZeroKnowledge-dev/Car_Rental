<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    rentals: Array,
    cars: Array,
    users: Array,
    totalCars: Number
});

// Calculate summary statistics
const totalCustomers = computed(() => props.users?.length || 0);
const activeRentals = computed(() => props.rentals?.filter(rental => rental.status === 'ongoing').length || 0);
const monthlyRevenue = computed(() => {
    const now = new Date();
    const firstDayOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
    return props.rentals
        ?.filter(rental => new Date(rental.created_at) >= firstDayOfMonth && rental.status !== 'canceled')
        .reduce((sum, rental) => sum + parseFloat(rental.total_cost), 0) || 0;
});

const stats = computed(() => [
    { name: 'Total Cars', value: props.totalCars || 0, icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { name: 'Total Customers', value: totalCustomers.value, icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' },
    { name: 'Active Rentals', value: activeRentals.value, icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' },
    { name: 'Monthly Revenue', value: `$${monthlyRevenue.value.toLocaleString()}`, icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' },
]);

// Get recent rentals (last 5)
const recentRentals = computed(() => {
    return props.rentals
        ? [...props.rentals]
            .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
            .slice(0, 5)
            .map(rental => ({
                ...rental,
                customer_name: props.users.find(user => user.id === rental.user_id)?.name || 'Unknown',
                car_name: props.cars.find(car => car.id === rental.car_id)?.name || 'Unknown'
            }))
        : [];
});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>

    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

            <!-- Stats Grid -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="item in stats" :key="item.name" class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-[#4CA771]" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        :d="item.icon" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        {{ item.name }}
                                    </dt>
                                    <dd class="text-lg font-semibold text-gray-900">
                                        {{ item.value }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900">Recent Rentals</h2>
                <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-md">
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="rental in recentRentals" :key="rental.id">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-10 w-10 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                                                {{ rental.customer_name.charAt(0) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-[#013237]">
                                                {{ rental.customer_name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ rental.car_name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <p class="text-sm font-medium text-[#4CA771]">
                                            ${{ rental.total_cost }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
