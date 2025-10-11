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
      // 👇 Redirige directamente a la vista dashboard-healthcare
      router.visit('/dashboard-healthcare');
      // Si usas Ziggy con nombre de ruta:
      // router.visit(route('dashboard.healthcare'));
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
