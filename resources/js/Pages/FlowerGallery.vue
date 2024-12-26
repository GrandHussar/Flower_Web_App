<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlowerCarousel from '@/Components/FlowerCarousel.vue';
import FlowerCard from '@/Components/FlowerCard.vue';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';

// Define categories
const categories = ['ALL', 'FUNERAL', 'BOUQUET', 'INAUGURAL', 'FRUITS AND FLOWERS', 'ARRANGEMENTS', 'FLOWERS FOR ALL SOULS'];

// Track selected category
const selectedCategory = ref('ALL');

// Store flowers data
const flowers = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);

// Fetch flowers data from the API
const fetchFlowers = async (page = 1) => {
    try {
        const response = await axios.get(`/api/flowers?page=${page}`);
        flowers.value = response.data.data;
        lastPage.value = response.data.last_page;
    } catch (error) {
        console.error('Error fetching flowers:', error);
    }
};

// Call fetchFlowers when component mounts
onMounted(() => fetchFlowers());

// Computed property to filter flowers by category
const filteredFlowers = computed(() => {
    return selectedCategory.value === 'ALL'
        ? flowers.value
        : flowers.value.filter(flower => flower.category === selectedCategory.value);
});

// Function to update the selected category and reset to the first page
function selectCategory(category) {
    selectedCategory.value = category;
    fetchFlowers(1); // Reset to first page on category change
}

// Pagination control function
const goToPage = (page) => {
    currentPage.value = page;
    fetchFlowers(page);
};
</script>

<template>
    <GuestLayout>
        <Head title="Flower Gallery" />

        <!-- Page Title and Description -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="text-center w-full max-w-7xl">
                <h1 class="text-4xl font-bold text-pink-600 mb-2">Flowers For All Occasions</h1>
                <p class="text-gray-500 mb-2">Our Categories</p>
            </div>
        </div>

        <!-- Flower Carousel Component -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="w-full max-w-2xl">
                <FlowerCarousel />
            </div>
        </div>

        <!-- Categories Filter Buttons -->
        <div class="flex justify-center bg-white/70 py-2">
            <div class="flex flex-wrap justify-center gap-2 w-full max-w-7xl">
                <button
                    v-for="category in categories"
                    :key="category"
                    :class="[
                        'btn',
                        selectedCategory === category ? 'btn-pink text-white' : 'btn-outline-pink',
                        'rounded-pill px-3 py-2 fw-bold'
                    ]"
                    @click="selectCategory(category)"
                >
                    {{ category }}
                </button>
            </div>
        </div>

        <!-- Flower Grid with Transparent White Background -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="w-full max-w-7xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <FlowerCard
                        v-for="flower in filteredFlowers"
                        :key="flower.id"
                        :src="flower.image_path"
                        :name="flower.name"
                        :price="flower.price"
                        :rating="flower.rating"
                    />
                </div>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="space-x-2">
                <button
                    v-for="page in lastPage"
                    :key="page"
                    :class="{
                        'px-4 py-2 rounded-full border': true,
                        'bg-pink-600 text-white': page === currentPage,
                        'bg-white text-pink-600 border-pink-600': page !== currentPage
                    }"
                    @click="goToPage(page)"
                >
                    {{ page }}
                </button>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
body {
    background: linear-gradient(135deg, #fbe4f0, #f8d8e6); /* Soft gradient background */
}
.btn-pink {
    background-color: #f06292;
    border-color: #f06292;
}
.btn-outline-pink {
    color: #f06292;
    border-color: #f06292;
}
.btn-outline-pink:hover {
    background-color: #f06292;
    color: white;
}
</style>
