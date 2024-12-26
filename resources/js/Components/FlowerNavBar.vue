<template>
    <nav class="bg-pink-100 border-b-4 border-pink-300 shadow-lg">
      <div class="container mx-auto flex justify-between items-center py-3 px-5">
        
        <!-- Logo or Branding -->
        <div class="flex items-center">
          <span class="text-pink-600 font-bold text-xl">R&RM Flowershop</span>
        </div>
    
        <!-- Search Bar in the Center -->
        <div class="flex-1 mx-10">
          <input
            type="text"
            placeholder="Search flowers..."
            class="w-full px-4 py-2 rounded-lg border-2 border-pink-300 focus:border-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-200"
          />
        </div>
    
        <!-- Order by Facebook Button on the Right -->
        <div>
          <a
            href="https://facebook.com"
            class="bg-pink-500 text-white font-bold py-2 px-4 rounded-lg shadow-lg hover:bg-pink-600"
          >
            ORDER BY FACEBOOK
          </a>
        </div>
      </div>
    </nav>
  </template>
  
  <script setup>
  // No additional logic required for this component yet
  </script>
  