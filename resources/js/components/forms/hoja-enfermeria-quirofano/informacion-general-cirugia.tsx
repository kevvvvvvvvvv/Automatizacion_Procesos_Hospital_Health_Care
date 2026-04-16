import React from 'react';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeriaQuirofano } from '@/types';

import PrimaryButton from '@/components/ui/primary-button';
import TextAreaInput from '@/components/ui/input-text-area';
import TextInput from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
}

const mediosOxigenoOptions = [
    { value: 'puntas_nasales', label: 'Puntas nasales' },
    { value: 'mascarilla_simple', label: 'Mascarilla simple' },
    { value: 'mascarilla_reservorio', label: 'Mascara reservorio' },
    { value: 'venturi', label: 'Venturi'},
    { value: 'tubo_endotraqueal', label: 'Tubo endotraqueal'},
]

const InformacionGeneralCirugia = ({
    hoja
}: Props) => {

    const {data,setData, errors, processing, patch} = useForm({
        nota_enfermeria: hoja?.nota_enfermeria || '',
        posicion_paciente: hoja?.posicion_paciente || '',
        procedimiento_quirurgico: hoja?.procedimiento_quirurgico || '',
        placa_cauterio: hoja?.placa_cauterio || '',
        medio_oxigeno: hoja?.medio_oxigeno || '',
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

            <SelectInput
                label='Dispositivo de administración de oxígeno'
                value={data.medio_oxigeno}
                onChange={e => setData('medio_oxigeno',e)}
                options={mediosOxigenoOptions}
                error={errors.medio_oxigeno}
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