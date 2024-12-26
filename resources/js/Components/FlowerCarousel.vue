<script setup>
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css'; // Ensure the carousel's CSS is imported


const flowerImages = [
    { src: 'storage/images/flower1.jpg', alt: 'Beautiful Pink Flower' },
    { src: 'storage/images/flower2.jpg', alt: 'Blooming White Flower' },
    { src: 'storage/images/flower3.jpg', alt: 'Vibrant Red Flower' },
    // Add more images as needed
];

</script>

<template>
    <div class="mb-10 mx-auto max-w-2xl p-4 bg-white rounded-lg shadow-md">
        <Carousel :autoplay="true" :loop="true" class="flower-carousel mx-auto max-w-lg">
            <Slide v-for="(flower, index) in flowerImages" :key="index">
                <img :src="flower.src" :alt="flower.alt" class="carousel-image w-full h-60 object-cover rounded-lg" />
            </Slide>
        </Carousel>
    </div>
</template>

<style scoped>
.carousel-image {
    object-fit: cover;
}
</style>

<style scoped>
.flower-carousel {
    max-width: 100%;
}

.carousel-image {
    max-height: 400px; /* Adjust as needed */
    object-fit: cover;
}
</style>
