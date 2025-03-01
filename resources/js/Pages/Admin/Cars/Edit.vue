<template>

    <Head :title="'Edit Car - ' + car.name" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                    Edit Car
                </h2>
                <p class="mt-2 text-sm text-gray-600">Update car information and details</p>
            </div>

            <div class="flex justify-center">
                <div class="w-full max-w-3xl">
                    <div class="bg-white shadow-lg sm:rounded-lg border border-gray-100">
                        <div class="px-6 py-8">
                            <form @submit.prevent="updateCar" class="space-y-6">
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <div>
                                        <InputLabel for="name" value="Car Name" class="text-[#013237]" />
                                        <TextInput id="name" type="text" v-model="form.name"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            required />
                                        <InputError :message="form.errors.name" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="brand" value="Brand" class="text-[#013237]" />
                                        <TextInput id="brand" type="text" v-model="form.brand"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            required />
                                        <InputError :message="form.errors.brand" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="model" value="Model" class="text-[#013237]" />
                                        <TextInput id="model" type="text" v-model="form.model"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            required />
                                        <InputError :message="form.errors.model" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="year" value="Year" class="text-[#013237]" />
                                        <TextInput id="year" type="text" v-model="form.year"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            required />
                                        <InputError :message="form.errors.year" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="daily_rent_price" value="Daily Rental Price ($)"
                                            class="text-[#013237]" />
                                        <TextInput id="daily_rent_price" type="number" step="0.01"
                                            v-model="form.daily_rent_price"
                                            class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                            required />
                                        <InputError :message="form.errors.daily_rent_price" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="car_type" value="Car Type" class="text-[#013237]" />
                                        <select id="car_type" v-model="form.car_type"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-[#4CA771] focus:ring focus:ring-[#4CA771] focus:ring-opacity-50"
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="sedan">Sedan</option>
                                            <option value="suv">SUV</option>
                                            <option value="luxury">Luxury</option>
                                            <option value="sports">Sports</option>
                                        </select>
                                        <InputError :message="form.errors.car_type" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <InputLabel for="image" value="Car Image" class="text-[#013237]" />
                                    <input type="file" id="image" @input="form.image = $event.target.files[0]"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#4CA771] file:text-white hover:file:bg-[#013237]"
                                        accept="image/*" />
                                    <InputError :message="form.errors.image" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-between pt-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="availability" v-model="form.availability"
                                            class="rounded border-gray-300 text-[#4CA771] focus:ring-[#4CA771]" />
                                        <label for="availability" class="ml-2 text-sm text-gray-600">
                                            Available for Rent
                                        </label>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <Link :href="route('admin.cars.show', car.id)"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        Cancel
                                        </Link>
                                        <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing" class="bg-[#4CA771] hover:bg-[#013237]">
                                            Update Car
                                        </PrimaryButton>
                                    </div>
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
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    car: Object,
});

const form = useForm({
    name: props.car.name,
    brand: props.car.brand,
    model: props.car.model,
    year: props.car.year.toString(),
    daily_rent_price: props.car.daily_rent_price,
    car_type: props.car.car_type,
    availability: props.car.availability,
    image: null,
    _method: 'PUT',
});

const updateCar = () => {
    form.post(route('admin.cars.update', props.car.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('image');
        },
    });
};
</script>
