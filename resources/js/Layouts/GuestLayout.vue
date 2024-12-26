<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import FlowerNavBar from '@/Components/FlowerNavBar.vue'; // Import the navbar
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <!-- Flower-themed Navbar -->
    <FlowerNavBar />
    <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
    <!-- Main Content Section -->

    <main class="flex min-h-screen flex-col bg-gradient-to-br from-pink-100 via-pink-200 to-pink-300 pt-6 sm:justify-center sm:pt-0">
        <slot />
    </main>
</template>
