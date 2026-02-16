import React, { useState } from 'react'; 
import { ChecklistItemData, Paciente, Estancia, ProductoServicio, HojaEnfermeria, HojaSignosGraficas, CatalogoEstudio, User, SolicitudEstudio, NotaPostoperatoria, notasEvoluciones, CategoriaDieta, CatalogoViaAdministracion } from '@/types';
import { Head } from '@inertiajs/react';
import 'sweetalert2/dist/sweetalert2.min.css';

import NavegationTab from '@/components/navegation-tab';

import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import TerapiaIVForm from '@/components/terapia-iv-form';
import SignosVitalesForm from '@/components/forms/signos-vitales-form';
import GraficaContent from '@/components/graphs/grafica-content'
import MedicamentosForm from '@/components/forms/medicamentos-form';
import SondasCateteresForm from '@/components/forms/sondas-cateteres-form';
import EstudiosForm from '@/components/forms/estudios-form';
import DietasForm from '@/components/forms/dietas-form';
import PlanPostoperatorioChecklist from '@/components/plan-postoperatorio-check-list';
import ServiciosEspecialesForm from '@/components/forms/servicios-especiales-form';
import EscalaValoracionForm from '@/components/forms/escalas-valoracion-form';
import ControlLiquidosForm from '@/components/forms/control-liquidos-form';
import HabitusExteriorForm from '@/components/forms/habitus-exterior-form';
import RiesgoCaidasForm from '@/components/forms/riesgo-caidas-form';
import CerrarHoja from '@/components/app-cerrrar-hoja';



interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hojaenfermeria: HojaEnfermeria;
    medicamentos: ProductoServicio[];
    soluciones: ProductoServicio[];
    sondas_cateters: ProductoServicio[];
    dataParaGraficas: HojaSignosGraficas[];
    catalogoEstudios: CatalogoEstudio[];
    solicitudesAnteriores: SolicitudEstudio[];
    medicos: User[];
    usuarios: User[];

    nota: notasEvoluciones | NotaPostoperatoria | null;
    checklistInicial:ChecklistItemData[];

    categoria_dietas: CategoriaDieta [];
    vias_administracion: CatalogoViaAdministracion[];
}

type SeccionHoja = 'signos' | 'riesgo_caidas' |'medicamentos' | 'terapia_iv' | 'estudios' | 'sondas' | 'dieta' | 'servicios_especiales' | 'observaciones' | 'graficas' | 'control_liquidos' | 'escalas_valoracion';

const secciones: { id: SeccionHoja, label: string }[] = [
    { id: 'signos', label: 'Tomar signos' },
    { id: 'control_liquidos', label:'Control de liquidos'},
    { id: 'escalas_valoracion', label:'Escalas de valoracion'},
    { id: 'riesgo_caidas', label: 'Riesgo de caídas'},

    { id: 'medicamentos', label: 'Ministración de medicamentos' },
    { id: 'terapia_iv', label: 'Terapia intravenosa' },
    { id: 'estudios', label: 'Ordenar estudios' },
    { id: 'sondas', label: 'Sondas y catéteres' },
    { id: 'dieta', label: 'Dieta' },
    { id: 'servicios_especiales', label: 'Servicios especiales'},
    { id: 'observaciones', label: 'Observaciones' },
    { id: 'graficas', label: 'Gráficas' },
];


type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};


const Create: CreateComponent = ({ 
    paciente, 
    estancia, 
    hojaenfermeria ,
    medicamentos, 
    soluciones, 
    dataParaGraficas, 
    catalogoEstudios, 
    solicitudesAnteriores, 
    medicos,          
    nota,
    checklistInicial,
    categoria_dietas,
    sondas_cateters,
    vias_administracion,
}) => {

    const [activeSection, setActiveSection] = useState<SeccionHoja>('signos');

    const NavigationTabs = () => (
        <>
        <div className="mt-12">
            <h2 className="text-2xl font-bold text-gray-800 mb-10">
                Checklist de plan
            </h2>
            <PlanPostoperatorioChecklist
                nota={nota} 
                checklistInicial={checklistInicial}
            />
        </div>
        <NavegationTab
            tabs={secciones}
            activeTab={activeSection}
            onTabChange={setActiveSection}
        />

        </>
    );

    const renderActiveSection = () => {
        switch (activeSection) {
            case 'signos':
                return <SignosVitalesForm 
                            hoja={hojaenfermeria}
                        />;
            case 'riesgo_caidas':
                return <RiesgoCaidasForm
                            hoja={hojaenfermeria}
                        />
            case 'control_liquidos': 
                return <ControlLiquidosForm
                            hoja={hojaenfermeria}
                        />;
            case 'escalas_valoracion':
                return <EscalaValoracionForm 
                            hoja={hojaenfermeria}   
                        />;
            case 'medicamentos':
                return <MedicamentosForm 
                            hoja={hojaenfermeria}
                            medicamentos={medicamentos}
                            vias_administracion={vias_administracion}
                        />;
            case 'terapia_iv':
                return <TerapiaIVForm
                            hoja={hojaenfermeria}
                            soluciones={soluciones}
                        />;
            case 'estudios':
                return <EstudiosForm
                            estancia={estancia}
                            catalogoEstudios={catalogoEstudios}
                            solicitudesAnteriores={solicitudesAnteriores}
                            medicos={medicos}
                            modeloId={hojaenfermeria.id}
                            modeloTipo='App\Models\HojaEnfermeria'
                        />
            case 'sondas':
                return <SondasCateteresForm
                            hoja={hojaenfermeria}
                            estancia={estancia}
                            sondas_cateters={sondas_cateters}
                        />
            case 'dieta':
                return <DietasForm
                            hoja={hojaenfermeria}
                            categoria_dietas={categoria_dietas}
                        />
            case 'servicios_especiales':
                return <ServiciosEspecialesForm
                            modelo={hojaenfermeria}
                            tipo="App\Models\HojaEnfermeria"
                        />
            case 'observaciones':
                return <HabitusExteriorForm
                            hojasenfermeria={hojaenfermeria}
                        />
            case 'graficas':
                return <GraficaContent
                            historialSignos={dataParaGraficas ?? []}
                        />
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
                <CerrarHoja 
                    hoja={hojaenfermeria} 
                    title='hoja de enfermería en hospitalización'
                    routeConfig={{ 
                        name: 'hojasenfermerias.update', 
                        params: { hojasenfermeria: hojaenfermeria.id } 
                    }}
                />
                
                <NavigationTabs />
                
                <div className="mt-4">
                    {renderActiveSection()}
                </div>
            </div>
        </>
    );
}

Create.layout = (page: React.ReactElement) => {

    const {estancia} = page.props as CreateProps;

    return (
        <MainLayout pageTitle='Creación de hoja de enfermería' children={page} link="estancias.show" linkParams={estancia.id}/>
    );
}

export default Create;