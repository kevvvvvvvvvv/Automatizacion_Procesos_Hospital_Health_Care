import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { HojaEnfermeriaQuirofano, Isquemia } from '@/types';
import { formatDate } from '@/utils/date-utils';
import { router } from '@inertiajs/react';
import Swal  from 'sweetalert2';

import TextInput from '@/components/ui/input-text';
import { DataTable } from '@/components/ui/data-table';
import PrimaryButton from '@/components/ui/primary-button';
import ContadorTiempo from '@/components/counter-time';

interface Props {
    isquemiable_id: number;
    isquemiable_type: string;    
    hoja: HojaEnfermeriaQuirofano;
}

const IsquemiaFields = ({ 
    isquemiable_id,
    isquemiable_type,
    hoja
 }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        isquemiable_id: isquemiable_id,
        isquemiable_type: isquemiable_type,
        sitio_anatomico: '',
        hora_inicio: '',
        hora_termino: '',
        observaciones: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('isquemias.store'), {
            onSuccess: () => {
                reset();
            },
        });
    };

    const columnasIsquemias = [
        {
            header: 'Fecha/Hora',
            key: 'created_at',
            render: (reg: Isquemia) => (
                <span>
                    {formatDate(reg.created_at)}
                </span>
            ) 
        },
        {
            header: 'Hora incio',
            key: 'hora_inicio',
            render: (reg: Isquemia) => (
                <span>
                    {reg.hora_inicio ? (
                        <span>
                            {formatDate(reg.hora_inicio)}
                        </span>
                    ):(
                        <PrimaryButton
                            onClick={() => {
                                Swal.fire({
                                    title: '¿Iniciar isquemia?',
                                    text: "Se registrará la hora actual como inicio del proceso.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, iniciar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        router.post(route('isquemias.horaInicio', { id: reg.id }), {}, {
                                            preserveScroll: true 
                                        });
                                    }
                                });
                            }}
                        >
                            Iniciar
                        </PrimaryButton>
                    )}
                </span>
            )
        },
        {
            header:'Tiempo transcurrido',
            key: 'tiempo_transcurrido',
            render: (reg: Isquemia) => (
                <span>
                    <ContadorTiempo
                        fechaInicioISO={reg.hora_inicio}
                        fechaFinISO={reg.hora_termino}
                    />
                </span>
            )
        },
        {
            header: 'hora_termino',
            key: 'hora_termino',
            render: (reg: Isquemia) => (
                <span>
                    {reg.hora_termino ? (
                        <span>
                            {formatDate(reg.hora_termino)}
                        </span>
                    ):(
                        <PrimaryButton
                            onClick={() => {
                                Swal.fire({
                                    title: '¿Finalizar isquemia?',
                                    text: "Se registrará la hora actual como fin del proceso.",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, finalizar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        router.post(route('isquemias.horaFin', { id: reg.id }), {}, {
                                            preserveScroll: true 
                                        });
                                    }
                                });
                            }}
                        >
                            Finalizar
                        </PrimaryButton>
                    )}
                </span>
            )
        },
        {
            header: 'Observaciones',
            key: 'observaciones'
        },
    ];

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <TextInput
                        id=''
                        name=''
                        label='Sitio anatómico'
                        value={data.sitio_anatomico}
                        onChange={e=>setData('sitio_anatomico',e.target.value)}
                        error={errors.sitio_anatomico}
                    />

                    <TextInput
                        id=''
                        name=''
                        label='Observaciones'
                        value={data.observaciones}
                        onChange={e=>setData('observaciones',e.target.value)}
                        error={errors.observaciones}        
                    />
                </div>
                <div className="mt-6 mb-6 flex justify-end">
                    <PrimaryButton
                        disabled={processing}
                        type='submit'
                    >
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
            <div>
                <DataTable 
                    columns={columnasIsquemias} data={hoja.isquemias}
                />
            </div>
        </div>
    );
};

export default IsquemiaFields;