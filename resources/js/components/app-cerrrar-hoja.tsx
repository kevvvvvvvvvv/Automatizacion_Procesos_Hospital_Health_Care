import React from 'react';
import Swal from 'sweetalert2';
import { router, useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import PrimaryButton from './ui/primary-button';
import { HojaEnfermeria, HojaEnfermeriaQuirofano, RecienNacido } from '@/types';

interface Props {
    routeConfig: {
        name: string;
        params: Record<string, any>; 
    };
    title: string;
    hoja: HojaEnfermeria | HojaEnfermeriaQuirofano | RecienNacido;
}

const CerrarHoja = ({
    routeConfig,
    title,
    hoja
}: Props) => {
    const { put, processing } = useForm({
        estado: 'Cerrado',
    });

    const handleCerrarHoja = () => {
        Swal.fire({
            title: `¿Estás seguro de cerrar la ${title}?`,
            text: "Una vez cerrada, no podrá ser modificada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', 
            cancelButtonColor: '#3085d6', 
            confirmButtonText: 'Sí, ¡cerrar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                put(route(routeConfig.name, routeConfig.params), {
                    onSuccess: () => {
                        Swal.fire('¡Cerrada!', `La ${title} ha sido cerrada.`, 'success');
                    
                        const estanciaId = hoja.formulario_instancia?.estancia_id;

                        if (estanciaId) {
                            router.get(route('estancias.show', { estancia: estanciaId }));
                        }
                    },
                    onError: () => {
                        Swal.fire('Error', 'No se pudo cerrar. Intenta de nuevo.', 'error');
                    }
                });
            }
        });
    };

    if (hoja.estado === 'Cerrado') {
        return (
            <div className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 border border-green-200" role="alert">
                <span className="font-medium">Registro cerrado:</span> {`Este ${title} ya ha sido finalizado y no permite más ediciones.`}
            </div>
        );
    }

    return (
        <div className="p-4 mb-6 border border-red-300 rounded-lg bg-red-50">
            <h3 className="text-lg font-medium text-red-800">Cerrar {title}</h3>
            <p className="mt-1 text-sm text-red-700">
                Esta acción marcará el registro como <strong>"Cerrado"</strong> permanentemente.
            </p>
            <div className="mt-4">
                <PrimaryButton
                    type="button"
                    className="bg-red-600 hover:bg-red-700"
                    onClick={handleCerrarHoja}
                    disabled={processing}
                >
                    {processing ? 'Cerrando...' : `Finalizar ${title}`}
                </PrimaryButton>
            </div>
        </div>
    );
}

export default CerrarHoja;