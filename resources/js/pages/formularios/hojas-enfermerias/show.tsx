import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { HojaEnfermeria } from '@/types';

import InfoCard from '@/components/ui/info-card';
import MainLayout from '@/layouts/MainLayout';
import NavegationTab from '@/components/navegation-tab';
import GraficaContent from '@/components/graphs/grafica-content'
import HojaSignosTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/signos-table';
import RiesgoCaidasTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/riesgo-caidas-table';
import ControlLiquidosTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/control-liquidos-table';
import EscalaValoracionTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/escala-valoracion-table';
import MedicamentosTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/ministracion-medicamentos-table';
import TerapiaIVTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/terapia-intravenosa-table';
import SolicitudEstudioTable from '@/components/forms/hoja-enfermeria-hospitalizacion-tables/solicitud-estudios-table';

interface Props{
    hoja: HojaEnfermeria;
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

const Show = ({ 
    hoja,
    DataParaGraficas 
}: Props) => {

    const [activeSection, setActiveSection] = useState<SeccionHoja>('signos');

    const NavigationTabs = () => (
        <>
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
                return <HojaSignosTable
                            hoja  = {hoja}                
                        />;
            case 'riesgo_caidas':
                 return <RiesgoCaidasTable
                            hoja={hoja} 
                        />;
            case 'control_liquidos': 
                return <ControlLiquidosTable
                            hoja={hoja} 
                        />;
            case 'escalas_valoracion':
                return <EscalaValoracionTable 
                            hoja={hoja}  
                        />;
            case 'medicamentos':
                return <MedicamentosTable 
                            hoja={hoja}
                        />;
            case 'terapia_iv':
                return <TerapiaIVTable
                            hoja={hoja}
                        />;
            case 'estudios':
                return <SolicitudEstudioTable
                            hoja={hoja}
                        /> 
            case 'sondas':
/*                 return <SondasCateteresForm
                            hoja={hojaenfermeria}
                            estancia={estancia}
                            sondas_cateters={sondas_cateters}
                        /> */
            case 'dieta':
/*                 return <DietasForm
                            hoja={hojaenfermeria}
                            categoria_dietas={categoria_dietas}
                        /> */
            case 'servicios_especiales':
/*                 return <ServiciosEspecialesForm
                            modelo={hojaenfermeria}
                            tipo="App\Models\HojaEnfermeria"
                        /> */
            case 'observaciones':
/*                 return <HabitusExteriorForm
                            hojasenfermeria={hojaenfermeria}
/*                         />   
            /*case 'graficas':
                return <GraficaContent
                            historialSignos={dataParaGraficas ?? []}
                        /> */
            default:
                return null;
        }
    }

    return (
        <MainLayout
            pageTitle='Hoja de enfermería en hospitalización'
            link='estancias.show'
            linkParams={hoja.formulario_instancia.estancia_id}
        >
            <Head 
                title={`Hoja de enfermería en hospitalización ${hoja.id}`}
            />

            <InfoCard
                title={`Hoja de enfermería en hospitalización de: ${hoja.formulario_instancia.estancia.paciente.nombre_completo}`}
            >
                Hola


            </InfoCard>
            <NavigationTabs/>
            <div className='mt-4'>
                {renderActiveSection()}
            </div>

        </MainLayout>
    );
}

export default Show;
