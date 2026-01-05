import React from 'react';

interface TextareaInputProps extends React.TextareaHTMLAttributes<HTMLTextAreaElement> {
  label: string;
  error?: string;
  className?: string;
}

const TextareaInput: React.FC<TextareaInputProps> = ({
  label,
  id,
  name,
  error,
  className = '',
  ...props 
}) => {
  const baseClasses =
    'block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mt-4 mb-4';

  const errorClasses = 'border-red-500 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500';

  const normalClasses = 'border-gray-300 placeholder-gray-400';

  return (
    <div className="w-full">
      <label htmlFor={id} className="block text-sm font-medium text-gray-700 mb-1">
        {label}
      </label>

      <textarea
        id={id}
        name={name}
        className={`
          ${baseClasses}
          ${error ? errorClasses : normalClasses}
          ${className}
        `}
        {...props}
      />

      {error && (
        <p className="mt-2 text-sm text-red-600" id={`${id}-error`}>
          {error}
        </p>
      )}
    </div>
  );
};

export default TextareaInput;