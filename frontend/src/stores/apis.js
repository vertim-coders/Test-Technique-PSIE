import axios from "axios";

let api;

function createApi() {
  api = axios.create({
    baseURL: import.meta.env.VITE_APP_URL,
    json: true,
    withCredentials: false,
    timeout: 50000,
  });
  return api;
}

export function useApi() {
  if (!api) {
    createApi();
  }
  return api;
}
