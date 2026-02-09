import React from 'react';

interface Props {
    label: string;
    value: boolean | null;
    onChange: (value: boolean) => void;
    error?: string;
}

const BooleanInput = ({ label, value, onChange, error }: Props) => {
    return (
        <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700 mb-2">{label}</label>
            <div className="flex gap-4">
                <button
                    type="button"
                    onClick={() => onChange(true)}
                    className={`px-6 py-2 rounded-md border transition-all ${
                        value === true 
                        ? 'bg-green-100 border-green-500 text-green-700 ring-2 ring-green-200' 
                        : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50'
                    }`}
                >
                    Sí
                </button>
                <button
                    type="button"
                    onClick={() => onChange(false)}
                    className={`px-6 py-2 rounded-md border transition-all ${
                        value === false 
                        ? 'bg-red-100 border-red-500 text-red-700 ring-2 ring-red-200' 
                        : 'bg-white border-gray-300 text-gray-600 hover:bg-gray-50'
                    }`}
                >
                    No
                </button>
            </div>
            {error && <p className="mt-1 text-sm text-red-600">{error}</p>}
        </div>
    );
};

export default BooleanInput;