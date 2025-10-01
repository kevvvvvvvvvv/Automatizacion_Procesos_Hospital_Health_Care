import { Plus } from 'lucide-react';
import { Link } from '@inertiajs/react';

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
        text-white 
        focus:outline-none focus:ring-2 focus:ring-offset-2
        transition
        ${className || ''}
      `}
      style={{ backgroundColor: '#1B1C38' }}
    >
      <Plus size={16} />
      {children}
    </Link>
  );
};

export default AddButton;
