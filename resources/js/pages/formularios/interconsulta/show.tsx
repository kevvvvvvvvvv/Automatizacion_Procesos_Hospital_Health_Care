import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil, Printer } from 'lucide-react';
import { route } from 'ziggy-js';
import MainLayout from '@/layouts/MainLayout';
import { Interconsulta, Paciente, Estancia, User } from '@/types';
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowInterconsultaProps {
    interconsulta: Interconsulta & {
        formularioInstancia: {
            user: User;
            estancia: Estancia & { paciente: Paciente };
        };
    };
    paciente: Paciente;
    estancia: Estancia;
}

const Show = ({ interconsulta, paciente, estancia }: ShowInterconsultaProps) => {
    const { formularioInstancia } = interconsulta;

    const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };

    return (
        <>
            <Head title={`Detalles de Interconsulta: ${paciente.nombre}`} />

            <InfoCard title={`Interconsulta para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <InfoField label="Tensión Arterial" value={interconsulta.ta || 'N/A'} />
                    <InfoField label="Frecuencia Cardíaca" value={interconsulta.fc ? interconsulta.fc.toString() : 'N/A'} />
                    <InfoField label="Frecuencia Respiratoria" value={interconsulta.fr ? interconsulta.fr.toString() : 'N/A'} />
                    <InfoField label="Temperatura" value={interconsulta.temp ? interconsulta.temp.toString() : 'N/A'} />
                    <InfoField label="Peso" value={interconsulta.peso ? interconsulta.peso.toString() : 'N/A'} />
                    <InfoField label="Talla" value={interconsulta.talla ? interconsulta.talla.toString() : 'N/A'} />
                    <InfoField label="Criterio Diagnóstico" value={interconsulta.criterio_diagnostico || 'N/A'} />
                    <InfoField label="Plan de Estudio" value={interconsulta.plan_de_estudio || 'N/A'} />
                    <InfoField label="Sugerencia Diagnóstica" value={interconsulta.sugerencia_diagnostica || 'N/A'} />
                    <InfoField label="Resumen del Interrogatorio" value={interconsulta.resumen_del_interrogatorio || 'N/A'} />
                    <InfoField label="Exploración Física" value={interconsulta.exploracion_fisica || 'N/A'} />
                    <InfoField label="Estado Mental" value={interconsulta.estado_mental || 'N/A'} />
                    <InfoField label="Resultados Relevantes del Estudio Diagnóstico" value={interconsulta.resultados_relevantes_del_estudio_diagnostico || 'N/A'} />
                    <InfoField label="Tratamiento y Pronóstico" value={interconsulta.tratamiento_y_pronostico || 'N/A'} />
                    <InfoField label="Motivo de la Atención o Interconsulta" value={interconsulta.motivo_de_la_atencion_o_interconsulta || 'N/A'} />
                    <InfoField label="Diagnóstico o Problemas Clínicos" value={interconsulta.diagnostico_o_problemas_clinicos || 'N/A'} />
                    <InfoField label="Registrado por" value={formularioInstancia.user.nombre} />
                    <InfoField label="Fecha de Registro" value={new Date(formularioInstancia.fecha_hora).toLocaleString('es-MX', dateOptions)} />
                </div>
            </InfoCard>
            <div className="mt-8">
        <h2 className="text-xl font-semibold text-gray-800 mb-4">Honorarios Asociados</h2>
        <div className="flex space-x-4">
            <Link
                href={route('honorarios.create', { interconsulta_id: interconsulta.id })}
                className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
            >
                <Plus size={16} className="mr-2" />
                Agregar Honorario
            </Link>
            <Link
                href={route('honorarios.index', { interconsulta_id: interconsulta.id })}
                className="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
            >
                Ver Honorarios
            </Link>
        </div>
    </div>
            <div className="mt-8 flex space-x-4">
                <Link
                    href={route('interconsultas.edit', { interconsulta: interconsulta.id })}
                    className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                >
                    <Pencil size={16} className="mr-2" />
                    Editar Interconsulta
                </Link>

                <a
                    href={route('interconsultas.pdf', { interconsulta: interconsulta.id })}
                    target="_blank"
                    className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                >
                    <Printer size={16} className="mr-2" />
                    Imprimir PDF
                </a>
            </div>
        </>
    );
};

Show.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as ShowInterconsultaProps;
    return (
        <MainLayout pageTitle={`Detalles de Interconsulta de ${paciente.nombre}`} children={page} />
    );
};

export default Show;