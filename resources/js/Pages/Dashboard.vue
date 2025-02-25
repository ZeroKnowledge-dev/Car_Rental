<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    rentals: Object,
    flash: Object
});

// State management
const isLoading = ref(false);

// Computed properties for counts
const ongoingCount = computed(() => {
    return props.rentals.data.filter(rental => rental.status === 'ongoing').length;
});

const completedCount = computed(() => {
    return props.rentals.data.filter(rental => rental.status === 'completed').length;
});

const canceledCount = computed(() => {
    return props.rentals.data.filter(rental => rental.status === 'canceled').length;
});

// Sort state
const sortBy = ref('start_date');
const sortDirection = ref('desc');

// Sorting function
const sort = (column) => {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = column;
        sortDirection.value = 'asc';
    }
};

// Sorted rentals
const sortedRentals = computed(() => {
    return [...props.rentals.data].sort((a, b) => {
        let comparison = 0;

        if (sortBy.value === 'start_date' || sortBy.value === 'end_date') {
            comparison = new Date(a[sortBy.value]) - new Date(b[sortBy.value]);
        } else if (sortBy.value === 'total_cost') {
            comparison = a.total_cost - b.total_cost;
        } else if (sortBy.value === 'status') {
            comparison = a.status.localeCompare(b.status);
        }

        return sortDirection.value === 'asc' ? comparison : -comparison;
    });
});

// Format date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString();
};

// Check if a rental can be canceled
const canCancel = (rental) => {
    if (rental.status !== 'ongoing') return false;

    const startDate = new Date(rental.start_date);
    const today = new Date();

    // Set hours to 0 to compare just the dates
    today.setHours(0, 0, 0, 0);

    return startDate > today;
};

// Cancel rental function
const cancelForm = useForm({});

const cancelRental = (rentalId) => {
    if (confirm('Are you sure you want to cancel this rental?')) {
        cancelForm.post(route('rentals.cancel', rentalId), {
            preserveScroll: true,
            onSuccess: () => {
                // Success message is handled by the flash message
            },
        });
    }
};

// Pagination
const currentPage = ref(1);
const itemsPerPage = 5;

const totalPages = computed(() => {
    return Math.ceil(sortedRentals.value.length / itemsPerPage);
});

const paginatedRentals = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedRentals.value.slice(start, end);
});

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const goToPage = (page) => {
    currentPage.value = page;
};
</script>

<template>

    <Head title="Dashboard" />

    <MainLayout>
        <div class="py-12 bg-[#EAF9E7]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                <div v-if="$page.props.flash.success"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                </div>

                <div v-if="$page.props.flash.error"
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ $page.props.flash.error }}</span>
                </div>

                <h1 class="text-3xl font-bold text-[#013237] mb-8">Dashboard</h1>

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#013237]">Ongoing Rentals</h3>
                        <p class="text-3xl font-bold text-[#4CA771] mt-2">{{ ongoingCount }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#013237]">Completed Rentals</h3>
                        <p class="text-3xl font-bold text-[#4CA771] mt-2">{{ completedCount }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold text-[#013237]">Canceled Rentals</h3>
                        <p class="text-3xl font-bold text-[#4CA771] mt-2">{{ canceledCount }}</p>
                    </div>
                </div>

                <!-- Rentals Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-[#013237]">Your Rentals</h2>
                    </div>

                    <div v-if="isLoading" class="p-6 text-center">
                        <p class="text-gray-500">Loading rentals...</p>
                    </div>

                    <div v-else-if="props.rentals.data.length === 0" class="p-6 text-center">
                        <p class="text-gray-500">You don't have any rentals yet.</p>
                        <Link :href="route('cars')"
                            class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA771] hover:bg-[#013237]">
                        Browse Cars
                        </Link>
                    </div>

                    <div v-else>
                        <!-- Custom Table Component -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Car
                                        </th>
                                        <th @click="sort('start_date')" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            Start Date
                                            <span v-if="sortBy === 'start_date'" class="ml-1">
                                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                                            </span>
                                        </th>
                                        <th @click="sort('end_date')" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            End Date
                                            <span v-if="sortBy === 'end_date'" class="ml-1">
                                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                                            </span>
                                        </th>
                                        <th @click="sort('total_cost')" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            Total Cost
                                            <span v-if="sortBy === 'total_cost'" class="ml-1">
                                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                                            </span>
                                        </th>
                                        <th @click="sort('status')" scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                            Status
                                            <span v-if="sortBy === 'status'" class="ml-1">
                                                {{ sortDirection === 'asc' ? '↑' : '↓' }}
                                            </span>
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(rental, index) in paginatedRentals" :key="rental.id"
                                        :class="{ 'bg-gray-50': index % 2 }">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ rental.car.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ formatDate(rental.start_date) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ formatDate(rental.end_date) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ rental.total_cost }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span :class="{
                                                'bg-green-100 text-green-800': rental.status === 'ongoing',
                                                'bg-blue-100 text-blue-800': rental.status === 'completed',
                                                'bg-red-100 text-red-800': rental.status === 'canceled'
                                            }"
                                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ rental.status.charAt(0).toUpperCase() + rental.status.slice(1) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button v-if="canCancel(rental)" @click="cancelRental(rental.id)"
                                                class="text-red-600 hover:text-red-900">
                                                Cancel
                                            </button>
                                            <span v-else>-</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div
                            class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ (currentPage - 1) * itemsPerPage + 1 }}</span>
                                        to
                                        <span class="font-medium">{{ Math.min(currentPage * itemsPerPage,
                                            sortedRentals.length) }}</span>
                                        of
                                        <span class="font-medium">{{ sortedRentals.length }}</span>
                                        results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                        aria-label="Pagination">
                                        <button @click="prevPage" :disabled="currentPage === 1"
                                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            &laquo;
                                        </button>

                                        <button v-for="page in totalPages" :key="page" @click="goToPage(page)"
                                            :class="{ 'bg-[#4CA771] text-white': page === currentPage, 'bg-white text-gray-500': page !== currentPage }"
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium hover:bg-gray-50">
                                            {{ page }}
                                        </button>

                                        <button @click="nextPage" :disabled="currentPage === totalPages"
                                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            &raquo;
                                        </button>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
