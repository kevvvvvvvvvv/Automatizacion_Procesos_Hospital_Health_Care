import React, { useState } from 'react'; // Importar useState
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, ProductoServicio } from '@/types';
import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import InputDateTime from '@/components/ui/input-date-time';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';

interface TerapiaAgregada {
    solucion_id: string;
    solucion_nombre: string;
    flujo: string;
    fecha_hora_inicio: string;
    temp_id: string; 
}

interface Props {
    hoja: HojaEnfermeria;
    soluciones: ProductoServicio[];
}

const TerapiaIVForm: React.FC<Props> = ({ hoja, soluciones }) => {

    const handleUpdateTerapia = (terapiaId: string, newDate: string) => {

        if (!newDate) {
            console.error('[handleUpdateTerapia] La fecha está vacía.');
            return; 
        }

        const routeParams = { 
            hojasenfermeria: hoja.id, 
            hojasterapiasiv: terapiaId 
        };

        router.patch(route('hojasterapiasiv.update', routeParams), {
            fecha_hora_inicio: newDate
        }, {
            preserveScroll: true,
            onSuccess: () => {
            },
            onError: (errors) => {
                alert('Error al actualizar la fecha: \n' + JSON.stringify(errors));
            }
        });
    }

    const solucionesOptions = soluciones.map(s =>({
        label: s.nombre_prestacion,
        value: s.id.toString()
    }));

    const [localData, setLocalData] = useState({
        solucion_id: '',
        solucion_nombre: '',
        flujo: '',
        fecha_hora_inicio: '',
    });

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        terapias_agregadas: [] as TerapiaAgregada[],
    });

    const handleAddToList = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (!localData.solucion_id || !localData.flujo) {
            alert("Debe seleccionar una solución y un flujo.");
            return;
        }

        const nuevaTerapia: TerapiaAgregada = {
            ...localData,
            temp_id: crypto.randomUUID(),
        };

        setData('terapias_agregadas', [...data.terapias_agregadas, nuevaTerapia]);

        setLocalData({
            solucion_id: '',
            solucion_nombre: '',
            flujo: '',
            fecha_hora_inicio: '',
        });
    }
    
    const handleRemoveFromList = (temp_id: string) => {
        setData('terapias_agregadas', 
            data.terapias_agregadas.filter(t => t.temp_id !== temp_id)
        );
    }

    const handleSubmitList = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasterapiasiv.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => {
                reset(); 
            }
        });
    }

    const handleRemoveSavedTerapia = (terapiaId: string) => {
        if (confirm('¿Seguro que deseas eliminar esta terapia (ya guardada)?')) {
            router.delete(route('hojastetapiasiv.destroy', { 
                hojaenfermeria: hoja.id,
                terapiaiv: terapiaId 
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <SelectInput
                    label="Solución"
                    options={solucionesOptions}
                    value={localData.solucion_id} 
                    onChange={(value) => {
                        const sel = solucionesOptions.find(o => o.value === value);
                        setLocalData(d => ({
                            ...d, 
                            solucion_id: value as string,
                            solucion_nombre: sel ? sel.label : ''
                        }))
                    }}
                    error={errors['terapias_agregadas.0.solucion_id']} 
                />
                <InputText 
                    id="flujo_local"
                    name="flujo"
                    label="Flujo (ml/hr)" 
                    type="number"
                    value={localData.flujo} 
                    onChange={e => setLocalData(d => ({...d, flujo: e.target.value}))} 
                    error={errors['terapias_agregadas.0.flujo']}
                />
            </div>
            <div className="flex justify-end mt-4">
                <PrimaryButton type="button" onClick={handleAddToList}>
                    Agregar a la lista
                </PrimaryButton>
            </div>

            <form onSubmit={handleSubmitList} className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Terapias pendientes por guardar</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Terapias guardadas con éxito.</div>}
                
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.terapias_agregadas.length === 0 ? (
                                <tr>
                                    <td colSpan={4} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay terapias pendientes.
                                    </td>
                                </tr>
                            ) : (
                                data.terapias_agregadas.map((terapia) => (
                                    <tr key={terapia.temp_id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">{terapia.solucion_nombre}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{terapia.flujo}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{terapia.fecha_hora_inicio}</td>
                                        <td className="px-4 py-4 text-sm">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveFromList(terapia.temp_id)}
                                                className="text-yellow-600 hover:text-yellow-900"
                                            >
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
                <div className="flex justify-end mt-4">
                    <PrimaryButton type="submit" disabled={processing || data.terapias_agregadas.length === 0}>
                        {processing ? 'Guardando...' : 'Guardar Lista de Terapias'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Terapias intravenosas ya guardadas</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <tbody className="bg-white divide-y divide-gray-200">
                            {hoja.hojas_terapia_i_v?.map((terapia) => (
                                <tr key={terapia.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">{terapia.solucion?.nombre_prestacion || '...'}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.flujo_ml_hora}</td>
                                    <td className="px-2 py-1 text-sm text-gray-500" style={{ minWidth: '200px' }}>
                                        <InputDateTime
                                            id={`fecha_saved_${terapia.id}`}
                                            name={`fecha_saved_${terapia.id}`}
                                            label=""
                                            value={terapia.fecha_hora_inicio}
                                            onChange={(newDate) => {
                                                handleUpdateTerapia(terapia.id, newDate as string);
                                            }}
                                        />
                                    </td>

                                    <td className="px-4 py-4 text-sm">
                                        <button
                                            type="button"
                                            onClick={() => handleRemoveSavedTerapia(terapia.id)}
                                            className="text-red-600 hover:text-red-900"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default TerapiaIVForm;