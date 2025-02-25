<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    car: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
        <div class="h-48 bg-gray-200 relative">
            <img :src="`/storage/${car.image}`" :alt="car.brand + ' ' + car.model" class="w-full h-full object-cover" />
            <div v-if="car.availability"
                class="absolute top-0 right-0 bg-green-500 text-white px-2 py-1 text-xs font-bold">
                Available
            </div>
            <div v-else class="absolute top-0 right-0 bg-red-500 text-white px-2 py-1 text-xs font-bold">
                Unavailable
            </div>
        </div>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-[#013237]">{{ car.brand }} {{ car.model }}</h3>
            <p class="text-gray-600 mb-2">{{ car.car_type }}</p>
            <div class="flex justify-between items-center">
                <p class="text-[#4CA771] font-bold">${{ car.daily_rent_price }}/day</p>
                <Link v-if="car.availability" :href="route('cars.show', car.id)"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#4CA771] hover:bg-[#013237]">
                View Details
                </Link>
                <Link v-else :href="route('cars.show', car.id)"
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-400">
                Not Available
                </Link>
            </div>
        </div>
    </div>
</template>
