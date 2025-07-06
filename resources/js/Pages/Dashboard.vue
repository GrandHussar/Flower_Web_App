<script setup>
import { ref, reactive, onMounted, computed, nextTick, watch } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const flowers = ref([]);
const loading = ref(false);
const currentPage = ref(1);
const lastPage = ref(1);
const selectedCategory = ref('ALL');
const categories = ['ALL', 'BOUQUET', 'INAUGURAL', 'FRUITS AND FLOWERS', 'MONEY BOQUET', 'FLOWERS AND GIFTS','FUNERAL'];

const form = reactive({
    id: null,
    name: '',
    category: '',
    price: '',
    rating: '',
    image_path: '',
    description: '',
});

const resetForm = () => {
    form.id = null;
    form.name = '';
    form.category = '';
    form.price = '';
    form.rating = '';
    form.image_path = '';
    form.description = '';
};

const fetchFlowers = async (page = 1) => {
    try {
        loading.value = true;
        const res = await axios.get('/api/flowers', {
            params: {
                category: selectedCategory.value !== 'ALL' ? selectedCategory.value : undefined,
                page: page
            }
        });
        flowers.value = res.data.data;
        currentPage.value = res.data.current_page;
        lastPage.value = res.data.last_page;
    } catch (err) {
        console.error(err);
    } finally {
        loading.value = false;
    }
};

const selectCategory = (category) => {
    selectedCategory.value = category;
    fetchFlowers(1);
};

const goToPage = (page) => {
    fetchFlowers(page);
};

watch([selectedCategory, currentPage], () => {
    fetchFlowers(currentPage.value);
});

const handleCreate = async () => {
    await nextTick();
    const categoryOptions = categories.filter(cat => cat !== 'ALL').map(cat => `<option value="${cat}">${cat}</option>`).join('');
    const { value: confirmed } = await Swal.fire({
        title: 'Add New Flower',
        html: `
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <input id="swal-name" class="swal2-input" placeholder="Name">
                <select id="swal-category" class="swal2-input">
                    ${categoryOptions}
                </select>
                <input id="swal-price" class="swal2-input" placeholder="Price" type="number">
                <input id="swal-rating" class="swal2-input" placeholder="Rating (1-5)" type="number">
                <input id="swal-image" class="swal2-file" type="file">
                <textarea id="swal-description" class="swal2-textarea" placeholder="Description"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Create',
        preConfirm: () => {
            const imageFile = document.getElementById('swal-image').files[0];
            const formData = new FormData();
            formData.append('name', document.getElementById('swal-name').value);
            formData.append('category', document.getElementById('swal-category').value);
            formData.append('price', document.getElementById('swal-price').value);
            formData.append('rating', document.getElementById('swal-rating').value);
            formData.append('description', document.getElementById('swal-description').value);
            if (imageFile) formData.append('image_path', imageFile);
            return formData;
        },
        didOpen: () => {
            document.querySelector('.swal2-container').addEventListener('keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });
        }
    });

    if (confirmed instanceof FormData) {
        try {
            await axios.post('/flowers', confirmed, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            await fetchFlowers(currentPage.value);
            Swal.fire('Success', 'Flower added!', 'success');
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Failed to add flower.', 'error');
        }
    }
};

const handleEdit = async (flower) => {
    await nextTick();
    const categoryOptions = categories.filter(cat => cat !== 'ALL').map(cat => `<option value="${cat}" ${flower.category === cat ? 'selected' : ''}>${cat}</option>`).join('');
    const { value: confirmed } = await Swal.fire({
        title: 'Edit Flower',
        html: `
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <input id="swal-name" class="swal2-input" placeholder="Name" value="${flower.name}">
                <select id="swal-category" class="swal2-input">
                    ${categoryOptions}
                </select>
                <input id="swal-price" class="swal2-input" placeholder="Price" type="number" value="${flower.price}">
                <input id="swal-rating" class="swal2-input" placeholder="Rating (1-5)" type="number" value="${flower.rating}">
                <input id="swal-image" class="swal2-file" type="file">
                <textarea id="swal-description" class="swal2-textarea" placeholder="Description">${flower.description}</textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        preConfirm: () => {
            const imageFile = document.getElementById('swal-image').files[0];
            const formData = new FormData();
            formData.append('name', document.getElementById('swal-name').value);
            formData.append('category', document.getElementById('swal-category').value);
            formData.append('price', document.getElementById('swal-price').value);
            formData.append('rating', document.getElementById('swal-rating').value);
            formData.append('description', document.getElementById('swal-description').value);
            if (imageFile) formData.append('image_path', imageFile);
            formData.append('_method', 'PUT');
            return formData;
        }
    });

    if (confirmed instanceof FormData) {
        try {
            await axios.post(`/flowers/${flower.id}`, confirmed, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            await fetchFlowers(currentPage.value);
            Swal.fire('Updated!', 'Flower updated successfully.', 'success');
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Failed to update flower.', 'error');
        }
    }
};

const handleDelete = async (flowerId) => {
    const confirm = await Swal.fire({
        title: 'Are you sure?',
        text: 'This will delete the flower permanently!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
    });

    if (confirm.isConfirmed) {
        await axios.delete(`/flowers/${flowerId}`);
        await fetchFlowers(currentPage.value);
        Swal.fire('Deleted!', 'Flower removed.', 'success');
    }
};

onMounted(() => fetchFlowers());
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="max-w-7xl mx-auto p-4">
            <h1 class="text-2xl font-bold text-pink-600 mb-4">Flower Management</h1>

            <div class="flex flex-wrap gap-2 mb-4">
                <button
                    v-for="category in categories"
                    :key="category"
                    :class="[
                        'px-3 py-1 rounded-full border font-bold',
                        selectedCategory === category ? 'bg-pink-600 text-white' : 'bg-white text-pink-600 border-pink-600'
                    ]"
                    @click="selectCategory(category)"
                >
                    {{ category }}
                </button>

                <button @click="handleCreate" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                    + Add Flower
                </button>
            </div>

            <div v-if="loading" class="text-gray-500">Loading...</div>

            <table class="w-full text-left border">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="p-2">Name</th>
                        <th class="p-2">Category</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Rating</th>
                        <th class="p-2">Image</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="flower in flowers" :key="flower.id" class="border-t">
                        <td class="p-2">{{ flower.name }}</td>
                        <td class="p-2">{{ flower.category }}</td>
                        <td class="p-2">₱{{ flower.price }}</td>
                        <td class="p-2">{{ flower.rating }}/5</td>
                        <td class="p-2">
                            <img :src="`/${flower.image_path}`" alt="Flower" class="w-16 h-16 object-cover" />
                        </td>
                        <td class="p-2 space-x-2">
                            <button @click="handleEdit(flower)" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                            <button @click="handleDelete(flower.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-center mt-4 space-x-2">
                <button
                    v-for="page in lastPage"
                    :key="page"
                    :class="[
                        'px-4 py-2 rounded-full border',
                        currentPage === page ? 'bg-pink-600 text-white' : 'bg-white text-pink-600 border-pink-600'
                    ]"
                    @click="goToPage(page)"
                >
                    {{ page }}
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
