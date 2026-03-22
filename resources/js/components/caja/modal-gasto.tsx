import React from 'react';
import { useForm } from '@inertiajs/react';

import SelectInput from '@/components/ui/input-select';
import TextInput from '@/components/ui/input-text';

interface Props {
    onClose: () => void;
}

const tipoMovimientoOptions = [
    { value: 'gasto', label: 'Retiro / Gasto (-)' },
    { value: 'ingreso', label: 'Ingreso extra'}
]

const ModalGasto = ({ onClose }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        tipo: 'egreso', 
        monto: '',
        concepto: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/caja/movimiento', {
            preserveScroll: true,
            onSuccess: () => {
                reset(); 
                onClose(); 
            },
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50 p-4">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl">
                
                
                <button onClick={onClose} className="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 className="mb-5 text-xl font-bold text-gray-800">Registrar movimiento</h3>

                <form onSubmit={handleSubmit} className="space-y-4">
                    
                    <SelectInput
                        label='Tipo'
                        options={tipoMovimientoOptions}
                        value={data.tipo}
                        onChange={e=>setData('tipo',e)}
                        error={errors.tipo}
                    />

                    <TextInput
                        id='concepto'
                        name='concepto'
                        label='Concepto'
                        value={data.concepto}
                        onChange={e=>setData('concepto',e.target.value)}
                        error={errors.concepto}
                    />

                    <TextInput
                        id=''
                        name=''
                        label='Monto'
                        value={data.monto}
                        onChange={e=>setData('monto',e.target.value)}
                        type='number'
                        error={errors.concepto}
                    />

                    <div className="mt-6 flex justify-end space-x-3">
                        <button 
                            type="button" 
                            onClick={onClose}
                            className="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            disabled={processing}
                            className="rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                        >
                            {processing ? 'Guardando...' : 'Guardar Movimiento'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalGasto;