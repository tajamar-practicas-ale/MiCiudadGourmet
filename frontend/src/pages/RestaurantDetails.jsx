import { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { getRestaurant, deleteRestaurant } from '../api/restaurants';
import { addFavorite, removeFavorite } from '../api/favorites';
import { useAuth } from '../contexts/AuthContext';

const RestaurantDetails = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const { user } = useAuth();

    const [restaurant, setRestaurant] = useState(null);
    const [error, setError] = useState('');
    const [isFavorite, setIsFavorite] = useState(false);

    useEffect(() => {
        getRestaurant(id)
            .then((res) => {
                setRestaurant(res.data.data);
                // puedes manejar si es favorito o no desde la API si lo tienes
            })
            .catch(() => setError('Error al cargar el restaurante.'));
    }, [id]);

    const handleDelete = async () => {
        if (!window.confirm('¿Estás seguro de eliminar este restaurante?')) return;
        try {
            await deleteRestaurant(id);
            navigate('/restaurants');
        } catch {
            setError('No se pudo eliminar el restaurante.');
        }
    };

    const toggleFavorite = async () => {
        try {
            if (isFavorite) {
                await removeFavorite(id);
                setIsFavorite(false);
            } else {
                await addFavorite(id);
                setIsFavorite(true);
            }
        } catch {
            setError('Error al actualizar favorito.');
        }
    };

    if (error) return <p>{error}</p>;
    if (!restaurant) return <p>Cargando...</p>;

    return (
        <div className="max-w-2xl mx-auto p-4 bg-white rounded shadow">
            <h2 className="text-2xl font-bold mb-2">{restaurant.name}</h2>
            <p className="text-gray-700 mb-1">Dirección: {restaurant.address}</p>
            <p className="text-gray-700 mb-1">{restaurant.description}</p>

            <div className="mb-2">
                <strong>Categorías:</strong>{' '}
                {restaurant.categories?.map((cat) => cat.name).join(', ') || 'Ninguna'}
            </div>

            {user && (
                <div className="flex gap-2 mt-4">
                    <button
                        onClick={() => navigate(`/restaurants/edit/${restaurant.id}`)}
                        className="bg-yellow-500 text-white px-4 py-2 rounded"
                    >
                        Editar
                    </button>
                    <button
                        onClick={handleDelete}
                        className="bg-red-600 text-white px-4 py-2 rounded"
                    >
                        Eliminar
                    </button>
                    <button
                        onClick={toggleFavorite}
                        className="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        {isFavorite ? 'Quitar de favoritos' : 'Agregar a favoritos'}
                    </button>
                </div>
            )}
        </div>
    );
};

export default RestaurantDetails;
