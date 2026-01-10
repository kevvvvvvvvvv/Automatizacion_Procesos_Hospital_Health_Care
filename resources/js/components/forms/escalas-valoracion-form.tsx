import { useForm } from '@inertiajs/react';
import React, { useState } from 'react';
import { route } from 'ziggy-js';
import InputText from '../ui/input-text';
import PrimaryButton from '../ui/primary-button';
import { HojaEnfermeria } from '@/types';
import Swal from 'sweetalert2';

interface DolorEntry {
    escala_eva: string;
    ubicacion_dolor: string;
}

interface Props {
    hoja: HojaEnfermeria;
}

const EscalaValoracionForm = ({ hoja }: Props) => {

    const [nuevoDolor, setNuevoDolor] = useState<DolorEntry>({
        escala_eva: '',
        ubicacion_dolor: '',
    });

    const { data, setData, errors, post, processing, reset } = useForm({
        escala_braden: '',
        escala_glasgow: '',
        escala_ramsey: '',
        valoracion_dolor: [] as DolorEntry[], 
    });

    const agregarDolor = () => {
        if(Number(nuevoDolor.escala_eva) < 0 || Number(nuevoDolor.escala_eva) > 10){
            Swal.fire({
                title:'Error',
                text:'Debe ingresar un valor válido para la escala de Eva',
                icon:'error'
            })
            return;
        }
        setData('valoracion_dolor', [...data.valoracion_dolor, nuevoDolor]);
        setNuevoDolor({ escala_eva: '', ubicacion_dolor: '' });
    };

    const eliminarDolor = (indexToRemove: number) => {
        setData('valoracion_dolor', data.valoracion_dolor.filter((_, index) => index !== indexToRemove));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojas-escalas-valoracion.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                setNuevoDolor({ escala_eva: '', ubicacion_dolor: '' });
            },
        });
    };

    return (
        <>
            <form onSubmit={handleSubmit} className="space-y-8">
                
                <section className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 className="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                        Escalas Generales
                    </h2>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <InputText
                            id="escala_glasgow"
                            name="escala_glasgow"
                            label="Escala Glasgow (3-15)"
                            type="number"
                            value={data.escala_glasgow}
                            onChange={(e) => setData('escala_glasgow', e.target.value)}
                            error={errors.escala_glasgow}
                        />
                        <InputText
                            id="escala_braden"
                            name="escala_braden"
                            label="Escala Braden (1-25)"
                            type="number"
                            value={data.escala_braden}
                            onChange={(e) => setData('escala_braden', e.target.value)}
                            error={errors.escala_braden}
                        />
                        <InputText
                            id="escala_ramsey"
                            name="escala_ramsey"
                            label="Escala Ramsey (1-6)"
                            type="number"
                            value={data.escala_ramsey}
                            onChange={(e) => setData('escala_ramsey', e.target.value)}
                            error={errors.escala_ramsey}
                        />
                    </div>
                </section>

                <section className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 className="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                        Valoración del dolor
                    </h2>

                    <div className="flex flex-col md:flex-row gap-4 items-end mb-6 bg-gray-50 p-4 rounded-md">
                        <div className="w-full md:w-1/3">
                            <InputText
                                id="temp_eva"
                                name="temp_eva"
                                type="number"
                                label="Escala EVA (0-10)"
                                value={nuevoDolor.escala_eva}
                                onChange={(e) => setNuevoDolor({ ...nuevoDolor, escala_eva: e.target.value })}
                            />
                        </div>

                        {nuevoDolor.escala_eva !== '' && Number(nuevoDolor.escala_eva) > 0 && (
                            <div className="w-full md:w-1/2 animate-fade-in-down">
                                <InputText
                                    id="temp_ubicacion"
                                    name="temp_ubicacion"
                                    label="Ubicación del dolor"
                                    value={nuevoDolor.ubicacion_dolor}
                                    onChange={(e) => setNuevoDolor({ ...nuevoDolor, ubicacion_dolor: e.target.value })}
                                />
                            </div>
                        )}

                        <button
                            type="button"
                            onClick={agregarDolor}
                            disabled={!nuevoDolor.escala_eva}
                            className="h-10 px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        
                        >
                            Agregar
                        </button>
                    </div>

                    {data.valoracion_dolor.length > 0 ? (
                        <div className="overflow-hidden border border-gray-200 rounded-lg">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Escala EVA</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                        <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {data.valoracion_dolor.map((dolor, index) => (
                                        <tr key={index}>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                {dolor.escala_eva}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {Number(dolor.escala_eva) > 0 ? dolor.ubicacion_dolor : 'Sin dolor'}
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button
                                                    type="button"
                                                    onClick={() => eliminarDolor(index)}
                                                    className="text-red-600 hover:text-red-900 hover:underline"
                                                >
                                                    Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    ) : (
                        <p className="text-sm text-gray-500 italic text-center py-4">
                            No se han agregado valoraciones de dolor aún.
                        </p>
                    )}
                    
                    {errors.valoracion_dolor && (
                        <p className="text-red-500 text-xs mt-2">{errors.valoracion_dolor}</p>
                    )}
                </section>

                <div className="flex justify-end pt-4">
                    <PrimaryButton type="submit" disabled={processing} className="w-full md:w-auto">
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
        </>
    );
};

export default EscalaValoracionForm;