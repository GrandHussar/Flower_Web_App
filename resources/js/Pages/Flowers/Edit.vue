<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js'; // ✅ required to use `route()`
import { Ziggy } from '@/ziggy';   // ✅ required context (if necessary)

const props = defineProps({ flower: Object });

const form = useForm({
    name: props.flower.name,
    category: props.flower.category,
    price: props.flower.price,
    rating: props.flower.rating,
    image_path: props.flower.image_path,
    description: props.flower.description,
});

const updateFlower = () => {
    form.put(route('flowers.update', props.flower.id));
};
</script>

<template>
    <Head title="Edit Flower" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Edit Flower</h2>
        </template>

        <div class="p-6 bg-white shadow-sm max-w-xl mx-auto">
            <form @submit.prevent="updateFlower">
                <div class="mb-4">
                    <label>Name</label>
                    <input v-model="form.name" class="w-full border p-2" />
                </div>
                <div class="mb-4">
                    <label>Category</label>
                    <input v-model="form.category" class="w-full border p-2" />
                </div>
                <div class="mb-4">
                    <label>Price</label>
                    <input v-model="form.price" type="number" class="w-full border p-2" />
                </div>
                <div class="mb-4">
                    <label>Rating</label>
                    <input v-model="form.rating" type="number" min="1" max="5" class="w-full border p-2" />
                </div>
                <div class="mb-4">
                    <label>Image Path</label>
                    <input v-model="form.image_path" class="w-full border p-2" />
                </div>
                <div class="mb-4">
                    <label>Description</label>
                    <textarea v-model="form.description" class="w-full border p-2"></textarea>
                </div>
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
