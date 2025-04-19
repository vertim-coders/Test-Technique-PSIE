<template>
  <div>
    <div class="flex justify-between items-center mt-4">
      <p class="text-gray-600">Modifier un évènement !</p>
      <button
        @click="$router.push('/events')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Retour à la liste des évènements
      </button>
    </div>
    <form @submit.prevent="updateEvent" class="mt-4">
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
        <label for="location" class="block text-gray-700"
          >Lieu de l'évènement</label
        >
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
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const eventsStore = useEventsStore();
const route = useRoute();
const event = ref({
  title: "",
  description: "",
  date: "",
  location: "",
  places_total: 1,
});

const fetchEvent = async () => {
  try {
    const eventId = route.params.id;
    const res = await eventsStore.getEventById(eventId);
    if (res) {
      event.value.title = res.title;
      event.value.description = res.description;
      event.value.date = res.date;
      event.value.location = res.location;
      event.value.places_total = res.places_total;
    }
  } catch (err) {
    console.error("Erreur lors de la récupération de l'évènement :", err);
  }
};

const updateEvent = async () => {
  try {
    await eventsStore.updateEvent(event.value, route.params.id);
  } catch (err) {
    console.error("Erreur lors de la mise à jour :", err);
  }
};

onMounted(() => {
  fetchEvent();
});
</script>

<style scoped></style>
