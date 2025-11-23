import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, HojaSondaCateter, Estancia } from '@/types'; 
import { route } from 'ziggy-js';

import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';
import PrimaryButton from '@/components/ui/primary-button';

import ContadorTiempo from '../counter-time';

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

const formatDateTime = (isoString: string | null) => {
    if (!isoString) return 'Pendiente';
    return new Date(isoString).toLocaleString('es-MX', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
};

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

    const handleUpdate = (sondacateterId: number, dataToUpdate: Record<string, any>) => {
        router.patch(route('hojassondascateters.update',{
            hojasenfermeria: hoja.id,
            hojassondascateter: sondacateterId
        }),
        dataToUpdate,
        {
            preserveScroll: true,
            onError: (errors) => {
                alert('Error al actualizar: \n' + JSON.stringify(errors));
            }
        });
    }

    /*const handleRemoveSaved = (sondaId: number) => {
        if (confirm('¿Seguro que deseas eliminar este registro?')) {
            router.delete(route('hojasondas.destroy', { 
                hojaenfermeria: hoja.id, 
                sonda: sondaId 
            }), {
                preserveScroll: true,
            });
        }
    }*/

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
                        {processing ? 'Guardando...' : 'Guardar dispositivo'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de sondas y catéteres</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Dispositivo</th>
                                <th className="px-4 py-3">Calibre</th>
                                <th className="px-4 py-3">F. instalación</th>
                                <th className="px-4 py-3">Tiempo transcurrido</th>
                                <th className="px-4 py-3">F. caducidad</th>
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
                                        <td className="px-4 py-4 text-sm text-gray-500" style={{minWidth: '200px'}}>
                                            {sonda.fecha_instalacion ? (
                                                <span>{formatDateTime(sonda.fecha_instalacion)}</span>
                                            ):(
                                                <PrimaryButton
                                                    type="button"
                                                    onClick={()=>{
                                                        const now_iso = new Date().toISOString();
                                                       handleUpdate(sonda.id, { fecha_instalacion: now_iso });
                                                    }}>
                                                        Registrar inicio
                                                </PrimaryButton>
                                            )}
                                        </td>
                                        <td className="px-4 py-4 text-sm font-medium text-gray-900">
                                            <ContadorTiempo 
                                                fechaInicioISO={sonda.fecha_instalacion} 
                                                fechaFinISO={sonda.fecha_caducidad}/>
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-500" style={{minWidth:'200px'}}>
                                            {sonda.fecha_instalacion ? (
                                                sonda.fecha_caducidad ? (
                                                    <span>{formatDateTime(sonda.fecha_caducidad)}</span>
                                                ):(
                                                    <PrimaryButton
                                                        type='button'
                                                        onClick={() => {
                                                            const now_iso = new Date().toISOString();
                                                            handleUpdate(sonda.id, { fecha_caducidad: now_iso });
                                                        }}
                                                    >
                                                        Registar caducidad    
                                                    </PrimaryButton>
                                                )
                                            ):(
                                                <span>Registra la fecha de instalacion</span>
                                            )}
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-500 truncate max-w-xs" style={{minWidth:'200px'}}>
                                            <InputTextArea
                                                    label=''
                                                    id={`obs-${sonda.id}`} 
                                                    defaultValue={sonda.observaciones || ''} 
                                                    className="w-full text-sm"
                                                    rows={2} 
                                                    onBlur={(e) => {
                                                        const newValue = e.target.value;
                                                        const oldValue = sonda.observaciones || '';

                                                        if (newValue !== oldValue) {
                                                            handleUpdate(sonda.id, { observaciones: newValue });
                                                        }
                                                    }}
                                                />
                                        </td>
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