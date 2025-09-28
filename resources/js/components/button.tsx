import { cva, type VariantProps } from 'class-variance-authority';
import React from 'react';

// 1. Define todas las variantes con cva
const buttonVariants = cva(
  // Estilos base, aplicados a todas las variantes
  'font-bold rounded-lg transition-transform duration-150 ease-in-out active:scale-95',
  {
    variants: {
      variant: {
        primary: 'bg-blue-600 text-white hover:bg-blue-700',
        secondary: 'bg-gray-200 text-gray-800 hover:bg-gray-300',
        destructive: 'bg-red-600 text-white hover:bg-red-700',
      },
      size: {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-base',
        lg: 'px-6 py-3 text-lg',
      },
    },
    // Valores por defecto
    defaultVariants: {
      variant: 'primary',
      size: 'md',
    },
  }
);

// 2. Define las props del componente
export interface ButtonProps
  extends React.ButtonHTMLAttributes<HTMLButtonElement>,
    VariantProps<typeof buttonVariants> {}

// 3. Crea el componente
const Button = ({ className, variant, size, ...props }: ButtonProps) => {
  // cva genera las clases correctas según las props que le pases
  return <button className={buttonVariants({ variant, size, className })} {...props} />;
};

export default Button;