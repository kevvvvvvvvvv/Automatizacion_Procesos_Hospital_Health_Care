import React, { InputHTMLAttributes } from 'react';

interface InputTextProps extends InputHTMLAttributes<HTMLInputElement> {
  id: string;
  name: string;
  label: string;
  value: string;
  error?: string | null;
}

const InputText = ({
  id,
  name,
  label,
  value,
  error = null,
  className = "", 
  ...props 
}: InputTextProps) => {
  return (
    <div className="mb-4 w-full">
      <label
        htmlFor={id}
        className={`block text-sm font-medium mb-1 ${
          error ? 'text-red-500' : 'text-gray-700'
        } ${props.disabled ? 'opacity-60 cursor-not-allowed' : ''}`}
      >
        {label}
      </label>

      <input
        id={id}
        name={name}
        value={value}
        {...props} 
        className={`
          w-full px-3 py-2 rounded-md shadow-sm 
          border 
          text-gray-900 
          bg-white 
          placeholder-gray-400 
          focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56]
          transition
          ${error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-600'}
          ${props.disabled ? 'bg-gray-200 cursor-not-allowed opacity-60' : ''}
          ${className} 
        `}
      />

      {error && (
        <p className="mt-1 text-xs text-red-500">
          {error}
        </p>
      )}
    </div>
  );
};

export default InputText;