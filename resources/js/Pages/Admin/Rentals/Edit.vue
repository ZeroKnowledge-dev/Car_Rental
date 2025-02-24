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
                            <h1>Edit Rental</h1>
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
                                    <input @change="calculateTotalPrice(form.car_id)" type="date"
                                        v-model="form.start_date" required />
                                </div>
                                <div>
                                    <label for="end_date">End Date:</label>
                                    <input @change="calculateTotalPrice(form.car_id)" type="date"
                                        v-model="form.end_date" required />
                                </div>
                                <div>
                                    <p><strong>Total Cost: </strong> {{ form.total_cost }}</p>
                                </div>
                                <button type="submit">Update Rental</button>
                            </form>

                            <div>
                                <Link :href="route('admin.rentals.index')" class="btn btn-secondary">Back to Rentals
                                List</Link>
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
    rental: Object,
    cars: Object,
    users: Object
})

// Initialize the form with the rental's current data
const form = useForm({
    user_id: props.rental.user_id,
    car_id: props.rental.car_id,
    start_date: props.rental.start_date,
    end_date: props.rental.end_date,
    total_cost: props.rental.total_cost,
});

function dateValidate() {
    form.start_date = new Date(props.rental.start_date).toISOString().split('T')[0];
    form.end_date = new Date(props.rental.end_date).toISOString().split('T')[0];
}

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
    form.put(route('admin.rentals.update', props.rental.id), {
        onSuccess: () => {
            alert('Rental updated successfully!');
        },
    });
};

dateValidate();
</script>
