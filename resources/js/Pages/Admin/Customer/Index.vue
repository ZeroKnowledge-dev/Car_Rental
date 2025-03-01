<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    customers: Array
});


// Search functionality
const search = ref('');

// Format date helper
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
};

// Delete functionality
const showDeleteModal = ref(false);
const customerToDelete = ref(null);
const form = useForm({});

const confirmCustomerDeletion = (customer) => {
    customerToDelete.value = customer;
    showDeleteModal.value = true;
};

const closeModal = () => {
    showDeleteModal.value = false;
    customerToDelete.value = null;
};

const deleteCustomer = () => {
    if (customerToDelete.value) {
        form.delete(route('admin.customers.destroy', customerToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Filtered customers based on search
const filteredCustomers = computed(() => {
    return props.customers.filter(customer => {
        const searchLower = search.value.toLowerCase();
        return search.value === '' ||
            customer.name.toLowerCase().includes(searchLower) ||
            customer.email.toLowerCase().includes(searchLower) ||
            (customer.phone && customer.phone.includes(search.value));
    });
});
</script>

<template>

    <Head title="Customers" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between mb-6">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                        Customers
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">Manage your customer accounts</p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <Link :href="route('admin.customers.create')"
                        class="inline-flex items-center rounded-md bg-[#4CA771] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#013237] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#4CA771]">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    New Customer
                    </Link>
                </div>
            </div>

            <!-- Search Section -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" v-model="search" placeholder="Search customers..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50" />
                    </div>
                </div>
            </div>

            <!-- Customers Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div v-for="customer in filteredCustomers" :key="customer.id"
                    class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <!-- Customer Info -->
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-[#4CA771] flex items-center justify-center text-white text-lg font-semibold">
                                {{ customer.name.charAt(0) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-[#013237]">{{ customer.name }}</h3>
                                <p class="text-sm text-gray-600">{{ customer.email }}</p>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="border-t border-gray-100 pt-4">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-600">Member Since</p>
                                    <p class="text-sm font-medium text-gray-900">{{ formatDate(customer.created_at) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Rentals</p>
                                    <p class="text-sm font-medium text-[#4CA771]">{{ customer.rentals.length || 0 }}
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="text-sm font-medium text-gray-900">{{ customer.phone || 'Not provided' }}</p>
                            </div>

                            <!-- Updated Actions -->
                            <div class="flex justify-end space-x-2">
                                <Link :href="route('admin.customers.show', customer.id)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771]">
                                View Details
                                </Link>
                                <Link :href="route('admin.customers.edit', customer.id)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-[#4CA771] hover:bg-[#013237] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771]">
                                Edit
                                </Link>
                                <button @click="confirmCustomerDeletion(customer)"
                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
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
                    <h3 class="text-lg font-medium text-gray-900">Delete Customer</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Are you sure you want to delete this customer? This action cannot be undone.
                    </p>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>
                    <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteCustomer">
                        Delete Customer
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
