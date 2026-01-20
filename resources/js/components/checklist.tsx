import React, { useMemo } from 'react';
import { NotaPostoperatoria, notasEvoluciones } from '@/types';

interface PlanSectionProps {
    title: string;
    tasks: string[];
    icon: React.ReactNode;
}

const PlanSection: React.FC<PlanSectionProps> = ({ title, tasks, icon }) => {
    const isEmpty = tasks.length === 0;

    return (
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
            <div className="flex items-center gap-3 p-4 border-b border-gray-50 bg-gray-50/50">
                <div className="p-2 bg-white rounded-lg shadow-sm text-blue-600">
                    {icon}
                </div>
                <h3 className="font-bold text-gray-800 text-base">{title}</h3>
            </div>

            <div className="p-4">
                {isEmpty ? (
                    <div className="p-3 bg-gray-50 rounded-lg text-sm text-gray-400 text-center italic">
                        Sin indicaciones registradas
                    </div>
                ) : (
                    <ul className="space-y-3">
                        {tasks.map((taskText, index) => (
                            <li key={index} className="flex items-start gap-3 group">
                                <div className="mt-1.5 h-1.5 w-1.5 rounded-full bg-blue-400 flex-shrink-0 group-hover:scale-125 transition-transform" />
                                <span className="text-sm leading-relaxed text-gray-700">
                                    {taskText}
                                </span>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        </div>
    );
};

interface Props {
    nota: NotaPostoperatoria | notasEvoluciones | null | undefined;
}

const parseTasksFromText = (text: string | null | undefined): string[] => {
    if (!text || text.trim() === '') return [];
    
    return text.split('\n')
               .map(line => line.trim()) 
               .filter(line => line.length > 0) 
               .map(line => line.replace(/^•\s*/, '')); 
};

const PlanPostoperatorioVista: React.FC<Props> = ({ nota }) => {
    const solucionesTasks = useMemo(() => parseTasksFromText(nota?.manejo_soluciones), [nota?.manejo_soluciones]);
    const medicamentosTasks = useMemo(() => parseTasksFromText(nota?.manejo_medicamentos), [nota?.manejo_medicamentos]);
    const laboratoriosTasks = useMemo(() => parseTasksFromText(nota?.manejo_laboratorios), [nota?.manejo_laboratorios]);

    if (!nota) {
        return (
            <div className="p-8 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                <p className="text-gray-500 font-medium">No hay información de plan postoperatorio disponible.</p>
            </div>
        );
    }

    return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <PlanSection 
                title="Plan de Soluciones" 
                tasks={solucionesTasks}
                icon={
                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                }
            />
            
            <PlanSection 
                title="Plan de Medicamentos" 
                tasks={medicamentosTasks}
                icon={
                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                }
            />

            
           
        </div>
    );
};

export default PlanPostoperatorioVista;