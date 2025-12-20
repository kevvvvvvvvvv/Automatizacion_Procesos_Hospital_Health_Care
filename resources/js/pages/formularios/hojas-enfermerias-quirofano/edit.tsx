import { Estancia, HojaEnfermeriaQuirofano, Paciente, ProductoServicio, User } from '@/types';
import React, { useState } from 'react';
import { Head } from '@inertiajs/react';

import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import Checkbox from '@/components/ui/input-checkbox';

import InsumosBasicosForm from '@/components/forms/insumos-basicos-form';
import EnvioPieza from '@/components/forms/envio-piezas-form';
import GeneralesForm from  '@/components/forms/generales-form';
import PersonalQuirurgicoForm from '@/components/forms/personal-quirurgico-form';
import ServiciosEspecialesForm from '@/components/forms/servicios-especiales-form';


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
        <nav className="mb-6 mt-12">
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

    const Servicios = () => (
        <>
        <div className='grid grid-cols-1 md:grid-cols-3 pb-15'>
            <div>
                <h3 className='pb-3 text-xl font-bold'>
                    Equipo de laparoscopía
                </h3>

                <Checkbox
                    id="torre"
                    label="Torre"
                />

                <Checkbox
                    id="armonico"
                    label="Armonico"
                />    

                <Checkbox
                    id="ligashure"
                    label="Ligashure"
                />

               <Checkbox
                    id="grapas_extras"
                    label="Grapas extras"
                />   

                <Checkbox
                    id="bolsa_endo"
                    label="Bolsa endo"
                />
                <Checkbox
                    id="arco_c"
                    label="Arco en C"
                />   
            </div>
        </div>

            <ServiciosEspecialesForm
                estancia={estancia}/>
        </>
    )

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'general':
                return <GeneralesForm
                        hoja={hoja}/>
            case 'insumos':
                return <InsumosBasicosForm
                        hoja={hoja}
                        materiales={insumos}/>
            case 'pieza_patologica':
                return <EnvioPieza
                        hoja={hoja}/>
            case 'servicios_especiales':
                return <Servicios/>
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

            <NavigationTabs/>

            <div className='mt-4'>
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