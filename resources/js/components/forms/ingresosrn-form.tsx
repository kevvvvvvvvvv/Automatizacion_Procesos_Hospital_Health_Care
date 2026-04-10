import { RecienNacido, ControlLiquidos } from '@/types';
import React from 'react';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/react';
import { Pencil } from 'lucide-react'; 
import Swal from 'sweetalert2';

import PrimaryButton from '../ui/primary-button'
import InputText from '../ui/input-text';
import { DataTable } from '../ui/data-table';

interface Props {
    hoja: RecienNacido;
}

const IngresosEgresosForm = ({ hoja }: Props) => {
    const { data, setData, errors, post, processing, reset } = useForm({
        seno_materno: '',
        formula: '',
        otros_ingresos: '',
        cantidad_ingresos: '',
        miccion: '',
        evacuacion: '',
        emesis: '',
        otros_egresos: '',
        cantidad_egresos: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar registro?',
            text: "Se guardarán los ingresos y egresos del neonato.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                post(route('hojas-control-liquidos.store', { id: hoja.id }), {
                    preserveScroll: true,
                    onSuccess: () => {
                        reset();
                        Swal.fire('Guardado', 'El registro se creó correctamente', 'success');
                    }
                });
            }
        });
    }

    const renderCelda = (valor: string | number | null) => {
        return valor ? (
            <span className="font-medium text-gray-900">{valor}</span>
        ) : (
            <span className="text-gray-400">-</span>
        );
    };

    const columnasIngresosEgresos = [
        { 
        header: 'Fecha/Hora', 
        key: 'created_at',
        render: (reg: any) => <span className="text-sm">{new Date(reg.created_at).toLocaleString()}</span>
    },
    // Cambia 'seno' por 'seno_materno'
    { header: 'Seno', key: 'seno_materno', render: (reg: any) => renderCelda(reg.seno_materno) },
    { header: 'Fórmula', key: 'formula', render: (reg: any) => renderCelda(reg.formula) },
    { header: 'Micción', key: 'miccion', render: (reg: any) => renderCelda(reg.miccion) },
    { 
        header: 'Balance', 
        key: 'balance_total', // Cambia 'balance' por 'balance_total'
        render: (reg: any) => (
            <span className={`font-bold ${Number(reg.balance_total) >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                {reg.balance_total} ml
            </span>
        )
    },
        {
            header: 'Acción',
            key: 'accion',
            render: (reg: any) => (
                <button onClick={() => console.log("Editar:", reg.id)} className="p-1 text-blue-600 hover:bg-blue-50 rounded-full">
                    <Pencil size={18} />
                </button>
            )
        }
    ];

    return (
        <div className="space-y-8">
            <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 className='mb-6 font-bold text-xl text-black-800 border-b pb-2'>Registro de Ingresos y Egresos</h2>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {/* SECCIÓN INGRESOS */}
                    <div className="space-y-4 bg-blue-50/30 p-4 rounded-md border border-blue-100">
                        <h3 className="font-semibold text-blue-700 text-sm uppercase tracking-wider">Ingresos</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <InputText id='seno' name='seno' label="Seno Materno" value={data.seno_materno} onChange={e => setData('seno_materno', e.target.value)} error={errors.seno_materno} />
                            <InputText id='formula' name='formula' label="Fórmula (ml)" type="number" value={data.formula} onChange={e => setData('formula', e.target.value)} error={errors.formula} />
                            
                            <InputText 
                                id='otros_ingresos' 
                                name='otros_ingresos' 
                                label="Otros Ingresos (Descripción)" 
                                placeholder="Ej. Solución Glucosada"
                                value={data.otros_ingresos} 
                                onChange={e => setData('otros_ingresos', e.target.value)} 
                            />

                            {/* Condicional para cantidad de ingresos */}
                            {data.otros_ingresos.trim() !== '' && (
                                <div className="animate-in slide-in-from-top-2 duration-300">
                                    <InputText 
                                        id='cantidad_ingresos' 
                                        name='cantidad_ingresos' 
                                        label={`Cantidad de ${data.otros_ingresos} (ml)`} 
                                        type="number" 
                                        value={data.cantidad_ingresos} 
                                        onChange={e => setData('cantidad_ingresos', e.target.value)} 
                                        required
                                    />
                                </div>
                            )}
                        </div>
                    </div>

                    {/* SECCIÓN EGRESOS */}
                    <div className="space-y-4 bg-red-50/30 p-4 rounded-md border border-red-100">
                        <h3 className="font-semibold text-red-700 text-sm uppercase tracking-wider">Egresos</h3>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <InputText id="miccion" name='miccion' label="Micción" value={data.miccion} onChange={e => setData('miccion', e.target.value)} error={errors.miccion} />
                            <InputText id='evacuacion' name='evacuacion' label="Evacuación" value={data.evacuacion} onChange={e => setData('evacuacion', e.target.value)} error={errors.evacuacion} />
                            <InputText id='emesis' name='emesis' label="Emesis (ml)" type="number" value={data.emesis} onChange={e => setData('emesis', e.target.value)} />
                            
                            <InputText 
                                id='otros_egresos' 
                                name='otros_egresos' 
                                label="Otros Egresos (Descripción)" 
                                placeholder="Ej. Sonda"
                                value={data.otros_egresos} 
                                onChange={e => setData('otros_egresos', e.target.value)} 
                            />

                            {/* Condicional para cantidad de egresos */}
                            {data.otros_egresos.trim() !== '' && (
                                <div className="animate-in slide-in-from-top-2 duration-300">
                                    <InputText 
                                        id='cantidad_egresos' 
                                        name='cantidad_egresos' 
                                        label={`Cantidad de ${data.otros_egresos} (ml)`} 
                                        type="number" 
                                        value={data.cantidad_egresos} 
                                        onChange={e => setData('cantidad_egresos', e.target.value)} 
                                        required
                                    />
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div className='flex justify-end mt-8'>
                    <PrimaryButton disabled={processing} type='submit'>
                        {processing ? 'Registrando...' : 'Guardar Control'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-8">
                <h3 className="text-lg font-bold mb-4 text-gray-700">Historial de Controles</h3>
                <DataTable 
                    columns={columnasIngresosEgresos} 
                    data={hoja.hoja_ingresos_egresos_rn || []} 
                />
            </div>
        </div>
    );
};

export default IngresosEgresosForm;