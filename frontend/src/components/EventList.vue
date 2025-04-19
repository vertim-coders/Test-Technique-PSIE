<!-- src/components/EventList.vue -->
<template>
    <div class="p-6">
    <h2 class="text-xl font-bold mb-4">📅 Événements à venir</h2>
    
    <ul>
        <li
        v-for="event in events"
        :key="event.id"
        class="mb-2 p-4 border rounded"
        >
        <h3 class="text-lg font-semibold">{{ event.title }}</h3>
        <p>{{ event.description }}</p>
        <p>Date : {{ event.date }}</p>
        <p>Places disponibles : {{ event.places_total - event.places_booked }}</p>

        <div class="mt-2 space-x-2">
            <button
            @click="reserveSpot(event.id)"
            class="bg-blue-500 text-white px-3 py-1 rounded"
            >
            Réserver
            </button>
            <button
            @click="selectedEvent = event"
            class="bg-yellow-400 text-black px-3 py-1 rounded"
            >
            Modifier
            </button>
            <button
            @click="deleteEvent(event.id)"
            class="bg-red-500 text-white px-3 py-1 rounded"
            >
            Supprimer
            </button>
        </div>
        </li>
    </ul>

    <!-- Afficher le formulaire de modification si un événement est sélectionné -->
    <EditEvent
        v-if="selectedEvent"
        :event="selectedEvent"
        @close="selectedEvent = null"
        @updated="refreshEvents"
    />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { getEvents, reserve, deleteEvent as deleteEventApi } from '@/api'
import EditEvent from './EditEvent.vue'

const events = ref([])
const selectedEvent = ref(null)

const refreshEvents = async () => {
    const res = await getEvents()
    events.value = res.data.data
}

onMounted(refreshEvents)

const reserveSpot = async (eventId) => {
    const nom = prompt('Entrez votre nom :')
    const email = prompt('Entrez votre email :')
    if (nom && email) {
    await reserve({ event_id: eventId, nom, email })
    alert('Réservation effectuée !')
    await refreshEvents()
    }
}

const deleteEvent = async (eventId) => {
if (confirm("❗ Es-tu sûr de vouloir supprimer cet événement ?")) {
    try {
    await deleteEventApi(eventId)
    alert("✅ Événement supprimé !")
    await refreshEvents()
    } catch (error) {
    alert("❌ Erreur lors de la suppression.")
    console.error(error)
    }
}
}

</script>
