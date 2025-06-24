import api from './axios';

export const addFavorite = (restaurantId) =>
    api.post(`/restaurants/${restaurantId}/favorite`);

export const removeFavorite = (restaurantId) =>
    api.delete(`/restaurants/${restaurantId}/favorite`);
