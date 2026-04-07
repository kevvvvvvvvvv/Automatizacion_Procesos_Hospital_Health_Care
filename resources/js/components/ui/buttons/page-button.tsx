import React from 'react';

interface Props {
    onClick: () => void;
    active: boolean;
    children: React.ReactNode;
}

const ModalButton = ({
    onClick,
    active,
    children
}: Props) => {
    return (
        <button
            onClick={onClick}
            className={`px-4 py-2 rounded-lg font-bold transition-colors ${
                active 
                ? 'bg-blue-600 text-white shadow-md' 
                : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'
            }`}
        >
            {children}
        </button>
    );
}

export default ModalButton;