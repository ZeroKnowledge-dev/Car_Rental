<template>

    <Head :title="'Rental Details'" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                        Rental Details
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">View and manage rental information</p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0 space-x-3">
                    <Link :href="route('admin.rentals.edit', rental.id)"
                        class="inline-flex items-center px-4 py-2 bg-[#4CA771] text-white rounded-md hover:bg-[#013237] transition-colors duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Rental
                    </Link>
                    <Link :href="route('admin.rentals.index')"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 hover:border-[#4CA771] transition-colors duration-150">
                    Back to List
                    </Link>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Customer Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-lg rounded-lg border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-[#013237] mb-4">Customer Information</h3>
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-16 w-16 rounded-full bg-[#4CA771] flex items-center justify-center text-white text-2xl font-semibold">
                                        {{ rental.user.name.charAt(0) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">{{ rental.user.name }}</h4>
                                    <p class="text-sm text-gray-500">{{ rental.user.email }}</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4">
                                <dl class="divide-y divide-gray-100">
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                                        <dd class="text-sm text-gray-900">{{ formatDate(rental.user.created_at) }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-lg rounded-lg border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-[#013237]">Rental Information</h3>
                                <span :class="[
                                    getStatusColor(rental.status),
                                    'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize'
                                ]">
                                    {{ rental.status }}
                                </span>
                            </div>

                            <!-- Car Information -->
                            <div class="mb-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img :src="`/storage/${rental.car.image}`" :alt="rental.car.name"
                                            class="h-20 w-20 rounded-lg object-cover" />
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">{{ rental.car.name }}</h4>
                                        <p class="text-sm text-gray-500">{{ rental.car.brand }} {{ rental.car.model }}
                                            {{
                                                rental.car.year }}</p>
                                        <p class="text-sm font-medium text-[#4CA771]">${{ rental.car.daily_rent_price
                                            }}/day
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Period -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Start Date</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ formatDate(rental.start_date) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">End Date</p>
                                        <p class="mt-1 text-sm text-gray-900">{{ formatDate(rental.end_date) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Breakdown -->
                            <div class="border-t border-gray-100 pt-4">
                                <h4 class="text-sm font-medium text-gray-500 mb-4">Cost Breakdown</h4>
                                <dl class="divide-y divide-gray-100">
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm text-gray-500">Daily Rate</dt>
                                        <dd class="text-sm font-medium text-gray-900">${{ rental.car.daily_rent_price }}
                                        </dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm text-gray-500">Number of Days</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ calculateDays() }}</dd>
                                    </div>
                                    <div class="py-3 flex justify-between">
                                        <dt class="text-sm font-medium text-gray-900">Total Cost</dt>
                                        <dd class="text-lg font-bold text-[#4CA771]">${{ rental.total_cost }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <!-- Status Actions -->
                            <div class="mt-6 flex justify-end space-x-3" v-if="rental.status === 'ongoing'">
                                <SecondaryButton @click="cancelRental(rental.id)" :disabled="processing">
                                    Cancel Rental
                                </SecondaryButton>
                                <PrimaryButton @click="completeRental(rental.id)" :disabled="processing"
                                    class="bg-[#4CA771] hover:bg-[#013237]">
                                    Mark as Completed
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    rental: Object,
});

const processing = ref(false);
const form = useForm({});

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const calculateDays = () => {
    const start = new Date(props.rental.start_date);
    const end = new Date(props.rental.end_date);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24) + 1);
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

const rentalForm = useForm({});

const cancelRental = (rentalId) => {
    if (confirm('Are you sure you want to cancel this rental?')) {
        rentalForm.post(route('rentals.cancel', { rental: rentalId }), {
            preserveScroll: true,
            onSuccess: () => {
                // You could also rely on flash messages instead of alert
                alert('Rental canceled successfully!');
            },
            onError: (errors) => {
                // Display errors if cancellation fails
                if (errors.message) {
                    alert(errors.message);
                } else {
                    alert('An error occurred while canceling the rental.');
                }
            }
        });
    }
};

const completeRental = (rentalId) => {
    if (confirm('Are you sure you want to complete this rental?')) {
        rentalForm.post(route('admin.rentals.complete', { rental: rentalId }), {
            preserveScroll: true,
            onSuccess: () => {
                // You could also rely on flash messages instead of alert
                alert('Rental completed successfully!');
            },
            onError: (errors) => {
                // Display errors if completion fails
                if (errors.message) {
                    alert(errors.message);
                } else {
                    alert('An error occurred while completing the rental.');
                }
            }
        });
    }
};
</script>
