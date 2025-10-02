import type { ChangeEvent } from 'react';

interface InputTextProps {
  id: string;
  name: string;
  label: string;
  value: string;
  onChange: (e: ChangeEvent<HTMLInputElement | HTMLSelectElement>) => void;
  placeholder?: string;
  error?: string | null;
  type?: 'text' | 'email' | 'password' | 'date';
  disabled?: boolean;
  required?: boolean;
  maxLength?: number;
}

const InputText = ({
  id,
  name,
  label,
  value,
  onChange,
  placeholder = '',
  error = null,
  type = 'text',
  disabled = false,
  required = false,
  maxLength,
}: InputTextProps) => {
  return (
    <div className="mb-4 w-full">
      <label
        htmlFor={id}
        className={`
            w-full px-3 py-2 rounded-md shadow-sm 
            border 
            text-gray-900 
            bg-white 
            placeholder-gray-500 
            focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
            transition
            ${error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300'}
            ${disabled ? 'bg-gray-200 cursor-not-allowed opacity-60' : ''}
          `}

      >
        {label}
      </label>

      <input
        type={type}
        id={id}
        name={name}
        value={value}
        onChange={onChange}
        placeholder={placeholder}
        disabled={disabled}
        required={required}
        maxLength={maxLength}
        className={`
          w-full px-3 py-2 rounded-md shadow-sm 
          border 
          text-gray-900 
          bg-white 
          placeholder-gray-400 
          focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56]
          transition
          ${error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-600'}
          ${disabled ? 'bg-gray-200 cursor-not-allowed opacity-60' : ''}
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
