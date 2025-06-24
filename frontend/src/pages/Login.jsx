import { useState } from 'react';
import { login } from '../api/auth';
import { useNavigate } from 'react-router-dom';

export default function Login({ setUser }) {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const res = await login({ email, password });
            setUser(res.data.user); // Asegúrate de que la API retorne `user`
            navigate('/restaurants'); // Redirigir al listado de restaurantes
        } catch (err) {
            alert('Login fallido');
        }
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4 max-w-sm mx-auto mt-10">
            <h2 className="text-xl font-semibold">Iniciar sesión</h2>
            <input className="w-full p-2 border" value={email} onChange={e => setEmail(e.target.value)} type="email" placeholder="Correo" />
            <input className="w-full p-2 border" value={password} onChange={e => setPassword(e.target.value)} type="password" placeholder="Contraseña" />
            <button className="bg-blue-600 text-white px-4 py-2" type="submit">Entrar</button>
        </form>
    );
}
