// resources/js/components/ui/AddButton.tsx

import { Plus } from 'lucide-react';
import { Link } from '@inertiajs/react'; // 1. Importante: Usamos Link en lugar de router

interface AddButtonProps {
  href: string;
  className?: string;
  children?: React.ReactNode;
}

const AddButton = ({ href, className, children = 'Añadir' }: AddButtonProps) => {
  return (
    <Link
      href={href}
      className={`
        inline-flex items-center justify-center gap-2 px-4 py-2 
        border border-transparent text-sm font-medium rounded-md shadow-sm 
        text-white bg-indigo-600 hover:bg-indigo-700 
        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
        transition
        ${className || ''}
      `}
    >
      <Plus size={16} />
      {children}
    </Link>
  );
};

export default AddButton;