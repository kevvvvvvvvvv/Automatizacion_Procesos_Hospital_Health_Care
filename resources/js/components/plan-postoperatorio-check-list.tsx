import React, { useState, useMemo } from 'react';
import axios from 'axios';
import { route } from 'ziggy-js' 
import Swal from 'sweetalert2';
import { router } from '@inertiajs/react';
import { ChecklistItemData, NotaPostoperatoria, notasEvoluciones, HojaMedicamento, HojaEnfermeria, HojaTerapiaIV } from '@/types';

import ChecklistSimple from '@/components/formularios/checklist/checklist-simple';
import StructuredChecklist from '@/components/formularios/checklist/structured-checklist';

interface Props {
    nota: NotaPostoperatoria | notasEvoluciones |null | undefined;
    hoja: HojaEnfermeria;
    checklistInicial?: ChecklistItemData[];
}

const parseTasksFromText = (text: string | null | undefined): string[] => {
    if (!text || text.trim() === '') {
        return [];
    }
    return text.split('\n')
               .map(line => line.trim()) 
               .filter(line => line.length > 0) 
               .map(line => line.replace(/^•\s*/, '')); 
};

const PlanPostoperatorioChecklist: React.FC<Props> = ({ 
    nota, 
    hoja,
    checklistInicial,
}) => {

    const [completedTasks, setCompletedTasks] = useState(() => {
        const initialSet = new Set<string>();
        if (checklistInicial) {
            checklistInicial.forEach(item => {
                initialSet.add(`${item.section_id}-${item.task_index}`);
            });
        }
        return initialSet;
    });
    
    const handleCheckChange = async (taskId: string, isChecked: boolean) => {
        if(!nota) return;
         setCompletedTasks(prev => {
                const newSet = new Set(prev);
                if (isChecked) {
                    newSet.add(taskId);
                } else {
                    newSet.delete(taskId);
                }
             return newSet;
         });

        const [sectionId, indexStr] = taskId.split('-');
        await axios.post(route('checklist.toggle'), {
            nota_id: nota.id,
            nota_type: nota.tipo_modelo,
            section_id: sectionId,
            task_index: parseInt(indexStr),
            is_completed: isChecked
        });
    };

    const dietaTasks = useMemo(() => parseTasksFromText(nota?.manejo_dieta), [nota?.manejo_dieta]);
    const medidasTasks = useMemo(() => parseTasksFromText(nota?.manejo_medidas_generales), [nota?.manejo_medidas_generales]);
    const laboratoriosTasks = useMemo(() => parseTasksFromText(nota?.manejo_laboratorios), [nota?.manejo_laboratorios]);


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

            <ChecklistSimple
                title="Plan de dieta"
                sectionId="dieta"
                tasks={dietaTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />
            
            <StructuredChecklist
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
            
            <StructuredChecklist
                title="Plan de medicamentos"
                items={nota.medicamentos || []} 
                renderText={(med: HojaMedicamento) => 
                    `${med.nombre_medicamento} - ${med.dosis}${med.gramaje} c/${med.duracion_tratamiento} hrs (${med.via_administracion})`
                }
                isCompleted={(med: HojaMedicamento) => med.estado === 'completado'} 
                onToggle={(med: HojaMedicamento) => toggleMedicamento(med.id, med.estado)}
                onSave={(med: HojaMedicamento) => handleGuardarMedicamento(med)}
            />
     
            <ChecklistSimple
                title="Medidas generales"
                sectionId="medidas"
                tasks={medidasTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />
            
            <ChecklistSimple
                title="Laboratorios y gabinetes"
                sectionId="laboratorios"
                tasks={laboratoriosTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            /> 
        </div>
    );
};

export default PlanPostoperatorioChecklist;