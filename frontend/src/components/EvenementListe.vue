<template>
  <div class="space-y-6">
    <h1 class="text-2xl font-bold">Liste des Événements disponibles</h1>

    <div
      v-for="event in evenements"
      :key="event.id"
      class="border border-gray-300 rounded-lg shadow p-4 space-y-2 bg-white"
    >
      <p><strong>{{ event.title }}</strong></p>
      <p>{{ event.description }}</p>
      <p>Date : {{ event.date }}</p>
      <p>Places : {{ event.places_booked }} / {{ event.places_total }}</p>

      <div class="flex space-x-2">
        <button
          @click="remplirForm(event)"
          class="px-3 py-1 bg-yellow-400 text-black rounded hover:bg-yellow-500"
        >
          Modifier
        </button>
        <button
          @click="supprimer(event.id)"
          class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
        >
          Supprimer
        </button>
        <button
          @click="reserver(event)"
          class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Réserver
        </button>
      </div>
    </div>

    <!-- Formulaire de modification -->
    <div v-if="eventToEdit" class="mt-6 border p-4 rounded bg-gray-50 space-y-4">
      <h3 class="text-xl font-semibold">Modifier Événement</h3>
      <form @submit.prevent="modifier" class="space-y-2">
        <input v-model="eventToEdit.title" placeholder="Titre" class="input" />
        <input v-model="eventToEdit.description" placeholder="Description" class="input" />
        <input v-model="eventToEdit.date" type="date" class="input" />
        <input v-model.number="eventToEdit.places_total" type="number" class="input" />
        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
          Sauvegarder
        </button>
      </form>
    </div>

    <!-- Formulaire de réservation -->
    <div v-if="showReservationForm" class="mt-6 border p-4 rounded bg-gray-50 space-y-4">
      <h3 class="text-xl font-semibold">Réserver un événement</h3>
      <form @submit.prevent="ajouterReservation" class="space-y-2">
        <input v-model="reservation.nom" placeholder="Nom" required class="input" />
        <input v-model="reservation.email" placeholder="Email" required class="input" />
        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          Réserver
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['evenements'],
  data() {
    return {
      eventToEdit: null,
      showReservationForm: false,
      reservation: {
        nom: '',
        email: '',
        event_id: null
      }
    };
  },
  methods: {
    remplirForm(event) {
      this.eventToEdit = { ...event };
    },
    modifier() {
      fetch(`http://localhost:8080/events/${this.eventToEdit.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(this.eventToEdit)
      })
        .then(res => res.json())
        .then(() => {
          this.$emit('actualiser');
          this.eventToEdit = null;
        });
    },
    supprimer(id) {
      if (!confirm("Confirmer la suppression ?")) return;

      fetch(`http://localhost:8080/events/${id}`, {
        method: 'DELETE'
      })
        .then(res => res.json())
        .then(() => {
          this.$emit('actualiser');
        });
    },
    reserver(event) {
      this.reservation.event_id = event.id;
      this.showReservationForm = true;
    },
    ajouterReservation() {
      fetch('http://localhost:8080/reservations/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(this.reservation)
      })
        .then(res => res.json())
        .then(() => {
          this.showReservationForm = false;
          this.reservation = { nom: '', email: '', event_id: null };
          this.$emit('actualiser');
        })
        .catch(err => console.error(err));
    }
  }
};
</script>

<style scoped>
.input {
  @apply w-full border px-3 py-2 rounded;
}
</style>
