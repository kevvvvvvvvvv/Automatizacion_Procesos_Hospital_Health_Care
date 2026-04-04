import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import TextInput from '../ui/input-text';
import PrimaryButton from '../ui/primary-button';
import { SesionCaja } from '@/types';

interface Props {
    onClose: () => void;
    sesion: SesionCaja;
    fondo: SesionCaja;
}

const ModalCierreCaja = ({ 
    onClose,
    sesion,
    fondo,
}: Props) => {
    const { data, setData, post, processing, errors } = useForm({
        monto_declarado: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Cerrar el turno?',
            text: "Se realizará el corte de caja y esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',  
            confirmButtonText: 'Sí, cerrar caja',
            cancelButtonText: 'Cancelar',
            reverseButtons: true 
        }).then((result) => {
            if (result.isConfirmed) {
                post(route('caja-cerrar'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        onClose();
                    },
                });
            }
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-opacity-60 p-4 backdrop-blur-sm">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl border-t-4 border-red-500">
                
                <h3 className="mb-2 text-xl font-bold text-gray-800">Corte y cierre de caja</h3>
                <p className="mb-6 text-sm text-gray-500">
                    Por favor, cuenta el dinero físico que hay en el cajón y escribe el total. El sistema calculará automáticamente si hay algún faltante o sobrante.
                </p>
                <p>Dinero esperado en caja: {sesion.monto_esperado}</p>
                <p>Dinero esperado en fondo: {fondo.monto_esperado}</p>

                <form onSubmit={handleSubmit} className="space-y-4">
                    <TextInput
                        id=''
                        name=''
                        label='Monto'
                        value={data.monto_declarado}
                        onChange={e=>setData('monto_declarado',e.target.value)}
                        error={errors.monto_declarado}
                    />

                    <div className="mt-8 flex justify-end space-x-3">
                        <PrimaryButton
                            type='submit'
                            disabled={processing}
                        >
                            Cerrar
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalCierreCaja;