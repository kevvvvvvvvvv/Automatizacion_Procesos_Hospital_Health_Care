import React from "react";
import DatePicker, { registerLocale } from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
// 1. Importar la configuración de español
import { es } from 'date-fns/locale/es';

// 2. Registrar el idioma español
registerLocale('es', es);

interface InputDateProps {
  value: Date | string | null; 
  onChange: (date: Date | null) => void; 
  name?: string; 
  id?: string;
  placeholder?: string; 
  className?: string;
  description?: string;
  error?: string;
  type?: string; 
}

const InputDate: React.FC<InputDateProps> = ({
  value,
  onChange,
  name,
  id,
  placeholder = "Selecciona una fecha",
  className = "",
  description = "",
  error = "",
}) => {

  const fechaProcesada = React.useMemo(() => {
      if (typeof value === 'string' && value) {
          return new Date(value.includes('T') ? value : value + "T00:00:00");
      }
      return value as Date | null;
  }, [value]);

  return (
    <div className="mb-5">
      {description && <label htmlFor={id} className="block mb-3 text-sm">{description}</label>}
      
      <DatePicker
        // 3. Aplicar el idioma español aquí
        locale="es"
        selected={fechaProcesada} 
        onChange={(date: Date | null) => {
            onChange(date); 
        }}
        placeholderText={placeholder}
        dateFormat="dd/MM/yyyy"
        name={name}
        id={id}
        className={`w-full border border-[#D9D9D9] bg-[#F9F7F5] rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 ${className}`}
        showMonthDropdown
        showYearDropdown
        scrollableYearDropdown
        yearDropdownItemNumber={50}
        autoComplete="off"
      />
      
      {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
    </div>
  );
};

export default InputDate;