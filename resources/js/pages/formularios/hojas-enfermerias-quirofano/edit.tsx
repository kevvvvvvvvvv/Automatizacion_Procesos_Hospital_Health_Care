import { Estancia, HojaEnfermeriaQuirofano, Paciente, ProductoServicio, User, CatalogoViaAdministracion } from '@/types';
import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { MORPH_MAP } from '@/types/model';

import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import InsumosBasicosForm from '@/components/forms/insumos-basicos-form';
import GeneralesForm from  '@/components/forms/generales-form';
import PersonalQuirurgicoForm from '@/components/forms/personal-quirurgico-form';
import EquipoLaparoscopiaForm from '@/components/forms/equipo-laparoscopia-form';
import EnvioPiezaHojaEnfermeria from '@/components/forms/envio-pieza-hoja-enfermeria-form';
import CerrarHoja from '@/components/app-cerrrar-hoja';
import InformacionGeneralCirugia from '@/components/forms/hoja-enfermeria-quirofano/informacion-general-cirugia';
import MaterialQuirofano from '@/components/forms/hoja-enfermeria-quirofano/conteo-material-quirofano';
import IsquemiaFormContainer from '@/components/formularios/hoja-enfermeria-quirofano/isquemia/isquemias-fields';
import SignosVitalesForm from '@/components/forms/signos-vitales-form';
import MedicamentosForm from '@/components/forms/medicamentos-form';
import TerapiaIVForm from '@/components/terapia-iv-form';
import EgresoLiquidoForm from '@/components/forms/hoja-enfermeria.tsx/egreso-liquido-form';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeriaQuirofano,
    insumos: ProductoServicio[];

    medicamentos: ProductoServicio[];
    vias_administracion: CatalogoViaAdministracion[];
    soluciones: ProductoServicio[];

    users: User[];
}

type SeccionHoja = 
    'insumos' | 
    'servicios_especiales' | 
    'pieza_patologica' | 
    'general' | 
    'personal' | 
    'informacion_general' | 
    'conteo_material_quirofano' | 
    'isquemias' | 
    'signos_vitales' | 
    'ministracion_medicamentos' |
    'terapia_i_v' |
    'egresos' ;



type CreateComponent = React.FC<CreateProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
}

const secciones: {id: SeccionHoja, label: string}[] = [
    { id: 'general', label: 'General' },
    { id: 'insumos', label : 'Insumos' },
    { id: 'servicios_especiales', label: 'Servicios especiales' },
    { id: 'pieza_patologica', label: 'Envio de pieza patológica' },
    { id: 'personal', label: 'Personal' },
    { id: 'informacion_general', label:'Información general'},
    { id: 'conteo_material_quirofano', label: 'Conteo de material en quirófano'},
    { id: 'isquemias', label: 'Isquemias'},
    { id: 'signos_vitales', label: 'Tomar signos'},
    { id: 'ministracion_medicamentos', label: 'Ministracion de medicamentos'},
    { id: 'terapia_i_v', label: 'Terapia intravenosa'},
    { id: 'egresos', label: 'Egresos'},

];

const tiposQuirofano = [
    { value: 'diuresis', label: 'Diuresis' },
    { value: 'sangrado', label: 'Sangrado' },
    { value: 'otros', label: 'Otros'},
];

const CreateHojaEnfermeriaQuirofano:CreateComponent = ({
    paciente, 
    estancia, 
    hoja, 
    insumos, 
    users,
    medicamentos = [],
    vias_administracion,
    soluciones = [],
}) => {
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
            case 'conteo_material_quirofano':
                return <MaterialQuirofano
                            hoja={hoja}
                        />

            case 'pieza_patologica':
                return <EnvioPiezaHojaEnfermeria
                            medicos={users}
                            modeloId={hoja.id}
                            modeloTipo={MORPH_MAP.HOJA_ENFERMERIA_QUIROFANO}
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
            case 'informacion_general':
                return <InformacionGeneralCirugia
                            hoja={hoja}
                        />
            case 'isquemias':
                return <IsquemiaFormContainer
                            isquemiable_id={hoja.id}
                            isquemiable_type={hoja.tipo_modelo}
                            hoja={hoja}
                        />
            case 'signos_vitales':
                return <SignosVitalesForm
                            hoja={hoja}
                        />
            case 'ministracion_medicamentos':
                return <MedicamentosForm
                            hoja={hoja}
                            medicamentos={medicamentos}
                            vias_administracion={vias_administracion}
                        />
            case 'terapia_i_v':
                return <TerapiaIVForm
                            hoja={hoja}
                            soluciones={soluciones}
                            medicamentos={medicamentos}
                        />
            case 'egresos':
                return <EgresoLiquidoForm
                            hoja={hoja}
                            tiposDisponibles={tiposQuirofano}
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
                <CerrarHoja
                    hoja={hoja}
                    title='hoja de enfermería en quirófano'
                    routeConfig={{
                        name: 'hojasenfermeriasquirofanos.cerrarHoja',
                        params: {hojasenfermeriaquirofanos: hoja.id}
                    }}
                />
                {/** 
                <button>
                    Relevar
                </button>
                */}
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