// src/api.js
import axios from 'axios';

const API = axios.create({
  baseURL: 'http://localhost:8080',
});

export const getEvents = () => API.get('/events');
export const getEvent = (id) => API.get(`/events/${id}`);
export const addEvent = (event) => API.post('/events/add', event);
export const updateEvent = (id, event) => API.put(`/events/${id}`, event);
export const deleteEvent = (id) => API.delete(`/events/${id}`);

export const getReservations = () => API.get('/reservations');
export const reserve = (data) => API.post('/reserves/add', data);
export const getReservationsByEmail = (email) => API.get(`/reservations?email=${email}`);
export const cancelReservation = (id, email) => API.delete(`/reservation/${id}/email/${email}`);
