import React, { useState } from 'react';
import { ChecklistItemData, NotaPostoperatoria, notasEvoluciones, HojaMedicamento, HojaEnfermeria, HojaTerapiaIV } from '@/types';
import axios from 'axios';
import { route } from 'ziggy-js' 
import Swal from 'sweetalert2';
import { router } from '@inertiajs/react';



interface ChecklistSectionEstructuradaProps<T> {
    title: string;
    items: T[];
    renderText: (item: T) => string;
    isCompleted: (item: T) => boolean;
    onToggle: (item: T) => void;
    onSave?: (item: T) => void;
}

function ChecklistSectionEstructurada<T extends { id: number }>({ 
    title, 
    items, 
    renderText, 
    isCompleted, 
    onToggle,
    onSave,
}: ChecklistSectionEstructuradaProps<T>) {
    const [isOpen, setIsOpen] = useState(false);

    const totalCount = items.length;
    const completedCount = items.filter(isCompleted).length;
    const isComplete = totalCount > 0 && completedCount === totalCount;
    const isEmpty = totalCount === 0;

    let pillColorClass = "bg-gray-100 text-gray-500"; 
    if (isComplete) pillColorClass = "bg-green-100 text-green-700 border border-green-200";
    else if (completedCount > 0) pillColorClass = "bg-blue-50 text-blue-600 border border-blue-100";

    return (
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
            <button 
                onClick={() => setIsOpen(!isOpen)}
                className="w-full flex items-center justify-between p-4 bg-white hover:bg-gray-50 transition-colors text-left group"
            >
                <div className="flex flex-col">
                    <span className="font-semibold text-gray-800 text-base group-hover:text-blue-600 transition-colors">
                        {title}
                    </span>
                </div>

                <div className="flex items-center gap-3">
                    {!isEmpty && (
                        <span className={`px-3 py-1 rounded-full text-xs font-semibold tracking-wide transition-colors ${pillColorClass}`}>
                            {isComplete ? 'Completado' : `${completedCount}/${totalCount}`}
                        </span>
                    )}
                    <div className={`p-1 rounded-full transition-transform duration-300 ${isOpen ? 'bg-gray-100 rotate-180' : ''}`}>
                        <svg className="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </button>
            {isOpen && (
                <div className="p-4 pt-0 border-t border-gray-50 animate-fadeIn">
                    {isEmpty ? (
                        <div className="mt-3 p-3 bg-gray-50 rounded-lg text-xs text-gray-400 text-center italic">
                            Sin indicaciones
                        </div>
                    ) : (
                        <ul className="space-y-1 mt-2">
                            {items.map((item) => {
                                const isChecked = isCompleted(item);
                                return (
                                    <li key={item.id} className="flex justify-between items-center p-2 rounded-lg transition-all duration-200 hover:bg-blue-50">
                                        <label className={`flex items-start cursor-pointer flex-1`}>
                                            <div className="relative flex items-center mt-0.5">
                                                <input
                                                    type="checkbox"
                                                    className="peer h-4 w-4 cursor-pointer..."
                                                    checked={isChecked}
                                                    onChange={() => onToggle(item)}
                                                />
                                            </div>
                                            <span className={`ml-3 text-sm leading-snug transition-colors ${isChecked ? 'text-gray-400 line-through' : 'text-gray-700'}`}>
                                                {renderText(item)}
                                            </span>
                                        </label>

                                        {onSave && (
                                            <button
                                                onClick={() => onSave(item)}
                                                className="ml-2 px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition-colors shrink-0"
                                                title="Mandar a la hoja de enfermería"
                                            >
                                                + Guardar
                                            </button>
                                        )}
                                        
                                    </li>
                                );
                            })}
                        </ul>
                    )}
                </div>
            )}
        </div>
    );
}


interface Props {
    nota: NotaPostoperatoria | notasEvoluciones |null | undefined;
    hoja: HojaEnfermeria;
    checklistInicial?: ChecklistItemData[];
}

