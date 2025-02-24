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
                            <h1>Create Customer</h1>
                            <form @submit.prevent="createCustomer">
                                <div>
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" v-model="form.name" required />
                                </div>
                                <div>
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" v-model="form.email" required />
                                </div>
                                <div>
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" v-model="form.password" required />
                                </div>
                                <div>
                                    <label for="password_confirmation">Confirm Password:</label>
                                    <input type="password" id="password_confirmation"
                                        v-model="form.password_confirmation" required />
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                                <Link :href="route('admin.customers.index')" class="btn btn-secondary">Cancel</Link>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const createCustomer = () => {
    form.post(route('admin.customers.store'), {
        onSuccess: () => {
            form.reset();
            alert('Customer created successfully');
        },
        onError: () => {
            alert('There was an error creating the customer');
        },
    });
};
</script>
