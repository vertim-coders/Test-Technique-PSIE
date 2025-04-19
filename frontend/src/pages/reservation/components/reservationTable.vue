<script setup lang="ts">
import { ref } from "vue";
import { Pencil, Trash, Plus } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import DeleteReservation from "./modal.vue";

interface Reservation {
  id: number;
  event_id: number;
  email: string;
  nom: string;
}

const reservations = ref<Reservation[]>([
  { id: 1, event_id: 2, email: "abokajr@vertimcoders.com", nom: "ABOKA JR" },
  { id: 2, event_id: 1, email: "abokajr@vertimcoders.com", nom: "ABOKA JR" },
  { id: 3, event_id: 1, email: "gohou@vertimcoders.com", nom: "GOHOU" },
]);

const isDeleteModalOpen = ref(false);
const reservationToDelete = ref<Reservation | null>(null);

const openDeleteModal = (reservation: Reservation) => {
  reservationToDelete.value = reservation;
  isDeleteModalOpen.value = true;
};

const deleteReservation = () => {
  if (reservationToDelete.value) {
    reservations.value = reservations.value.filter(
      (r) => r.id !== reservationToDelete.value?.id
    );
  }
  isDeleteModalOpen.value = false;
};

const cancelDelete = () => {
  isDeleteModalOpen.value = false;
};

const editReservation = (reservation: Reservation) => {
  alert(`Édition de la réservation : ${reservation.nom}`);
};

const createReservation = () => {
  alert("Création d’une nouvelle réservation");
};
</script>

<template>
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Liste des Réservations</h2>
      <Button @click="createReservation">
        Ajouter une réservation
        <Plus class="ml-2 w-4 h-4" />
      </Button>
    </div>

    <div class="overflow-x-auto rounded border border-gray-200 shadow-sm">
      <table class="min-w-full bg-white divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Event ID</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Email</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nom</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-for="reservation in reservations" :key="reservation.id">
            <td class="px-4 py-2">{{ reservation.event_id }}</td>
            <td class="px-4 py-2">{{ reservation.email }}</td>
            <td class="px-4 py-2">{{ reservation.nom }}</td>
            <td class="px-4 py-2 flex gap-2">
              <button @click="editReservation(reservation)" class="text-blue-600 hover:underline">
                <Pencil class="h-4 w-4" />
              </button>
              <button @click="openDeleteModal(reservation)" class="text-red-600 hover:underline">
                <Trash class="h-4 w-4" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  
    <DeleteReservation
      v-model:isOpen="isDeleteModalOpen"
      :reservation="reservationToDelete"
      @delete="deleteReservation"
      @cancel="cancelDelete"
    />
  </div>
</template>
