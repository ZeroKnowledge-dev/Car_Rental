<script setup>
import Footer from '@/Components/Footer.vue';
import NavBar from '@/Components/NavBar.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <NavBar />

        <!-- Main Content -->
        <main class="flex-grow">
            <slot></slot>
        </main>

        <Footer />
    </div>
</template>
