<script setup>
import { Carousel, Slide } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import axios from 'axios';
import { ref, onMounted } from 'vue';

const carouselImages = ref([]);

const fetchCarouselImages = async () => {
    try {
        const res = await axios.get('/api/carousels');
        carouselImages.value = res.data;
    } catch (error) {
        console.error('Error loading carousel images:', error);
    }
};

onMounted(fetchCarouselImages);
</script>

<template>
    <div class="mb-10 mx-auto max-w-2xl p-4 bg-white rounded-lg shadow-md">
        <Carousel :autoplay="true" :loop="true" class="flower-carousel mx-auto max-w-lg">
            <Slide v-for="(image, index) in carouselImages" :key="index">
            <img
            :src="`/storage/${image.image_path}`"
            :alt="image.alt || 'Carousel Image'"
            class="carousel-image w-full h-60 object-cover rounded-lg"
            />
            </Slide>
        </Carousel>
    </div>
</template>

<style scoped>
.flower-carousel {
    max-width: 100%;
}

.carousel-image {
    max-height: 400px;
    object-fit: cover;
}
</style>
