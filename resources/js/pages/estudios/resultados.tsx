import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { SolicitudEstudio, User, Estancia } from '@/types';
import { route } from 'ziggy-js';

import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import InputDateTime from '@/components/ui/input-date-time';

interface Props {
    solicitud_estudio: SolicitudEstudio;
    grupos_estudios: any[];
    personal: User[];
}

const ResultadosComponent = ({ solicitud_estudio, grupos_estudios }: Props) => {
    const gruposSeguros = grupos_estudios || [];

    const { data, setData, post, processing, errors } = useForm({
        _method: 'PUT',
        grupos: gruposSeguros.map(grupo => {
            // Tomamos el primer item del grupo para extraer los datos generales 
            // que se guardaron previamente (fecha, problema clínico, etc.)
            const primerItem = grupo.items[0] || {};

            return {
                nombre_grupo: grupo.nombre_grupo,
                // Si existe el dato en el primer item, úsalo; si no, pon vacío
                problema_clinico: primerItem.problema_clinico || '',
                incidentes_accidentes: primerItem.incidentes_accidentes || '',
                ruta_archivo_actual: primerItem.ruta_archivo_resultado || null,
                archivos: [] as File[],
                
                archivos_existentes: grupo.items.flatMap((item: any) => item.archivos || []),
                // Formatear fecha para el input datetime-local (YYYY-MM-DDTHH:mm)
                fecha_hora_grupo: primerItem.fecha_realizacion 
                    ? new Date(primerItem.fecha_realizacion).toISOString().slice(0, 16) 
                    : '', 

                
                items: grupo.items.map((item: any) => ({
                    id: item.id,
                    nombre_estudio: item.catalogo_estudio?.nombre || item.otro_estudio,
                    cancelado: item.estado === 'CANCELADO', 
                    catalogo_estudio_id: item.catalogo_estudio_id,
                }))
            };
        })
    });

    const handleMultipleFiles = (gIndex: number, e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files) {
            // Convertimos el FileList de HTML en un Array de JavaScript
            const filesArray = Array.from(e.target.files);
            updateGroupField(gIndex, 'archivos', filesArray);
        }
    };

    const updateGroupField = (groupIndex: number, field: string, value: any) => {
        const newGrupos = [...data.grupos];
        newGrupos[groupIndex] = { ...newGrupos[groupIndex], [field]: value };
        setData('grupos', newGrupos);
    };

    const updateItemInGroup = (groupIndex: number, itemIndex: number, field: string, value: any) => {
        const newGrupos = [...data.grupos];
        const newItems = [...newGrupos[groupIndex].items];
        newItems[itemIndex] = { ...newItems[itemIndex], [field]: value };
        newGrupos[groupIndex].items = newItems;
        setData('grupos', newGrupos);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('solicitudes-estudios.update', solicitud_estudio.id), {
            forceFormData: true,
        });
    };

    return (
        <MainLayout pageTitle='Entrega de resultados' link='estancias.show' linkParams={solicitud_estudio.formulario_instancia.estancia_id}>
            <Head title="Resultados de estudios"/>
            
            <FormLayout 
                title={`Solicitud  de estudios #${solicitud_estudio.id}`} 
                onSubmit={handleSubmit} 
                actions={
                    <PrimaryButton disabled={processing} type='submit'>
                        {processing ? 'Guardando...' : 'Guardar'} 
                    </PrimaryButton>
                }
            >
                {data.grupos.length === 0 ? (
                    <div className="text-center py-10">
                        <p className="text-gray-500">No hay estudios pendientes o no tienes permisos para verlos.</p>
                    </div>
                ) : (
                    data.grupos.map((grupo, gIndex) => (
                        <div key={gIndex} className="mb-10 border-2 border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div className="bg-gray-100 p-4 border-b border-gray-200">
                                <h2 className="text-xl font-bold text-gray-800 flex flex-wrap items-center gap-2">
                                    <span className="bg-blue-600 text-white text-xs px-2 py-1 rounded uppercase tracking-wide shrink-0">
                                        Departamento
                                    </span>
                                    <span className="break-words">
                                        {grupo.nombre_grupo}
                                    </span>
                                </h2>
                            </div>

                            <div className="p-6 bg-white space-y-6">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div className="space-y-4">
                                        <InputDateTime
                                            id={`date_group_${gIndex}`}
                                            name={`grupos[${gIndex}].fecha_hora_grupo`}
                                            label="Fecha y hora del estudio"
                                            value={grupo.fecha_hora_grupo}
                                            onChange={(val) => updateGroupField(gIndex, 'fecha_hora_grupo', val)}
                                            error={errors[`grupos.${gIndex}.fecha_hora_grupo` as keyof typeof errors]}
                                        />

                                        <InputText
                                            id={`prob_${gIndex}`}
                                            name={`grupos[${gIndex}].problema_clinico`}
                                            label="Problema clínico en estudio"
                                            value={grupo.problema_clinico}
                                            onChange={e => updateGroupField(gIndex, 'problema_clinico', e.target.value)}
                                        />
                                        
                                        <InputText
                                            id={`incid_${gIndex}`}
                                            name={`grupos[${gIndex}].incidentes_accidentes`}
                                            label=" Incidentes y accidentes, si los hubo"
                                            value={grupo.incidentes_accidentes}
                                            onChange={e => updateGroupField(gIndex, 'incidentes_accidentes', e.target.value)}
                                        />
                                    </div>
                                    <div className="bg-blue-50 p-5 rounded-lg border border-blue-100 h-fit">
                                        <label className="block text-sm font-bold text-gray-700 mb-2">
                                            Adjuntar resultados ({grupo.nombre_grupo})
                                        </label>
                                        
                                        {/* Input con atributo 'multiple' */}
                                        <input 
                                            type="file" 
                                            multiple 
                                            accept=".pdf,.jpg,.png,.jpeg,.xlsx,.xls"
                                            className="block w-full text-sm text-gray-500 file:bg-blue-600 file:text-white file:rounded file:border-0 file:px-4 file:py-2 cursor-pointer bg-white rounded border border-gray-300"
                                            onChange={(e) => handleMultipleFiles(gIndex, e)}
                                        />

                                        {/* Feedback de archivos seleccionados */}
                                        {grupo.archivos.length > 0 && (
                                            <div className="mt-3 space-y-1">
                                                <p className="text-xs font-bold text-gray-600">Archivos nuevos a subir:</p>
                                                {grupo.archivos.map((file, fIndex) => (
                                                    <div key={fIndex} className="text-xs text-blue-700 bg-blue-100 px-2 py-1 rounded flex items-center gap-2">
                                                        📎 {file.name}
                                                    </div>
                                                ))}
                                            </div>
                                        )}

                                        {/* Errores dinámicos para el array de archivos */}
                                        {errors[`grupos.${gIndex}.archivos` as keyof typeof errors] && (
                                            <p className="text-red-500 text-sm mt-2">{errors[`grupos.${gIndex}.archivos` as keyof typeof errors]}</p>
                                        )}

                                        {/* Mostrar archivos ya guardados (si tu relación los trae) */}
                                        {grupo.archivos_existentes && grupo.archivos_existentes.length > 0 && (
                                            <div className="mt-4 border-t border-blue-200 pt-3">
                                                <p className="text-[10px] uppercase font-bold text-gray-400 mb-2">Archivos en plataforma:</p>
                                                <div className="grid grid-cols-1 gap-2">
                                                    {grupo.archivos_existentes.map((archivo: any) => (
                                                        <a 
                                                            key={archivo.id}
                                                            href={`/storage/${archivo.ruta_archivo_resultado}`} 
                                                            target="_blank" 
                                                            className="text-xs font-semibold text-blue-700 hover:underline flex items-center gap-2"
                                                        >
                                                            📄 Ver archivo guardado
                                                        </a>
                                                    ))}
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>

                                <hr className="border-gray-200" />
                                <div>
                                    <h4 className="font-bold text-gray-700 mb-3">Estudios incluidos:</h4>
                                    <div className="space-y-2">
                                        {grupo.items.map((item: any, iIndex: number) => (
                                            <div key={item.id} className={`grid grid-cols-1 md:grid-cols-2 items-center p-3 rounded border transition-colors ${item.cancelado ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200'}`}>
                                                
                                                <div className="flex items-center gap-3">
                                                    <span className="font-mono text-sm text-gray-400">#{iIndex + 1}</span>
                                                    <span className={`font-medium ${item.cancelado ? 'line-through text-red-700' : 'text-gray-800'}`}>
                                                        {item.nombre_estudio}
                                                    </span>
                                                </div>

                                                <label className="flex items-center gap-2 cursor-pointer select-none justify-end">
                                                    <input 
                                                        type="checkbox" 
                                                        checked={item.cancelado}
                                                        onChange={(e) => updateItemInGroup(gIndex, iIndex, 'cancelado', e.target.checked)}
                                                        className="w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500"
                                                    />
                                                    <span className="text-sm font-medium text-gray-600 hover:text-red-600">Cancelar</span>
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))
                )}
            </FormLayout>
        </MainLayout>
    );
}

export default ResultadosComponent;