import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { HojaEnfermeria } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
import MainLayout from '@/layouts/MainLayout';
import NavegationTab from '@/components/navegation-tab';
import SignosVitalesForm from '@/components/forms/signos-vitales-form';

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
    hoja 
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
/*                 return <SignosVitalesForm 
                            hoja={hoja}
                        />; */
            case 'riesgo_caidas':
/*                 return <RiesgoCaidasForm
                            hoja={hojaenfermeria} 
                        />*/
            case 'control_liquidos': 
/*                 return <ControlLiquidosForm
                            hoja={hojaenfermeria} 
                        />;*/
            case 'escalas_valoracion':
/*                 return <EscalaValoracionForm 
                            hoja={hojaenfermeria}  
                        />;*/
            case 'medicamentos':
/*                 return <MedicamentosForm 
                            hoja={hojaenfermeria}
                            medicamentos={medicamentos}
                            vias_administracion={vias_administracion} 
                        />;*/
            case 'terapia_iv':
                /* return <TerapiaIVForm
                            hoja={hojaenfermeria}
                            soluciones={soluciones}
                        />; */
            case 'estudios':
/*                 return <EstudiosForm
                            estancia={estancia}
                            catalogoEstudios={catalogoEstudios}
                            solicitudesAnteriores={solicitudesAnteriores}
                            medicos={medicos}
                            modeloId={hojaenfermeria.id}
                            modeloTipo='App\Models\HojaEnfermeria'
                        /> */
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
                        /> */
            case 'graficas':
/*                 return <GraficaContent
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
