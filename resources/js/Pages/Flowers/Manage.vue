<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { route } from 'ziggy-js'; // ✅ required to use `route()`
import { Ziggy } from '@/ziggy';   // ✅ required context (if necessary)
defineProps({ flowers: Array });

const deleteFlower = (id) => {
    if (confirm('Are you sure you want to delete this flower?')) {
        router.delete(route('flowers.destroy', id));
    }
};
</script>

<template>
    <Head title="Manage Flowers" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Manage Flowers</h2>
        </template>

        <div class="p-6 bg-white shadow-sm">
            <table class="w-full table-auto border">
                <Link :href="route('flowers.create')" class="btn btn-pink mb-4">Add Flower</Link>

                <thead>
                    <tr>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Category</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Rating</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="flower in flowers" :key="flower.id">
                        <td class="border px-4 py-2">{{ flower.name }}</td>
                        <td class="border px-4 py-2">{{ flower.category }}</td>
                        <td class="border px-4 py-2">{{ flower.price }}</td>
                        <td class="border px-4 py-2">{{ flower.rating }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <Link :href="route('flowers.edit', flower.id)" class="text-blue-500">Edit</Link>
                            <button @click="deleteFlower(flower.id)" class="text-red-500">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
