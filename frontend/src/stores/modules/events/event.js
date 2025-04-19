import { useApi } from "@/stores/apis";
import { defineStore } from "pinia";
import { ref } from "vue";
import Swal from "sweetalert2";

export const useEventsStore = defineStore("eventsStore", () => {
  const api = useApi();
  const events = ref([]);
  const event = ref({});
  const loading = ref(false);
  const error = ref(null);

  const getEvents = async () => {
    loading.value = true;
    try {
      const response = await api.get("/events");
      events.value = response.data.data;
    } catch (err) {
      console.error(err);
      error.value = err.message;
    } finally {
      loading.value = false;
    }
  };

  const saveEvent = async (eventData) => {
    loading.value = true;
    try {
      const response = await api.post("/events/add", eventData);
      events.value.push(response.data.data);
      event.value = response.data.data;
      if (response.status === 200) {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Evènement enregistré avec succès!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/events";
          }
        });
      }
    } catch (err) {
      console.error(err);
      error.value = err.message;
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "Une erreur s'est produite lors de l'enregistrement de l'événement.",
      });
    } finally {
      loading.value = false;
    }
  };

  const getEventById = async (id) => {
    loading.value = true;
    try {
      const response = await api.get(`/events/${id}`);
      return response.data.data;
    } catch (err) {
      console.error(err);
      error.value = err.message;
    } finally {
      loading.value = false;
    }
  };

  const updateEvent = async (eventData, eventId) => {
    loading.value = true;
    try {
      const response = await api.put(`/events/${eventId}`, eventData);
      const index = events.value.findIndex((e) => e.id === eventData.id);
      if (index !== -1) {
        events.value[index] = response.data.data;
        event.value = response.data.data;
      }
      if (response.status === 200) {
        Swal.fire({
          icon: "success",
          title: "Success",
          text: "Evènement mis à jour avec succès!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "/events";
          }
        });
      }
    } catch (err) {
      console.error(err);
      error.value = err.message;
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "Une erreur s'est produite lors de la mise à jour de l'événement.",
      });
    } finally {
      loading.value = false;
    }
  };

  const deleteEvent = async (eventId) => {
    loading.value = true;
    Swal.fire({
      title: "Êtes-vous sûr ?",
      text: "Vous ne pourrez pas revenir en arrière !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Oui, supprimer !",
    }).then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await api.delete(`/events/${eventId}`);
          events.value = events.value.filter((e) => e.id !== eventId);
          if (response.status === 200) {
            Swal.fire({
              icon: "success",
              title: "Supprimé !",
              text: "L'événement a été supprimé avec succès.",
            });
          }
        } catch (err) {
          console.error(err);
          error.value = err.message;
          Swal.fire({
            icon: "error",
            title: "Erreur",
            text: "Une erreur s'est produite lors de la suppression de l'événement.",
          });
        } finally {
          loading.value = false;
        }
      }
    });
  }

  return {
    events,
    event,
    loading,
    error,
    getEvents,
    saveEvent,
    getEventById,
    updateEvent,
    deleteEvent,
  };
});
