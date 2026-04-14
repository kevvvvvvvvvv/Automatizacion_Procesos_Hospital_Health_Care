import { InputHTMLAttributes } from 'react';
import CurrencyInput from 'react-currency-input-field';

interface MoneyInputProps extends Omit<InputHTMLAttributes<HTMLInputElement>, 'value' | 'onChange' | 'defaultValue'> {
    label?: string; 
    id: string;
    name: string;
    value?: string | number | null; 
    onValueChange: (value: string | undefined, name?: string) => void;
    error?: string;
    placeholder?: string;
    step?: number;
}

export default function MoneyInput({ 
    label, 
    id, 
    name, 
    value, 
    onValueChange, 
    error, 
    placeholder = "$ 0.00",
    className = "", 
    ...props 
}: MoneyInputProps) {
    return (
        <div className="w-full mb-4">
            {label && (
                <label 
                    htmlFor={id} 
                    className={`block text-sm font-medium mb-1 ${
                        error ? 'text-red-500' : 'text-gray-700'
                    } ${props.disabled ? 'opacity-60 cursor-not-allowed' : ''}`}
                >
                    {label}
                </label>
            )}
            
            <CurrencyInput
                id={id}
                name={name}
                placeholder={placeholder}
                decimalsLimit={2}
                prefix="$ "
                value={value ?? ''}
                onValueChange={(val) => onValueChange(val)}
                {...props}
                className={`
                    w-full px-3 py-2 rounded-md shadow-sm 
                    border text-gray-900 bg-white placeholder-gray-400 
                    focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56]
                    transition
                    ${error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-600'}
                    ${props.disabled ? 'bg-gray-200 cursor-not-allowed opacity-60' : ''}
                    ${className} 
                `}
            />
            
            {error && (
                <p className="mt-1 text-sm text-red-600">{error}</p>
            )}
        </div>
    );
}