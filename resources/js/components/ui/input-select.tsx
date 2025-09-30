import React from 'react';
import Select, { OnChangeValue, StylesConfig } from 'react-select';

type SelectOption<T = string | number> = {
  value: T;
  label: string;
};

interface SelectInputProps {
  label?: string;
  options: SelectOption[];
  value: string | number | null; 
  onChange: (value: string | number) => void; 
  error?: string;
  placeholder?: string;
}

const SelectInput: React.FC<SelectInputProps> = ({
  label,
  options,
  value,
  onChange,
  error,
  placeholder = 'Selecciona una opción',
}) => {

  const customStyles: StylesConfig<SelectOption> = {
    control: (provided, state) => ({
      ...provided,
      borderColor: '#D9D9D9',
      backgroundColor: '#F9F7F5',
      borderRadius: '0.5rem',
      padding: '2px 4px',
      boxShadow: state.isFocused ? '0 0 0 2px #3B82F6' : 'none',
      '&:hover': {
        borderColor: '#D9D9D9',
      },
      minHeight: '40px',
    }),
    placeholder: (provided) => ({ ...provided, color: '#9CA3AF' }),
    singleValue: (provided) => ({ ...provided, color: '#111827' }),
    dropdownIndicator: (provided) => ({ ...provided, color: '#6B7280' }),
    indicatorSeparator: () => ({ display: 'none' }),
  };

  const selectedOption = options.find((opt) => opt.value === value) || null;
  
  const handleChange = (selected: OnChangeValue<SelectOption, false>) => {
    onChange(selected ? selected.value : '');
  };

  return (
    <div className="mb-5 w-full"> 
      {label && <label className="block text-sm mb-3">{label}</label>}
      <Select<SelectOption> 
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