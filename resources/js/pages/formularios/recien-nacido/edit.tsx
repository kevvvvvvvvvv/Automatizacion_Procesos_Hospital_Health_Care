import React, { useState } from 'react'; 
import { 
    Paciente, 
    Estancia, 
    ProductoServicio, 
    HojaEnfermeria, 
    HojaSignosGraficas, 
    CatalogoViaAdministracion,
    RecienNacido
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
import SomatometriaForm from '@/components/forms/somatometria-form';
import IngresosEgresosForm from '@/components/forms/ingresosrn-form';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hoja: RecienNacido;
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
    //hojaenfermeria,
    medicamentos, 
    soluciones, 
    vias_administracion,
    hoja,
    dataParaGraficas 
}) => {

    const [activeSection, setActiveSection] = useState<SeccionRN>('signos');

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'signos':
                return <SignosVitalesForm 
                            hoja={hoja} 
                        />;
            case 'medicamentos':
                return <MedicamentosForm 
                            hoja={hoja}
                            medicamentos={medicamentos}
                            vias_administracion={vias_administracion}
                        />;
            case 'soluciones':
                return <TerapiaIVForm
                            hoja={hoja}
                            soluciones={soluciones}
                            medicamentos={medicamentos}
                        />;
            case 'ingresos_egresos':
                return <IngresosEgresosForm
                    hoja={hoja}
                        />;
            case 'somatometria':
                return <SomatometriaForm 
                            hoja={hoja} 
                        />;
            default:
                return null;
        }
    };
// Si usas props
    return (
        <> 
            <Head title="Hoja de Enfermería Neonatal" />
            
            {/* Tarjeta de identificación del Neonato */}
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <div className="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mt-6 p-6">
                

                <CerrarHoja 
                    // Cambiamos 'reciennacido' por 'hoja', que es donde vienen tus datos
                    hoja={hoja} 
                    title="Hoja de Recién Nacido"
                    routeConfig={{ 
                        name: 'reciennacido.update', 
                        // Usamos hoja.id porque 'hoja' es la prop que recibe el componente
                        params: { reciennacido: hoja?.id } 
                    }}
                />
                    <div className="flex justify-between items-center mb-6 border-b pb-4">
                    
                    <div>
                        <h1 className="text-xl font-bold text-gray-800">Hoja de Control Neonatal</h1>
                        <p className="text-sm text-gray-500">Registro clínico especializado para recién nacidos</p>
                    </div>
                    
                    
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
