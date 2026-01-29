import React from 'react';
import { useForm } from '@inertiajs/react';
import { Estancia, User } from '@/types';
import { route } from 'ziggy-js';

import EnvioPieza from './envio-piezas';
import SelectInput from '../ui/input-select';
import PrimaryButton from '../ui/primary-button';

interface Props {
    medicos: User[];
    modeloId: number;
    modeloTipo: string;
    estancia: Estancia;
}

const EnvioPiezaHojaEnfermeria = ({medicos, modeloId, modeloTipo, estancia}: Props) => {

    const medicosOptions = medicos.map((medico)=>(
        { value: medico.id, label: medico.nombre + " " + medico.apellido_paterno + " " + medico.apellido_materno }
    ));

    const { data, setData, errors, processing, post, reset} = useForm({
        user_solicita_id: '',
        estudio_solicitado: '',
        biopsia_pieza_quirurgica: '',
        revision_laminillas: '',
        estudios_especiales: '',
        pcr: '',
        pieza_remitida: '',
        datos_clinicos: '',
        empresa_enviar: '',    
        itemable_id: modeloId,
        itemable_type: modeloTipo,
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('solicitudes-patologias.store',{estancia: estancia.id}),{
            preserveScroll: true,
            onSuccess:() => reset(),
        });
    }

    return (
        <>
            <form onSubmit={handleSubmit}>
                <SelectInput
                    label="Medico solicita"
                    options={medicosOptions}
                    value={data.user_solicita_id}
                    onChange={(e)=>setData('user_solicita_id',e)}
                />

                <EnvioPieza
                    data={data}
                    setData={setData}
                    errors={errors}
                />

                <div className="flex justify-end mt-5">
                    <PrimaryButton type='submit'>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
        </>
    )
}

export default EnvioPiezaHojaEnfermeria;