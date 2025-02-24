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
                            <h1>Edit Customer</h1>
                            <form @submit.prevent="updateCustomer">
                                <div>
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" v-model="form.name" required />
                                </div>
                                <div>
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" v-model="form.email" required />
                                </div>
                                <div>
                                    <label for="password">Password (Leave blank to keep current password):</label>
                                    <input type="password" id="password" v-model="form.password" />
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
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
import { useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    customer: Object
})

const form = useForm({
    name: props.customer.name,
    email: props.customer.email,
    password: props.customer.password,
});

const updateCustomer = () => {
    form.put(route('admin.customers.update', props.customer.id), {
        onSuccess: () => {
            alert('Customer updated successfully');
        },
        onError: () => {
            alert('There was an error updating the customer');
        },
    });
};
</script>
