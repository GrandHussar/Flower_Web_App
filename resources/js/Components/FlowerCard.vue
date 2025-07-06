<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    src: String,
    name: String,
    price: String,
    rating: Number,
    description: String // optional
});

const emit = defineEmits(['view-details']);

const viewDetails = () => {
    emit('view-details', {
        name: props.name,
        price: props.price,
        rating: props.rating,
        src: props.src,
        description: props.description || ''
    });
};
</script>

<template>
    <div class="flower-card relative bg-white rounded-lg shadow-lg p-4 border border-pink-200 transition-all duration-300 ease-in-out transform hover:scale-105">
        <img :src="src" :alt="name" class="w-full h-60 object-cover rounded-lg mb-4" />
        
        <h2 class="font-semibold text-pink-700 text-lg">{{ name }}</h2>
        
        <div class="flex justify-center text-yellow-500 my-2">
            <span v-for="n in rating" :key="n">★</span>
        </div>
        
        <p class="text-gray-800 font-bold">₱{{ price }}</p>

        <!-- Hover Details -->
        <div class="absolute inset-0 flex flex-col justify-center items-center bg-white bg-opacity-90 rounded-lg opacity-0 hover:opacity-100 transition-opacity duration-300">
            <p class="text-pink-700 font-semibold mb-2">Learn More</p>
            <button @click="viewDetails" class="bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600">View Details</button>
        </div>
    </div>
</template>

<style scoped>
/* Optional custom styles */
</style>
