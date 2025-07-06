<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { route } from 'ziggy-js';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-pink-100 to-white font-sans">
    <!-- Navbar -->
    <nav class="bg-white shadow-md border-b border-pink-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <!-- Logo + Links -->
          <div class="flex items-center space-x-8">
            <Link :href="route('dashboard')" class="flex items-center space-x-2">
              <span class="text-xl font-bold text-pink-600">Flower Admin</span>
            </Link>
            <NavLink
              :href="route('dashboard')"
              :active="route().current('dashboard')"
              class="text-pink-600 hover:text-pink-800 font-semibold"
            >
              Dashboard
            </NavLink>
            <NavLink :href="route('carousel.management')" :active="route().current('carousel.management')">
                Carousel Management
            </NavLink>

          </div>

          <!-- User Dropdown -->
          <div class="flex items-center space-x-4">
            <Dropdown align="right" width="48">
              <template #trigger>
                <!-- ✅ Dropdown trigger fix -->
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="flex items-center px-3 py-2 text-sm font-medium text-pink-600 hover:text-pink-800 bg-pink-100 rounded transition"
                  >
                    {{ $page.props.auth.user.name }}
                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414L10 13.414l-4.707-4.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink :href="route('logout')" method="post" as="button">
                  Log Out
                </DropdownLink>
              </template>
            </Dropdown>

            <!-- Hamburger (mobile) -->
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="sm:hidden text-pink-600 hover:text-pink-800 focus:outline-none"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile nav -->
      <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden px-4">
        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
          Dashboard
        </ResponsiveNavLink>
        <div class="border-t border-pink-200 mt-2 pt-2">
          <p class="text-sm text-pink-600 font-semibold">{{ $page.props.auth.user.name }}</p>
          <p class="text-xs text-gray-500">{{ $page.props.auth.user.email }}</p>
          <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="mt-2">
            Log Out
          </ResponsiveNavLink>
        </div>
      </div>
    </nav>

    <!-- Page Header (if provided) -->
    <header v-if="$slots.header" class="bg-white shadow-sm border-b border-pink-100">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <!-- Main Content -->
    <main class="py-6">
      <slot />
    </main>
  </div>
</template>
