import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil, Printer, Plus } from 'lucide-react';
import { route } from 'ziggy-js';
import MainLayout from '@/layouts/MainLayout';
import { Interconsulta, Paciente, Estancia, User } from '@/types';
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

type Honorario = {
  id: number;
  interconsulta_id: number;
  monto: number | string;
  descripcion: string | null;
  created_at?: string;
  updated_at?: string;
};

interface ShowInterconsultaProps {
  interconsulta: Interconsulta & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
  honorarios: Honorario[];
  honorarios_total?: number;
}

const Show = ({
  interconsulta,
  paciente,
  estancia,
  honorarios,
  honorarios_total,
}: ShowInterconsultaProps) => {
  const { formularioInstancia } = interconsulta;

  const dateOptions: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  return (
    <>
      <Head title={`Detalles de Interconsulta: ${paciente.nombre}`} />

      <InfoCard
        title={`Interconsulta para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      >
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <InfoField
            label="Tensión Arterial"
            value={interconsulta.ta || 'N/A'}
          />
          <InfoField
            label="Frecuencia Cardíaca"
            value={
              interconsulta.fc ? interconsulta.fc.toString() : 'N/A'
            }
          />
          <InfoField
            label="Frecuencia Respiratoria"
            value={
              interconsulta.fr ? interconsulta.fr.toString() : 'N/A'
            }
          />
          <InfoField
            label="Temperatura"
            value={
              interconsulta.temp ? interconsulta.temp.toString() : 'N/A'
            }
          />
          <InfoField
            label="Peso"
            value={
              interconsulta.peso ? interconsulta.peso.toString() : 'N/A'
            }
          />
          <InfoField
            label="Talla"
            value={
              interconsulta.talla ? interconsulta.talla.toString() : 'N/A'
            }
          />
        </div>

        <div className="grid grid-cols-1 gap-4 mt-4">
          <InfoField
            label="Criterio Diagnóstico"
            value={interconsulta.criterio_diagnostico || 'N/A'}
          />
          <InfoField
            label="Plan de Estudio"
            value={interconsulta.plan_de_estudio || 'N/A'}
          />
          <InfoField
            label="Sugerencia Diagnóstica"
            value={interconsulta.sugerencia_diagnostica || 'N/A'}
          />
          <InfoField
            label="Resumen del Interrogatorio"
            value={interconsulta.resumen_del_interrogatorio || 'N/A'}
          />
          <InfoField
            label="Exploración Física"
            value={interconsulta.exploracion_fisica || 'N/A'}
          />
          <InfoField
            label="Estado Mental"
            value={interconsulta.estado_mental || 'N/A'}
          />
          <InfoField
            label="Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento"
            value={
              interconsulta
                .resultados_relevantes_del_estudio_diagnostico ||
              'N/A'
            }
          />
          <InfoField
            label="Tratamiento "
            value={interconsulta.tratamiento || 'N/A'}
          />
          <InfoField
            label="Pronóstico"
            value={interconsulta.pronostico || 'N/A'}
          />
          <InfoField
            label="Motivo de la Atención o Interconsulta"
            value={
              interconsulta.motivo_de_la_atencion_o_interconsulta ||
              'N/A'
            }
          />
          <InfoField
            label="Diagnóstico o Problemas Clínicos"
            value={
              interconsulta.diagnostico_o_problemas_clinicos || 'N/A'
            }
          />
        </div>
      </InfoCard>

      {/* Tabla de honorarios */}
      <div className="mt-8">
        <h2 className="text-xl font-semibold text-gray-800 mb-4">
          Honorarios Asociados
        </h2>

        {honorarios.length === 0 ? (
          <p className="text-sm text-gray-600">
            No hay honorarios registrados.
          </p>
        ) : (
          <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200 border rounded-lg">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID
                  </th>
                  <th className="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Monto
                  </th>
                  <th className="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Descripción
                  </th>
                  <th className="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Fecha
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white divide-y divide-gray-200">
                {honorarios.map((h) => (
                  <tr key={h.id}>
                    <td className="px-4 py-2">{h.id}</td>
                    <td className="px-4 py-2">
                      ${Number(h.monto).toFixed(2)}
                    </td>
                    <td className="px-4 py-2">
                      {h.descripcion ?? '-'}
                    </td>
                    <td className="px-4 py-2">
                      {h.created_at
                        ? new Date(h.created_at).toLocaleString()
                        : '-'}
                    </td>
                  </tr>
                ))}
              </tbody>
              <tfoot>
                <tr className="bg-gray-50">
                  <td className="px-4 py-2 font-semibold" colSpan={1}>
                    Total
                  </td>
                  <td className="px-4 py-2 font-semibold">
                    $
                    {typeof honorarios_total !== 'undefined'
                      ? Number(honorarios_total).toFixed(2)
                      : honorarios
                          .reduce(
                            (acc, h) => acc + Number(h.monto || 0),
                            0
                          )
                          .toFixed(2)}
                  </td>
                  <td colSpan={2}></td>
                </tr>
              </tfoot>
            </table>
          </div>
        )}
      </div>

      {/* Botón agregar honorario */}
      <div className="mt-6">
        <Link
          href={route(
            'pacientes.estancias.interconsultas.honorarios.create',
            {
              paciente: paciente.id,
              estancia: estancia.id,
              interconsulta: interconsulta.id,
            }
          )}
          className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
        >
          <Plus size={16} className="mr-2" />
          Agregar Honorario
        </Link>
      </div>

      {/* Acciones */}
      <div className="mt-8 flex space-x-4">
        <Link
          href={route('interconsultas.edit', {
            interconsulta: interconsulta.id,
          })}
          className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
        >
          <Pencil size={16} className="mr-2" />
          Editar Interconsulta
        </Link>

        <a
          href={route('interconsultas.pdf', {
            interconsulta: interconsulta.id,
          })}
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
  const { estancia, paciente } = page.props as ShowInterconsultaProps;

  return (
    <MainLayout
      pageTitle={`Detalles de Interconsulta de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
};

export default Show;
