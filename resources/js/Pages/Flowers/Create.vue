<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const name = ref('');
const category = ref('');
const price = ref('');
const rating = ref('');
const image_path = ref('');
const description = ref('');

const submit = () => {
    router.post('/flowers', {
        name: name.value,
        category: category.value,
        price: price.value,
        rating: rating.value,
        image_path: image_path.value,
        description: description.value,
    });
};
</script>

<template>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Add New Flower</h1>
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label>Name</label>
                <input v-model="name" class="input" type="text" required />
            </div>
            <div class="mb-3">
                <label>Category</label>
                <input v-model="category" class="input" type="text" required />
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input v-model="price" class="input" type="number" required />
            </div>
            <div class="mb-3">
                <label>Rating</label>
                <input v-model="rating" class="input" type="number" min="1" max="5" required />
            </div>
            <div class="mb-3">
                <label>Image Path</label>
                <input v-model="image_path" class="input" type="text" />
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea v-model="description" class="input"></textarea>
            </div>
            <button type="submit" class="btn btn-pink">Create</button>
        </form>
    </div>
</template>

<style scoped>
.input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.btn-pink {
    background-color: #f06292;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 4px;
}
</style>
