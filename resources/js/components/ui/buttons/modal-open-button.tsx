import React from 'react';

const buttonThemes = {
  danger: "bg-red-50 border border-red-200 text-red-700 hover:bg-red-100",
  success: "bg-green-50 border border-green-200 text-green-700 hover:bg-green-100",
  primary: "bg-blue-50 border border-blue-200 text-blue-700 hover:bg-blue-100",
  warning: "bg-amber-50 border border-amber-200 text-amber-700 hover:bg-amber-100",
  info: "bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-100",
  neutral: "bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100",
};

const baseClasses = "px-4 py-2 rounded-lg font-bold transition-colors shadow-sm mr-4 inline-flex items-center justify-center";

interface Props {
    onClick: () => void;
    children: React.ReactNode;
    variant?: keyof typeof buttonThemes;
}

const ModalOpenButton = ({
    onClick,
    variant='primary',
    children,
}:Props) => {
    return (
        <>
            <button
                onClick={onClick}
                className={`${baseClasses} ${buttonThemes[variant]}`}
            >
                {children}
            </button>
        </>
    );
}

export default ModalOpenButton;