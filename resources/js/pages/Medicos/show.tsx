import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Pencil } from 'lucide-react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

import AddButton from '@/components/ui/add-button';
import {User, CredencialEmpleado} from "@/types";
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';



type ShowDoctorProps = {
  doctor?: User; 
  credencial?: CredencialEmpleado;
};

const Show = ({ doctor, credencial }: ShowDoctorProps) => {
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
  const fechaNacimientoFormatted = doctor.fecha_nacimiento || 
    (doctor.fecha_nacimiento ? new Date(doctor.fecha_nacimiento).toLocaleDateString('es-MX') : 'No especificada');

  return (
    <>
      <Head title={`Doctor: ${doctor.nombre_completo}`} />
      
      <div >
        <div className="flex justify-between items-center mb-6">
          
          
          <h1 className="flex-1 text-center text-3xl font-bold text-black">
            Ficha del Doctor: {doctor.nombre_completo}
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
              value={doctor.nombre_completo}
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
            {/*<InfoField
              label="Cargo"
              value={doctor.cargo || 'No asignado'}
            />  
            <InfoField
              label="Colaborador Responsable"
              value={doctor.colaborador_responsable_id || 'Sin responsable'}
              className="md:col-span-2"
            />
            */}
          </div>
        </InfoCard>
<InfoCard title="Calificaciones Profesionales" className="mt-8">
  {Array.isArray(credencial) && credencial.length > 0 ? (
    <div className="overflow-x-auto">
      <table className="w-full border-collapse border border-gray-300 bg-white rounded-lg shadow">
        <thead className="bg-gray-100">
          <tr>
            <th className="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Título</th>
            <th className="border border-gray-300 px-4 py-2 text-left font-semibold text-gray-700">Cédula Profesional</th>
          </tr>
        </thead>
        <tbody>
          {credencial.map((item, index) => (
            <tr key={index} className="hover:bg-gray-50 transition-colors">
              <td className="border border-gray-300 px-4 py-2 text-gray-800">
                {item.titulo || 'No especificado'}
              </td>
              <td className="border border-gray-300 px-4 py-2 text-gray-800 font-mono">
                {item.cedula_profesional || item.cedula || 'Sin cédula'}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  ) : (
    <div className="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
      <p className="text-gray-500 text-sm italic">
        No se han encontrado títulos registrados para este doctor.
      </p>
    </div>
  )}
</InfoCard>
        

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
