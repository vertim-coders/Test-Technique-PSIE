<script setup>
import { RouterView } from "vue-router";
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow">
      <div
        class="container mx-auto px-4 py-4 flex justify-between items-center"
      >
        <div class="text-lg font-bold">Vertim Coders</div>
        <ul class="flex space-x-6">
          <li>
            <router-link to="/" class="text-gray-700 hover:text-blue-500"
              >Accueil</router-link
            >
          </li>
          <li>
            <router-link to="/events" class="text-gray-700 hover:text-blue-500"
              >Evenements</router-link
            >
          </li>
          <li>
            <router-link
              to="/reservations"
              class="text-gray-700 hover:text-blue-500"
              >Reservations</router-link
            >
          </li>
        </ul>
      </div>
    </nav>
    <main class="container mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold text-gray-800">
        Event Booking App – Test Technique PSIE
      </h1>
      <RouterView />
    </main>
  </div>
</template>
