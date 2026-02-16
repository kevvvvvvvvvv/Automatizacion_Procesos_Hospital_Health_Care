import React from 'react';
import Swal from 'sweetalert2';
import { router, useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';


import PrimaryButton from './ui/primary-button';
import { HojaEnfermeria, HojaEnfermeriaQuirofano } from '@/types';


interface Props {
    routeConfig: {
        name: string;
        params: Record<string, number>;
    };
    title: string;
    hoja: HojaEnfermeria | HojaEnfermeriaQuirofano;

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
            title: '¿Estás seguro de cerrar la hoja?',
            text: "Una vez cerrada, esta hoja no podrá ser modificada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', 
            cancelButtonColor: '#3085d6', 
            confirmButtonText: 'Sí, ¡cerrar hoja!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                put(String(route(routeConfig.name, routeConfig.params)), {
                    onSuccess: () => {
                         Swal.fire(
                            '¡Cerrada!',
                            'La hoja de enfermería ha sido cerrada.',
                            'success'
                        );
                        router.get(route('estancias.show', { estancia: hoja.formulario_instancia.estancia_id }));
                    },
                    onError: () => {
                        Swal.fire(
                            'Error',
                            'No se pudo cerrar la hoja. Intenta de nuevo.',
                            'error'
                        );
                    }
                });
            }
        });
    };

    if (hoja.estado === 'Cerrado') {
        return (
            <div className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                <span className="font-medium">Hoja cerrada:</span> {`Esta ${title} ya ha sido finalizada y no puede ser editada.`}
            </div>
        );
    }

    return (
        <div className="p-4 mb-6 border border-red-300 rounded-lg bg-red-50">
            <h3 className="text-lg font-medium text-red-800">{`Cerrar ${title}`} </h3>
            <p className="mt-1 text-sm text-red-700">
                {`Esta acción finalizará la ${title} y la marcará como "Cerrada".
                No podrás realizar más cambios después de esto.`}
            </p>
            <div className="mt-4">
                <PrimaryButton
                    type="button"
                    className="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:ring-red-500"
                    onClick={handleCerrarHoja}
                    disabled={processing}
                >
                    {processing ? 'Cerrando...' : 'Cerrar hoja permanentemente'}
                </PrimaryButton>
            </div>
        </div>
    );
}

export default CerrarHoja;