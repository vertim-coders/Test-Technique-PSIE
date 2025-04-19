<template>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow space-y-6">
      <h2 class="text-2xl font-bold text-center mb-4">Liste des Réservations</h2>
  
      <div v-for="reservation in reservations" :key="reservation.id" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-4">
        <h3 class="font-semibold text-lg">{{ reservation.nom }}</h3>
        <p><strong>Email:</strong> {{ reservation.email }}</p>
        <p><strong>Événement:</strong> {{ reservation.event_title }}</p>
        <p><strong>Date:</strong> {{ reservation.event_date }}</p>
  
        <div class="mt-4 flex justify-between">
          <button
            @click="modifierReservation(reservation)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
          >
            Modifier
          </button>
          <button
            @click="supprimerReservation(reservation.id)"
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition"
          >
            Supprimer
          </button>
        </div>
      </div>
  
      <div v-if="reservationToEdit" class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Modifier Réservation</h3>
        <form @submit.prevent="modifier" class="space-y-4">
          <input
            v-model="reservationToEdit.nom"
            placeholder="Nom"
            required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300"
          />
          <input
            v-model="reservationToEdit.email"
            placeholder="Email"
            required
            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300"
          />
          <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
          >
            Sauvegarder
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
        reservations: [],
        reservationToEdit: null,
      };
    },
  
    mounted() {
      this.fetchReservations();
    },
  
    methods: {
      fetchReservations() {
        fetch('http://localhost:8080/reservations')
          .then(res => res.json())
          .then(data => {
            if (data && data.data) {
              this.reservations = data.data.map(reservation => {
                const event = this.evenements?.find(ev => ev.id === reservation.event_id);
                return {
                  ...reservation,
                  event_title: event ? event.title : "Inconnu",
                  event_date: event ? event.date : "Date inconnue"
                };
              });
            }
          })
          .catch(err => {
            console.error("Erreur lors de la récupération des réservations", err);
          });
      },
  
    
      modifierReservation(reservation) {
        this.reservationToEdit = { ...reservation };
      },
  
      modifier() {
        fetch(`http://localhost:8080/reservations/${this.reservationToEdit.id}`, {
          method: 'PUT',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(this.reservationToEdit)
        })
          .then(res => res.json())
          .then(data => {
            this.fetchReservations();
            this.reservationToEdit = null;
          })
          .catch(err => console.error("Erreur dans la mise à jour de la réservation", err));
      },
  
      supprimerReservation(id) {
        if (!confirm("Confirmer la suppression ?")) return;
  
        fetch(`http://localhost:8080/reservations/${id}`, {
          method: 'DELETE'
        })
          .then(res => res.json())
          .then(data => {
            this.fetchReservations();
          })
          .catch(err => console.error("Erreur lors de la suppression de la réservation", err));
      }
    }
  };
  </script>
  
  <style scoped>
  input {
    @apply w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300;
  }
  </style>
  