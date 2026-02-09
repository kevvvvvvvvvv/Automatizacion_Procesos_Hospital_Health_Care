import React, { useMemo } from 'react';
import Select, { OnChangeValue, StylesConfig, MultiValue, SingleValue } from 'react-select';

type SelectOption<T = string | number> = {
  value: T;
  label: string;
};

interface SelectInputProps {
  label?: string;
  options: SelectOption[];
  // Ahora el value puede ser un solo valor o un array de valores
  value: string | number | null | (string | number)[]; 
  // Ahora el onChange devuelve el valor individual o el array completo
  onChange: (value: any) => void; 
  error?: string;
  placeholder?: string;
  isMulti?: boolean; // Nueva prop para habilitar multiselect
}

const SelectInput: React.FC<SelectInputProps> = ({
  label,
  options,
  value,
  onChange,
  error,
  placeholder = 'Selecciona una opción',
  isMulti = false, // Por defecto es falso para no romper los otros selects
}) => {

  const customStyles: StylesConfig<SelectOption, boolean> = {
    control: (provided, state) => ({
      ...provided,
      borderColor: '#D9D9D9',
      backgroundColor: '#F9F7F5',
      borderRadius: '0.5rem',
      padding: '2px 4px',
      boxShadow: state.isFocused ? '0 0 0 2px #3B82F6' : 'none',
      '&:hover': { borderColor: '#D9D9D9' },
      minHeight: '40px',
    }),
    placeholder: (provided) => ({ ...provided, color: '#9CA3AF' }),
    singleValue: (provided) => ({ ...provided, color: '#111827' }),
    multiValue: (provided) => ({ // Estilo para las "etiquetas" del multiselect
      ...provided,
      backgroundColor: '#E5E7EB',
      borderRadius: '4px',
    }),
    dropdownIndicator: (provided) => ({ ...provided, color: '#6B7280' }),
    indicatorSeparator: () => ({ display: 'none' }),
  };

  // Buscamos la(s) opción(es) seleccionada(s)
  const selectedOption = useMemo(() => {
    if (isMulti && Array.isArray(value)) {
      return options.filter((opt) => value.map(String).includes(String(opt.value)));
    }
    return options.find((opt) => String(opt.value) === String(value)) || null;
  }, [options, value, isMulti]);

  const handleChange = (selected: OnChangeValue<SelectOption, boolean>) => {
    if (isMulti) {
      // Si es multi, extraemos un array de valores
      const values = (selected as MultiValue<SelectOption>).map(opt => opt.value);
      onChange(values);
    } else {
      // Si es único, extraemos el valor solo
      const val = (selected as SingleValue<SelectOption>)?.value || '';
      onChange(val);
    }
  };

  return (
    <div className="mb-5 w-full"> 
      {label && <label className="block text-sm mb-3">{label}</label>}
      <Select<SelectOption, boolean> 
        isMulti={isMulti} // Pasamos la prop a react-select
        options={options}
        value={selectedOption}
        onChange={handleChange}
        placeholder={placeholder}
        styles={customStyles}
        isClearable
      />
      {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
    </div>
  );
};

export default SelectInput;