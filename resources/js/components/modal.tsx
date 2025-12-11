import React, { useEffect } from 'react';

interface ModalProps {
    show: boolean;
    onClose: () => void;
    maxWidth?: 'sm' | 'md' | 'lg' | 'xl' | '2xl';
    children: React.ReactNode;
}

export default function Modal({ show = false, maxWidth = '2xl', onClose, children }: ModalProps) {
    
    // Cierra el modal con la tecla ESC
    useEffect(() => {
        const closeOnEscape = (e: KeyboardEvent) => {
            if (e.key === 'Escape' && show) {
                onClose();
            }
        };
        window.addEventListener('keydown', closeOnEscape);
        return () => window.removeEventListener('keydown', closeOnEscape);
    }, [show, onClose]);

    // Evita el scroll del body cuando el modal está abierto
    useEffect(() => {
        if (show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'unset';
        }
    }, [show]);

    if (!show) return null;

    const maxWidthClass = {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[maxWidth];

    return (
        <div className="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0 flex items-center justify-center">
            
            {/* Backdrop (Fondo oscuro) */}
            <div 
                className="fixed inset-0 transform transition-all" 
                onClick={onClose}
            >
                <div className="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            {/* Contenido del Modal */}
            <div className={`mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto ${maxWidthClass} relative z-10`}>
                {children}
            </div>
        </div>
    );
}