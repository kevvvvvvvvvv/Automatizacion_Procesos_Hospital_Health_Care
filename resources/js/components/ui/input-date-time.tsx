import React from "react";

interface InputDateTimeProps {
  value: string;
  onChange: (value: string) => void;
  name: string;
  id: string;
  label: string; 
  placeholder?: string;
  className?: string;
  error?: string;
}

const InputDateTime: React.FC<InputDateTimeProps> = ({
    value,
    onChange,
    name,
    id,
    label,
    placeholder = "Selecciona fecha y hora",
    className = "",
    error = "",
}) => {
    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (onChange) {
        onChange(e.target.value);
        }
    };

    return (
        <div className={`w-full ${className}`}>
        <label htmlFor={id} className="block text-sm font-medium text-gray-700 mb-1">
            {label}
        </label>
        <input
            type="datetime-local"
            id={id}
            name={name}
            value={value}
            onChange={handleChange}
            placeholder={placeholder}
            className={`w-full border border-[#D9D9D9] bg-[#F9F7F5] rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 ${error ? 'border-red-500' : ''}`}
            autoComplete="off"
        />
        {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
        </div>
    );
};

export default InputDateTime;

