<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Car Details -->
                        <div>
                            <div class="aspect-w-16 aspect-h-9">
                                <img :src="`/storage/${car.image}`" :alt="car.name" class="object-cover rounded-lg" />
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-gray-900">{{ car.name }}</h3>
                                <p class="mt-1 text-gray-600">{{ car.brand }} {{ car.model }}</p>
                                <p class="text-gray-600">{{ car.year }} · {{ car.car_type }}</p>
                                <p class="mt-2 text-xl font-bold text-indigo-600">${{ car.daily_rent_price
                                }}/day</p>
                            </div>
                        </div>

                        <!-- Rental Form -->
                        <div>
                            <form @submit.prevent="handleSubmit" class="space-y-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <div class="mt-1">
                                        <input type="date" v-model="startDate" id="start_date" required :min="minDate"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <div class="mt-1">
                                        <input type="date" v-model="endDate" id="end_date" required :min="startDate"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <!-- Rental Summary -->
                                <div v-if="totalCostVisible" class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-lg font-medium text-gray-900">Rental Summary</h4>
                                    <div class="mt-2 space-y-2">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Duration:</span>
                                            <span>{{ rentalDuration }}</span> days
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Daily Rate:</span>
                                            ${{ car.daily_rent_price }}
                                        </p>
                                        <p class="text-lg font-bold text-indigo-600">
                                            <span class="font-medium text-gray-900">Total Cost:</span>
                                            $<span>{{ totalCost }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end space-x-3">
                                    <Link :href="`/cars/${car.id}`"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                    </Link>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Confirm Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';


defineProps({
    car: Object
})

// Reactive states for form handling
const startDate = ref('');
const endDate = ref('');
const totalCostVisible = ref(false);
const rentalDuration = ref(0);
const totalCost = computed(() => {
    if (startDate.value && endDate.value) {
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        if (days > 0) {
            rentalDuration.value = days;
            return (days * car.daily_rent_price).toFixed(2);
        }
    }
    return '0.00';
});

const minDate = computed(() => new Date().toISOString().split('T')[0]);

// Methods
const handleSubmit = () => {
    // Handle rental form submission (replace with actual booking logic)
    alert('Booking confirmed!');
};

const checkAvailability = async () => {
    if (startDate.value && endDate.value) {
        const response = await fetch(`/api/check-availability/${car.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ start_date: startDate.value, end_date: endDate.value })
        });
        const data = await response.json();
        if (!data.available) {
            alert('Sorry, this car is not available for the selected dates.');
            resetForm();
        }
    }
};

const resetForm = () => {
    startDate.value = '';
    endDate.value = '';
    totalCostVisible.value = false;
};

// Watchers
watch([startDate, endDate], () => {
    totalCostVisible.value = startDate.value && endDate.value;
    checkAvailability();
});
</script>

<style scoped>
/* Add custom styles here */
</style>
