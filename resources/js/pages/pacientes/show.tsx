import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Eye, Pencil } from 'lucide-react';
import MainLayout from '@/layouts/MainLayout';
import {route} from 'ziggy-js';

import BackButton from '@/components/ui/back-button';
import AddButton from '@/components/ui/add-button';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';


type Estancia = {
    id: number;
    folio: string;
    fecha_ingreso: string;
    fecha_egreso: string | null; 
    num_habitacion: string | null;
    tipo_estancia: string;
};


type Paciente = {
    id: number;
    curp: string;
    nombre: string;
    apellido_paterno: string;
    apellido_materno: string;
    sexo: string;
    fecha_nacimiento: string;
    calle: string;
    numero_exterior: string;
    numero_interior: string | null;
    colonia: string;
    municipio: string;
    estado: string;
    pais: string;
    cp: string;
    telefono: string;
    estado_civil: string;
    ocupacion: string;
    lugar_origen: string;
    nombre_padre: string;
    nombre_madre: string;
    estancias: Estancia[];
};

type ShowProps = {
    paciente: Paciente;
};

const Show = ({ paciente }: ShowProps) => {
    
  return (
    <>
      <Head title={`Paciente: ${paciente.nombre}`} />
      
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">



        <div>
          <BackButton />
        </div>
          
        </div>
        
    <InfoCard title="Datos Personales">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <InfoField
                label="Nombre Completo"
                value={`${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
            />
            <InfoField
                label="CURP"
                value={paciente.curp}
            />
            <InfoField
                label="Fecha de Nacimiento"
                value={paciente.fecha_nacimiento}
            />
            <InfoField
                label="Sexo"
                value={paciente.sexo}
            />
            <InfoField
                label="Estado Civil"
                value={paciente.estado_civil}
            />
            <InfoField
                label="Ocupación"
                value={paciente.ocupacion}
            />
        </div>
    </InfoCard>

    <InfoCard title="Información de Contacto" className="mt-8">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <InfoField
                label="Teléfono"
                value={paciente.telefono}
            />
            <InfoField
                label="Dirección"
                className="md:col-span-2"
                value={
                    <>
                        <p className="text-lg text-black">
                            {`${paciente.calle} ${paciente.numero_exterior} ${paciente.numero_interior || ''}, Col. ${paciente.colonia}, C.P. ${paciente.cp}`}
                        </p>
                        <p className="text-base text-black">{`${paciente.municipio}, ${paciente.estado}, ${paciente.pais}`}</p>
                    </>
                }
            />
        </div>
    </InfoCard>

        <AddButton href={route('pacientes.estancias.create', { paciente: paciente.id })}>
            Añadir Estancia
        </AddButton>

      </div>
          <h2 className="text-xl font-semibold border-b pb-2 mt-8 mb-4">Historial de Estancias</h2>
<div className="space-y-4">
            {paciente.estancias && paciente.estancias.length > 0 ? (
              paciente.estancias.map((estancia) => (
                // 2. Contenedor principal ahora usa flexbox para alinear los elementos
                <div key={estancia.id} className="p-4 border rounded-md bg-gray-50 flex justify-between items-center">
                  
                  {/* Div para la información de la estancia */}
                  <div>
                    <p className="text-sm font-semibold text-gray-700">
                        Folio: {estancia.folio}
                    </p>
                    <p className="text-sm text-gray-600">
                      Fecha de Ingreso: {estancia.fecha_ingreso}
                    </p>
                    <p className="text-sm text-gray-600">
                      Fecha de Alta: {estancia.fecha_egreso || (estancia.tipo_estancia === "Hospitalizacion" ? 'Aún hospitalizado(a)' : '')}
                    </p>
                  </div>

                  {/* 3. Div para los botones de acción */}
                  <div className="flex items-center space-x-2">
                    
                    {/* Botón para Visualizar */}
                    <Link 
                      href={route('estancias.show', estancia.id)}
                      className="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition"
                      title="Ver detalles"
                    >
                      <Eye size={18} />
                    </Link>

                    {/* Botón para Editar */}
                    <Link 
                      href={route('estancias.edit', estancia.id)}
                      className="p-2 text-blue-500 hover:bg-blue-100 hover:text-blue-700 rounded-full transition"
                      title="Editar estancia"
                    >
                      <Pencil size={18} />
                    </Link>

                  </div>
                </div>
              ))
            ) : (
              <p className="text-gray-500 italic">No hay estancias registradas para este paciente.</p>
            )}
          </div>
    </>
  );
};

Show.layout = (page: React.ReactElement) => (
  <MainLayout title="Ficha del Paciente" children={page} />
);

export default Show;