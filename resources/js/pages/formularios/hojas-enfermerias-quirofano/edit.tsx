import { Estancia, HojaEnfermeriaQuirofano, Paciente, ProductoServicio, User } from '@/types';
import React, { useState } from 'react';
import { Head } from '@inertiajs/react';

import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';

import InsumosBasicosForm from '@/components/forms/insumos-basicos-form';
import GeneralesForm from  '@/components/forms/generales-form';
import PersonalQuirurgicoForm from '@/components/forms/personal-quirurgico-form';
import EquipoLaparoscopiaForm from '@/components/forms/equipo-laparoscopia-form';
import EnvioPiezaHojaEnfermeria from '@/components/forms/envio-pieza-hoja-enfermeria-form';



interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeriaQuirofano,
    insumos: ProductoServicio[];
    users: User[];
}

type SeccionHoja = 'insumos' | 'servicios_especiales' | 'pieza_patologica' | 'general' | 'personal';



type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
}

const secciones: {id: SeccionHoja, label: string}[] = [
    { id: 'general', label: 'General' },
    { id: 'insumos', label : 'Insumos' },
    { id: 'servicios_especiales', label: 'Servicios espciales' },
    { id: 'pieza_patologica', label: 'Envio de pieza patológica' },
    { id: 'personal', label: 'Personal' }
];

const CreateHojaEnfermeriaQuirofano:CreateComponent = ({paciente, estancia, hoja, insumos, users}) => {
    const [activeSection, setActiveSection] = useState<SeccionHoja>('general');

    const NavigationTabs = () => (
        <nav className="mb-6">
            <div className="border-b border-gray-200">
                <div className="flex flex-wrap -mb-px gap-x-6 gap-y-2" aria-label="Tabs">
                    {secciones.map((seccion) => (
                        <button
                            key={seccion.id}
                            type="button" 
                            onClick={() => setActiveSection(seccion.id)}
                            className={`
                                ${activeSection === seccion.id
                                    ? 'border-blue-500 text-blue-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                }
                                whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors duration-150
                            `}
                        >
                            {seccion.label}
                        </button>
                    ))}
                </div>
            </div>
        </nav>
    );

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'general':
                return <GeneralesForm
                            hoja={hoja}
                        />
            case 'insumos':
                return <InsumosBasicosForm
                            hoja={hoja}
                            materiales={insumos}
                        />
            case 'pieza_patologica':
                return <EnvioPiezaHojaEnfermeria
                            medicos={users}
                            modeloId={hoja.id}
                            modeloTipo='App\Models\HojaEnfermeriaQuirofano'
                            estancia={estancia}
                        />
            case 'servicios_especiales':
                return <EquipoLaparoscopiaForm
                            hoja={hoja}
                        />
            case 'personal':
                return <PersonalQuirurgicoForm
                            itemableId={hoja.id}
                            itemableType='hoja'
                            users={users}
                            personalEmpleados={hoja.personal_empleados}
                        />

            default:
                return null;
        }
    }

    return (
        <>
            <Head title='Creación de la hoja de enfermería en quirófano'/>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <div className='mt-4 bg-white p-6 border rounded-lg shadow-sm'>
                <NavigationTabs/>
                {renderActiveSection()}
            </div>
        </>

    )
}

CreateHojaEnfermeriaQuirofano.layout = (page: React.ReactElement) => {

    const {estancia} = page.props as CreateProps;

    return <MainLayout 
    pageTitle='Edición de la hoja de enfermería en quirófano' 
    children={page} 
    link="estancias.show" 
    linkParams={estancia.id}/>
}


export default CreateHojaEnfermeriaQuirofano;