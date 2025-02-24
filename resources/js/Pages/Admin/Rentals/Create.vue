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
                            <h1>Create Rental</h1>
                            <form @submit.prevent="submitForm">
                                <div>
                                    <label for="user_id">User:</label>
                                    <select v-model="form.user_id" required>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="car_id">Car:</label>
                                    <select @change="calculateTotalPrice(form.car_id)" v-model="form.car_id" required>
                                        <option v-for="car in cars" :key="car.id" :value="car.id">{{ car.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" v-model="form.start_date"
                                        @change="calculateTotalPrice(form.car_id)" required />
                                </div>
                                <div>
                                    <label for="end_date">End Date:</label>
                                    <input type="date" v-model="form.end_date"
                                        @change="calculateTotalPrice(form.car_id)" required />
                                </div>
                                <template v-if="form.start_date && form.end_date && form.car_id">
                                    <div>
                                        <p>Total Price: ${{ form.total_cost }}</p>
                                    </div>
                                </template>
                                <button type="submit">Create Rental</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    users: Object,
    cars: Object
})

const form = useForm({
    user_id: '',
    car_id: '',
    start_date: '',
    end_date: '',
    total_cost: 0, // Initialize to 0
});

function calculateTotalPrice(id) {
    // Ensure both dates are valid
    if (!form.start_date || !form.end_date || !form.car_id) return;

    // Define the two dates
    const date1 = new Date(form.start_date);
    const date2 = new Date(form.end_date);

    // Calculate the difference in milliseconds
    const differenceInTime = date2.getTime() - date1.getTime();

    // Convert the difference from milliseconds to days
    const differenceInDays = differenceInTime / (1000 * 3600 * 24);

    // Ensure the difference is non-negative
    if (differenceInDays >= 0) {
        //Find car
        const car = props.cars.find(car => car.id === id);
        // Calculate the total price
        form.total_cost = differenceInDays * car.daily_rent_price; // Replace 5 with the actual daily rate if needed
    } else {
        form.total_cost = 0; // Reset if end date is before start date
    }
}


const submitForm = () => {
    form.post(route('admin.rentals.store'), {
        onSuccess: () => {
            alert('Rental created successfully!');
        },
    });
};
</script>
