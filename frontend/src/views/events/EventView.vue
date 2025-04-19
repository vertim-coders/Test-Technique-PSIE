<template>
  <div>
    <div class="flex justify-between items-center mt-4">
      <p class="text-gray-600">Liste des Evenements !</p>
      <button
        @click="$router.push('/events/add')"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Ajouter un événement
      </button>
    </div>
    <table class="table-auto w-full mt-6 bg-white shadow-md rounded-lg">
      <thead>
        <tr class="bg-gray-200 text-gray-700">
          <th class="px-4 py-2">N°</th>
          <th class="px-4 py-2">Titre</th>
          <th class="px-4 py-2">Lieu</th>
          <th class="px-4 py-2">Description</th>
          <th class="px-4 py-2">Date</th>
          <th class="px-4 py-2">Places totales</th>
          <th class="px-4 py-2">Places réservées</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(event, index) in eventsStore.events"
          :key="event.id"
          class="border-t"
        >
          <td class="px-4 py-2 text-center">{{ index + 1 }}</td>
          <td class="px-4 py-2 text-center">{{ event.title }}</td>
          <td class="px-4 py-2 text-center">{{ event.location }}</td>
          <td class="px-4 py-2 text-center">{{ event.description }}</td>
          <td class="px-4 py-2 text-center">{{ event.date }}</td>
          <td class="px-4 py-2 text-center">{{ event.places_total }}</td>
          <td class="px-4 py-2 text-center">{{ event.places_booked }}</td>
          <td class="px-4 py-2 text-center">
            <button
              @click="$router.push(`/events/${event.id}`)"
              class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"
            >
              Réserver
            </button>
            <button
              @click="$router.push(`/events/edit/${event.id}`)"
              class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 ml-2"
            >
              Modifier
            </button>
            <button
              @click="eventsStore.deleteEvent(event.id)"
              class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 ml-2"
            >
              Supprimer
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { useEventsStore } from "@/stores/modules/events/event";
import { ref, computed, onMounted } from "vue";

const eventsStore = useEventsStore();

onMounted(() => {
  eventsStore.getEvents();
});
</script>

<style scoped></style>
