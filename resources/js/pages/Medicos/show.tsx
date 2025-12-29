import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil } from 'lucide-react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

import AddButton from '@/components/ui/add-button';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

type Doctor = {
  id: number;
  nombre?: string;  // Opcional, como indicas
  apellido_paterno: string;
  apellido_materno?: string | null;
  nombre_completo?: string;  // Accessor (opcional si no se envía)
  fecha_nacimiento?: string;  // Accessor formateado (opcional)
  sexo?: string;
  curp?: string;
  cargo?: string;  // Accessor (opcional)
  colaborador_responsable?: {
    id: number;
    nombre_completo: string;
  } | null;
  email: string;
  created_at: string;
  professional_qualifications?: Array<{  // AGREGADO: Para títulos y cédulas (basado en CreateDoctor)
    titulo: string;
    cedula?: string;
  }>;  // Array de calificaciones, opcional
};

type ShowDoctorProps = {
  doctor?: Doctor;  // Opcional para manejar undefined
};

const Show = ({ doctor }: ShowDoctorProps) => {

  // Safeguard: Si no hay doctor, muestra error
  if (!doctor) {
    return (
      <div className="p-4 md:p-8">
        <div className="bg-red-50 border border-red-200 rounded-lg p-4">
          <h1 className="text-xl font-bold text-red-800 mb-2">Error</h1>
          <p className="text-red-600">No se pudo cargar la información del doctor. Verifica la URL o contacta al administrador.</p>
        </div>
      </div>
    );
  }

  // Fallback para nombre completo: Prioriza accessor, luego construye
  const nombreCompleto = doctor.nombre_completo || 
    `${doctor.nombre || ''} ${doctor.apellido_paterno || ''} ${doctor.apellido_materno || ''}`.trim() || 
    'Nombre no disponible';

  // Formatear fecha si no es accessor
  const fechaNacimientoFormatted = doctor.fecha_nacimiento || 
    (doctor.fecha_nacimiento ? new Date(doctor.fecha_nacimiento).toLocaleDateString('es-MX') : 'No especificada');

  return (
    <>
      <Head title={`Doctor: ${nombreCompleto}`} />
      
      <div >
        <div className="flex justify-between items-center mb-6">
          
          
          <h1 className="flex-1 text-center text-3xl font-bold text-black">
            Ficha del Doctor: {nombreCompleto}
          </h1>
          
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
              value={nombreCompleto}
            />
            <InfoField
              label="Sexo"
              value={doctor.sexo || 'No especificado'}
            />
            <InfoField
              label="Fecha de Nacimiento"
              value={fechaNacimientoFormatted}
            />
            <InfoField
              label="CURP"
              value={doctor.curp || 'No proporcionada'}
            />
            <InfoField
              label="Cargo"
              value={doctor.cargo || 'No asignado'}
            />  
            <InfoField
              label="Colaborador Responsable"
              value={doctor.colaborador_responsable?.nombre_completo || 'Sin responsable'}
              className="md:col-span-2"
            />
          </div>
        </InfoCard>

        {/* AGREGADO: Sección para Calificaciones Profesionales (títulos y cédulas) */}
        {doctor.professional_qualifications && doctor.professional_qualifications.length > 0 && (
          <InfoCard title="Calificaciones Profesionales" className="mt-8">
            <div className="overflow-x-auto">
              <table className="w-full border-collapse border border-gray-300 bg-white rounded-lg shadow">
                <thead className="bg-gray-100">
                  <tr>
                    <th className="border border-gray-300 px-4 py-2 text-left">Título</th>
                    <th className="border border-gray-300 px-4 py-2 text-left">Cédula</th>
                  </tr>
                </thead>
                <tbody>
                  {doctor.professional_qualifications.map((qual, index) => (
                    <tr key={index} className="hover:bg-gray-50">
                      <td className="border border-gray-300 px-4 py-2">{qual.titulo}</td>
                      <td className="border border-gray-300 px-4 py-2">{qual.cedula || 'N/A'}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
            {doctor.professional_qualifications.length === 0 && (
              <p className="text-gray-500 text-sm italic mt-4">No hay calificaciones registradas.</p>
            )}
          </InfoCard>
        )}

        <InfoCard title="Información de Contacto" className="mt-8">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InfoField
              label="Email"
              value={doctor.email || 'No proporcionado'}
            />
            <InfoField
              label="Registrado el"
              value={new Date(doctor.created_at).toLocaleDateString('es-MX') || 'No disponible'}
            />
          </div>
        </InfoCard>
      </div>
    </>
  );
};
Show.layout = (page: React.ReactElement) => <MainLayout pageTitle='Consulta de doctor' children={page} link = 'doctores.index'/>
  


export default Show;
