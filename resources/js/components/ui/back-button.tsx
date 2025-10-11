// resources/js/components/BackButton.tsx
import { ArrowLeft } from 'lucide-react';
import { router } from '@inertiajs/react'; // 👈 importa router de Inertia
import Button from '@/components/button';

interface BackButtonProps {
  onClick?: () => void;
  className?: string;
}

const BackButton = ({ onClick, className }: BackButtonProps) => {
  const handleBack = () => {
  if (onClick) {
    onClick();
  } else {
    window.history.back(); // vuelve a la página anterior
  }
};

  return (
    <Button
      variant="secondary"
      onClick={handleBack}
      className={`flex items-center gap-2 ${className || ''}`}
      type="button"
    >
      <ArrowLeft size={16} />
      Regresar
    </Button>
  );
};

export default BackButton;
