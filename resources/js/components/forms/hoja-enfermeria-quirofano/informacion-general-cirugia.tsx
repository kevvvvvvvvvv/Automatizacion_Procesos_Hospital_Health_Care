import React from 'react';
import { route } from 'ziggy-js';

import PrimaryButton from '@/components/ui/primary-button';
import TextAreaInput from '@/components/ui/input-text-area';
import TextInput from '@/components/ui/input-text';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeriaQuirofano } from '@/types';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
}

const InformacionGeneralCirugia = ({
    hoja
}: Props) => {

    const {data,setData, errors, processing, patch} = useForm({
        nota_enfermeria: hoja?.nota_enfermeria || '',
        posicion_paciente: hoja?.posicion_paciente || '',
        procedimiento_quirurgico: hoja?.procedimiento_quirurgico || '',
        placa_cauterio: hoja?.placa_cauterio || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault()
        patch(route('hojasenfermeriasquirofanos.update', { hojasenfermeriasquirofano: hoja.id }));
    }

    return (
        <>  
            <form onSubmit={handleSubmit}>
            <TextAreaInput
                label="Nota de enfermería"
                value={data.nota_enfermeria}
                onChange={e => setData('nota_enfermeria', e.target.value)}
                error={errors.nota_enfermeria}
            />

            <TextAreaInput
                label="Procedimiento quirúrgico"
                value={data.procedimiento_quirurgico}
                onChange={e => setData('procedimiento_quirurgico',e.target.value)}
                error={errors.procedimiento_quirurgico}
            />

            <TextAreaInput
                label='placa de cauterio'
                value={data.placa_cauterio}
                onChange={e => setData('placa_cauterio',e.target.value)}
                error={errors.placa_cauterio}
            />

            <TextInput
                id=''
                name=''
                label='Posicion del paciente'
                value={data.posicion_paciente}
                onChange={e => setData('posicion_paciente',e.target.value)}
                error={errors.posicion_paciente}
            />
            <div className='flex justify-end'>
                <PrimaryButton
                    disabled={processing}
                    type='submit'
                >
                    {processing ? 'Guardando...' : 'Guardar'}
                </PrimaryButton>
            </div>
            </form>
        </>
    );
}

export default InformacionGeneralCirugia;