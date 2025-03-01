<script setup>
import Footer from '@/Components/Footer.vue';
import NavBar from '@/Components/NavBar.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <NavBar />
        <main class="flex-1">
            <div class="py-6">
                <slot></slot>
            </div>
        </main>
        <Footer />
    </div>
</template>
