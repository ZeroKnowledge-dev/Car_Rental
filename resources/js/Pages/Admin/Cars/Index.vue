<template>

    <Head title="Manage Cars" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                        Manage Cars
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">Manage your fleet of rental vehicles</p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <Link :href="route('admin.cars.create')"
                        class="inline-flex items-center px-3 py-1 bg-[#4CA771] text-white text-sm font-medium rounded-md hover:bg-[#013237] transition-colors duration-150">

                    Add New Car
                    </Link>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" v-model="search" placeholder="Search cars..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50" />
                    </div>
                    <div class="flex gap-4">
                        <select v-model="filterAvailability"
                            class="rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Not Available</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Cars Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="car in filteredCars" :key="car.id" class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md
                    transition-shadow duration-200">
                    <div class="aspect-w-16 aspect-h-9">
                        <img :src="`/storage/${car.image}`" :alt="car.name" class="object-cover w-full h-48" />
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-[#013237]">{{ car.name }}</h3>
                                <p class="text-sm text-gray-600">{{ car.brand }} {{ car.model }} {{ car.year }}</p>
                                <p class="text-sm text-gray-600">{{ car.car_type }}</p>
                            </div>
                            <span :class="[
                                car.availability ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                                'inline-flex rounded-full px-2 py-1 text-xs font-semibold'
                            ]">
                                {{ car.availability ? 'Available' : 'Not Available' }}
                            </span>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-lg font-bold text-[#4CA771]">${{ car.daily_rent_price }}/day</span>
                            <div class="flex space-x-2">
                                <Link :href="route('admin.cars.show', car.id)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771]">
                                View Details
                                </Link>
                                <Link :href="route('admin.cars.edit', car.id)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#4CA771] hover:bg-[#013237] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771]">
                                Edit
                                </Link>
                                <button @click="confirmCarDeletion(car)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Car Modal -->
            <Modal :show="showDeleteModal" @close="closeModal">
                <div class="p-6">
                    <div class="flex items-center justify-center mb-4">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900">Delete Car</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Are you sure you want to delete this car? This action cannot be undone.
                        </p>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <SecondaryButton @click="closeModal">
                            Cancel
                        </SecondaryButton>
                        <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            @click="deleteCar">
                            Delete Car
                        </DangerButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    cars: {
        type: Array, // Change from Object to Array
        required: true,
    },
});

const showDeleteModal = ref(false);
const search = ref('');
const filterAvailability = ref('');
const carToDelete = ref(null);

const form = useForm({});

// Computed property to filter cars based on search and availability
const filteredCars = computed(() => {
    return props.cars.filter(car => {
        const matchesSearch = car.name.toLowerCase().includes(search.value.toLowerCase()) ||
            car.brand.toLowerCase().includes(search.value.toLowerCase()) ||
            car.model.toLowerCase().includes(search.value.toLowerCase());

        const matchesAvailability = filterAvailability.value
            ? (filterAvailability.value === 'available' ? car.availability : !car.availability)
            : true;

        return matchesSearch && matchesAvailability;
    });
});

const confirmCarDeletion = (car) => {
    carToDelete.value = car;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
    carToDelete.value = null;
};

const deleteCar = () => {
    if (carToDelete.value) {
        form.delete(route('admin.cars.destroy', carToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
        });
    }
};
</script>
