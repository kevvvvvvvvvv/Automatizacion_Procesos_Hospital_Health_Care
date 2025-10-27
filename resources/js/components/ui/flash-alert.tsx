import React, { useState, useEffect } from 'react';
import { Transition } from '@headlessui/react';

interface AlertProps {
    message: string | null;
    type: 'success' | 'error';
    onClose: () => void;
}

const FlashAlert: React.FC<AlertProps> = ({ message, type, onClose }) => {
    const [isVisible, setIsVisible] = useState(false);

    const baseStyles = "fixed top-5 right-5 z-50 p-4 rounded-lg shadow-lg flex items-center max-w-sm";
    
    const typeStyles = {
        success: "bg-green-100 border border-green-400 text-green-700",
        error: "bg-red-100 border border-red-400 text-red-700"
    };

    const icons = {
        success: (
            <svg className="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
            </svg>
        ),
        error: (
            <svg className="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
            </svg>
        )
    };

    useEffect(() => {
        if (message) {
            setIsVisible(true);
            const timer = setTimeout(() => {
                handleClose();
            }, 5000); 
            return () => clearTimeout(timer);
        } else {
            setIsVisible(false);
        }
    }, [message]); 

    const handleClose = () => {
        setIsVisible(false);
        setTimeout(() => {
            onClose(); 
        }, 300); 
    };

    return (
        <Transition
            show={isVisible}
            enter="transition ease-out duration-300"
            enterFrom="transform opacity-0 scale-95 translate-x-10"
            enterTo="transform opacity-100 scale-100 translate-x-0"
            leave="transition ease-in duration-300"
            leaveFrom="transform opacity-100 scale-100 translate-x-0"
            leaveTo="transform opacity-0 scale-95 translate-x-10"
        >
            <div className={`${baseStyles} ${typeStyles[type]}`} role="alert">
                {icons[type]}
                <span className="flex-1">{message}</span>
                <button
                    type="button"
                    className={`ml-3 -mr-1 -my-1 p-1 rounded-md ${typeStyles[type]} opacity-70 hover:opacity-100`}
                    onClick={handleClose}
                    aria-label="Cerrar"
                >
                    <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                    </svg>
                </button>
            </div>
        </Transition>
    );
};

export default FlashAlert;
