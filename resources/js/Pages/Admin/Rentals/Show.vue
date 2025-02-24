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
                            <h1>Rental Details</h1>
                            <div>
                                <p><strong>User:</strong> {{ rental.user.name }}</p>
                                <p><strong>Car:</strong> {{ rental.car.name }}</p>
                                <p><strong>Start Date:</strong> {{ rental.start_date }}</p>
                                <p><strong>End Date:</strong> {{ rental.end_date }}</p>
                                <p><strong>Total Price:</strong> ${{ rental.total_cost }}</p>
                            </div>

                            <div>
                                <Link :href="route('admin.rentals.edit', rental.id)" class="btn btn-primary">Edit
                                Rental</Link>
                                <Link :href="route('admin.rentals.index')" class="btn btn-secondary">Back to Rentals
                                List</Link>
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
    rental: Object
})

function dateValidate() {
    props.rental.start_date = new Date(props.rental.start_date).toISOString().split('T')[0];
    props.rental.end_date = new Date(props.rental.end_date).toISOString().split('T')[0];
}

dateValidate();
</script>
