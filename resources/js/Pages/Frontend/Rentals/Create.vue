<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

const props = defineProps({
    car: Object
});

// Get start and end dates from query params or set default values
const urlParams = new URLSearchParams(window.location.search);
const startDateParam = urlParams.get('start_date');
const endDateParam = urlParams.get('end_date');

// Create form using Inertia useForm
const form = useForm({
    start_date: startDateParam || '',
    end_date: endDateParam || '',
});

// Computed properties for validation and calculations
const today = new Date().toISOString().split('T')[0];

const calculateDays = computed(() => {
    if (!form.start_date || !form.end_date) return 0;

    const start = new Date(form.start_date);
    const end = new Date(form.end_date);
    const diffTime = end - start;
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
});

const totalCost = computed(() => {
    return calculateDays.value * props.car.daily_rent_price;
});

// Submit form
const submitForm = () => {
    form.post(route('rentals.store', props.car.id));
};
</script>

<template>

    <Head title="Rent a Car" />

    <MainLayout>
        <div class="py-12 bg-[#EAF9E7]">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-[#013237] mb-6">Rent a Car</h1>

                        <!-- Car Info Summary -->
                        <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md overflow-hidden">
                                <img :src="`/storage/${car.image}`" :alt="car.brand + ' ' + car.model"
                                    class="w-full h-full object-cover" />
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-[#013237]">{{ car.brand }} {{ car.model }}</h2>
                                <p class="text-gray-600">{{ car.car_type }} | {{ car.year }}</p>
                                <p class="text-[#4CA771] font-bold">${{ car.daily_rent_price }}/day</p>
                            </div>
                        </div>

                        <!-- Rental Form -->
                        <form @submit.prevent="submitForm">
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="start_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                        <input type="date" id="start_date" v-model="form.start_date" :min="today"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]"
                                            required />
                                        <div v-if="form.errors.start_date" class="mt-1 text-red-600 text-sm">{{
                                            form.errors.start_date }}</div>
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End
                                            Date</label>
                                        <input type="date" id="end_date" v-model="form.end_date"
                                            :min="form.start_date || today"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]"
                                            required />
                                        <div v-if="form.errors.end_date" class="mt-1 text-red-600 text-sm">{{
                                            form.errors.end_date }}</div>
                                    </div>
                                </div>

                                <!-- Rental Summary -->
                                <div class="bg-[#EAF9E7] p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold text-[#013237] mb-2">Rental Summary</h3>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-700">Duration:</span>
                                            <span class="font-medium">{{ calculateDays }} days</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-700">Daily Rate:</span>
                                            <span class="font-medium">${{ car.daily_rent_price }}/day</span>
                                        </div>
                                        <div class="border-t border-gray-300 my-2 pt-2 flex justify-between">
                                            <span class="text-gray-700 font-semibold">Total Cost:</span>
                                            <span class="text-[#4CA771] font-bold">${{ totalCost.toFixed(2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-md font-semibold text-[#013237] mb-2">Rental Terms & Conditions</h3>
                                    <ul class="text-sm text-gray-600 space-y-1 list-disc pl-5">
                                        <li>Full payment will be charged at the time of booking</li>
                                        <li>Driver must be 21 years or older with a valid driver's license</li>
                                        <li>Security deposit may be required at pickup</li>
                                        <li>Cancellations made 48 hours before the rental start date are eligible for a
                                            full refund</li>
                                        <li>Late returns will incur additional charges</li>
                                    </ul>
                                </div>

                                <div v-if="form.errors.message" class="bg-red-50 p-4 rounded-lg text-red-600">
                                    {{ form.errors.message }}
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button type="submit" :disabled="form.processing"
                                        class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#4CA771] hover:bg-[#013237] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771] disabled:opacity-50">
                                        {{ form.processing ? 'Processing...' : 'Confirm Booking' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
