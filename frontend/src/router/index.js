import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import EventView from '@/views/events/EventView.vue'
import AddEventView from '@/views/events/AddEventView.vue'
import ReservationView from '@/views/reservations/ReservationView.vue'
import EditEventView from '@/views/events/EditEventView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/events',
      name: 'events',
      component: EventView
    },
    {
      path: '/events/add',
      name: 'add-event',
      component: AddEventView
    },
    {
      path: '/events/edit/:id',
      name: 'edit-event',
      component: EditEventView,
    },
    {
      path: '/reservations',
      name: 'reservations',
      component: ReservationView
    }
  ],
})


export default router
