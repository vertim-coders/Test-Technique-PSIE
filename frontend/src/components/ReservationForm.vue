<template>
    <div class="p-6 border rounded shadow mt-4">
    <h2 class="text-xl font-bold mb-4">➕ Nouvelle réservation</h2>
    <form @submit.prevent="submitReservation" class="space-y-4">
        <div>
        <label class="block text-sm font-medium">Nom</label>
        <input v-model="nom" type="text" class="w-full border rounded p-2" required />
        </div>
        <div>
        <label class="block text-sm font-medium">Email</label>
        <input v-model="email" type="email" class="w-full border rounded p-2" required />
        </div>
        <div>
        <label class="block text-sm font-medium">ID de l'événement</label>
        <input v-model.number="eventId" type="number" class="w-full border rounded p-2" required />
        </div>
        <button
        type="submit"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
        >
        Réserver
        </button>
    </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { reserve } from '@/api'

const nom = ref('')
const email = ref('')
const eventId = ref(null)

const submitReservation = async () => {
    try {
    await reserve({ nom: nom.value, email: email.value, event_id: eventId.value })
    alert('Réservation réussie ✅')
    // Reset form
    nom.value = ''
    email.value = ''
    eventId.value = null
    } catch (err) {
    alert('Une erreur est survenue ❌')
    console.error(err)
    }
}
</script>
