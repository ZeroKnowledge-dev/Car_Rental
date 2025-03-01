<template>

    <Head title="Create Customer" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-[#013237] sm:text-4xl">
                    Create New Customer
                </h2>
                <p class="mt-2 text-sm text-gray-600">Add a new customer to your rental system</p>
            </div>

            <div class="flex justify-center">
                <div class="w-full max-w-xl">
                    <div class="bg-white shadow-lg sm:rounded-lg border border-gray-100">
                        <div class="px-6 py-8">
                            <form @submit.prevent="createCustomer" class="space-y-6">
                                <div>
                                    <InputLabel for="name" value="Name" class="text-[#013237]" />
                                    <TextInput id="name" type="text" v-model="form.name"
                                        class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                        required autofocus />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" class="text-[#013237]" />
                                    <TextInput id="email" type="email" v-model="form.email"
                                        class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                        required />
                                    <InputError :message="form.errors.email" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="password" value="Password" class="text-[#013237]" />
                                    <TextInput id="password" type="password" v-model="form.password"
                                        class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                        required autocomplete="new-password" />
                                    <InputError :message="form.errors.password" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="password_confirmation" value="Confirm Password"
                                        class="text-[#013237]" />
                                    <TextInput id="password_confirmation" type="password"
                                        v-model="form.password_confirmation"
                                        class="mt-1 block w-full border-gray-300 focus:border-[#4CA771] focus:ring-[#4CA771]"
                                        required />
                                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4">
                                    <Link :href="route('admin.customers.index')"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 hover:border-[#4CA771] focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                    </Link>
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing" class="bg-[#4CA771] hover:bg-[#013237]">
                                        Create Customer
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
import { Head, useForm, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const createCustomer = () => {
    form.post(route('admin.customers.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
