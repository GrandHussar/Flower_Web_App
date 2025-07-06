<template>
  <nav class="bg-pink-100 border-b-4 border-pink-300 shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-3 px-5">
      
      <!-- Logo -->
      <div class="flex items-center">
        <span class="text-pink-600 font-bold text-xl">RRM Flowershop</span>
      </div>

      <!-- Search Bar -->
      <div class="flex-1 mx-10">
        <input
          type="text"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          placeholder="Search flowers..."
          class="w-full px-4 py-2 rounded-lg border-2 border-pink-300 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-200"
        />
      </div>

      <!-- Social Icons -->
      <div class="flex items-center space-x-4">
        <!-- WhatsApp -->
        <a
          href="https://api.whatsapp.com/send/?phone=639615291842&text&type=phone_number&app_absent=0"
          target="_blank"
          class="text-green-600 hover:text-green-800 text-xl"
          title="Chat on WhatsApp"
        >
          <i class="fab fa-whatsapp"></i>
        </a>

        <!-- Instagram -->
        <a
          href="https://www.instagram.com/rrmflowershop/"
          target="_blank"
          class="text-pink-500 hover:text-pink-700 text-xl"
          title="View on Instagram"
        >
          <i class="fab fa-instagram"></i>
        </a>

        <!-- Facebook -->
        <a
          href="https://facebook.com/raintraje88"
          target="_blank"
          class="text-blue-600 hover:text-blue-800 text-xl"
          title="Order on Facebook"
        >
          <i class="fab fa-facebook"></i>
        </a>
      </div>
    </div>
  </nav>
</template>

<script setup>
defineProps(['modelValue']);
</script>
