<template>
    <AdminLayout>

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Manage Rentals
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div>
                            <h1>Rental List</h1>
                            <div v-if="rentals.length === 0">No rentals available.</div>
                            <table v-else>
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Car</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="rental in rentals" :key="rental.id">
                                        <td>{{ rental.user.name }}</td>
                                        <td>{{ rental.car.name }}</td>
                                        <td>{{ rental.start_date.split('T')[0] }}</td>
                                        <td>{{ rental.end_date.split('T')[0] }}</td>
                                        <td>${{ rental.total_cost }}</td>
                                        <td>
                                            <Link :href="route('admin.rentals.show', rental.id)" class="btn btn-info">
                                            View</Link>
                                            <Link :href="route('admin.rentals.edit', rental.id)"
                                                class="btn btn-primary">Edit
                                            </Link>
                                            <button @click="deleteRental(rental.id)"
                                                class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Link :href="route('admin.rentals.create')" class="btn btn-success">Create New Rental</Link>
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
    rentals: Object
})

const deleteRental = async (id) => {
    if (confirm('Are you sure you want to delete this rental?')) {
        try {
            await axios.delete(route('admin.rentals.destroy', id));
            location.reload(); // Refresh the page after deletion
        } catch (error) {
            console.error(error);
        }
    }
};
</script>
