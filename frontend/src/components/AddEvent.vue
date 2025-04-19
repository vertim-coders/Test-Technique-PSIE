<!-- src/components/AddEvent.vue -->
<template>
    <div class="p-6 max-w-md mx-auto">
    <h2 class="text-xl font-bold mb-4">➕ Ajouter un événement</h2>
    <form @submit.prevent="submitEvent" class="space-y-4">
        <input v-model="title" placeholder="Titre" class="w-full border rounded p-2" required />
        <input v-model="description" placeholder="Description" class="w-full border rounded p-2" required />
        <input v-model="date" type="date" class="w-full border rounded p-2" required />
        <input v-model.number="places_total" type="number" min="1" placeholder="Nombre de places" class="w-full border rounded p-2" required />
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
        Ajouter
        </button>
    </form>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { addEvent } from '@/api'

const title = ref('')
const description = ref('')
const date = ref('')
const places_total = ref(10)

const submitEvent = async () => {
    const event = {
    title: title.value,
    description: description.value,
    date: date.value,
    places_total: places_total.value,
    places_booked: 0
    }

    try {
    await addEvent(event)
    alert('✅ Événement ajouté avec succès')
    // Réinitialiser le formulaire
    title.value = ''
    description.value = ''
    date.value = ''
    places_total.value = 10
    } catch (error) {
    alert('❌ Une erreur est survenue')
    console.error(error)
    }
}
</script>
