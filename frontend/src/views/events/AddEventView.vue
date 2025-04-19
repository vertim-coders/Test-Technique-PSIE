<template>
  <div>
    <div class="flex justify-between items-center mt-4">
      <p class="text-gray-600">Enregistrer un évènement !</p>
      <button
        @click="$router.push('/events')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Retour à la liste des évènements
      </button>
    </div>
    <form @submit.prevent="addEvent" class="mt-4">
      <div class="mb-4">
        <label for="title" class="block text-gray-700">Titre</label>
        <input
          type="text"
          id="title"
          v-model="event.title"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
          required
        />
      </div>
      <div class="mb-4">
        <label for="location" class="block text-gray-700">Lieu de l'évènement</label>
        <input
          type="text"
          id="location"
          v-model="event.location"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
          required
        />
      </div>
      <div class="mb-4">
        <label for="description" class="block text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="event.description"
          rows="4"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
          required
        ></textarea>
      </div>
      <div class="mb-4">
        <label for="date" class="block text-gray-700">Date</label>
        <input
          type="date"
          id="date"
          v-model="event.date"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
          required
        />
      </div>
      <div class="mb-4">
        <label for="places_total" class="block text-gray-700"
          >Places totales</label
        >
        <input
          type="number"
          id="places_total"
          v-model.number="event.places_total"
          class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:ring-blue-500"
          required
        />
      </div>
      <button
        type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Enregistrer l'évènement
      </button>
    </form>
  </div>
</template>

<script setup>
import { useEventsStore } from "@/stores/modules/events/event";
import { ref } from "vue";
import { useRouter } from "vue-router";

const eventsStore = useEventsStore();
const router = useRouter();
const event = ref({
  title: "",
  description: "",
  date: "",
  location: "",
  places_total: 1,
});

const addEvent = async () => {
  try {
    await eventsStore.saveEvent(event.value);
  } catch (err) {
    console.error("Erreur lors de l'ajout :", err);
  }
};
</script>

<style scoped></style>
