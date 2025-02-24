<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});
</script>

<template>

    <Head title="Contact" />
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


    <main class="mt-6">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Heading Section -->
                        <div class="lg:text-center mb-12">
                            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Get in Touch
                            </h2>
                            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                We'd Love to Hear From You
                            </p>
                            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                                Have questions about our services? Fill out the form below and we'll get back to you as
                                soon as possible.
                            </p>
                        </div>

                        <!-- Contact Form Section -->
                        <div class="mt-10 max-w-xl mx-auto">
                            <form class="grid grid-cols-1 gap-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <div class="mt-1">
                                        <input type="text" id="name" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1">
                                        <input type="email" id="email" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                                    </div>
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                    <div class="mt-1">
                                        <textarea id="message" rows="4" required
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit"
                                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="mt-16 lg:text-center">
                            <h3 class="text-lg font-medium text-gray-900">Other Ways to Reach Us</h3>
                            <dl class="mt-8 text-base text-gray-500 grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <div class="flex flex-col items-center">
                                    <dt class="font-medium text-gray-900">Email</dt>
                                    <dd>support@carental.com</dd>
                                </div>
                                <div class="flex flex-col items-center">
                                    <dt class="font-medium text-gray-900">Phone</dt>
                                    <dd>+1 (555) 123-4567</dd>
                                </div>
                                <div class="flex flex-col items-center">
                                    <dt class="font-medium text-gray-900">Address</dt>
                                    <dd>123 Rental Street, City, Country</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
