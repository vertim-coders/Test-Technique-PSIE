import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/home.vue'
import Event from '../pages/event/event.vue'
import Reservation from '../pages/reservation/reservation.vue'
const routes = [
  { path: '/', component: Home },
  { path: '/event', component: Event },
  { path: '/reservation', component: Reservation },

]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
