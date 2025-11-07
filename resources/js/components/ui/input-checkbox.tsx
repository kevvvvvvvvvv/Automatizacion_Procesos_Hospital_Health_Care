import React from 'react';

interface CheckboxProps extends React.InputHTMLAttributes<HTMLInputElement> {
    label: string;
    id: string;
    error?: string;
}

const Checkbox: React.FC<CheckboxProps> = ({
    label,
    id,
    error,
    checked,
    onChange,
    ...props 
}) => {
    return (
        <div className="relative flex items-start">
            <div className="flex h-6 items-center">
                <input
                    id={id}
                    name={id} 
                    type="checkbox"
                    checked={checked}
                    onChange={onChange}
                    {...props}
                    className="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-600"
                />
            </div>
            <div className="ml-3 text-sm leading-6">
                <label htmlFor={id} className="font-medium text-gray-900 cursor-pointer">
                    {label}
                </label>
                {error && (
                    <p className="mt-1 text-xs text-red-600">{error}</p>
                )}
            </div>
        </div>
    );
};

export default Checkbox;