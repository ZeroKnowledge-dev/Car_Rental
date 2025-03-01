<template>

    <Head :title="'Edit Customer - ' + customer.name" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                        Edit Customer
                    </h2>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <Link :href="route('admin.customers.show', customer.id)"
                        class="ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Back to Details
                    </Link>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="max-w-xl">
                            <form @submit.prevent="updateCustomer" class="space-y-6">
                                <div>
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" v-model="form.name" class="mt-1 block w-full"
                                        required autofocus />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput id="email" type="email" v-model="form.email" class="mt-1 block w-full"
                                        required />
                                    <InputError :message="form.errors.email" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="password" value="New Password (optional)" />
                                    <TextInput id="password" type="password" v-model="form.password"
                                        class="mt-1 block w-full" autocomplete="new-password" />
                                    <InputError :message="form.errors.password" class="mt-2" />
                                </div>

                                <div v-if="form.password">
                                    <InputLabel for="password_confirmation" value="Confirm New Password" />
                                    <TextInput id="password_confirmation" type="password"
                                        v-model="form.password_confirmation" class="mt-1 block w-full" />
                                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end gap-4">
                                    <Link :href="route('admin.customers.index')"
                                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Cancel
                                    </Link>
                                    <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                        :disabled="form.processing">
                                        Update Customer
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
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    customer: Object
});

const form = useForm({
    name: props.customer.name,
    email: props.customer.email,
    password: '',
    password_confirmation: '',
});

const updateCustomer = () => {
    form.put(route('admin.customers.update', props.customer.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
