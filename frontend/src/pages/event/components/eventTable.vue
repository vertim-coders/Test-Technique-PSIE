<script setup lang="ts">
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Pencil, Trash, Plus } from 'lucide-vue-next';
import DeleteEvent from './modal.vue';

interface Event {
  id: number;
  title: string;
  description: string;
  date: string;
  places_total: number;
  places_booked: number;
}

const events = ref<Event[]>([
  {
    id: 1,
    title: "Conférence PHP",
    description: "Tout savoir sur PHP en 2025",
    date: "2025-05-20",
    places_total: 50,
    places_booked: 1,
  },
  {
    id: 2,
    title: "Atelier Vue.js",
    description: "Construire une app dynamique",
    date: "2025-05-21",
    places_total: 30,
    places_booked: 2,
  },
]);

const isDeleteModalOpen = ref(false);
const eventToDelete = ref<Event | null>(null);

const openDeleteModal = (event: Event) => {
  eventToDelete.value = event;
  isDeleteModalOpen.value = true;
};

const deleteEvent = () => {
  if (eventToDelete.value) {
    events.value = events.value.filter(event => event.id !== eventToDelete.value?.id);
  }
  isDeleteModalOpen.value = false;
};

const cancelDelete = () => {
  isDeleteModalOpen.value = false;
};

const createEvent = () => {
  alert("Création d’un nouvel événement");
};

const editEvent = (event: Event) => {
  alert("Édition de l’événement : " + event.title);
};
</script>

<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Liste des Événements</h2>
      <Button @click="createEvent">Ajouter événement <Plus class="ml-2" /></Button>
    </div>

    <div class="overflow-x-auto rounded border border-gray-200 shadow-sm">
      <table class="min-w-full bg-white divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Titre</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Description</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Date</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Places</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          <tr v-for="event in events" :key="event.id">
            <td class="px-4 py-2">{{ event.title }}</td>
            <td class="px-4 py-2">{{ event.description }}</td>
            <td class="px-4 py-2">{{ event.date }}</td>
            <td class="px-4 py-2">{{ event.places_booked }} / {{ event.places_total }}</td>
            <td class="px-4 py-2 flex gap-2">
              <button @click="editEvent(event)" class="text-blue-600 hover:underline">
                <Pencil class="h-4 w-4" />
              </button>
              <button @click="openDeleteModal(event)" class="text-red-600 hover:underline">
                <Trash class="h-4 w-4" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <DeleteEvent
  v-model:isOpen="isDeleteModalOpen"
  :event="eventToDelete"
  @delete="deleteEvent"
  @cancel="cancelDelete"
/>

  </div>
</template>
