import MainLayout from "@/layouts/MainLayout";
import React from "react";
import PlanPostoperatorioChecklist from '@/components/checklist';
import { Habitacion, Estancia, Paciente, notasEvoluciones, NotaPostoperatoria, ChecklistItemData } from "@/types";
import { Head } from "@inertiajs/react";
import InfoCard from "@/components/ui/info-card";
interface Props {
    habitacion: Habitacion;
    paciente?: Paciente;
    estancia?: Estancia;
    nota: any; // O el tipo correcto que definiste
    checklistInicial: any[];
}

const Show = ({ habitacion, paciente, estancia, nota, checklistInicial }: Props) => {
    return (
        <MainLayout pageTitle="Detalles de habitación" link="habitaciones.index">
             <Head title={`Habitación ${habitacion.identificador}`} />
             
             {/* Info del Paciente */}
             <InfoCard title={`Habitación ${habitacion.identificador}`}>
                {paciente ? (
                    <p>Paciente: <strong>{paciente.nombre}</strong></p>
                ) : (
                    <p>Sin paciente asignado</p>
                )}
             </InfoCard>

             {/* Checklist - Solo se muestra si hay estancia */}
             {estancia && (
                <div className="mt-6 bg-white p-6 shadow rounded-lg">
                    <h2 className="text-xl font-bold mb-4">Checklist de Plan</h2>
                    <PlanPostoperatorioChecklist 
                        nota={nota} 
                       
                    />
                </div>
             )}
        </MainLayout>
    );
}
export default Show;