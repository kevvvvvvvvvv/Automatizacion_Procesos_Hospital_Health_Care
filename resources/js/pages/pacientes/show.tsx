import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Eye, Pencil } from 'lucide-react';
import MainLayout from '@/layouts/MainLayout';
import {route} from 'ziggy-js';

import AddButton from '@/components/ui/add-button';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
import { Paciente } from '@/types';


type ShowProps = {
    paciente: Paciente;
};

const Show = ({ paciente }: ShowProps) => {
    
    return (
        <>
            <Head title={`Consulta de paciente`} />
            
            <div className=""> 
                <InfoCard title="Datos personales">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <InfoField
                            label="Nombre completo"
                            value={`${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
                        />
                        <InfoField
                            label="CURP"
                            value={paciente.curp}
                        />
                        <InfoField
                            label="Edad"
                            value={`${paciente.age} años`}
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

                <InfoCard title="Información de contacto" className="mt-8 mb-8">
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

                <div className="flex justify-end w-full">
                    <AddButton href={route('pacientes.estancias.create', { paciente: paciente.id })}>
                        Añadir estancia
                    </AddButton>
                </div>
            </div>

            <h2 className="text-xl font-semibold border-b pb-2 mt-8 mb-4">Historial de estancias</h2>
            <div className="space-y-4">
                {paciente.estancias && paciente.estancias.length > 0 ? (
                paciente.estancias.map((estancia) => (
                    <div key={estancia.id} className="p-4 border rounded-md bg-gray-50 flex justify-between items-center">
                        <div>
                            <p className="text-sm font-semibold text-gray-700">
                                Folio: {estancia.folio}
                            </p>
                            <p className="text-sm text-gray-600">
                            Fecha de ingreso: {estancia.fecha_ingreso}
                            </p>
                            <p className="text-sm text-gray-600">
                            Fecha de alta: {estancia.fecha_egreso || (estancia.tipo_estancia === "Hospitalizacion" ? 'Aún hospitalizado(a)' : '')}
                            </p>
                        </div>

                        <div className="flex items-center space-x-2">

                            <Link 
                            href={route('estancias.show', estancia.id)}
                            className="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition"
                            title="Ver detalles"
                            >
                            <Eye size={18} />
                            </Link>
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
    <MainLayout pageTitle="Consulta de paciente" children={page} link='pacientes.index'/>
);

export default Show;