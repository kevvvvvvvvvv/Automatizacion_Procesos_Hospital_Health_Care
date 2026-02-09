import React from 'react';

interface Props {
    label: string;
    value: number;
    onChange: (value: number) => void;
    error?: string;
}

const RatingInput = ({ label, value, onChange, error }: Props) => {
    return (
        <div className="mb-4">
            <label className="block text-sm font-medium text-gray-700 mb-2">{label}</label>
            <div className="flex gap-2">
                {[1, 2, 3, 4, 5].map((num) => (
                    <button
                        key={num}
                        type="button"
                        onClick={() => onChange(num)}
                        className={`w-10 h-10 rounded-full border transition-colors ${
                            value === num 
                            ? 'bg-blue-600 text-white border-blue-600' 
                            : 'bg-white text-gray-600 border-gray-300 hover:border-blue-400'
                        }`}
                    >
                        {num}
                    </button>
                ))}
            </div>
            {error && <p className="mt-1 text-sm text-red-600">{error}</p>}
        </div>
    );
};

export default RatingInput;