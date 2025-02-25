<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const sidebarOpen = ref(false);

const navigation = [
    { name: 'Dashboard', href: route('dashboard'), icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
    { name: 'Cars', href: route('admin.cars.index'), icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z' },
    { name: 'Customers', href: route('admin.customers.index'), icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z' },
    { name: 'Rentals', href: route('admin.rentals.index'), icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2' },
];

const userNavigation = [
    { name: 'Sign out', href: route('logout'), method: 'post' }
];
</script>

<template>
    <div>
        <!-- Off-canvas menu for mobile -->
        <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">
            <div v-show="sidebarOpen" class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>

            <div v-show="sidebarOpen" class="fixed inset-0 z-40 flex">
                <div class="relative flex w-full max-w-xs flex-1 flex-col bg-[#013237] pt-5 pb-4">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="sidebarOpen = false"
                            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex flex-shrink-0 items-center px-4">
                        <h1 class="text-2xl font-bold text-white">Car Rental</h1>
                    </div>
                    <div class="mt-5 h-0 flex-1 overflow-y-auto">
                        <nav class="space-y-1 px-2">
                            <Link v-for="item in navigation" :key="item.name" :href="item.href"
                                :class="[$page.url.startsWith(item.href) ? 'bg-[#4CA771] text-white' : 'text-gray-300 hover:bg-[#4CA771] hover:text-white', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                            <svg class="mr-4 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                            </svg>
                            {{ item.name }}
                            </Link>
                        </nav>
                    </div>
                </div>

                <div class="w-14 flex-shrink-0" aria-hidden="true">
                    <!-- Dummy element to force sidebar to shrink to fit close icon -->
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <!-- Sidebar component -->
            <div class="flex flex-grow flex-col overflow-y-auto bg-[#013237] pt-5">
                <div class="flex flex-shrink-0 items-center px-4">
                    <h1 class="text-2xl font-bold text-white">Car Rental</h1>
                </div>
                <div class="mt-5 flex flex-1 flex-col">
                    <nav class="flex-1 space-y-1 px-2 pb-4">
                        <Link v-for="item in navigation" :key="item.name" :href="item.href"
                            :class="[$page.url.startsWith(item.href) ? 'bg-[#4CA771] text-white' : 'text-gray-300 hover:bg-[#4CA771] hover:text-white', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
                        <svg class="mr-3 h-6 w-6 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="item.icon" />
                        </svg>
                        {{ item.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col md:pl-64">
            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
                <button type="button" @click="sidebarOpen = true"
                    class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#4CA771] md:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <div class="flex flex-1 justify-end px-4">
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button type="button"
                                    class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[#4CA771] focus:ring-offset-2"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div
                                        class="h-8 w-8 rounded-full bg-[#4CA771] flex items-center justify-center text-white font-semibold">
                                        {{ $page.props.auth.user.name.charAt(0) }}
                                    </div>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div v-show="false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <Link v-for="item in userNavigation" :key="item.name" :href="item.href"
                                    :method="item.method"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1">
                                {{ item.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <div class="py-6">
                    <slot></slot>
                </div>
            </main>
        </div>
    </div>
</template>
