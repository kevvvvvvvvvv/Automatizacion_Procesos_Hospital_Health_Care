import type { ChangeEvent } from 'react';

interface InputTextProps {
  id: string;
  name: string;
  label: string;
  value: string;
  onChange: (e: ChangeEvent<HTMLInputElement>) => void;
  placeholder?: string;
  error?: string | null;
  type?: 'text' | 'email' | 'password';
  disabled?: boolean;
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
}: InputTextProps) => {
  return (
    <div className="mb-4 w-full">
      <label
        htmlFor={id}
        className="block text-sm font-medium text-gray-300 mb-1"
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
        className={`
          w-full px-3 py-2 rounded-md shadow-sm 
          border 
          text-white 
          bg-[#1B1C38] 
          placeholder-gray-400 
          focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56]
          transition
          ${error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-600'}
          ${disabled ? 'bg-gray-800 cursor-not-allowed opacity-60' : ''}
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
