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

    // FUNCIÓN DE AYUDA: Formatear el valor para que datetime-local lo acepte
    const formatValue = (val: string) => {
        if (!val) return "";
        
        // Si viene formato SQL "2025-12-20 14:30:00", lo convertimos a "2025-12-20T14:30"
        // 1. Reemplazar espacio por T
        // 2. Cortar los segundos si existen (los primeros 16 caracteres: YYYY-MM-DDThh:mm)
        return val.replace(' ', 'T').substring(0, 16);
    };

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (onChange) {
            // El input devuelve "2025-12-20T14:30", se lo pasamos tal cual al estado
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
                // AQUÍ USAMOS LA FUNCIÓN DE FORMATEO
                value={formatValue(value)}
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