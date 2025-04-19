<!-- src/App.vue ou page principale -->
<template>
  <div>
    <AddEvent />
    <EventList />
    <ReservationForm />
    <ReservationList />
  </div>
</template>

<script setup>
import AddEvent from '@/components/AddEvent.vue'
import EventList from '@/components/EventList.vue'
import ReservationList from '@/components/ReservationList.vue'
import ReservationForm from '@/components/ReservationForm.vue'
</script>
