import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Edit, Printer } from 'lucide-react';  // Cambié Plus por Edit para editar la interconsulta
import { route } from 'ziggy-js';
import MainLayout from '@/layouts/MainLayout';
import { Interconsulta, Paciente, Estancia, User } from '@/types';  // Asumiendo que tienes estos tipos definidos
import InfoCard from '@/components/ui/info-card';

import InfoField from '@/components/ui/info-field';

interface ShowInterconsultaProps {
    interconsulta: Interconsulta & {
        paciente: Paciente;
        estancia: Estancia;
        creator: User | null;
        updater: User | null;
    };
}

const Show = ({ interconsulta }: ShowInterconsultaProps) => {
    console.log("Datos completos de la interconsulta que llegan a React:", interconsulta);
    const { paciente, estancia, creator, updater } = interconsulta;

    const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };

    return (
        <>
            <Head title={`Detalles de Interconsulta: ${paciente.nombre} ${paciente.apellido_paterno}`} />

            <InfoCard title={`Interconsulta para: ${paciente.nombre} ${paciente.apellido_paterno}`}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <InfoField label="Paciente" value={`${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`} />
                    <InfoField label="Estancia Folio" value={estancia.folio} />
                    <InfoField label="Tipo de Estancia" value={estancia.tipo_estancia} />
                    <InfoField 
                        label="Fecha de Creación" 
                        value={new Date(interconsulta.created_at).toLocaleString('es-MX', dateOptions)} 
                    />
                    <InfoField 
                        label="Última Actualización" 
                        value={new Date(interconsulta.updated_at).toLocaleString('es-MX', dateOptions)} 
                    />
                    <InfoField label="Creado por" value={creator ? creator.nombre : 'N/A'} />
                    <InfoField 
                        label="Actualizado por" 
                        value={updater ? updater.nombre : 'N/A'} 
                    />
                </div>
            </InfoCard>

            {/* Sección de Signos Vitales */}
            <InfoCard title="Signos Vitales" className="mt-8">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <InfoField label="T.A. (Tensión Arterial)" value={interconsulta.ta || 'N/A'} />
                    <InfoField label="FC (Frecuencia Cardíaca)" value={interconsulta.fc ? `${interconsulta.fc} bpm` : 'N/A'} />
                    <InfoField label="FR (Frecuencia Respiratoria)" value={interconsulta.fr ? `${interconsulta.fr} rpm` : 'N/A'} />
                    <InfoField label="Temperatura" value={interconsulta.temp ? `${interconsulta.temp} °C` : 'N/A'} />
                    <InfoField label="Peso" value={interconsulta.peso ? `${interconsulta.peso} kg` : 'N/A'} />
                    <InfoField label="Talla" value={interconsulta.talla ? `${interconsulta.talla} m` : 'N/A'} />
                </div>
            </InfoCard>

            {/* Sección de Motivo y Exploración */}
            <InfoCard title="Motivo y Exploración" className="mt-8">
                <div className="grid grid-cols-1 gap-4">
                    <InfoField label="Motivo de la Atención o Interconsulta" value={interconsulta.motivo_de_la_atencion_o_interconsulta || 'N/A'} />
                    <InfoField label="Resumen del Interrogatorio" value={interconsulta.resumen_del_interrogatorio || 'N/A'} />
                    <InfoField label="Exploración Física" value={interconsulta.exploracion_fisica || 'N/A'} />
                    <InfoField label="Estado Mental" value={interconsulta.estado_mental || 'N/A'} />
                </div>
            </InfoCard>

            {/* Sección de Diagnóstico y Plan */}
            <InfoCard title="Diagnóstico y Plan" className="mt-8">
                <div className="grid grid-cols-1 gap-4">
                    <InfoField label="Criterio Diagnóstico" value={interconsulta.criterio_diagnostico || 'N/A'} />
                    <InfoField label="Sugerencia Diagnóstica" value={interconsulta.sugerencia_diagnostica || 'N/A'} />
                    <InfoField label="Resultados Relevantes del Estudio Diagnóstico" value={interconsulta.resultados_relevantes_del_estudio_diagnostico || 'N/A'} />
                    <InfoField label="Diagnóstico o Problemas Clínicos" value={interconsulta.diagnostico_o_problemas_clinicos || 'N/A'} />
                    <InfoField label="Plan de Estudio" value={interconsulta.plan_de_estudio || 'N/A'} />
                    <InfoField label="Tratamiento y Pronóstico" value={interconsulta.tratamiento_y_pronostico || 'N/A'} />
                </div>
            </InfoCard>

            {/* Acciones */}
            <div className="mt-8 flex justify-between items-center">
                <Link
                    href={route('pacientes.estancias.interconsultas.edit', {
                        paciente: paciente.id,
                        estancia: estancia.id,
                        interconsulta: interconsulta.id
                    })}
                    className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
                >
                    <Edit size={16} className="mr-2" />
                    Editar Interconsulta
                </Link>
                <a 
                    href={route('interconsultas.pdf', interconsulta.id)}  // Asumiendo que tienes una ruta para PDF
                    target="_blank"
                    className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25 transition"
                >
                    <Printer size={16} className="mr-2" />
                    Imprimir / Descargar PDF
                </a>
            </div>
        </>
    );
};
//
Show.layout = (page: React.ReactElement) => {                   
    const { interconsulta } = page.props as ShowInterconsultaProps;
    return (
        <MainLayout pageTitle={`Detalles de Interconsulta de ${interconsulta.paciente.nombre}`} children={page} />
    );
};

export default Show;