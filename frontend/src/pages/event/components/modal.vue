<!-- src/components/Modal.vue -->
<template>
  <div v-if="isOpen" class="fixed inset-0 flex justify-center items-center z-50 bg-gray-800 bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
      <div class="mb-4">
        <h3 class="text-xl font-semibold">{{ title }}</h3>
      </div>
      <div class="mb-4">
        <slot></slot> <!-- Contenu dynamique du modal -->
      </div>
      <div class="flex justify-end gap-2">
        <Button @click="closeModal" class="bg-gray-300">Annuler</Button>
        <Button @click="onConfirm" :class="confirmButtonClass">Confirmer</Button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Button } from '@/components/ui/button';

const isOpen = ref(false);
const title = ref<string>('');
const onConfirm = ref<() => void>(() => {});
const confirmButtonClass = ref('bg-blue-500');

const openModal = (modalTitle: string, confirmCallback: () => void, buttonClass: string = 'bg-blue-500') => {
  title.value = modalTitle;
  onConfirm.value = confirmCallback;
  confirmButtonClass.value = buttonClass;
  isOpen.value = true;
};

const closeModal = () => {
  isOpen.value = false;
};

defineExpose({
  openModal
});
</script>
