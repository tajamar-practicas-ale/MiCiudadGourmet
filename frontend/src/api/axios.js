// Instancia de axios

import axios from 'axios';

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL, // Toma la ruta que se añadió en el .env
    withCredentials: true,
});

export default api;