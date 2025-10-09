import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil } from 'lucide-react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

import BackButton from '@/components/ui/back-button';
import AddButton from '@/components/ui/add-button';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

type Doctor = {
  id: number;
  nombre: string;  // Campo crudo (opcional ahora)
  apellido_paterno: string;
  apellido_materno: string | null;
  nombre_completo: string;  // AGREGADO: Del accessor (usa directo)
  fecha_nacimiento: string;  // Formateada del accessor
  sexo?: string;
  curp?: string;
  cargo: string;  // Del accessor
  colaborador_responsable: {
    id: number;
    nombre_completo: string;  // Del accessor del responsable
  } | null;
  email: string;
  created_at: string;
};

type ShowDoctorProps = {
  doctor: Doctor;
};

const Show = ({ doctor }: ShowDoctorProps) => {
  // DEBUG: Ver en consola
  React.useEffect(() => {
    console.log('Doctor recibido en Show:', doctor);
  }, [doctor]);

  // Usa nombre_completo directo (del accessor) – más simple
  const nombreCompleto = doctor.nombre_completo || `${doctor.nombre || ''} ${doctor.apellido_paterno || ''} ${doctor.apellido_materno || ''}`.trim();

  return (
    <>
      <Head title={`Doctor: ${nombreCompleto}`} />
      
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
             
          </div>
          
          <div className="flex items-center space-x-2">
            <AddButton href={route('doctores.create')}>
              Agregar Doctor
            </AddButton>
            
            <Link
              href={route('doctores.edit', doctor.id)}
              className="p-2 text-blue-500 hover:bg-blue-100 hover:text-blue-700 rounded-full transition"
              title="Editar doctor"
            >
              <Pencil size={18} />
            </Link>
          </div>
        </div>
        
        <InfoCard title="Datos del Doctor">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <InfoField
              label="Nombre Completo"
              value={nombreCompleto}  // Usa accessor o fallback
            />
            <InfoField
              label="Sexo"
              value={doctor.sexo || 'No especificado'}
            />
            <InfoField
              label="Fecha de Nacimiento"
              value={doctor.fecha_nacimiento || 'No especificada'}
            />
            <InfoField
              label="CURP"
              value={doctor.curp || 'No proporcionada'}
            />
            <InfoField
              label="Cargo"
              value={doctor.cargo}
            />
            <InfoField
              label="Colaborador Responsable"
              value={doctor.colaborador_responsable?.nombre_completo || 'Sin responsable'}
              className="md:col-span-2"
            />
          </div>
        </InfoCard>

        <InfoCard title="Información de Contacto" className="mt-8">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InfoField
              label="Email"
              value={doctor.email || 'No proporcionado'}
            />
            <InfoField
              label="Registrado el"
              value={doctor.created_at || 'No disponible'}
            />
          </div>
        </InfoCard>
      </div>
    </>
  );
};

Show.layout = (page: React.ReactElement) => (
  <MainLayout pageTitle="Ficha del Doctor" children={page} />
);

export default Show;
