<template>

    <Head title="Create Rental" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                    Create New Rental
                </h2>
                <p class="mt-2 text-sm text-gray-600">Create a new car rental booking</p>
            </div>

            <div class="flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="bg-white shadow-lg sm:rounded-lg border border-gray-100">
                        <div class="px-6 py-8">
                            <form @submit.prevent="createRental" class="space-y-6">
                                <!-- Customer Selection -->
                                <div>
                                    <InputLabel for="user_id" value="Customer" class="text-[#013237]" />
                                    <select id="user_id" v-model="form.user_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50">
                                        <option value="">Select Customer</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">
                                            {{ user.name }} ({{ user.email }})
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.user_id" class="mt-2" />
                                </div>

                                <!-- Car Selection -->
                                <div>
                                    <InputLabel for="car_id" value="Car" class="text-[#013237]" />
                                    <select id="car_id" v-model="form.car_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50">
                                        <option value="">Select Car</option>
                                        <option v-for="car in availableCars" :key="car.id" :value="car.id">
                                            {{ car.name }} - {{ car.brand }} {{ car.model }} (${{ car.daily_rent_price
                                            }}/day)
                                        </option>
                                    </select>
                                    <InputError :message="form.errors.car_id" class="mt-2" />
                                </div>

                                <!-- Rental Dates -->
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <InputLabel for="start_date" value="Start Date" class="text-[#013237]" />
                                        <TextInput id="start_date" type="date" v-model="form.start_date"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            :min="today" required />
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

                                <!-- Total Cost Preview -->
                                <div v-if="totalCost > 0" class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total Cost</p>
                                            <p class="text-lg font-bold text-[#4CA771]">${{ totalCost }}</p>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ rentalDays }} days × ${{ selectedCarRate }}/day
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4">
                                    <Link :href="route('admin.rentals.index')"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                    </Link>
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing" class="bg-[#4CA771] hover:bg-[#013237]">
                                        Create Rental
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
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    users: Array,
    cars: Array,
});

const form = useForm({
    user_id: '',
    car_id: '',
    start_date: '',
    end_date: '',
});

const today = new Date().toISOString().split('T')[0];

const availableCars = computed(() => {
    return props.cars.filter(car => car.availability);
});

const selectedCarRate = computed(() => {
    const car = props.cars.find(c => c.id === form.car_id);
    return car ? car.daily_rent_price : 0;
});

const rentalDays = computed(() => {
    if (!form.start_date || !form.end_date) return 0;
    const start = new Date(form.start_date);
    const end = new Date(form.end_date);
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
});

const totalCost = computed(() => {
    return selectedCarRate.value * rentalDays.value;
});

const createRental = () => {
    form.post(route('admin.rentals.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
