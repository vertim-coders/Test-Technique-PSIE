<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { Pencil, Trash, Clock, Plus } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
interface Reservation {
  id: number;
  event_id: string;
  email: string;
  nom: string;
}

const reservations = ref<Reservation[]>([
  {
    id: 1,
    event_id: 2,
    email: "abokajr@vertimcoders.com",
    nom: "ABOKA JR",
  },
  {
    id: 2,
    event_id: 1,
    email: "abokajr@vertimcoders.com",
    nom: "ABOKA JR",
  },
  {
    id: 3,
    event_id: 1,
    email: "gohou@vertimcoders.com",
    nom: "GOHOU",
  },
]);

/*
onMounted(async () => {
  try {
    const res = await axios.get("http://localhost:8000/reservations")
    events.value = res.data.data
  } catch (err) {
    console.error("Erreur lors de la récupération des événements", err)
  }
})
*/

const deleteReservation = (id: number) => {
  reservations.value = reservations.value.filter((reservation) => reservation.id !== id);
};


const editReservation = (reservation: Reservation) => {
  alert(`Édition de l'événement: ${reservation.title}`);
};

const createReservation = () => {
  alert("Création d’un nouvel événement");
};
</script>

<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Liste des Réservations</h2>
      <Button>Ajouter une réservation<Plus /></Button>
    </div>

    <div class="overflow-x-auto rounded border border-gray-200 shadow-sm">
      <table class="min-w-full bg-white divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">
              ID
            </th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">
              Email
            </th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">
              Nom
            </th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>

          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          <tr v-for="reservation in reservations" :key="reservation.id">
            <td class="px-4 py-2">{{ reservation.event_id }}</td>
            <td class="px-4 py-2">{{ reservation.email }}</td>
            <td class="px-4 py-2">{{ reservation.nom }}</td>
            <td class="px-4 py-2 flex gap-2">
              <button
                @click="editEvent(event)"
                class="text-blue-600 hover:underline"
              >
                <Pencil class="h-4 w-4" />
              </button>
              <button
                @click="deleteEvent(event.id)"
                class="text-red-600 hover:underline"
              >
                <Trash class="h-4 w-4" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
