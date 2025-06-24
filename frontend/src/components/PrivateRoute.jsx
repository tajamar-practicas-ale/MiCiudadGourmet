import { Navigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';

// Redirigar al login si el usuario no está autenticado
const PrivateRoute = ({ children }) => {
    const { user } = useAuth();

    return user ? children : <Navigate to="/login" />;
};

export default PrivateRoute;
