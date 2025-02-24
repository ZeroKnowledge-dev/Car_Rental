<template>
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
                            <h1>Edit Car</h1>
                            <form @submit.prevent="submitForm">
                                <div>
                                    <label for="name">Car Name:</label>
                                    <input type="text" v-model="form.name" required />
                                </div>
                                <div>
                                    <label for="brand">Brand:</label>
                                    <input type="text" v-model="form.brand" required />
                                </div>
                                <div>
                                    <label for="model">Model:</label>
                                    <input type="text" v-model="form.model" required />
                                </div>
                                <div>
                                    <label for="year">Year:</label>
                                    <input type="number" v-model="form.year" required />
                                </div>
                                <div>
                                    <label for="daily_rent_price">Daily Rent Price:</label>
                                    <input type="number" v-model="form.daily_rent_price" required />
                                </div>
                                <div>
                                    <label for="availability">Available:</label>
                                    <input type="checkbox" v-model="form.availability" />
                                </div>
                                <div>
                                    <label for="image">Car Image:</label>
                                    <input type="file" @change="handleImageChange" />
                                    <div v-if="form.image && form.image.name">
                                        <p>Selected File: {{ form.image.name }}</p>
                                    </div>
                                </div>
                                <button type="submit">Update Car</button>
                            </form>
                            <div>
                                <Link :href="route('admin.cars.index')" class="btn btn-secondary">Back to List</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    car: Object
})

// Initialize the form with car data
const form = useForm({
    id: props.car.id,
    name: props.car.name,
    brand: props.car.brand,
    model: props.car.model,
    year: props.car.year,
    daily_rent_price: props.car.daily_rent_price,
    availability: props.car.availability,
    image: null,
});

const submitForm = () => {
    form.put(route('admin.cars.update', props.car.id), {
        onSuccess: () => {
            alert('Car updated successfully!');
        },
    });
};

const handleImageChange = (e) => {
    form.image = e.target.files[0];
};
</script>
