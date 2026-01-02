import React, { useState } from 'react'; // Importar useState
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, ProductoServicio } from '@/types';
import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';

interface TerapiaAgregada {
    solucion_id: string;
    solucion_nombre: string;
    duracion: number;
    cantidad: number;
    flujo: number
    fecha_hora_inicio: string;
    temp_id: string; 
}

interface Props {
    hoja: HojaEnfermeria;
    soluciones: ProductoServicio[];
}

const formatDateTime = (isoString: string | null) => {
    if (!isoString) return 'Pendiente';
    return new Date(isoString).toLocaleString('es-MX', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
};

const TerapiaIVForm: React.FC<Props> = ({ hoja, soluciones }) => {

    const handleDateUpdate = (terapiaId: number, newDate: string) => {
        if (!newDate) {
            console.warn("La fecha está vacía, no se guardará.");
            return;
        }

        router.patch(route('hojasterapiasiv.update', { 
            hojasenfermeria: hoja.id, 
            hojasterapiasiv: terapiaId 
        }), {
            fecha_hora_inicio: newDate 
        }, {
            preserveScroll: true,
            onError: (errors) => {
                alert('Error al actualizar: \n' + JSON.stringify(errors));
            }
        });
    };

    const solucionesOptions = soluciones.map(s =>({
        label: s.nombre_prestacion,
        value: s.id.toString()
    }));

    const [localData, setLocalData] = useState({
        solucion_id: '',
        solucion_nombre: '',
        cantidad: '',
        duracion: '',
        fecha_hora_inicio: '',
    });

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        terapias_agregadas: [] as TerapiaAgregada[],
    });

    const handleAddToList = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (!localData.solucion_id) {
            alert("Debe seleccionar una solución y un flujo.");
            return;
        }
        const cantidadNum = Number(localData.cantidad);
        const duracionNum = Number(localData.duracion);
        let flujoCalculado = 0;


        if (duracionNum > 0) {
            flujoCalculado = cantidadNum / duracionNum;
        }

        const nuevaTerapia: TerapiaAgregada = {
            ...localData,
            duracion: Number(localData.duracion), 
            cantidad: Number(localData.cantidad), 
            flujo: flujoCalculado,
            temp_id: crypto.randomUUID(),
        };

        setData('terapias_agregadas', [...data.terapias_agregadas, nuevaTerapia]);

        setLocalData({
            solucion_id: '',
            solucion_nombre: '',
            cantidad: '',
            duracion: '',
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
                    id="cantidad"
                    name="cantidad"
                    label="Cantidad (mililitros)"
                    type="number"
                    value={localData.cantidad}
                    onChange={e => setLocalData(d => ({...d, cantidad: e.target.value}))}
                    error={errors['terapias_agregadas.0.cantidad']}
                />

                <InputText
                    id="duracion"
                    name="duracion"
                    label="Duración"
                    type="number"
                    value={localData.duracion}
                    onChange={e => setLocalData(d => ({...d, duracion: e.target.value}))}
                    error={errors['terapias_agregadas.0.duracion']}
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
                        <thead>
                            <tr className="text-left">
                                <th className="px-4 py-4 text-sm text-gray-900">Solución</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Cantidad</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Flujo</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
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
                                        <td className="px-4 py-4 text-sm text-gray-900">{terapia.cantidad}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{terapia.duracion}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">
                                            {
                                                terapia.duracion > 0 
                                                    ? (terapia.cantidad / terapia.duracion).toFixed(2) + ' ml/hr' 
                                                    : 'N/A'
                                            }
                                        </td>
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
                        {processing ? 'Guardando...' : 'Guardar lista de terapias'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Terapias intravenosas ya guardadas</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className="text-left">
                                <th className="px-4 py-4 text-sm text-gray-900">Solución</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Cantidad</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Flujo</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {hoja.hojas_terapia_i_v?.length === 0 ? (
                                <tr>
                                    <td colSpan={4} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay terapias registradas.
                                    </td>
                                </tr>
                            ) : (
                            hoja.hojas_terapia_i_v?.map((terapia) => (
                                <tr key={terapia.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">{terapia.detalle_soluciones?.nombre_prestacion || '...'}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.cantidad}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.duracion}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.flujo_ml_hora}</td>
                                    <td className="px-2 py-1 text-sm text-gray-500" style={{ minWidth: '200px' }}>
                                        {terapia.fecha_hora_inicio ? (
                                            <span>{formatDateTime(terapia.fecha_hora_inicio)}</span>
                                        ): (
                                            <PrimaryButton
                                                type="button"
                                                onClick={() => {
                                                    const now_iso = new Date().toISOString();
                                                    handleDateUpdate(terapia.id, now_iso);
                                                }}
                                            >
                                                Registrar inicio
                                            </PrimaryButton>
                                        )}
                                    </td>

                                    <td className="px-4 py-4 text-sm">
                                        <button
                                            type="button"
                                            onClick={() => handleRemoveSavedTerapia(terapia.id.toString())}
                                            className="text-red-600 hover:text-red-900"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            )))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default TerapiaIVForm;