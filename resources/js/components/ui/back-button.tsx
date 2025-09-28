// resources/js/components/BackButton.tsx

import { ArrowLeft } from 'lucide-react'; // 1. Importamos el ícono
import Button from '@/components/button';     // 2. Importamos nuestro botón genérico

interface BackButtonProps {
  // Hacemos onClick opcional para que pueda tener un comportamiento por defecto
  onClick?: () => void;
  className?: string;
}

const BackButton = ({ onClick, className }: BackButtonProps) => {
  
  // 3. Define la acción por defecto: regresar en el historial del navegador
  const handleBack = () => {
    if (onClick) {
      onClick(); // Si se provee una función, úsala
    } else {
      window.history.back(); // Si no, usa la función nativa del navegador
    }
  };

  return (
    // 4. Usamos el componente Button con un estilo predefinido
    <Button
      variant="secondary" // Le damos un estilo secundario para diferenciarlo del botón de "Enviar"
      onClick={handleBack}
      className={`flex items-center gap-2 ${className || ''}`}
      type="button" // Importante para que no envíe formularios por defecto
    >
      <ArrowLeft size={16} /> {/* El ícono */}
      Regresar
    </Button>
  );
};

export default BackButton;