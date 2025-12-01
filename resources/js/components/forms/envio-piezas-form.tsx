import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { HojaEnfermeriaQuirofano } from '@/types'; 
import Swal from 'sweetalert2';

// Componentes UI
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';
import PrimaryButton from '@/components/ui/primary-button';

interface EnvioPiezaProps {
    hoja: HojaEnfermeriaQuirofano; 
}

const EnvioPieza: React.FC<EnvioPiezaProps> = ({ hoja }) => {
    
    // 1. Estado Interno del Formulario (Independiente del Padre)
    const { data, setData, post, processing, errors, reset } = useForm({
        estudio_solicitado: '',
        biopsia_pieza_quirurgica: '',
        revision_laminillas: '',
        estudios_especiales: '',
        pcr: '',
        pieza_remitida: '',
        datos_clinicos: '',
        empresa_enviar: '',
    });

    const handleSend = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();

        // 2. Validación básica en frontend
        if (!data.estudio_solicitado || !data.pieza_remitida || !data.datos_clinicos) {
            Swal.fire({
                title: 'Campos Incompletos',
                text: 'Debe especificar al menos: Estudio solicitado, Pieza remitida y Datos clínicos.',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        // 3. Enviar usando el método post() de useForm
        post(route('solicitudes-patologia.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => {
                reset(); // Limpia el formulario al terminar
                Swal.fire({
                    title: 'Éxito',
                    text: 'La solicitud de patología ha sido enviada correctamente.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            onError: () => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al guardar la solicitud. Verifique los campos marcados en rojo.',
                    icon: 'error'
                });
            }
        });
    };

    return (
        <>
            <div className="flex justify-between items-center mb-3 col-span-full">
                <h4 className="text-md font-semibold text-gray-800">
                    Envío de piezas (patología)
                </h4>
            </div>
                        
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 col-span-full">                         
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <InputText
                        label="Estudio solicitado *"
                        id='estudio_solicitado'
                        name='estudio_solicitado'
                        value={data.estudio_solicitado}
                        onChange={(e) => setData('estudio_solicitado', e.target.value)}
                        error={errors.estudio_solicitado}
                    />
                    <InputText
                        label="Biopsia o pieza quirúrgica"
                        id='biopsia_pieza_quirurgica'
                        name='biopsia_pieza_quirurgica'
                        value={data.biopsia_pieza_quirurgica}
                        onChange={(e) => setData('biopsia_pieza_quirurgica', e.target.value)}
                        error={errors.biopsia_pieza_quirurgica}
                    />

                    <InputText
                        label="Revisión de laminillas"
                        id='revision_laminillas'
                        name='revision_laminillas'
                        value={data.revision_laminillas}
                        onChange={(e) => setData('revision_laminillas', e.target.value)}
                        error={errors.revision_laminillas}
                    />

                    <InputText
                        label="Estudios especiales"
                        id='estudios_especiales'
                        name='estudios_especiales'
                        value={data.estudios_especiales}
                        onChange={(e) => setData('estudios_especiales', e.target.value)}
                        error={errors.estudios_especiales}
                    />
                    <InputText
                        label="PCR"
                        id='pcr'
                        name='pcr'
                        value={data.pcr}
                        onChange={(e) => setData('pcr', e.target.value)}
                        error={errors.pcr}
                    />
                    <InputText
                        label="Pieza remitida *"
                        id='pieza_remitida'
                        name='pieza_remitida'
                        value={data.pieza_remitida}
                        onChange={(e) => setData('pieza_remitida', e.target.value)}
                        error={errors.pieza_remitida}
                    />
                </div>

                <InputTextArea
                    label="Datos clínicos (anotar registro previo si existe) *"
                    id="datos_clinicos"
                    name="datos_clinicos"
                    value={data.datos_clinicos}
                    onChange={e => setData('datos_clinicos', e.target.value)}
                    error={errors.datos_clinicos}
                    rows={3}
                />

                <InputText
                    id="empresa_enviar"
                    name="empresa_enviar"
                    label="Empresa a enviar la solicitud de patología"
                    value={data.empresa_enviar}
                    onChange={e => setData('empresa_enviar', e.target.value)}
                    error={errors.empresa_enviar}
                />

                {/* Botón de acción directa */}
                <div className="flex justify-end mt-4">
                    <PrimaryButton 
                        type="button" 
                        onClick={handleSend}
                        disabled={processing}
                    >
                        {processing ? 'Enviando...' : 'Guardar Solicitud de Patología'}
                    </PrimaryButton>
                </div>
            </div>
        </>
    )
}

export default EnvioPieza;