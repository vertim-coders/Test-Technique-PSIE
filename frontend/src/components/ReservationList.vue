<template>
    <div class="p-6">
    <h2 class="text-xl font-bold mb-4">📋 Réservations</h2>
    <ul>
        <li
        v-for="reservation in reservations"
        :key="reservation.id"
        class="mb-2 p-4 border rounded"
        >
        <p><strong>Nom :</strong> {{ reservation.nom }}</p>
        <p><strong>Email :</strong> {{ reservation.email }}</p>
        <p><strong>Événement ID :</strong> {{ reservation.event_id }}</p>
        <button
        @click="deleteReservation(reservation.id, reservation.email)"
        class="bg-red-500 text-white px-3 py-1 rounded mt-2"
        >
        Supprimer
        </button>
        </li>
    </ul>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getReservations } from '@/api'

const reservations = ref([])

onMounted(async () => {
    const res = await getReservations()
    reservations.value = res.data.data
})
</script>
