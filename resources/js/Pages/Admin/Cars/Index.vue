<template>

    <Head title="Manage Cars" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Cars</h1>
                <PrimaryButton @click="showCreateModal = true">Add New Car</PrimaryButton>
            </div>

            <!-- Cars Table -->
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            Car</th>
                                        
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Daily Rate
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="car in props.cars" :key="car.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img :src="`/storage/${car.image}`" :alt="car.name"
                                                        class="h-10 w-10 rounded-full object-cover" />
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ car.name }}</div>
                                                    <div class="text-gray-500">{{ car.model }} {{ car.year }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">${{ car.daily_rent_price
                                            }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span :class="[
                                                car.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                                                'inline-flex rounded-full px-2 text-xs font-semibold leading-5'
                                            ]">
                                                {{ car.is_available ? 'Available' : 'Rented' }}
                                            </span>
                                        </td>
                                        <td
                                            class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <SecondaryButton class="mr-2" @click="editCar(car)">Edit</SecondaryButton>
                                            <DangerButton @click="confirmCarDeletion(car)">Delete</DangerButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Car Modal -->
            <Modal :show="showCreateModal" @close="showCreateModal = false">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Add New Car</h2>
                    <form @submit.prevent="createCar" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" v-model="form.name" class="mt-1 block w-full" required />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="model" value="Model" />
                                <TextInput id="model" type="text" v-model="form.model" class="mt-1 block w-full"
                                    required />
                                <InputError :message="form.errors.model" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="year" value="Year" />
                                <TextInput id="year" type="number" v-model="form.year" class="mt-1 block w-full"
                                    required />
                                <InputError :message="form.errors.year" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="color" value="Color" />
                                <TextInput id="color" type="text" v-model="form.color" class="mt-1 block w-full"
                                    required />
                                <InputError :message="form.errors.color" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="license_plate" value="License Plate" />
                                <TextInput id="license_plate" type="text" v-model="form.license_plate"
                                    class="mt-1 block w-full" required />
                                <InputError :message="form.errors.license_plate" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="daily_rate" value="Daily Rate" />
                            <TextInput id="daily_rate" type="number" step="0.01" v-model="form.daily_rate"
                                class="mt-1 block w-full" required />
                            <InputError :message="form.errors.daily_rate" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea id="description" v-model="form.description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]"
                                required></textarea>
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="image" value="Image" />
                            <input type="file" id="image" @input="form.image = $event.target.files[0]"
                                class="mt-1 block w-full" accept="image/*" required />
                            <InputError :message="form.errors.image" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-6 gap-4">
                            <SecondaryButton @click="showCreateModal = false">Cancel</SecondaryButton>
                            <PrimaryButton :disabled="form.processing">Create Car</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Edit Car Modal -->
            <Modal :show="showEditModal" @close="showEditModal = false">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Edit Car</h2>
                    <form @submit.prevent="updateCar" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="edit_name" value="Name" />
                            <TextInput id="edit_name" type="text" v-model="editForm.name" class="mt-1 block w-full"
                                required />
                            <InputError :message="editForm.errors.name" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="edit_model" value="Model" />
                                <TextInput id="edit_model" type="text" v-model="editForm.model"
                                    class="mt-1 block w-full" required />
                                <InputError :message="editForm.errors.model" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="edit_year" value="Year" />
                                <TextInput id="edit_year" type="number" v-model="editForm.year"
                                    class="mt-1 block w-full" required />
                                <InputError :message="editForm.errors.year" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="edit_color" value="Color" />
                                <TextInput id="edit_color" type="text" v-model="editForm.color"
                                    class="mt-1 block w-full" required />
                                <InputError :message="editForm.errors.color" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="edit_license_plate" value="License Plate" />
                                <TextInput id="edit_license_plate" type="text" v-model="editForm.license_plate"
                                    class="mt-1 block w-full" required />
                                <InputError :message="editForm.errors.license_plate" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="edit_daily_rate" value="Daily Rate" />
                            <TextInput id="edit_daily_rate" type="number" step="0.01" v-model="editForm.daily_rate"
                                class="mt-1 block w-full" required />
                            <InputError :message="editForm.errors.daily_rate" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="edit_description" value="Description" />
                            <textarea id="edit_description" v-model="editForm.description" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]"
                                required></textarea>
                            <InputError :message="editForm.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="edit_image" value="Image" />
                            <input type="file" id="edit_image" @input="editForm.image = $event.target.files[0]"
                                class="mt-1 block w-full" accept="image/*" />
                            <InputError :message="editForm.errors.image" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-6 gap-4">
                            <SecondaryButton @click="showEditModal = false">Cancel</SecondaryButton>
                            <PrimaryButton :disabled="editForm.processing">Update Car</PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>

            <!-- Delete Car Modal -->
            <Modal :show="showDeleteModal" @close="showDeleteModal = false">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">Delete Car</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Are you sure you want to delete this car? This action cannot be undone.
                    </p>

                    <div class="mt-6 flex justify-end gap-4">
                        <SecondaryButton @click="showDeleteModal = false">Cancel</SecondaryButton>
                        <DangerButton :disabled="form.processing" @click="deleteCar">Delete Car</DangerButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

const props = defineProps({
    cars: {
        type: Object,
        required: true,
    },
});

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedCar = ref(null);

const form = useForm({
    name: '',
    model: '',
    year: '',
    color: '',
    license_plate: '',
    daily_rate: '',
    description: '',
    image: null,
});

const editForm = useForm({
    name: '',
    model: '',
    year: '',
    color: '',
    license_plate: '',
    daily_rate: '',
    description: '',
    image: null,
});

const createCar = () => {
    form.post(route('admin.cars.store'), {
        onSuccess: () => {
            form.reset();
            showCreateModal.value = false;
        },
    });
};

const editCar = (car) => {
    selectedCar.value = car;
    editForm.name = car.name;
    editForm.model = car.model;
    editForm.year = car.year;
    editForm.color = car.color;
    editForm.license_plate = car.license_plate;
    editForm.daily_rate = car.daily_rate;
    editForm.description = car.description;
    showEditModal.value = true;
};

const updateCar = () => {
    editForm.post(route('admin.cars.update', selectedCar.value.id), {
        onSuccess: () => {
            editForm.reset();
            showEditModal.value = false;
            selectedCar.value = null;
        },
    });
};

const confirmCarDeletion = (car) => {
    selectedCar.value = car;
    showDeleteModal.value = true;
};

const deleteCar = () => {
    if (selectedCar.value) {
        useForm().delete(route('admin.cars.destroy', selectedCar.value.id), {
            onSuccess: () => {
                showDeleteModal.value = false;
                selectedCar.value = null;
            },
        });
    }
};
</script>
