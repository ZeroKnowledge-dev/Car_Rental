<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-2xl font-bold text-[#155E64]">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="shadow-lg rounded-lg p-8 bg-[#A0E4D0]">
                    <h1 class="text-2xl font-semibold mb-6 text-[#155E64]">Create New Car</h1>

                    <form @submit.prevent="submitForm" class="space-y-6">
                        <!-- Car Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-[#155E64] font-medium">Car Name</label>
                            <input type="text" v-model="form.name" id="name" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</span>
                        </div>

                        <!-- Brand -->
                        <div class="space-y-2">
                            <label for="brand" class="block text-[#155E64] font-medium">Brand</label>
                            <input type="text" v-model="form.brand" id="brand" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.brand" class="text-red-600 text-sm">{{ form.errors.brand }}</span>
                        </div>

                        <!-- Model -->
                        <div class="space-y-2">
                            <label for="model" class="block text-[#155E64] font-medium">Model</label>
                            <input type="text" v-model="form.model" id="model" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.model" class="text-red-600 text-sm">{{ form.errors.model }}</span>
                        </div>

                        <!-- Car Type -->
                        <div class="space-y-2">
                            <label for="car_type" class="block text-[#155E64] font-medium">Car Type</label>
                            <input type="text" v-model="form.car_type" id="car_type" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.car_type" class="text-red-600 text-sm">{{ form.errors.car_type
                            }}</span>
                        </div>

                        <!-- Year -->
                        <div class="space-y-2">
                            <label for="year" class="block text-[#155E64] font-medium">Year</label>
                            <input type="number" v-model="form.year" id="year" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.year" class="text-red-600 text-sm">{{ form.errors.year }}</span>
                        </div>

                        <!-- Daily Rent Price -->
                        <div class="space-y-2">
                            <label for="daily_rent_price" class="block text-[#155E64] font-medium">Daily Rent
                                Price</label>
                            <input type="number" v-model="form.daily_rent_price" id="daily_rent_price" required
                                class="w-full p-3 border-2 border-[#75B39C] rounded-md focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]" />
                            <span v-if="form.errors.daily_rent_price" class="text-red-600 text-sm">{{
                                form.errors.daily_rent_price }}</span>
                        </div>

                        <!-- Availability Checkbox -->
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" v-model="form.availability" id="availability"
                                class="border-[#75B39C] rounded-md focus:ring-[#A0E4D0]" />
                            <label for="availability" class="text-[#155E64]">Available</label>
                        </div>

                        <!-- Car Image -->
                        <div class="space-y-2">
                            <label for="image" class="block text-[#155E64] font-medium">Car Image</label>
                            <input type="file" @change="handleImageChange" id="image"
                                class="block w-full text-[#155E64] p-3 border-2 border-[#75B39C] rounded-md" />
                            <span v-if="form.errors.image" class="text-red-600 text-sm">{{ form.errors.image }}</span>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-4">
                            <button type="submit"
                                class="px-6 py-2 text-white font-semibold bg-[#75B39C] rounded-md hover:bg-[#7bd1b7] focus:outline-none focus:ring-2 focus:ring-[#A0E4D0]"
                                :disabled="form.processing">
                                <span v-if="form.processing">Creating...</span>
                                <span v-else>Create Car</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
    name: '',
    brand: '',
    model: '',
    year: '',
    car_type: '',
    daily_rent_price: '',
    availability: false,
    image: null,
});

const submitForm = () => {
    form.post(route('admin.cars.store'), {
        onSuccess: () => {
            form.reset();
            alert('Car created successfully!');
        },
        onError: () => {
            console.error(form.errors);
            alert('There was an error creating the car');
        },
    });
};

const handleImageChange = (e) => {
    form.image = e.target.files[0];
};
</script>

<style scoped>
/* Apply smooth transitions for input fields */
input[type="text"],
input[type="number"],
input[type="file"] {
    transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="file"]:focus {
    border-color: var(--primary-hover);
    box-shadow: 0 0 5px var(--primary-hover);
}
</style>
