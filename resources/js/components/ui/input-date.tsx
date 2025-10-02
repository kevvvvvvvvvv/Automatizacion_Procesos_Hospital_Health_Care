import React, { useState } from "react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";


interface InputDateProps {
  value: Date | null;
  onChange: (date: Date | null) => void; 
  name: string;
  id: string;
  placeholder?: string; 
  className?: string;
  description?: string;
  error?: string;
}

// 2. Aplicamos el tipo de props a nuestro componente funcional
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
  
  const [selectedDate, setSelectedDate] = useState<Date | null>(value || null);

  const handleChange = (date: Date | null) => {
    setSelectedDate(date);
    if (onChange) {
      onChange(date);
    }
  };

  return (
    <div className="mb-5">
      {description && <p className="mb-3 text-sm">{description}</p>}
      <DatePicker
        selected={selectedDate}
        onChange={handleChange}
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