const PlanPostoperatorioChecklist: React.FC<Props> = ({ 
    nota, 
    hoja,
}) => {

    const handleGuardarMedicamento = (med: HojaMedicamento) => {
        if (!hoja?.id) {
            return;
        }

        Swal.fire({
            title: '¿Agregar medicamento?',
            text: `Se registrará "${med.nombre_medicamento}" directamente en la hoja de enfermería actual.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, agregar a la hoja',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                router.post(route('hojasmedicamentos.store'), {
                    medicable_id: hoja.id,
                    medicable_type: hoja.tipo_modelo,
                    medicamentos_agregados: [{
                        id: med.producto_servicio_id, 
                        nombre_medicamento: med.nombre_medicamento,
                        dosis: med.dosis,
                        gramaje: med.gramaje,
                        unidad: med.unidad,
                        via_id: med.via_administracion,
                        duracion: med.duracion_tratamiento,
                        inicio: '',
                    }]
                }, {
                    preserveScroll: true,
                });
            }
        });
    };

    const handleGuardarSolucion = (sol: HojaTerapiaIV) => {
        if (!hoja?.id) {
            return;
        }

        Swal.fire({
            title: '¿Agregar solución?',
            text: `Se registrará "${sol.nombre_solucion}" directamente en la hoja de enfermería actual.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, agregar a la hoja',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const medicamentosFormateados = sol.medicamentos?.map(med => ({
                    es_manual: med.producto_servicio_id ? false : true,
                    id: med.id, 
                    nombre: med.nombre_medicamento,
                    dosis: med.dosis,
                    unidad: med.unidad_medida,
                })) || [];

                router.post(route('hojasterapiasiv.store'), {
                    terapiable_id: hoja.id,
                    terapiable_type: hoja.tipo_modelo,
                    terapias_agregadas: [
                        {
                            es_manual: sol.detalle_soluciones.id ? false : true,
                            solucion_id: sol.detalle_soluciones.id ?? null,
                            nombre_solucion: sol.nombre_solucion,
                            cantidad: sol.cantidad,
                            duracion: sol.duracion,
                            flujo: sol.flujo_ml_hora,
                            medicamentos: medicamentosFormateados
                        }
                    ]
                }, {
                    preserveScroll: true,
                });
            }
        });
    };


    const toggleMedicamento = async (id: number, currentEstado: string) => {
        const nuevoEstado = currentEstado === 'completado' ? 'solicitado' : 'completado';
        try {
            await axios.patch(route('indicaciones.medicamentos.update-estado', id), {
                estado: nuevoEstado
            });
        } catch (error) {
            console.error("Error al actualizar medicamento", error);
        }
    };

    if (!nota) {
        return <div className="text-center text-gray-500">No se han cargado instrucciones.</div>;
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
{/*             <ChecklistSection
                title="Plan de dieta"
                sectionId="dieta"
                tasks={dietaTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />*/}
            
            <ChecklistSectionEstructurada
                title="Plan de soluciones"
                items={nota.soluciones || []}
                renderText={(sol: HojaTerapiaIV) => {
                    const listaMedicamentos = sol.medicamentos
                        ?.map(med => `  • ${med.nombre_medicamento}`)
                        .join('\n') || '';

                    return `${sol.nombre_solucion} - ${sol.flujo_ml_hora} ml/hr\n${listaMedicamentos}`;
                }}
                isCompleted={(sol: HojaTerapiaIV) => false}
                onToggle={(sol: HojaTerapiaIV) => toggleSolucion(sol.id)}
                onSave={(sol: HojaTerapiaIV) => handleGuardarSolucion(sol)}
            /> 
            
            <ChecklistSectionEstructurada
                title="Plan de medicamentos"
                items={nota.medicamentos || []} 
                renderText={(med: HojaMedicamento) => 
                    `${med.nombre_medicamento} - ${med.dosis}${med.gramaje} c/${med.duracion_tratamiento} hrs (${med.via_administracion})`
                }
                isCompleted={(med: HojaMedicamento) => med.estado === 'completado'} 
                onToggle={(med: HojaMedicamento) => toggleMedicamento(med.id, med.estado)}
                onSave={(med: HojaMedicamento) => handleGuardarMedicamento(med)}
            />
{/* 
            <ChecklistSection
                title="Medidas generales"
                sectionId="medidas"
                tasks={medidasTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />
            
            <ChecklistSection
                title="Laboratorios y gabinetes"
                sectionId="laboratorios"
                tasks={laboratoriosTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            /> */}
        </div>
    );
};

export default PlanPostoperatorioChecklist;