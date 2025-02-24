<template>

    <Head title="Cars" />
    <header class="bg-[#66abb8] dark:bg-gray-900">
        <nav v-if="canLogin" class=" py-2 px-20">
            <template v-if="$page.props.auth.user">
                <div class="flex justify-between items-center px-4 py-2">
                    <!-- Left side (Dashboard link) -->
                    <div class="flex items-center">
                        <Link :href="route('dashboard')"
                            class="text-black dark:text-white px-3 py-2 rounded-md text-lg font-semibold ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>
                    </div>

                    <!-- Right side (Home, Cars, About, Contact links) -->
                    <div class="flex space-x-4">
                        <Link :href="route('welcome')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Home
                        </Link>
                        <Link :href="route('cars')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Cars
                        </Link>
                        <Link :href="route('about')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        About
                        </Link>
                        <Link :href="route('contact')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Contact
                        </Link>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="flex justify-end items-center px-4 py-2">
                    <!-- Login/Register links -->
                    <div class="flex space-x-4">
                        <Link :href="route('welcome')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Home
                        </Link>
                        <Link :href="route('cars')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Cars
                        </Link>
                        <Link :href="route('about')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        About
                        </Link>
                        <Link :href="route('contact')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Contact
                        </Link>
                        <Link :href="route('login')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Log in
                        </Link>

                        <Link v-if="canRegister" :href="route('register')"
                            class="text-black dark:text-white px-3 py-2 rounded-md transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Register
                        </Link>
                    </div>
                </div>
            </template>
        </nav>
    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Car Image -->
                        <div>
                            <div class="aspect-w-16 aspect-h-9">
                                <img :src="`/storage/${car.image}`" :alt="car.name" class="object-cover rounded-lg" />
                            </div>
                        </div>

                        <!-- Car Details -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ car.name }}</h1>
                            <div class="mt-4 space-y-2">
                                <p class="text-gray-600"><span class="font-medium">Brand:</span> {{ car.brand }}</p>
                                <p class="text-gray-600"><span class="font-medium">Model:</span> {{ car.model }}</p>
                                <p class="text-gray-600"><span class="font-medium">Year:</span> {{ car.year }}</p>
                                <p class="text-gray-600"><span class="font-medium">Type:</span> {{ car.car_type }}</p>
                                <p class="text-xl font-bold text-indigo-600">${{ car.daily_rent_price }}/day
                                </p>
                            </div>

                            <div v-if="canLogin">
                                <template v-if="$page.props.auth.user">
                                    <div v-if="car.availability">
                                        <!-- Booking Form -->
                                        <div class="mt-8">
                                            <h3 class="text-lg font-medium text-gray-900">Book This Car</h3>
                                            <form @submit.prevent="handleBooking" class="mt-4 space-y-4">
                                                <div>
                                                    <label for="start_date"
                                                        class="block text-sm font-medium text-gray-700">Start
                                                        Date</label>
                                                    <input type="date" v-model="startDate" id="start_date" required
                                                        :min="minDate"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                </div>

                                                <div>
                                                    <label for="end_date"
                                                        class="block text-sm font-medium text-gray-700">End
                                                        Date</label>
                                                    <input type="date" v-model="endDate" id="end_date" required
                                                        :min="startDate"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                                </div>

                                                <div v-if="totalCostVisible">
                                                    <p class="text-lg font-medium text-gray-900">Total Cost: <span>{{
                                                        totalCost }}</span></p>
                                                </div>

                                                <div class="flex items-center justify-end">
                                                    <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Book Now
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <p class="text-red-600 font-medium">This car is currently not available for
                                            rent.
                                        </p>
                                    </div>
                                </template>
                                <template v-else>
                                    <p class="text-gray-600">Please
                                        <Link :href="route('login')" class=" text-indigo-600 hover:text-indigo-900">log
                                        in</Link> to
                                        book this
                                        car.
                                    </p>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Similar Cars -->
                    <div v-if="similarCars.length > 0" class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900">Similar Cars</h2>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div v-for="similarCar in similarCars" :key="similarCar.id"
                                class="bg-white overflow-hidden shadow-sm rounded-lg">
                                <div class="relative pb-48">
                                    <img :src="`/storage/${similarCar.image}`" :alt="similarCar.name"
                                        class="absolute h-full w-full object-cover" />
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ similarCar.name }}</h3>
                                    <p class="mt-1 text-gray-600">{{ similarCar.brand }} {{ similarCar.model }}</p>
                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-lg font-bold text-indigo-600">${{
                                            similarCar.daily_rent_price }}/day</span>
                                        <Link :href="`/cars/${similarCar.id}`" class=" inline-flex items-center px-3 py-2 border border-transparent
                                            text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100
                                            hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2
                                            focus:ring-indigo-500">
                                        View Details
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, Head } from '@inertiajs/vue3';
import { ref, computed, watch, onMounted } from 'vue';

const props = defineProps({
    car: Object,
    similarCars: Array,
    canLogin: Boolean,
    canRegister: Boolean
});


// Reactive data for form handling
const startDate = ref('');
const endDate = ref('');
const totalCostVisible = ref(false);
const totalCost = computed(() => {
    if (startDate.value && endDate.value) {
        const start = new Date(startDate.value);
        const end = new Date(endDate.value);
        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
        if (days > 0) {
            return `$${(days * props.car.daily_rent_price).toFixed(2)}`;
        }
    }
    return '';
});

const minDate = computed(() => new Date().toISOString().split('T')[0]);

// Methods for booking form and availability
const handleBooking = () => {
    // Handle booking logic here
    alert('Booking confirmed!');
};

// Watch for date changes to show/hide cost
watch([startDate, endDate], () => {
    totalCostVisible.value = startDate.value && endDate.value;
});
</script>

<style scoped>
/* Add your custom styles here */
</style>
