<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Pencil, Trash, Plus } from "lucide-vue-next";
import { Button } from '@/components/ui/button';

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
    places_booked: 1
  },
  {
    id: 2,
    title: "Atelier Vue.js",
    description: "Construire une app dynamique",
    date: "2025-05-21",
    places_total: 30,
    places_booked: 2
  }
]);

// Modal ref
const modalRef = ref(null);

const deleteEvent = (id: number) => {
  modalRef.value.openModal(
    "Êtes-vous sûr de vouloir supprimer cet événement ?",
    () => {
      events.value = events.value.filter(event => event.id !== id);
      modalRef.value.closeModal();
    },
    "bg-red-500"
  );
};

const editEvent = (event: Event) => {
  modalRef.value.openModal(
    `Modifier l'événement : ${event.title}`,
    () => {
      alert(`Édition de l'événement: ${event.title}`);
      modalRef.value.closeModal();
    },
    "bg-blue-500"
  );
};

const createEvent = () => {
  modalRef.value.openModal(
    "Créer un nouvel événement",
    () => {
      alert("Création d’un nouvel événement");
      modalRef.value.closeModal();
    },
    "bg-green-500"
  );
};
</script>

<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Liste des Événements</h2>
      <Button @click="createEvent">Ajouter événement <Plus /></Button>
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
              <button @click="deleteEvent(event.id)" class="text-red-600 hover:underline">
                <Trash class="h-4 w-4" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  
  </div>
</template>
