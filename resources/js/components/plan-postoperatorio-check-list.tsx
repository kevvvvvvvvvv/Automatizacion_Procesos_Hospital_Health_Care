import React, { useState, useMemo } from 'react';
import { NotaPostoperatoria } from '@/types'; 

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
    return (
        <div className="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 className="text-xl font-semibold mb-4 border-b pb-2 text-gray-800">
                {title}
            </h2>
            
            {tasks.length === 0 ? (
                <p className="text-sm text-gray-500 italic">No hay indicaciones para este apartado.</p>
            ) : (
                <ul className="space-y-3">
                    {tasks.map((taskText, index) => {
                        const taskId = `${sectionId}-${index}`;
                        const isChecked = completedTasks.has(taskId);

                        return (
                            <li key={taskId}>
                                <label 
                                    htmlFor={taskId} 
                                    className="flex items-center cursor-pointer group w-full"
                                >
                                    <input
                                        id={taskId}
                                        type="checkbox"
                                        className="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 peer"
                                        checked={isChecked}
                                        onChange={(e) => onCheckChange(taskId, e.target.checked)}
                                    />
                                    <span className={`ml-3 text-sm text-gray-800 transition-colors
                                        peer-checked:line-through peer-checked:text-gray-400 peer-checked:italic
                                    `}>
                                        {taskText}
                                    </span>
                                </label>
                            </li>
                        );
                    })}
                </ul>
            )}
        </div>
    );
};


interface Props {
    nota: NotaPostoperatoria | null | undefined;
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

const PlanPostoperatorioChecklist: React.FC<Props> = ({ nota }) => {
    
    const [completedTasks, setCompletedTasks] = useState(new Set<string>());
    const handleCheckChange = (taskId: string, isChecked: boolean) => {
        const newSet = new Set(completedTasks);
        
        if (isChecked) {
            newSet.add(taskId);
        } else {
            newSet.delete(taskId);
        }
        
        setCompletedTasks(newSet);
    };

    const dietaTasks = useMemo(() => parseTasksFromText(nota?.manejo_dieta), [nota?.manejo_dieta]);
    const solucionesTasks = useMemo(() => parseTasksFromText(nota?.manejo_soluciones), [nota?.manejo_soluciones]);
    const medicamentosTasks = useMemo(() => parseTasksFromText(nota?.manejo_medicamentos), [nota?.manejo_medicamentos]);
    const medidasTasks = useMemo(() => parseTasksFromText(nota?.manejo_medidas_generales), [nota?.manejo_medidas_generales]);
    const laboratoriosTasks = useMemo(() => parseTasksFromText(nota?.manejo_laboratorios), [nota?.manejo_laboratorios]);

    if (!nota) {
        return <div className="text-center text-gray-500">No se ha cargado la nota postoperatoria.</div>;
    }

    return (
        <div className="space-y-6">
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