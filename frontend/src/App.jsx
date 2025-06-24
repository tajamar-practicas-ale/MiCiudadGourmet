import { Routes, Route, Link, useNavigate } from 'react-router-dom';
import { useState } from 'react';

import Home from './pages/Home';

// Componente para proteger la ruta
import PrivateRoute from './components/PrivateRoute';

// Páginas Auth
import Register from './pages/Register';
import Login from './pages/Login';

// Páginas Restaurants
import Restaurants from './pages/Restaurants';
import RestaurantForm from './pages/RestaurantForm';
import RestaurantDetails from './pages/RestaurantDetails';

// Página Categories
import Categories from './pages/Categories';

// Logout
import { logout } from './api/auth';

function App() {
  const [user, setUser] = useState(null);
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      await logout();
      setUser(null);
      navigate('/login');
    } catch (error) {
      console.error('Logout failed', error);
    }
  };

  return (
    <div>
      <nav className="bg-neutral-800 py-4 px-6 text-white flex justify-between">
        <div className="space-x-4 flex justify-between w-full">
          <div>
            {!user && <Link to="/" className='hover:underline'>Inicio</Link>}
            {user && <h2>Mi Ciudad Gourmet</h2>}
          </div>
          <div className='flex gap-6'>
            {!user && <Link to="/login" className="hover:underline">Login</Link>}
            {!user && <Link to="/register" className="hover:underline">Registro</Link>}
            {user && <button onClick={handleLogout} className="hover:underline">Logout</button>}
          </div>
        </div>
      </nav>
      <div className="p-4">
        <Routes>
          {/* Ruta home */}
          <Route path="/" element={<Home />} />

          {/* Ruta Auth */}
          <Route path="/register" element={<Register setUser={setUser} />} />
          <Route path="/login" element={<Login setUser={setUser} />} />

          {/* Ruta Restaurants */}
          <Route path="/restaurants" element={
            <PrivateRoute>
              <Restaurants />
            </PrivateRoute>
          } />
          <Route path="/restaurants/create" element={
            <PrivateRoute>
              <RestaurantForm />
            </PrivateRoute>
          } />
          <Route path="/restaurants/edit/:id" element={
            <PrivateRoute>
              <RestaurantForm />
            </PrivateRoute>
          } />
          <Route path="/restaurants/:id" element={
            <PrivateRoute>
              <RestaurantDetails />
            </PrivateRoute>
          } />

          {/* Ruta Categories */}
          <Route path="/categories" element={
            <PrivateRoute>
              <Categories />
            </PrivateRoute>
          } />
        </Routes>
      </div>
    </div>
  );
}

export default App;
