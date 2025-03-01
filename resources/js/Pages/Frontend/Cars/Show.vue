<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import CarCard from '@/Components/CarCard.vue';
import axios from 'axios';

const props = defineProps({
    car: Object,
    similarCars: Array,
    canLogin: Boolean,
    canRegister: Boolean
});

const startDate = ref('');
const endDate = ref('');
const isChecking = ref(false);
const isAvailable = ref(null);
const error = ref('');

// Check availability function
const checkAvailability = async () => {
    if (!startDate.value || !endDate.value) {
        error.value = 'Please select both start and end dates';
        return;
    }

    error.value = '';
    isChecking.value = true;

    try {
        const response = await axios.post(`/cars/${props.car.id}/check-availability`, {
            start_date: startDate.value, // '2025-02-25' format
            end_date: endDate.value      // '2025-02-28' format
        });

        // Use response.data to access the response
        const data = response.data;
        isAvailable.value = data.available;
    } catch (err) {
        // Log detailed error
        error.value = 'An error occurred while checking availability';
    } finally {
        isChecking.value = false;
    }
};

// Proceed to booking function
const proceedToBooking = () => {
    router.visit(route('rentals.create', props.car.id), {
        data: {
            start_date: startDate.value,
            end_date: endDate.value
        }
    });
};

// Calculate rental days function
const calculateDays = () => {
    if (!startDate.value || !endDate.value) return 0;

    const start = new Date(startDate.value);
    const end = new Date(endDate.value);
    const diffTime = end - start;
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
};

// Calculate estimated cost function
const estimatedCost = () => {
    const days = calculateDays();
    return days * props.car.daily_rent_price;
};

// Get today's date for min attribute
const today = new Date().toISOString().split('T')[0];
</script>

<template>

    <Head :title="`${car.name}`" />

    <MainLayout>
        <div class="py-12 bg-[#EAF9E7]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Car Details -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Car Image -->
                        <div class="md:col-span-1 h-64 md:h-full bg-gray-200">
                            <img :src="`/storage/${car.image}`" :alt="car.brand + ' ' + car.model"
                                class="w-full h-full object-cover" />
                        </div>

                        <!-- Car Information -->
                        <div class="md:col-span-2 p-6">
                            <div class="flex justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-[#013237]">{{ car.brand }} {{ car.model }}</h1>
                                    <p class="text-gray-600">{{ car.car_type }} | {{ car.year }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-[#4CA771]">${{ car.daily_rent_price }}/day</p>
                                    <span
                                        :class="car.availability ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                        class="inline-block px-2 py-1 text-xs font-medium rounded-full">
                                        {{ car.availability ? 'Available' : 'Unavailable' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <h2 class="text-lg font-semibold text-[#013237] mb-2">Car Features</h2>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA771] mr-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ car.seats }} Seats</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA771] mr-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ car.transmission }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA771] mr-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ car.fuel_type }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA771] mr-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Air Conditioning</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Check Availability -->
                            <form @submit.prevent="checkAvailability" v-if="$page.props.auth.user">
                                <div class="mt-6 p-4 bg-[#EAF9E7] rounded-lg">
                                    <h2 class="text-lg font-semibold text-[#013237] mb-4">Check Availability</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="start_date"
                                                class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                            <input type="date" id="start_date" v-model="startDate" :min="today"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]" />
                                        </div>
                                        <div>
                                            <label for="end_date"
                                                class="block text-sm font-medium text-gray-700 mb-1">End
                                                Date</label>
                                            <input type="date" id="end_date" v-model="endDate" :min="startDate || today"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]" />
                                        </div>
                                    </div>

                                    <div v-if="error" class="mt-2 text-red-600 text-sm">{{ error }}</div>

                                    <div v-if="startDate && endDate && !error" class="mt-4">
                                        <p class="text-gray-700">
                                            <span class="font-semibold">Rental Period:</span> {{ calculateDays() }} days
                                        </p>
                                        <p class="text-gray-700">
                                            <span class="font-semibold">Estimated Cost:</span>
                                            <span class="text-[#4CA771] font-semibold">${{ estimatedCost() }}</span>
                                        </p>
                                    </div>

                                    <div class="mt-4 flex flex-col sm:flex-row sm:space-x-4">
                                        <button type="submit" :disabled="isChecking || !startDate || !endDate"
                                            class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA771] hover:bg-[#013237] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771] disabled:opacity-50">
                                            {{ isChecking ? 'Checking...' : 'Check Availability' }}
                                        </button>

                                        <Link v-if="isAvailable === true" :href="route('rentals.create', car.id)"
                                            :data="{ start_date: startDate, end_date: endDate }"
                                            class="mt-3 sm:mt-0 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#013237] hover:bg-[#002227] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#013237]">
                                        Rent Now
                                        </Link>
                                    </div>

                                    <div v-if="isAvailable !== null" class="mt-4">
                                        <div v-if="isAvailable" class="text-green-600 font-medium">
                                            This car is available for your selected dates!
                                        </div>
                                        <div v-else class="text-red-600 font-medium">
                                            Sorry, this car is not available for your selected dates. Please try
                                            different
                                            dates.
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-6 p-4 bg-[#EAF9E7] rounded-lg" v-else>
                                <p class="text-gray-600">Please <a :href="route('login')"
                                        class="text-indigo-600 hover:text-indigo-900">log in</a> to book this car.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Similar Cars -->
                <div v-if="similarCars.length > 0" class="mt-12">
                    <h2 class="text-2xl font-bold text-[#013237] mb-6">Similar Cars</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <CarCard v-for="similarCar in similarCars" :key="similarCar.id" :car="similarCar" />
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
