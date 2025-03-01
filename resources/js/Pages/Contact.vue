<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
});

const form = ref({
    name: '',
    email: '',
    subject: '',
    message: ''
});

const loading = ref(false);
const success = ref(false);
const error = ref('');

const contactInfo = [
    {
        title: 'Email',
        value: 'support@carental.com',
        icon: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'
    },
    {
        title: 'Phone',
        value: '+1 (555) 123-4567',
        icon: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'
    },
    {
        title: 'Location',
        value: '123 Rental Street, City, Country',
        icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'
    }
];

const submitForm = async () => {
    loading.value = true;
    error.value = '';
    success.value = false;

    try {
        // Here you would typically make an API call to your backend
        // For now, we'll simulate a successful submission
        await new Promise(resolve => setTimeout(resolve, 1000));
        success.value = true;
        form.value = { name: '', email: '', subject: '', message: '' };
    } catch (e) {
        error.value = 'Something went wrong. Please try again.';
    } finally {
        loading.value = false;
    }
};
</script>

<template>

    <Head title="Contact Us" />

    <MainLayout>
        <!-- Hero Section -->
        <div class="relative bg-[#EAF9E7] py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-[#013237] sm:text-5xl md:text-6xl">
                        Get in Touch
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-gray-600 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Have questions about our services? We're here to help you 24/7.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-2xl font-bold text-[#013237] mb-8">Contact Information</h2>
                        <div class="space-y-6">
                            <div v-for="info in contactInfo" :key="info.title"
                                class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-[#4CA771] flex items-center justify-center">
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path :d="info.icon" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-[#013237]">{{ info.title }}</h3>
                                    <p class="mt-1 text-gray-600">{{ info.value }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Links -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-[#013237] mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-[#4CA771]">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-[#4CA771]">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-[#4CA771]">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div>
                        <h2 class="text-2xl font-bold text-[#013237] mb-8">Send us a Message</h2>
                        <form @submit.prevent="submitForm" class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" id="name" v-model="form.name" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]" />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" v-model="form.email" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]" />
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <input type="text" id="subject" v-model="form.subject" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]" />
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea id="message" v-model="form.message" rows="4" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA771] focus:ring-[#4CA771]"></textarea>
                            </div>

                            <div>
                                <button type="submit" :disabled="loading"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA771] hover:bg-[#013237] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA771] disabled:opacity-50">
                                    {{ loading ? 'Sending...' : 'Send Message' }}
                                </button>
                            </div>

                            <!-- Success/Error Messages -->
                            <div v-if="success" class="rounded-md bg-green-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">
                                            Message sent successfully! We'll get back to you soon.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div v-if="error" class="rounded-md bg-red-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">{{ error }}</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl font-bold text-[#013237]">Visit Our Office</h2>
                    <p class="mt-4 text-gray-600">Find us at our convenient location in the heart of the city.</p>
                </div>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937595!2d2.292292615509614!3d48.85837007928757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sEiffel%20Tower!5e0!3m2!1sen!2sfr!4v1645543463429!5m2!1sen!2sfr"
                        class="w-full h-[400px] rounded-lg" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
