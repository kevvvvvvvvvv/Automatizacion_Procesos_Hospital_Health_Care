import React, { useState, useMemo } from 'react';
import { ChecklistItemData, NotaPostoperatoria, notasEvoluciones } from '@/types';
import axios from 'axios';
import { route } from 'ziggy-js' 

interface ChecklistSectionProps {
    title: string;
    sectionId: string; 
    tasks: string[]; 
    completedTasks: Set<string>; 
    onCheckChange: (taskId: string, isChecked: boolean) => void;
}

const ChecklistSection: React.FC<ChecklistSectionProps> = ({ 
    title, 
    sectionId, 
    tasks, 
    completedTasks, 
    onCheckChange 
}) => {
    const [isOpen, setIsOpen] = useState(false);

    const completedCount = tasks.filter((_, idx) => completedTasks.has(`${sectionId}-${idx}`)).length;
    const totalCount = tasks.length;
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
                            {tasks.map((taskText, index) => {
                                const taskId = `${sectionId}-${index}`;
                                const isChecked = completedTasks.has(taskId);

                                return (
                                    <li key={taskId}>
                                        <label 
                                            htmlFor={taskId} 
                                            className={`flex items-start p-2 rounded-lg cursor-pointer transition-all duration-200 ${isChecked ? 'bg-gray-50' : 'hover:bg-blue-50'}`}
                                        >
                                            <div className="relative flex items-center mt-0.5">
                                                <input
                                                    id={taskId}
                                                    type="checkbox"
                                                    className="peer h-4 w-4 cursor-pointer appearance-none rounded border border-gray-300 shadow-sm checked:border-blue-500 checked:bg-blue-500 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-0"
                                                    checked={isChecked}
                                                    onChange={(e) => onCheckChange(taskId, e.target.checked)}
                                                />
                                                <svg className="pointer-events-none absolute h-3 w-3 left-0.5 top-0.5 text-white opacity-0 peer-checked:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="3">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>

                                            <span className={`ml-3 text-sm leading-snug transition-colors ${isChecked ? 'text-gray-400 line-through' : 'text-gray-700'}`}>
                                                {taskText}
                                            </span>
                                        </label>
                                    </li>
                                );
                            })}
                        </ul>
                    )}
                </div>
            )}
        </div>
    );
};


interface Props {
    nota: NotaPostoperatoria | notasEvoluciones |null | undefined;
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

const PlanPostoperatorioChecklist: React.FC<Props> = ({ nota, checklistInicial = [] }) => {

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
            nota_type: nota.model_type,
             section_id: sectionId,
             task_index: parseInt(indexStr),
             is_completed: isChecked
         });
    };

    const dietaTasks = useMemo(() => parseTasksFromText(nota?.manejo_dieta), [nota?.manejo_dieta]);
    const solucionesTasks = useMemo(() => parseTasksFromText(nota?.manejo_soluciones), [nota?.manejo_soluciones]);
    const medicamentosTasks = useMemo(() => parseTasksFromText(nota?.manejo_medicamentos), [nota?.manejo_medicamentos]);
    const medidasTasks = useMemo(() => parseTasksFromText(nota?.manejo_medidas_generales), [nota?.manejo_medidas_generales]);
    const laboratoriosTasks = useMemo(() => parseTasksFromText(nota?.manejo_laboratorios), [nota?.manejo_laboratorios]);

    if (!nota) {
        return <div className="text-center text-gray-500">No se han cargado instrucciones.</div>;
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <ChecklistSection
                title="Plan de dieta"
                sectionId="dieta"
                tasks={dietaTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />
            
            <ChecklistSection
                title="Plan de soluciones"
                sectionId="soluciones"
                tasks={solucionesTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />
            
            <ChecklistSection
                title="Plan de medicamentos"
                sectionId="medicamentos"
                tasks={medicamentosTasks}
                completedTasks={completedTasks}
                onCheckChange={handleCheckChange}
            />

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
            />
        </div>
    );
};

export default PlanPostoperatorioChecklist;