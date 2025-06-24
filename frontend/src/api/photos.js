import api from './axios';

export const uploadPhoto = (restaurantId, formData) =>
    api.post(`/restaurants/${restaurantId}/photos`, formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });

export const deletePhoto = (photoId) =>
    api.delete(`/photos/${photoId}`);
