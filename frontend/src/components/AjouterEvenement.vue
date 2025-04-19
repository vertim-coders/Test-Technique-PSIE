<template>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow space-y-4">
      <h2 class="text-xl font-bold mb-2">Ajouter un événement</h2>
      <form @submit.prevent="ajouter" class="space-y-3">
        <input
          v-model="form.title"
          placeholder="Titre"
          required
          class="input"
        />
        <input
          v-model="form.description"
          placeholder="Description"
          required
          class="input"
        />
        <input
          v-model="form.date"
          type="date"
          required
          class="input"
        />
        <input
          v-model.number="form.places_total"
          type="number"
          placeholder="Places totales"
          required
          class="input"
        />
        <button
          type="submit"
          class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
        >
          Valider
        </button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          title: '',
          description: '',
          date: '',
          places_total: 0
        },
      };
    },
    methods: {
      ajouter() {
        const eventData = {
          ...this.form,
          places_booked: 0 
        };
  
        fetch('http://localhost:8080/events/add', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(eventData),
        })
          .then(res => {
            if (!res.ok) {
              throw new Error('Erreur dans la réponse du serveur');
            }
            return res.json();
          })
          .then(data => {
            console.log(data);  
            if (data.message) {
              this.$emit('evenement-ajoute', eventData);
              this.form = { title: '', description: '', date: '', places_total: 0 }; 
            } else {
              console.error("Erreur dans les données retournées", data);
            }
          })
          .catch(err => {
            console.error("Erreur:", err);  // Afficher des messages d'erreur 
          });
      }
    }
  };
  </script>
  
  
  <style scoped>
  .input {
    @apply w-full border px-3 py-2 rounded focus:outline-none focus:ring focus:border-blue-300;
  }
  </style>
  