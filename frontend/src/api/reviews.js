import api from './axios';

export const createReview = (restaurantId, data) =>
    api.post(`/restaurants/${restaurantId}/reviews`, data);

export const updateReview = (reviewId, data) =>
    api.put(`/reviews/${reviewId}`, data);

export const deleteReview = (reviewId) =>
    api.delete(`/reviews/${reviewId}`);
