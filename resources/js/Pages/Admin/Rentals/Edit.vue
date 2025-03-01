<template>

    <Head :title="'Edit Rental'" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                    Edit Rental
                </h2>
                <p class="mt-2 text-sm text-gray-600">Update rental information</p>
            </div>

            <div class="flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="bg-white shadow-lg sm:rounded-lg border border-gray-100">
                        <div class="px-6 py-8">
                            <form @submit.prevent="updateRental" class="space-y-6">
                                <!-- Customer Information (Read-only) -->
                                <div>
                                    <InputLabel value="Customer" class="text-[#013237]" />
                                    <div class="mt-1 flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                                            {{ user.name.charAt(0) }}
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                                            <p class="text-sm text-gray-500">{{ user.email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Car Information (Read-only) -->
                                <div>
                                    <InputLabel value="Car" class="text-[#013237]" />
                                    <div class="mt-1 flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img :src="`/storage/${car.image}`" :alt="car.name"
                                                class="h-10 w-10 rounded-lg object-cover" />
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ car.name }}</p>
                                            <p class="text-sm text-gray-500">{{ car.brand }} {{ car.model }}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <p class="text-sm font-medium text-[#4CA771]">${{ car.daily_rent_price
                                                }}/day</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rental Dates -->
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <InputLabel for="start_date" value="Start Date" class="text-[#013237]" />
                                        <TextInput id="start_date" type="date" v-model="form.start_date"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            :min="minStartDate" required />
                                        <InputError :message="form.errors.start_date" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="end_date" value="End Date" class="text-[#013237]" />
                                        <TextInput id="end_date" type="date" v-model="form.end_date"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            :min="form.start_date" required />
                                        <InputError :message="form.errors.end_date" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Rental Status -->
                                <div>
                                    <InputLabel for="status" value="Status" class="text-[#013237]" />
                                    <select id="status" v-model="form.status"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50">
                                        <option value="ongoing">Ongoing</option>
                                        <option value="completed">Completed</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                    <InputError :message="form.errors.status" class="mt-2" />
                                </div>

                                <!-- Total Cost Preview -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total Cost</p>
                                            <p class="text-lg font-bold text-[#4CA771]">${{ totalCost }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ rentalDays }} days × ${{ car.daily_rent_price }}/day
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4">
                                    <Link :href="route('admin.rentals.show', rental.id)"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                    </Link>
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing" class="bg-[#4CA771] hover:bg-[#013237]">
                                        Update Rental
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { computed, watch } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    rental: Object,
    user: Object,
    car: Object
});

// Helper function to format date to 'yyyy-MM-dd'
const formatDate = (date) => {
    const d = new Date(date);
    return d.toISOString().split('T')[0]; // 'yyyy-MM-dd' format
};

const form = useForm({
    start_date: formatDate(props.rental.start_date),
    end_date: formatDate(props.rental.end_date),
    status: props.rental.status,
    total_cost: props.rental.total_cost,
    user_id: props.user.id,
    car_id: props.car.id,
    _method: 'PUT',
});

// Use the rental's original start date as minimum if it's in the past
const minStartDate = computed(() => {
    const originalStart = new Date(props.rental.start_date);
    const today = new Date();
    const formattedToday = today.toISOString().split('T')[0]; // Format today's date as 'yyyy-MM-dd'
    return originalStart < today ? formatDate(props.rental.start_date) : formattedToday;
});

const rentalDays = computed(() => {
    if (!form.start_date || !form.end_date) return 0;
    const start = new Date(form.start_date);
    const end = new Date(form.end_date);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Add 1 to include both start and end dates
});

const totalCost = computed(() => {
    const cost = props.car.daily_rent_price * rentalDays.value;
    form.total_cost = cost; // Update the form's total_cost
    return cost;
});

// Watch for date changes to validate end_date
watch([() => form.start_date, () => form.end_date], ([newStart, newEnd]) => {
    if (newStart && newEnd && new Date(newEnd) < new Date(newStart)) {
        form.end_date = newStart;
    }
});

const updateRental = () => {
    form.start_date = formatDate(form.start_date);
    form.end_date = formatDate(form.end_date);
    form.post(route('admin.rentals.update', props.rental.id), {
        preserveScroll: true,
    });
};
</script>
