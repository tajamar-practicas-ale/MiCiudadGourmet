import { useState, useEffect } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import {
    createRestaurant,
    updateRestaurant,
    getRestaurant,
} from '../api/restaurants';
import { getCategories } from '../api/categories';

const RestaurantForm = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const isEdit = Boolean(id);

    const [form, setForm] = useState({
        name: '',
        description: '',
        address: '',
        category_ids: [],
    });

    const [categories, setCategories] = useState([]);
    const [error, setError] = useState(null);

    useEffect(() => {
        getCategories().then((res) => setCategories(res.data));
        if (isEdit) {
            getRestaurant(id).then((res) => {
                const { name, description, address, categories } = res.data;
                setForm({
                    name,
                    description,
                    address,
                    category_ids: categories.map((c) => c.id),
                });
            });
        }
    }, [id]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setForm((prev) => ({ ...prev, [name]: value }));
    };

    const handleCategoryChange = (e) => {
        const options = Array.from(e.target.selectedOptions);
        const values = options.map((o) => Number(o.value));
        setForm((prev) => ({ ...prev, category_ids: values }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            if (isEdit) {
                await updateRestaurant(id, form);
            } else {
                await createRestaurant(form);
            }
            navigate('/restaurants');
        } catch (err) {
            setError('Error al guardar restaurante');
        }
    };

    return (
        <div className="max-w-xl mx-auto">
            <h2 className="text-2xl font-bold mb-4">{isEdit ? 'Editar' : 'Crear'} Restaurante</h2>
            {error && <p className="text-red-500 mb-4">{error}</p>}
            <form onSubmit={handleSubmit} className="space-y-4">
                <input
                    className="w-full p-2 border rounded"
                    type="text"
                    name="name"
                    placeholder="Nombre"
                    value={form.name}
                    onChange={handleChange}
                    required
                />
                <input
                    className="w-full p-2 border rounded"
                    type="text"
                    name="address"
                    placeholder="Dirección"
                    value={form.address}
                    onChange={handleChange}
                    required
                />
                <textarea
                    className="w-full p-2 border rounded"
                    name="description"
                    placeholder="Descripción"
                    value={form.description}
                    onChange={handleChange}
                />
                <select
                    multiple
                    className="w-full p-2 border rounded"
                    value={form.category_ids}
                    onChange={handleCategoryChange}
                >
                    {categories.map((cat) => (
                        <option key={cat.id} value={cat.id}>
                            {cat.name}
                        </option>
                    ))}
                </select>
                <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded">
                    {isEdit ? 'Actualizar' : 'Crear'}
                </button>
            </form>
        </div>
    );
};

export default RestaurantForm;
