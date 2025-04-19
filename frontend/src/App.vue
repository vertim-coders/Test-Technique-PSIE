<template>
  <div class="min-h-screen bg-gray-100 p-4">
    <div class="max-w-4xl mx-auto space-y-6">
      <!-- Bouton d'ajout d'événement -->
      <button 
        @click="showForm = !showForm" 
        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded shadow hover:bg-blue-700 transition"
      >
        {{ showForm ? 'Annuler' : 'Ajouter un événement' }}
      </button>

      <!-- Formulaire d'ajout -->
      <FormulaireEvenement 
        v-if="showForm" 
        @evenement-ajoute="handleAjoutEvenement"
      />

      <!-- Liste des événements -->
      <EvenementListe 
        :evenements="evenements"
        @actualiser="fetchEvenements"
      />

      <!-- Bouton pour afficher/masquer les réservations -->
      <button 
        @click="showReservations = !showReservations" 
        class="bg-green-600 text-white font-semibold px-4 py-2 rounded shadow hover:bg-green-700 transition"
      >
        {{ showReservations ? 'Masquer Réservations' : 'Afficher Réservations' }}
      </button>

      <!-- Liste des réservations -->
      <Reservation 
        v-if="showReservations" 
        :evenements="evenements" 
      />
    </div>
  </div>
</template>

<script>
import EvenementListe from './components/EvenementListe.vue';
import FormulaireEvenement from './components/AjouterEvenement.vue';
import Reservation from './components/Reservation.vue';

export default {
  components: {
    EvenementListe,
    FormulaireEvenement,
    Reservation
  },
  data() {
    return {
      evenements: [],
      showForm: false,
      showReservations: false
    };
  },
  methods: {
    fetchEvenements() {
      fetch('http://localhost:8080/events')
        .then(res => res.json())
        .then(data => this.evenements = data.data)
        .catch(err => console.error('Erreur lors de la récupération des événements :', err));
    },
    handleAjoutEvenement() {
      this.fetchEvenements();
      this.showForm = false;
    }
  },
  mounted() {
    this.fetchEvenements();
  }
};
</script>
