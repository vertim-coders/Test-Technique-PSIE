<template>
  <div v-if="isOpen" class="fixed inset-0 flex justify-center items-center bg-gray-500 bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
      <h2 class="text-xl font-bold mb-4">Modifier une réservation</h2>
      <form @submit.prevent="submitForm">
       
        <div class="mb-4">
          <label for="nom" class="block text-sm font-medium text-gray-600">Nom</label>
          <input
            id="nom"
            v-model="eventData.nom"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>

       
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
          <input
            id="email"
            v-model="eventData.email"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"
            required
          />
        </div>

        <div class="flex justify-end gap-2">
          <button @click="cancel" type="button" class="px-4 py-2 bg-gray-300 text-white rounded">Annuler</button>
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Modifier</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
  isOpen: Boolean,
});


const emit = defineEmits(['save', 'cancel']);


const eventData = ref({
  nom: '',
  email: '',
 
 
});

const submitForm = () => {
  emit('save', { ...eventData.value });
};

const cancel = () => {
  emit('cancel');
};
</script>
