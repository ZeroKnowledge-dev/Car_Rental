<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

const showMobileMenu = ref(false);
const user = usePage().props.auth?.user;

</script>

<template>
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <Link :href="route('welcome')" class="text-2xl font-bold text-[#4CA771]">
                        CarRental
                        </Link>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <Link :href="route('welcome')" class="inline-flex items-center px-1 pt-1 border-b-2"
                            :class="route().current('welcome') ? 'border-[#4CA771] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                        Home
                        </Link>
                        <Link :href="route('cars')" class="inline-flex items-center px-1 pt-1 border-b-2"
                            :class="route().current('cars') ? 'border-[#4CA771] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                        Cars
                        </Link>
                        <Link :href="route('about')" class="inline-flex items-center px-1 pt-1 border-b-2"
                            :class="route().current('about') ? 'border-[#4CA771] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                        About
                        </Link>
                        <Link :href="route('contact')" class="inline-flex items-center px-1 pt-1 border-b-2"
                            :class="route().current('contact') ? 'border-[#4CA771] text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
                        Contact
                        </Link>
                    </div>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div v-if="user">
                        <div v-if="user.role === 'customer'" class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <Link :href="route('customerDashboard')"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Dashboard
                                </Link>
                                <Link :href="route('logout')" method="post" as="button"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Logout
                                </Link>
                            </div>
                        </div>
                        <div v-else class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <Link :href="route('dashboard')"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Dashboard
                                </Link>
                                <Link :href="route('admin.customers.index')"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Customers
                                </Link>
                                <Link :href="route('admin.cars.index')"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Cars
                                </Link>
                                <Link :href="route('admin.rentals.index')"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Rentals
                                </Link>
                                <Link :href="route('logout')" method="post" as="button"
                                    class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                                Logout
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div v-else class="flex items-center space-x-4">
                        <Link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-[#4CA771]">
                        Login
                        </Link>
                        <Link :href="route('register')"
                            class="ml-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA771] hover:bg-[#013237]">
                        Register
                        </Link>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button @click="showMobileMenu = !showMobileMenu"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#4CA771]">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path v-if="showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-show="showMobileMenu" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <Link :href="route('welcome')" class="block pl-3 pr-4 py-2 border-l-4"
                    :class="route().current('welcome') ? 'border-[#4CA771] bg-[#EAF9E7] text-[#4CA771]' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'">
                Home
                </Link>
                <Link :href="route('cars')" class="block pl-3 pr-4 py-2 border-l-4"
                    :class="route().current('cars') ? 'border-[#4CA771] bg-[#EAF9E7] text-[#4CA771]' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'">
                Cars
                </Link>
                <Link :href="route('about')" class="block pl-3 pr-4 py-2 border-l-4"
                    :class="route().current('about') ? 'border-[#4CA771] bg-[#EAF9E7] text-[#4CA771]' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'">
                About
                </Link>
                <Link :href="route('contact')" class="block pl-3 pr-4 py-2 border-l-4"
                    :class="route().current('contact') ? 'border-[#4CA771] bg-[#EAF9E7] text-[#4CA771]' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800'">
                Contact
                </Link>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div v-if="user" class="space-y-1">
                    <Link :href="route('customerDashboard')"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Dashboard
                    </Link>
                    <Link :href="route('logout')" method="post" as="button"
                        class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Logout
                    </Link>
                </div>
                <div v-else class="space-y-1">
                    <Link v-if="canLogin" :href="route('login')"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Login
                    </Link>
                    <Link v-if="canRegister" :href="route('register')"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800">
                    Register
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped></style>
