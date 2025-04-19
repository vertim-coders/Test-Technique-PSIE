<!-- src/components/EditEvent.vue -->
<template>
    <div class="mt-6 p-4 border rounded bg-gray-50 max-w-md mx-auto">
    <h2 class="text-lg font-bold mb-4">✏️ Modifier l'événement</h2>
    <form @submit.prevent="submitEdit" class="space-y-4">
        <input v-model="edited.title" placeholder="Titre" class="w-full border rounded p-2" required />
        <input v-model="edited.description" placeholder="Description" class="w-full border rounded p-2" required />
        <input v-model="edited.date" type="date" class="w-full border rounded p-2" required />
        <input v-model.number="edited.places_total" type="number" min="1" class="w-full border rounded p-2" required />
        
        <div class="flex justify-between">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Enregistrer</button>
        <button @click="$emit('close')" type="button" class="text-red-500">Fermer</button>
        </div>
    </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { updateEvent } from '@/api'

const props = defineProps({ event: Object })
const emit = defineEmits(['close', 'updated'])

const edited = ref({ ...props.event })

watch(() => props.event, (newVal) => {
    edited.value = { ...newVal }
})

const submitEdit = async () => {
    try {
    await updateEvent(edited.value.id, edited.value)
    alert('✅ Événement modifié avec succès')
    emit('updated') // Pour rafraîchir la liste
    emit('close')   // Fermer le formulaire
    } catch (error) {
    alert('❌ Erreur lors de la modification')
    console.error(error)
    }
}
</script>
