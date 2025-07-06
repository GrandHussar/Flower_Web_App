<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const carousels = ref([]);
const image = ref(null);
const alt = ref('');

const fetchCarousels = async () => {
    try {
        const response = await axios.get('/api/carousels');
        carousels.value = response.data;
    } catch (err) {
        console.error('Failed to fetch carousel data', err);
    }
};

const handleAdd = async () => {
    const { value: formValues } = await Swal.fire({
        title: 'Add Carousel Image',
        html: `
            <input type="file" id="carousel-image" class="swal2-file" accept="image/*">
            <input type="text" id="carousel-alt" class="swal2-input" placeholder="Alt text (optional)">
        `,
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            const file = document.getElementById('carousel-image').files[0];
            const altText = document.getElementById('carousel-alt').value;
            if (!file) {
                Swal.showValidationMessage('Please choose an image.');
            }
            return { file, alt: altText };
        },
    });

    if (formValues?.file) {
        const formData = new FormData();
        formData.append('image', formValues.file);
        formData.append('alt', formValues.alt);

        try {
            await axios.post('/carousel', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });
            Swal.fire('Success', 'Carousel image added', 'success');
            fetchCarousels();
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Upload failed', 'error');
        }
    }
};

const handleDelete = async (id) => {
    const confirm = await Swal.fire({
        title: 'Delete this image?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
    });

    if (confirm.isConfirmed) {
        try {
            await axios.delete(`/carousel/${id}`);
            Swal.fire('Deleted!', 'Carousel image removed.', 'success');
            fetchCarousels();
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'Failed to delete image.', 'error');
        }
    }
};

onMounted(() => fetchCarousels());
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Carousel Management" />

    <div class="max-w-7xl mx-auto p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-pink-600">Carousel Management</h1>
        <button
          class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
          @click="handleAdd"
        >
          + Add Image
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div
          v-for="item in carousels"
          :key="item.id"
          class="bg-white shadow-md rounded p-2 relative"
        >
          <img
            :src="`/storage/${item.image_path}`"
            :alt="item.alt"
            class="w-full h-48 object-cover rounded"
          />
          <p class="text-sm mt-2 text-gray-600">{{ item.alt }}</p>
          <button
            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-1 rounded"
            @click="handleDelete(item.id)"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>