import React, { useState } from 'react'; 
import { 
    Paciente, 
    Estancia, 
    ProductoServicio, 
    HojaEnfermeria, 
    HojaSignosGraficas, 
    CatalogoViaAdministracion 
} from '@/types';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import NavegationTab from '@/components/navegation-tab';

// Componentes de Formulario (Asegúrate de crear estos específicos para RN)
import SignosVitalesForm from '@/components/forms/signos-vitales-form';
import MedicamentosForm from '@/components/forms/medicamentos-form';
import TerapiaIVForm from '@/components/terapia-iv-form';
import CerrarHoja from '@/components/app-cerrrar-hoja';
import reciennacido from '@/routes/reciennacido';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hojaenfermeria: HojaEnfermeria; // Tu instancia de RecienNacido o Hoja RN
    medicamentos: ProductoServicio[];
    soluciones: ProductoServicio[];
    vias_administracion: CatalogoViaAdministracion[];
    dataParaGraficas: HojaSignosGraficas[];
}

// Definición de las 5 áreas solicitadas
type SeccionRN = 'signos' | 'medicamentos' | 'soluciones' | 'ingresos_egresos' | 'somatometria';

const seccionesRN: { id: SeccionRN, label: string }[] = [
    { id: 'signos', label: 'Registro de Signos' },
    { id: 'medicamentos', label: 'Medicamentos' },
    { id: 'soluciones', label: 'Soluciones / Terapias' },
    { id: 'ingresos_egresos', label: 'Ingresos y Egresos' },
    { id: 'somatometria', label: 'Somatometría' },
];
type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const Create: CreateComponent = ({ 
    paciente, 
    estancia, 
    hojaenfermeria,
    medicamentos, 
    soluciones, 
    vias_administracion,
    dataParaGraficas 
}) => {

    const [activeSection, setActiveSection] = useState<SeccionRN>('signos');

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'signos':
                return <SignosVitalesForm 
                            hoja={hojaenfermeria} 
                        />;
            case 'medicamentos':
                return <MedicamentosForm 
                            hoja={hojaenfermeria}
                            medicamentos={medicamentos}
                            vias_administracion={vias_administracion}
                        />;
            case 'soluciones':
                return <TerapiaIVForm
                            hoja={hojaenfermeria}
                            soluciones={soluciones}
                            medicamentos={medicamentos}
                        />;
            /*case 'ingresos_egresos':
                return < ''
                        />;
            case 'somatometria':
                return <SomatometriaRNForm 
                            hoja={hojaenfermeria} 
                        />;*/
            default:
                return null;
        }
    };

    return (
        <> 
            <Head title="Hoja de Enfermería Neonatal" />
            
            {/* Tarjeta de identificación del Neonato */}
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <div className="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mt-6 p-6">
                <div className="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h1 className="text-xl font-bold text-gray-800">Hoja de Control Neonatal</h1>
                        <p className="text-sm text-gray-500">Registro clínico especializado para recién nacidos</p>
                    </div>
                    
                    <CerrarHoja 
                        hoja={hojaenfermeria} 
                        title='hoja neonatal'
                        routeConfig={{ 
                            name: 'reciennacido.update', // 1. Asegúrate que este sea el nombre de tu ruta
                            params: { reciennacido: hojaenfermeria.id } // 2. El nombre de la llave debe coincidir con el parámetro de la ruta
                        }}
                    />
                </div>

                {/* Navegación por áreas */}
                <NavegationTab
                    tabs={seccionesRN}
                    activeTab={activeSection}
                    onTabChange={setActiveSection}
                />
                
                {/* Contenedor dinámico de formularios */}
                <div className="mt-8 transition-all duration-300">
                    {renderActiveSection()}
                </div>
            </div>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {
    const { estancia } = page.props as CreateProps;
    return (
        <MainLayout 
            pageTitle='Hoja de Enfermería - Recién Nacidos' 
            children={page} 
            link="estancias.show" 
            linkParams={estancia.id}
        />
    );
}

export default Create;
