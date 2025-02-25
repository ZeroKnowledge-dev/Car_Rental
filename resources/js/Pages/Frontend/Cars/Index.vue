<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import CarCard from '@/Components/CarCard.vue';


const props = defineProps({
    cars: Array,
    canLogin: Boolean,
    canRegister: Boolean
});

// Existing filtering logic
const selectedCarType = ref(''); // Car type selected
const selectedBrand = ref(''); // Brand selected
const minPrice = ref(null); // Min price
const maxPrice = ref(null); // Max price

// Get unique car types
const carTypes = computed(() => {
    const types = new Set();
    props.cars.forEach(car => types.add(car.car_type));
    return Array.from(types);
});

// Get unique brands
const brands = computed(() => {
    const uniqueBrands = new Set();
    props.cars.forEach(car => uniqueBrands.add(car.brand));
    return Array.from(uniqueBrands);
});

// Filtered cars
const filteredCars = computed(() => {
    return props.cars.filter(car => {
        // Type match (car type)
        const typeMatch = !selectedCarType.value || selectedCarType.value === car.car_type;

        // Brand match
        const brandMatch = !selectedBrand.value || selectedBrand.value === car.brand;

        // Price logic: Ensure minPrice and maxPrice are valid numbers and reset if needed
        const validMinPrice = minPrice.value !== null && minPrice.value > 0;
        const validMaxPrice = maxPrice.value !== null && maxPrice.value > 0;

        // Price match (min and max price)
        const minPriceMatch = !validMinPrice || car.daily_rent_price >= minPrice.value;
        const maxPriceMatch = !validMaxPrice || car.daily_rent_price <= maxPrice.value;

        return typeMatch && brandMatch && minPriceMatch && maxPriceMatch;
    });
});



</script>

<template>

    <Head title="Cars" />

    <MainLayout>
        <div class="py-12 bg-[#EAF9E7]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-[#013237] mb-8">Browse Our Cars</h1>

                <!-- Filters -->
                <div class="mb-8 bg-white rounded-lg shadow p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Car Type Filter (Dropdown) -->
                        <div>
                            <label for="car-type" class="block text-sm font-medium text-gray-700 mb-1">Car Type</label>
                            <select id="car-type" v-model="selectedCarType"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]">
                                <option value="">Select Car Type</option>
                                <option v-for="type in carTypes" :key="type" :value="type">{{ type }}</option>
                            </select>
                        </div>

                        <!-- Brand Filter (Dropdown) -->
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                            <select id="brand" v-model="selectedBrand"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]">
                                <option value="">Select Brand</option>
                                <option v-for="brand in brands" :key="brand" :value="brand">{{ brand }}</option>
                            </select>
                        </div>

                        <!-- Min Price Filter -->
                        <div>
                            <label for="min-price" class="block text-sm font-medium text-gray-700 mb-1">Min
                                Price</label>
                            <input type="number" id="min-price" v-model="minPrice"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]"
                                placeholder="Min Price" min="0" />
                        </div>

                        <!-- Max Price Filter -->
                        <div>
                            <label for="max-price" class="block text-sm font-medium text-gray-700 mb-1">Max
                                Price</label>
                            <input type="number" id="max-price" v-model="maxPrice"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-[#4CA771] focus:border-[#4CA771]"
                                placeholder="Max Price" min="0" />
                        </div>
                    </div>
                </div>


                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <CarCard v-for="car in filteredCars" :key="car.id" :car="car" />
                </div>

            </div>
        </div>
    </MainLayout>
</template>

<style>
.custom-table {
    --easy-table-border: 1px solid #e5e7eb;
    --easy-table-header-background-color: #f9fafb;
    --easy-table-header-font-color: #111827;
    --easy-table-header-height: 50px;
    --easy-table-header-font-size: 14px;
    --easy-table-header-font-weight: 600;
    --easy-table-body-row-height: 80px;
    --easy-table-body-row-font-size: 14px;
    --easy-table-body-row-font-color: #374151;
    --easy-table-footer-background-color: #f9fafb;
    --easy-table-footer-font-color: #374151;
    --easy-table-rows-per-page-selector-width: 80px;
    --easy-table-rows-per-page-selector-option-padding: 10px;
    --easy-table-scrollbar-thumb-color: #90a4ae;
}

/* Base Input Styling */
input[type="text"],
input[type="number"],
select {
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* On Focus - Green Focus */
input:focus,
select:focus {
    border-color: #4CA771;
    box-shadow: 0 0 5px rgba(76, 167, 113, 0.5);
}

/* Select Dropdown Styling */
select {
    appearance: none;
    /* Remove default styling */
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
    padding-right: 2.5rem;
    /* Add some space for the dropdown arrow */
}

/* Focused select state */
select:focus {
    outline: none;
    border-color: #4CA771;
}
</style>
