import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, HojaSondaCateter, Estancia } from '@/types'; 
import { route } from 'ziggy-js';

import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';
import PrimaryButton from '@/components/ui/primary-button';

const opcionesDispositivo = [
    { value: '', label: 'Seleccionar un dispositivo...' },
    { value: 'Catéter venoso central', label: 'Catéter venoso central' },
    { value: 'Sonda vesical', label: 'Sonda vesical' },
    { value: 'Sonda nasogástrica', label: 'Sonda nasogástrica' },
    { value: 'Catéter venoso', label: 'Catéter venoso' }
];

interface Props {
    hoja: HojaEnfermeria;
    estancia:Estancia;
}

const SondasCateteresForm: React.FC<Props> = ({ hoja, estancia }) => {

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        tipo_dispositivo: '',
        calibre: '',
        fecha_instalacion: '',
        fecha_caducidad: '',
        observaciones: '',
    });

    const handleTipoChange = (value: string) => {
        setData(currentData => ({
            ...currentData,
            tipo_dispositivo: value,
            ...(value === '' && {
                calibre: '',
                fecha_instalacion: '',
                fecha_caducidad: '',
                observaciones: '',
            })
        }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojassondascateters.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }

    const handleRemoveSaved = (sondaId: number) => {
        if (confirm('¿Seguro que deseas eliminar este registro?')) {
            router.delete(route('hojasondas.destroy', { 
                hojaenfermeria: hoja.id, 
                sonda: sondaId 
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <h3 className="text-lg font-semibold mb-4">Registrar Nuevo Dispositivo</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Dispositivo guardado.</div>}
                
                <SelectInput
                    label="Tipo de Dispositivo"
                    options={opcionesDispositivo}
                    value={data.tipo_dispositivo} 
                    onChange={(value) => handleTipoChange(value as string)}
                    error={errors.tipo_dispositivo}
                />

                {data.tipo_dispositivo && (
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 border-t pt-6">
                        <InputText 
                            id="calibre"
                            name="calibre"
                            label="Calibre"
                            value={data.calibre}
                            onChange={e => setData('calibre', e.target.value)}
                            error={errors.calibre}
                        />

                        <InputText 
                            id="dispositivo_fecha_instalacion"
                            name="dispositivo_fecha_instalacion"
                            label="Fecha de Instalación"
                            type="date"
                            value={data.fecha_instalacion} 
                            onChange={e => setData('fecha_instalacion', e.target.value)}
                            error={errors.fecha_instalacion}
                        />

                        <InputText 
                            id="dispositivo_fecha_colocacion"
                            name="dispositivo_fecha_colocacion"
                            label="Fecha de Colocación"
                            type="date"
                            value={data.fecha_caducidad} 
                            onChange={e => setData('fecha_caducidad', e.target.value)}
                            error={errors.fecha_caducidad}
                        />

                        <div className="md:col-span-3">
                            <InputTextArea 
                                id="dispositivo_observaciones"
                                label="Observaciones"
                                value={data.observaciones} 
                                onChange={e => setData('observaciones', e.target.value)}
                                error={errors.observaciones}
                            />
                        </div>
                    </div>
                )}
                
                <div className="flex justify-end mt-4">
                    <PrimaryButton type="submit" disabled={processing || !data.tipo_dispositivo}>
                        {processing ? 'Guardando...' : 'Guardar Dispositivo'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Sondas y Catéteres</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Dispositivo</th>
                                <th className="px-4 py-3">Calibre</th>
                                <th className="px-4 py-3">F. Instalación</th>
                                <th className="px-4 py-3">Observaciones</th>
                                <th className="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {(estancia.hoja_sondas_cateters ?? []).length === 0 ? (
                                <tr>
                                    <td colSpan={5} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay dispositivos guardados.
                                    </td>
                                </tr>
                            ) : (

                                (estancia.hoja_sondas_cateters?? []).map((sonda: HojaSondaCateter) => (
                                    <tr key={sonda.id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">{sonda.tipo_dispositivo}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{sonda.calibre || 'N/A'}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{sonda.fecha_instalacion || 'N/A'}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500 truncate max-w-xs">{sonda.observaciones || 'N/A'}</td>
                                        <td className="px-4 py-4 text-sm space-x-2 whitespace-nowrap">
                                           
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default SondasCateteresForm;