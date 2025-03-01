<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <!-- Footer -->
    <footer class="bg-[#013237] text-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">CarRental</h3>
                    <p class="text-gray-300">
                        Your trusted partner for car rentals. Quality vehicles at affordable prices.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <Link :href="route('welcome')" class="text-gray-300 hover:text-white">Home</Link>
                        </li>
                        <li>
                            <Link :href="route('cars')" class="text-gray-300 hover:text-white">Cars</Link>
                        </li>
                        <li>
                            <Link :href="route('about')" class="text-gray-300 hover:text-white">About Us</Link>
                        </li>
                        <li>
                            <Link :href="route('contact')" class="text-gray-300 hover:text-white">Contact Us</Link>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <address class="not-italic text-gray-300">
                        123 Car Street<br>
                        Automobile City, AC 12345<br>
                        info@carrental.com<br>
                        (123) 456-7890
                    </address>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-300">© {{ new Date().getFullYear() }} CarRental. All rights reserved.</p>
            </div>
        </div>
    </footer>
</template>

<style scoped></style>
