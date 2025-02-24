<template>

    <Head title="Admin Dashboard" />
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
                            <h2>Welcome to Admin Dashboard</h2>

                            <!-- Overview widgets -->
                            <div class="overview">
                                <div class="widget">
                                    <h3>Total Rentals</h3>
                                    <p>{{ rentalCount }}</p>
                                </div>

                                <div class="widget">
                                    <h3>Available Cars</h3>
                                    <p>{{ availableCarsCount }}</p>
                                </div>

                                <div class="widget">
                                    <h3>Total Customers</h3>
                                    <p>{{ customerCount }}</p>
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
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const rentalCount = ref(0);
const availableCarsCount = ref(0);
const customerCount = ref(0);

onMounted(() => {
    // Retrieve data using Inertia's props passed to the page
    const { rentals, cars, users } = usePage().props;

    rentalCount.value = rentals.length;
    availableCarsCount.value = cars.filter(car => car.availability).length;
    customerCount.value = users.length;
});
</script>
