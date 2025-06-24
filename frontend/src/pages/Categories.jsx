import { useEffect, useState } from 'react';
import {
    getCategories,
    createCategory,
    updateCategory,
    deleteCategory,
} from '../api/categories';

const Categories = () => {
    const [categories, setCategories] = useState([]);
    const [name, setName] = useState('');
    const [editingId, setEditingId] = useState(null);

    const fetchCategories = async () => {
        const res = await getCategories();
        setCategories(res.data);
    };

    useEffect(() => {
        fetchCategories();
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            if (editingId) {
                await updateCategory(editingId, { name });
            } else {
                await createCategory({ name });
            }
            setName('');
            setEditingId(null);
            fetchCategories();
        } catch (err) {
            alert('Error al guardar la categoría');
        }
    };

    const handleEdit = (category) => {
        setName(category.name);
        setEditingId(category.id);
    };

    const handleDelete = async (id) => {
        if (!confirm('¿Estás seguro?')) return;
        try {
            await deleteCategory(id);
            fetchCategories();
        } catch (err) {
            alert('Error al eliminar la categoría');
        }
    };

    return (
        <div className="p-4">
            <h1 className="text-xl font-bold mb-4">Categorías</h1>
            <form onSubmit={handleSubmit} className="mb-4 flex gap-2">
                <input
                    type="text"
                    placeholder="Nombre de la categoría"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="border p-2 rounded w-full"
                />
                <button className="bg-green-500 text-white px-4 py-2 rounded">
                    {editingId ? 'Actualizar' : 'Crear'}
                </button>
            </form>

            <ul className="space-y-2">
                {categories.map((cat) => (
                    <li
                        key={cat.id}
                        className="flex justify-between items-center border-b pb-1"
                    >
                        {cat.name}
                        <div className="space-x-2">
                            <button
                                onClick={() => handleEdit(cat)}
                                className="text-blue-500"
                            >
                                Editar
                            </button>
                            <button
                                onClick={() => handleDelete(cat.id)}
                                className="text-red-500"
                            >
                                Eliminar
                            </button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default Categories;
