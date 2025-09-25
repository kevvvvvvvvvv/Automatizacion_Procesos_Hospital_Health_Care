import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

// Definimos un tipo más completo para el paciente, incluyendo todos sus datos.
type Paciente = {
  curpp: string;
  nombre: string;
  apellidop: string;
  apellidom: string;
  sexo: string;
  fechaNacimiento: string;
  calle: string;
  numeroExterior: string;
  numeroInterior: string | null;
  colonia: string;
  municipio: string;
  estado: string;
  pais: string;
  cp: string;
  telefono: string;
  estadoCivil: string;
  ocupacion: string;
  lugarOrigen: string;
  nombrePadre: string;
  nombreMadre: string;
};

// Las props que esta página recibe del controlador.
type ShowProps = {
  paciente: Paciente;
};

const Show = ({ paciente }: ShowProps) => {
  return (
    <>
      <Head title={`Paciente: ${paciente.nombre}`} />
      
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-3xl font-bold text-black">
            Ficha del Paciente
          </h1>
          <Link 
            href={route('pacientes.index')} 
            className="text-blue-600 hover:underline"
          >
            &larr; Volver al listado
          </Link>
        </div>
        
        <div className="mt-6 p-6 bg-white rounded-lg shadow-md">
          {/* Sección de Datos Personales */}
          <h2 className="text-xl font-semibold border-b pb-2 mb-4">Datos Personales</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <p className="text-sm text-gray-500">Nombre Completo</p>
              <p className="text-lg text-black">{`${paciente.nombre} ${paciente.apellidop} ${paciente.apellidom}`}</p>
            </div>
            <div>
              <p className="text-sm text-gray-500">CURP</p>
              <p className="text-lg font-mono text-black">{paciente.curpp}</p>
            </div>
             <div>
              <p className="text-sm text-gray-500">Fecha de Nacimiento</p>
              <p className="text-lg text-black">{paciente.fechaNacimiento}</p>
            </div>
             <div>
              <p className="text-sm text-gray-500">Sexo</p>
              <p className="text-lg text-black">{paciente.sexo}</p>
            </div>
            <div>
              <p className="text-sm text-gray-500">Estado Civil</p>
              <p className="text-lg text-black">{paciente.estadoCivil}</p>
            </div>
             <div>
              <p className="text-sm text-gray-500">Ocupación</p>
              <p className="text-lg text-black">{paciente.ocupacion}</p>
            </div>
          </div>

          {/* Sección de Contacto */}
          <h2 className="text-xl font-semibold border-b pb-2 mt-8 mb-4">Información de Contacto</h2>
           <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p className="text-sm text-gray-500">Teléfono</p>
                <p className="text-lg text-black">{paciente.telefono || 'No registrado'}</p>
            </div>
            <div className="col-span-2">
                <p className="text-sm text-gray-500">Dirección</p>
                <p className="text-lg text-black">
                    {`${paciente.calle} ${paciente.numeroExterior} ${paciente.numeroInterior || ''}, Col. ${paciente.colonia}, C.P. ${paciente.cp}`}
                </p>
                <p className="text-base text-black">{`${paciente.municipio}, ${paciente.estado}, ${paciente.pais}`}</p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

// Asignamos el layout persistente
Show.layout = (page: React.ReactNode) => <MainLayout children={page} />;

export default Show;