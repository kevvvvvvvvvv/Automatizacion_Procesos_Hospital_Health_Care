import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { HojaEnfermeriaQuirofano, User } from '@/types';

import SelectInput from '@/components/ui/input-select';
import TextInput from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';

interface Props {
    onClose: () => void;
    enfermeras: User[];
    hoja: HojaEnfermeriaQuirofano;
}




const ModalRelevarTurno = ({ 
    onClose,
    enfermeras =[],
    hoja
}: Props) => {

    const enfermerasOptions = enfermeras.map( e => (
        { value: e.id , label: e.nombre_completo}
    ))

    const {data, setData, processing, errors, post} = useForm({
        user_id: '',
        observaciones_entrega: '',
    })

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('relevar-turno',{hoja: hoja.id}),{
            onSuccess: onClose,
        });
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-opacity-50 backdrop-blur-sm p-4">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl">
                <button onClick={onClose} className="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 className="mb-5 text-xl font-bold text-gray-800">Registrar movimiento</h3>

                <form onSubmit={handleSubmit} className="space-y-4"></form>
                
                <SelectInput
                    label = 'Enfermera(o) que relevará'
                    options={enfermerasOptions}
                    onChange={e => setData('user_id',e)}
                    value={data.user_id}
                />

                <TextInput
                    id=''
                    name=''
                    label='Observaciones'
                    value={data.observaciones_entrega}
                    onChange={e => setData('observaciones_entrega',e.target.value)}
                    error={errors.observaciones_entrega}
                />
                <div className='flex justify-end'>
                    <PrimaryButton
                        disabled={processing}
                        type='submit'
                    >
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </div>
        </div>
    );
};

export default ModalRelevarTurno;