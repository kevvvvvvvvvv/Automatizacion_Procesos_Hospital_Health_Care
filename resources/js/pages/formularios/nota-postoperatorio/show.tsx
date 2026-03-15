import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { NotaPostoperatoria, Paciente, Estancia, User } from '@/types';

import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface Props {
    nota: NotaPostoperatoria;
    paciente: Paciente;
    estancia: Estancia;
    medico: User;
}

const Show = ({ nota, paciente, estancia, medico }: Props) => {
    
    return (
        <>
            <Head title={`Nota Postoperatoria - ${paciente.nombre}`} />

            <InfoCard
                title={`Nota Postoperatoria de: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
            >
                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full">
                     Signos Vitales 
                </h2>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <InfoField label="Tensión Arterial" value={nota.ta} />
                    <InfoField label="Frecuencia Cardiaca" value={`${nota.fc} `} />
                    <InfoField label="Frecuencia Respiratoria" value={`${nota.fr}`} />
                    <InfoField label="Temperatura" value={`${nota.temp}`} />
                    <InfoField label="SPO2" value={`${nota.spo2}`} />
                    <InfoField label="Peso" value={`${nota.peso}`} />
                    <InfoField label="Talla" value={`${nota.talla}`} />
                </div>

                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full border-t pt-4">
                     Protocolo Quirúrgico
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <InfoField 
                        label="Inicio de Operación" 
                        value={new Date(nota.hora_inicio_operacion).toLocaleString('es-MX')} 
                    />
                    <InfoField 
                        label="Término de Operación" 
                        value={new Date(nota.hora_termino_operacion).toLocaleString('es-MX')} 
                    />
                    <InfoField label="Diagnóstico Preoperatorio" value={nota.diagnostico_preoperatorio} />
                    <InfoField label="Diagnóstico Postoperatorio" value={nota.diagnostico_postoperatorio} />
                    <InfoField label="Operación Planeada" value={nota.operacion_planeada} />
                    <InfoField label="Operación Realizada" value={nota.operacion_realizada} />
                    
                    <div className="col-span-full space-y-4">
                        <InfoField label="Descripción de la Técnica Quirúrgica" value={nota.descripcion_tecnica_quirurgica} />
                        <InfoField label="Hallazgos Transoperatorios" value={nota.hallazgos_transoperatorios} />
                        <InfoField label="Incidentes y Accidentes" value={nota.incidentes_accidentes} />
                    </div>
                </div>

                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full border-t pt-4">
                     Personal y Transfusiones
                </h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <span className="block text-sm font-bold text-gray-700 uppercase mb-2">Personal en Quirófano</span>
                        <div className="space-y-1">
                            {nota.personal_empleados?.map((p: any) => (
                                <div key={p.id} className="text-sm p-2 bg-gray-50 rounded border border-gray-100">
                                    <span className="font-bold">{p.user?.nombre} {p.user?.apellido_paterno}</span> - <span className="text-xs uppercase">{p.cargo}</span>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div>
                        <span className="block text-sm font-bold text-gray-700 uppercase mb-2">Transfusiones</span>
                        {nota.transfusiones?.length ? nota.transfusiones.map((t: any) => (
                            <div key={t.id} className="text-sm p-2 bg-red-50 rounded border border-red-100 mb-1">
                                {t.tipo_transfusion}: <span className="font-bold">{t.cantidad} UNID.</span>
                            </div>
                        )) : <p className="text-sm text-gray-400 italic">Sin registros.</p>}
                    </div>
                </div>

                <h2 className="text-lg font-semibold text-gray-800 mb-2 col-span-full border-t pt-4">
                     Plan de Manejo y Pronóstico
                </h2>
                <div className="space-y-4 mb-6">
                    <InfoField label="Estado Postquirúrgico Inmediato" value={nota.estado_postquirurgico} />
                    <InfoField label="Manejo de Dieta" value={nota.manejo_dieta} />
                    <InfoField label="Manejo de Soluciones" value={nota.manejo_soluciones} />
                    <InfoField label="Manejo de Medicamentos" value={nota.manejo_medicamentos} />
                    <InfoField label="Pronóstico" value={nota.pronostico} />
                </div>
            </InfoCard>
        </>
    );
};


Show.layout = (page: React.ReactElement) => {
    const { estancia, paciente } = page.props as Props;
    return (
        <MainLayout 
            pageTitle={`Detalles de nota post-operatoria de ${paciente.nombre} ${paciente.apellido_paterno}`} 
            link="estancias.show" 
            linkParams={estancia.id}
        >
            {page}
        </MainLayout>
    );
};

export default Show;