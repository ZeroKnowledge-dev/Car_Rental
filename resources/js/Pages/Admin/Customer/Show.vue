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
                            <h1>Customer Details</h1>
                            <div>
                                <strong>Name:</strong> {{ props.customer.name }}
                            </div>
                            <div>
                                <strong>Email:</strong> {{ props.customer.email }}
                            </div>
                            <div>
                                <Link :href="route('admin.customers.edit', customer.id)" class="btn btn-primary">Edit
                                </Link>
                                <Link :href="route('admin.customers.index')" class="btn btn-secondary">Back to List
                                </Link>
                            </div>
                            <!-- Loop over rentals and cars -->
                            <h2>Rental {{ rentals.length }}</h2>
                            <div v-for="rental in rentals" :key="rental.id">
                                <div>
                                    <strong>Start Date:</strong> {{ rental.start_date }}
                                </div>
                                <div>
                                    <strong>End Date:</strong> {{ rental.end_date }}
                                </div>
                                <div>
                                    <strong>Total Cost:</strong> {{ rental.total_cost }}
                                </div>
                                <div v-for="car in cars" :key="car.id">
                                    <div v-if="car.id === rental.car_id">
                                        <strong>Car:</strong> {{ car.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    customer: Object,
    rentals: Array,
    cars: Array
})

console.log(props.rentals);
console.log(props.cars);


</script>
