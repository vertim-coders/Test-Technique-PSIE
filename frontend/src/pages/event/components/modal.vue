<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Copy } from 'lucide-vue-next'
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button variant="outline">
        Share
      </Button>
    </DialogTrigger>
    <DialogContent class="sm:max-w-md">
      <DialogHeader>
        <DialogTitle>Suppression évènement</DialogTitle>
        <DialogDescription>
          Etes vous sur de vouloir supprimer cet évènement?
        </DialogDescription>
      </DialogHeader>
      
      <DialogFooter class="sm:justify-start">
        <DialogClose as-child>
           <div class="flex">
            <Button type="button" variant="secondary">
            Annuler
          </Button>

          <Button type="button" variant="secondary">
            Supprimer
          </Button>
           
           </div>
        
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>