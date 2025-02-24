<template>
    <AdminLayout>

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <h1>Car Details</h1>
                            <div>
                                <p><strong>Name:</strong> {{ car.name }}</p>
                                <p><strong>Brand:</strong> {{ car.brand }}</p>
                                <p><strong>Model:</strong> {{ car.model }}</p>
                                <p><strong>Year:</strong> {{ car.year }}</p>
                                <p><strong>Car Type:</strong> {{ car.car_type }}</p>
                                <p><strong>Daily Rent Price:</strong> ${{ car.daily_rent_price }}</p>
                                <p><strong>Availability:</strong> {{ car.availability ? 'Available' : 'Not Available' }}
                                </p>
                                <div v-if="car.image">
                                    <img :src="`/storage/${car.image}`" alt="Car Image" width="300" />
                                </div>
                            </div>

                            <div>
                                <Link :href="route('admin.cars.edit', car.id)" class="btn btn-primary">Edit</Link>
                                <Link :href="route('admin.cars.index')" class="btn btn-secondary">Back to List</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    car: Object
})
</script>
