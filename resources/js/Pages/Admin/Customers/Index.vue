<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  customers: {
    type: Object,
    required: true,
  },
});

const showDetailsModal = ref(false);
const selectedCustomer = ref(null);
const searchQuery = ref('');
const filterStatus = ref('all');

const viewCustomerDetails = (customer) => {
  selectedCustomer.value = customer;
  showDetailsModal.value = true;
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
};

const getStatusColor = (status) => {
  switch (status) {
    case 'completed':
      return 'bg-green-100 text-green-800';
    case 'ongoing':
      return 'bg-blue-100 text-blue-800';
    case 'canceled':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};

const calculateTotalSpent = (rentals) => {
  return rentals?.reduce((sum, rental) => sum + parseFloat(rental.total_cost), 0) || 0;
};
</script>

<template>

  <Head title="Manage Customers" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
          <h1 class="text-2xl font-semibold text-gray-900">Customers</h1>
          <p class="mt-2 text-sm text-gray-700">
            A list of all customers in your car rental system including their details and rental history.
          </p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <div class="flex space-x-4">
            <!-- Search Input -->
            <div class="relative">
              <input type="text" v-model="searchQuery" placeholder="Search customers..."
                class="block w-full rounded-md border-gray-300 pr-10 focus:border-[#4CA771] focus:ring-[#4CA771] sm:text-sm" />
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Customers Table -->
      <div class="mt-8 flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                      Customer</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Rentals</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Spent</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr v-for="customer in customers.data" :key="customer.id">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      <div class="flex items-center">
                        <div
                          class="h-10 w-10 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                          {{ customer.name.charAt(0) }}
                        </div>
                        <div class="ml-4">
                          <div class="font-medium text-gray-900">{{ customer.name }}</div>
                          <div class="text-gray-500">Member since {{ formatDate(customer.created_at) }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      <div class="text-gray-900">{{ customer.email }}</div>
                      <div class="text-gray-500">{{ customer.phone || 'No phone number' }}</div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                      {{ customer.rentals?.length || 0 }} rentals
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-[#4CA771]">
                      ${{ calculateTotalSpent(customer.rentals).toLocaleString() }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                      <span
                        :class="[customer.rentals?.some(r => r.status === 'ongoing') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800', 'inline-flex rounded-full px-2 text-xs font-semibold leading-5']">
                        {{customer.rentals?.some(r => r.status === 'ongoing') ? 'Active' : 'Inactive'}}
                      </span>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                      <SecondaryButton @click="viewCustomerDetails(customer)" class="ml-2">
                        View Details
                      </SecondaryButton>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Details Modal -->
      <Modal :show="showDetailsModal" @close="showDetailsModal = false" maxWidth="4xl">
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">Customer Details</h2>
            <SecondaryButton @click="showDetailsModal = false">
              <span class="sr-only">Close</span>
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </SecondaryButton>
          </div>

          <div v-if="selectedCustomer" class="space-y-8">
            <!-- Customer Profile -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center space-x-6">
                  <div
                    class="h-20 w-20 rounded-full bg-[#4CA771] flex items-center justify-center text-white text-3xl font-semibold">
                    {{ selectedCustomer.name.charAt(0) }}
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900">{{ selectedCustomer.name }}</h3>
                    <div class="mt-1 text-sm text-gray-500">
                      <p>{{ selectedCustomer.email }}</p>
                      <p>{{ selectedCustomer.phone || 'No phone number' }}</p>
                      <p>Member since {{ formatDate(selectedCustomer.created_at) }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Customer Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
              <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Rentals</dt>
                  <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ selectedCustomer.rentals?.length || 0 }}</dd>
                </div>
              </div>
              <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                  <dt class="text-sm font-medium text-gray-500 truncate">Total Spent</dt>
                  <dd class="mt-1 text-3xl font-semibold text-[#4CA771]">${{
                    calculateTotalSpent(selectedCustomer.rentals).toLocaleString() }}</dd>
                </div>
              </div>
              <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                  <dt class="text-sm font-medium text-gray-500 truncate">Active Rentals</dt>
                  <dd class="mt-1 text-3xl font-semibold text-gray-900">{{selectedCustomer.rentals?.filter(r =>
                    r.status === 'ongoing').length || 0 }}</dd>
                </div>
              </div>
            </div>

            <!-- Rental History -->
            <div class="bg-white shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Rental History</h4>
                <div class="flow-root">
                  <ul role="list" class="-mb-8">
                    <li v-for="(rental, rentalIdx) in selectedCustomer.rentals" :key="rental.id">
                      <div class="relative pb-8">
                        <span v-if="rentalIdx !== selectedCustomer.rentals.length - 1"
                          class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        <div class="relative flex space-x-3">
                          <div>
                            <span
                              :class="[getStatusColor(rental.status), 'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white']">
                              <svg class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                  clip-rule="evenodd" />
                              </svg>
                            </span>
                          </div>
                          <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-gray-900">
                              {{ rental.car_name }}
                              <span
                                :class="[getStatusColor(rental.status), 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium']">
                                {{ rental.status }}
                              </span>
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                              <p>{{ formatDate(rental.start_date) }} - {{ formatDate(rental.end_date) }}</p>
                              <p class="font-medium text-[#4CA771]">${{ rental.total_cost }}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </Modal>
    </div>
  </AdminLayout>
</template>
