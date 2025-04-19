<script setup lang="ts">
import { ref, watch } from 'vue'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle
} from '@/components/ui/dialog'

const props = defineProps<{
  isOpen: boolean
  event: {
    title: string
  } | null
}>()

const emit = defineEmits(['update:isOpen', 'delete', 'cancel'])


const open = ref(props.isOpen)
watch(() => props.isOpen, (val) => {
  open.value = val
})
watch(open, (val) => {
  emit('update:isOpen', val)
})
</script>

<template>
  <Dialog v-model:open="open">
    <DialogContent class="sm:max-w-md">
      <DialogHeader>
        <DialogTitle>Suppression de l’évènement</DialogTitle>
        <DialogDescription>
          Êtes-vous sûr de vouloir supprimer
          <strong> {{ event?.title }} </strong> ?
        </DialogDescription>
      </DialogHeader>

      <DialogFooter class="sm:justify-end flex gap-2">
        <Button type="button" variant="secondary" @click="emit('cancel')">
          Annuler
        </Button>

        <Button type="button" variant="destructive" @click="emit('delete')">
          Supprimer
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
