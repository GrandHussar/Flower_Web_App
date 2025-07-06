<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlowerCarousel from '@/Components/FlowerCarousel.vue';
import FlowerCard from '@/Components/FlowerCard.vue';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import FlowerNavbar from '@/Components/FlowerNavbar.vue';

// Define categories
const categories = ['ALL', 'BOUQUET', 'INAUGURAL', 'FRUITS AND FLOWERS', 'MONEY BOQUET', 'FLOWERS AND GIFTS','FUNERAL'];

const searchQuery = ref('');
const selectedCategory = ref('ALL');
const flowers = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);

const showFlowerDetails = (flower) => {
    Swal.fire({
        title: flower.name,
        html: `
            <div style="display: flex; flex-direction: row; gap: 2rem; align-items: center; justify-content: center; flex-wrap: wrap;">
                <img 
                    src="${flower.src}" 
                    alt="${flower.name}" 
                    style="max-width: 300px; max-height: 400px; width: auto; height: auto; border-radius: 8px;" 
                />
                <div style="max-width: 300px; text-align: left;">
                    <p style="color: #555;">${flower.description || 'No description available.'}</p>
                    <p style="font-weight: bold; color: #f06292; margin-top: 1rem;">Price: ₱${flower.price}</p>
                    <div style="color: gold; font-size: 1.2rem; margin-bottom: 1rem;">
                        ${'★'.repeat(flower.rating || 0)}
                    </div>
                    <a 
                        href="https://www.facebook.com/raintraje88" 
                        target="_blank"
                        style="
                            display: inline-block;
                            background-color: #f06292;
                            color: white;
                            padding: 0.5rem 1rem;
                            border-radius: 8px;
                            text-decoration: none;
                            font-weight: bold;
                            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                        "
                    >
                        ORDER BY FACEBOOK
                    </a>
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'Close',
        confirmButtonColor: '#f06292',
        width: 'fit-content',
        padding: '2rem',
    });
};

const filteredFlowers = computed(() => {
  const query = searchQuery.value.toLowerCase();
  return flowers.value.filter(flower =>
    flower.name.toLowerCase().includes(query)
  );
});

const fetchFlowers = async (page = 1) => {
    try {
        const params = {
            page,
            ...(selectedCategory.value !== 'ALL' && { category: selectedCategory.value })
        };
        const response = await axios.get('/api/flowers', { params });
        flowers.value = response.data.data;
        currentPage.value = response.data.current_page;
        lastPage.value = response.data.last_page;
    } catch (error) {
        console.error('Error fetching flowers:', error);
    }
};

onMounted(() => fetchFlowers());

const selectCategory = (category) => {
    selectedCategory.value = category;
    fetchFlowers(1);
};

const goToPage = (page) => {
    currentPage.value = page;
    fetchFlowers(page);
};
</script>

<template>
    <GuestLayout>
        <Head title="RRM Flowershop" />

        <!-- NavBar -->
        <FlowerNavbar v-model="searchQuery" />

        <!-- Page Title -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="text-center w-full max-w-7xl">
                <h1 class="text-4xl font-bold text-pink-600 mb-2">Flowers For All Occasions</h1>
            </div>
        </div>

        <!-- Carousel -->
        <div class="flex justify-center bg-white/70 py-4">
            <div class="w-full max-w-2xl">
                <FlowerCarousel />
            </div>
        </div>

        <!-- Category Buttons -->
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

        <!-- Flower Grid -->
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
                        :description="flower.description"
                        @view-details="showFlowerDetails"
                    />
                </div>
            </div>
        </div>

        <!-- Pagination -->
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
<!-- Contact Section -->
<div class="w-full py-10 bg-gradient-to-br from-pink-200 via-pink-100 to-pink-300 text-left px-6 md:px-20">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-pink-600 mb-4">📞 Contact Us</h2>
    
    <p class="text-sm text-gray-700 mb-1">
      <span class="font-semibold">Contact Number:  </span> 
      <a href="tel:09615291842" class="text-pink-600 hover:underline">09615291842</a>
    </p>
    
    <p class="text-sm text-gray-700 mb-1">
      <span class="font-semibold">Email: </span> 
      <a href="mailto:sales@rrmflowershop.com" class="text-pink-600 hover:underline">sales@rrmflowershop.com</a>
    </p>
    
    <p class="text-sm text-gray-700 mb-1">
      <span class="font-semibold">Address:</span> 
      GF West Tower Tektite, Exchange Road, Ortigas, Pasig City, 1605
    </p>
  </div>
</div>


    </GuestLayout>
</template>

<style scoped>
body {
    background: linear-gradient(135deg, #fbe4f0, #f8d8e6);
}
.btn-pink {
    background-color: #f06292;
    border-color: #f06292;
}
.btn-outline-pink {
    color: #f06292;
    border: 2px solid #f06292;
}
.btn-outline-pink:hover {
    background-color: #f06292;
    color: white;
}
</style>
