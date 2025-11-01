import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil, Printer } from 'lucide-react';
import { route } from 'ziggy-js';
import MainLayout from '@/layouts/MainLayout';
import { Interconsulta, Paciente, Estancia, User, Honorario } from '@/types';

import InfoCard from '@/components/ui/info-card';


interface ShowHonorarioProps {
  interconsulta: Interconsulta & {
    formularioInstancia?: {
      user?: User;
      estancia: Estancia & { paciente: Paciente };
    };
  };
  paciente: Paciente;
  estancia: Estancia;
  honorario: Honorario;
}

const Show = ({ interconsulta, paciente, estancia, honorario }: ShowHonorarioProps) => {
    const { Interconsulta } = honorario;

    
  const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };

 

  return (
    <>
      <Head title={`Detalles del Honorario: ${honorario.id}`} />
     <InfoCard title={`Honorarios de la Interconsulta para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
      <div className="p-4 md:p-8">
        <h1 className="text-2xl font-bold mb-4">{`Honorario para la Interconsulta #${interconsulta.id} de ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}</h1>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
          <div>
            <label className="block text-sm font-medium text-gray-700">Monto</label>
            <p className="mt-1 text-sm text-gray-900">{honorario.monto ? String(honorario.monto) : 'N/A'}</p>
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700">Descripción</label>
            <p className="mt-1 text-sm text-gray-900">{honorario.descripcion || 'N/A'}</p>
          </div>
          <div>
            <label className="block text-sm font-medium text-gray-700">Fecha de Creación</label>
            <p className="mt-1 text-sm text-gray-900">{honorario.created_at ? new Date(honorario.created_at).toLocaleString('es-MX', dateOptions) : 'N/A'}</p>
          </div>
        </div>

        <div className="grid grid-cols-1 gap-4">
          <div>
            <label className="block text-sm font-medium text-gray-700">Fecha de Actualización</label>
            <p className="mt-1 text-sm text-gray-900">{honorario.updated_at ? new Date(honorario.updated_at).toLocaleString('es-MX', dateOptions) : 'N/A'}</p>
          </div>
        </div>
      </div>

      <div className="mt-8 flex space-x-4 px-4 md:px-8">
        <Link
          href={route('pacientes.estancias.interconsultas.honorarios.edit', {
            paciente: paciente.id,
            estancia: estancia.id,
            interconsulta: interconsulta.id,
            honorario: honorario.id
          })}
          className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
        >
          <Pencil size={16} className="mr-2" />
          Editar Honorario
        </Link>

        <a
          href={route('pacientes.estancias.interconsultas.honorarios.pdf', {
            paciente: paciente.id,
            estancia: estancia.id,
            interconsulta: interconsulta.id,
            honorario: honorario.id
          })}
          target="_blank"
          className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
        >
          <Printer size={16} className="mr-2" />
          Imprimir PDF
        </a>

        <Link
          href={route('pacientes.estancias.interconsultas.show', {
            paciente: paciente.id,
            estancia: estancia.id,
            interconsulta: interconsulta.id
          })}
          className="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
        >
          Volver a Interconsulta
        </Link>
      </div>
    </InfoCard>
    </>
  );
};

Show.layout = (page: React.ReactElement) => {
  const { paciente } = page.props as ShowHonorarioProps;
  return (
    <MainLayout pageTitle={`Detalles del Honorario de ${paciente?.nombre || 'Paciente'}`} children={page} />
  );
};

export default Show;