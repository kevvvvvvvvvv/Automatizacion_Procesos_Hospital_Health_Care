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
      <label htmlFor={id} className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
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
          w-full px-3 py-2 border rounded-md shadow-sm 
          focus:outline-none focus:ring-2 focus:ring-blue-500 
          ${error ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'}
          ${disabled ? 'bg-gray-100 cursor-not-allowed' : 'bg-white dark:bg-gray-700'}
          dark:text-white
        `}
      />

      {error && (
        <p className="mt-1 text-xs text-red-600">
          {error}
        </p>
      )}
    </div>
  );
};

export default InputText;