<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const isActive = (routePrefix) => {
    return window.location.pathname.startsWith(routePrefix);
};

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div
        class="min-h-screen bg-gradient-to-r from-[#A0E4D0] via-[#A0E4D0] to-[#f1f7f5] dark:from-[#1f2a27] dark:via-[#1f2a27] dark:to-[#2d3c34]">
        <nav class="border-b border-border-light bg-white dark:border-gray-700 dark:bg-[#1f2a27] shadow-lg">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <Link :href="route('dashboard')">
                        <ApplicationLogo class="h-9 w-auto text-primary" />
                        </Link>
                        <!-- Navigation Links -->
                        <div class="hidden sm:flex space-x-8 ml-10">
                            <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                            <NavLink :href="route('admin.customers.index')" :active="isActive('/admin/customers')">
                                Customers
                            </NavLink>
                            <NavLink :href="route('admin.cars.index')" :active="isActive('/admin/cars')">
                                Cars
                            </NavLink>
                            <NavLink :href="route('admin.rentals.index')" :active="isActive('/admin/rentals')">
                                Rentals
                            </NavLink>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center text-gray-700 dark:text-gray-200 hover:text-primary focus:outline-none"
                                    aria-label="User settings">
                                    {{ $page.props.auth.user.name }}
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="p-2 rounded-md focus:outline-none text-gray-700 dark:text-gray-200 hover:text-primary">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path
                                    :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path
                                    :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden bg-white dark:bg-[#1f2a27]">
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.customers.index')" :active="isActive('/admin/customers')">
                        Customers
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.cars.index')" :active="isActive('/admin/cars')">
                        Cars
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('admin.rentals.index')" :active="isActive('/admin/rentals')">
                        Rentals
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-gradient-to-r from-[#A0E4D0] to-[#86c6a1] text-white shadow-lg" v-if="$slots.header">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 bg-white dark:bg-[#2d3c34] text-[#2d3c34] dark:text-[#e0f7f2]">
            <slot />
        </main>
    </div>
</template>
