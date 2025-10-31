import React, { useState } from 'react'; 
import { Paciente, Estancia, ProductoServicio, HojaEnfermeria, HojaSignosGraficas } from '@/types';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import TerapiaIVForm from '@/components/terapia-iv-form';
import SignosVitalesForm from '@/components/signos-vitales-form';
import GraficaContent from '@/components/graphs/grafica-content'
import MedicamentosForm from '@/components/forms/medicamentos-form';
import SondasCateteresForm from '@/components/forms/sondas-cateteres-form';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hojaenfermeria: HojaEnfermeria;
    medicamentos: ProductoServicio[];
    soluciones: ProductoServicio[];
    dataParaGraficas: HojaSignosGraficas[];
}


type SeccionHoja = 'signos' | 'medicamentos' | 'terapia_iv' | 'estudios' | 'sondas' | 'liquidos' | 'dieta' | 'observaciones' | 'graficas';

const secciones: { id: SeccionHoja, label: string }[] = [
    { id: 'signos', label: 'Tomar Signos' },
    { id: 'medicamentos', label: 'Ministración de Medicamentos' },
    { id: 'terapia_iv', label: 'Terapia Intravenosa' },
    { id: 'estudios', label: 'Ordenar Estudios' },
    { id: 'sondas', label: 'Sondas y Catéteres' },
    { id: 'liquidos', label: 'Control de Líquidos' },
    { id: 'dieta', label: 'Dieta' },
    { id: 'observaciones', label: 'Observaciones' },
    { id: 'graficas', label: 'Gráficas' },
];



type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ paciente, estancia, hojaenfermeria ,medicamentos, soluciones, dataParaGraficas}) => {

    const [activeSection, setActiveSection] = useState<SeccionHoja>('signos');

    const NavigationTabs = () => (
        <nav className="mb-6 -mt-2">
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
            case 'signos':
                return <SignosVitalesForm 
                    hoja={hojaenfermeria}/>;
            case 'medicamentos':
                return <MedicamentosForm 
                        hoja={hojaenfermeria}
                        medicamentos={medicamentos}/>;
            case 'terapia_iv':
                return <TerapiaIVForm
                        hoja={hojaenfermeria}
                        soluciones={soluciones}/>;
            //case 'estudios':
            case 'sondas':
                return <SondasCateteresForm
                        hoja={hojaenfermeria}
                        estancia={estancia}/>
            case 'liquidos':
                return <div><p>Campos para Control de Líquidos...</p></div>;
            case 'dieta':
                return <div><p>Campos para Dieta...</p></div>;
            case 'graficas':
                return <GraficaContent
                        historialSignos={dataParaGraficas ?? []}/>
            default:
                return null;
        }
    }

    return (
        <> 
            <Head title="Hoja de enfermería" />
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />
            <div className="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 mt-6 p-6">
                <NavigationTabs />
                
                <div className="mt-4">
                    {renderActiveSection()}
                </div>
            </div>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Creación de hoja de enfermería' children={page} />
    );
}

export default Create;