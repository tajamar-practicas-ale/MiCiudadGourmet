import { useEffect, useState } from 'react';
import { getRestaurants, deleteRestaurant } from '../api/restaurants';
import { Link } from 'react-router-dom';

export default function Restaurants() {
    const [restaurants, setRestaurants] = useState([]);

    useEffect(() => {
        getRestaurants().then(res => setRestaurants(res.data));
    }, []);

    const handleDelete = async (id) => {
        if (confirm('Eliminar restaurante?')) {
            await deleteRestaurant(id);
            setRestaurants(restaurants.filter(r => r.id !== id));
        }
    };

    return (
        <div className="p-4">
            <h2 className="text-2xl font-bold mb-4">Restaurantes</h2>
            <Link to="/restaurants/new" className="bg-blue-500 text-white px-4 py-2 rounded">Agregar</Link>
            <ul className="mt-4 space-y-4">
                {restaurants.map(r => (
                    <li key={r.id} className="border p-4 rounded shadow">
                        <h3 className="text-xl font-semibold">{r.name}</h3>
                        <p>{r.description}</p>
                        <div className="mt-2 space-x-2">
                            <Link to={`/restaurants/${r.id}`} className="text-blue-600 underline">Ver</Link>
                            <Link to={`/restaurants/edit/${r.id}`} className="text-yellow-600 underline">Editar</Link>
                            <button onClick={() => handleDelete(r.id)} className="text-red-600 underline">Eliminar</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}
