import React from 'react';

interface PrimaryButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  children: React.ReactNode; 
  className?: string;
  disabled?: boolean;
}

const PrimaryButton: React.FC<PrimaryButtonProps> = ({
  children,
  className = '',
  disabled = false,
  type = 'button',
  ...props 
}) => {
  return (
    <button
      {...props} 
      type={type}
      disabled={disabled}
      className={`
        inline-flex items-center justify-center px-4 py-2 
        border border-transparent text-sm font-medium rounded-md shadow-sm 
        text-white bg-blue-600 
        transition duration-150 ease-in-out
        ${disabled 
          ? 'opacity-50 cursor-not-allowed' 
          : 'hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'
        }
        ${className} // 4. Permite añadir clases personalizadas desde fuera
      `}
    >
      {children}
    </button>
  );
};

export default PrimaryButton;