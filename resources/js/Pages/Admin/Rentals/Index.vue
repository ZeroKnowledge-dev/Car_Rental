<template>

    <Head title="Manage Rentals" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Rentals</h1>
            </div>

            <!-- Rentals Table -->
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Customer</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Car</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Dates</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Cost
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="rental in rentals.data" :key="rental.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <div
                                                        class="h-10 w-10 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                                                        {{ rental.customer_name.charAt(0) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ rental.customer_name }}
                                                    </div>
                                                    <div class="text-gray-500">{{ rental.customer_email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div class="font-medium text-gray-900">{{ rental.car_name }}</div>
                                            <div class="text-gray-500">{{ rental.car_license_plate }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div>{{ formatDate(rental.start_date) }}</div>
                                            <div>{{ formatDate(rental.end_date) }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-[#4CA771]">
                                            ${{ rental.total_cost }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span
                                                :class="[getStatusColor(rental.status), 'inline-flex rounded-full px-2 text-xs font-semibold leading-5']">
                                                {{ rental.status }}
                                            </span>
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <SecondaryButton @click="viewRentalDetails(rental)">View Details
                                            </SecondaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Details Modal -->
            <Modal :show="showDetailsModal" @close="showDetailsModal = false">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Rental Details</h2>
                    <div v-if="selectedRental" class="mt-6 space-y-6">
                        <!-- Customer Information -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Customer Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <div
                                        class="h-12 w-12 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                                        {{ selectedRental.customer_name.charAt(0) }}
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">{{ selectedRental.customer_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ selectedRental.customer_email }}</p>
                                        <p class="text-sm text-gray-500">{{ selectedRental.customer_phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Car Information -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Car Information</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ selectedRental.car_name }}</p>
                                        <p class="text-sm text-gray-500">License Plate: {{
                                            selectedRental.car_license_plate }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-[#4CA771]">${{ selectedRental.total_cost }}
                                        </p>
                                        <p class="text-sm text-gray-500">Daily Rate: ${{ selectedRental.daily_rate }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Details -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Rental Period</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Start Date</p>
                                        <p class="text-sm font-medium text-gray-900">{{
                                            formatDate(selectedRental.start_date) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">End Date</p>
                                        <p class="text-sm font-medium text-gray-900">{{
                                            formatDate(selectedRental.end_date) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Management -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 mb-4">Rental Status</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <span
                                        :class="[getStatusColor(selectedRental.status), 'inline-flex rounded-full px-3 py-1 text-sm font-semibold']">
                                        {{ selectedRental.status }}
                                    </span>
                                    <div class="space-x-2">
                                        <PrimaryButton v-if="selectedRental.status !== 'completed'"
                                            @click="updateRentalStatus(selectedRental, 'completed')">
                                            Mark as Completed
                                        </PrimaryButton>
                                        <SecondaryButton v-if="selectedRental.status !== 'canceled'"
                                            @click="updateRentalStatus(selectedRental, 'canceled')">
                                            Cancel Rental
                                        </SecondaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="showDetailsModal = false">Close</SecondaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    rentals: {
        type: Object,
        required: true,
    },
});

const showDetailsModal = ref(false);
const selectedRental = ref(null);

const viewRentalDetails = (rental) => {
    selectedRental.value = rental;
    showDetailsModal.value = true;
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const updateRentalStatus = (rental, status) => {
    useForm().put(route('admin.rentals.update-status', rental.id), {
        status: status
    }, {
        preserveScroll: true,
        onSuccess: () => {
            showDetailsModal.value = false;
            selectedRental.value = null;
        },
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
