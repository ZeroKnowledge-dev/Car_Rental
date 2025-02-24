<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Manage Cars
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <h1>Cars List</h1>
                            <div v-if="cars.length === 0">No cars available.</div>
                            <table v-else>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="car in cars" :key="car.id">
                                        <td>{{ car.name }}</td>
                                        <td>{{ car.brand }}</td>
                                        <td>{{ car.model }}</td>
                                        <td>{{ car.year }}</td>
                                        <td>
                                            <Link :href="route('admin.cars.edit', car.id)" class="btn btn-primary">Edit
                                            </Link>
                                            <button @click="deleteCar(car.id)" class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Link :href="route('admin.cars.create')" class="btn btn-success">Create New Car</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    cars: Array
})

const deleteCar = async (id) => {
    if (confirm('Are you sure you want to delete this car?')) {
        try {
            await axios.delete(route('admin.cars.destroy', id));
            location.reload(); // Refresh the page after deletion
        } catch (error) {
            console.error(error);
        }
    }
};
</script>
