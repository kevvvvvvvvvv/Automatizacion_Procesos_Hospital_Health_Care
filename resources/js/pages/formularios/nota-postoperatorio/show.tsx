import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { NotaPostoperatoria, Paciente, Estancia, User } from '@/types';
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

interface Props {
    nota: NotaPostoperatoria;
    paciente: Paciente;
    estancia: Estancia;
    medico: User;
}

const ShowNotaPostoperatoria = ({ nota, paciente, estancia, medico }: Props) => {

    // Componente interno para mostrar campos de texto de forma consistente
    const InfoSection = ({ label, content, fullWidth = false }: { label: string, content?: string | number, fullWidth?: boolean }) => (
        <div className={`${fullWidth ? 'col-span-2' : 'col-span-1'} mb-4`}>
            <span className="block text-[10px] font-bold uppercase text-blue-700 mb-1">{label}</span>
            <div className="text-sm text-gray-800 bg-white p-3 rounded-lg border border-gray-200 shadow-sm min-h-[45px] whitespace-pre-wrap">
                {content || <span className="text-gray-400 italic">No especificado</span>}
            </div>
        </div>
    );

    return (
        <div className="pb-20">
            <Head title={`Nota Postoperatoria - ${paciente.nombre_completo}`} />
            
            <PacienteCard paciente={paciente} estancia={estancia} />

            <div className="max-w-7xl mx-auto mt-6">
                <div className="bg-gray-100 rounded-xl border border-gray-300 overflow-hidden">
                    
                    {/* Header con acciones */}
                    <div className="bg-white px-6 py-4 border-b border-gray-300 flex justify-between items-center">
                        <div>
                            <h2 className="text-xl font-black text-gray-800 uppercase tracking-tight">Nota Postoperatoria</h2>
                            <p className="text-xs text-gray-500 font-medium">
                                Médico: <span className="text-gray-700">{medico.nombre} {medico.apellido_paterno}</span> | 
                                Fecha: {new Date(nota.created_at!).toLocaleDateString('es-MX')}
                            </p>
                        </div>
                        
                    </div>

                    <div className="p-6 space-y-8">
                        
                        {/* 1. SIGNOS VITALES Y SOMATOMETRÍA */}
                        <section>
                            <h3 className="text-sm font-black text-gray-400 uppercase mb-3 tracking-widest">I. Signos Vitales y Somatometría</h3>
                            <div className="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
                                <div className="bg-blue-600 text-white p-3 rounded-lg text-center">
                                    <span className="block text-[10px] uppercase opacity-80">TA</span>
                                    <p className="font-bold text-lg">{nota.ta}</p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">FC</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.fc} <small className="text-[10px]">LPM</small></p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">FR</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.fr} <small className="text-[10px]">RPM</small></p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">Temp</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.temp}°C</p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">Peso</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.peso} <small className="text-[10px]">kg</small></p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">Talla</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.talla} <small className="text-[10px]">cm</small></p>
                                </div>
                                <div className="bg-white p-3 rounded-lg border border-gray-200 text-center">
                                    <span className="block text-[10px] text-gray-500 uppercase">SPO2</span>
                                    <p className="font-bold text-lg text-gray-800">{nota.spo2}%</p>
                                </div>
                            </div>
                        </section>

                        {/* 2. DATOS QUIRÚRGICOS TÉCNICOS */}
                        <section className="bg-white/50 p-4 rounded-xl border border-gray-200">
                            <h3 className="text-sm font-black text-gray-400 uppercase mb-4 tracking-widest">II. Protocolo Quirúrgico</h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <InfoSection label="Hora Inicio de Operación" content={new Date(nota.hora_inicio_operacion).toLocaleString('es-MX')} />
                                <InfoSection label="Hora Término de Operación" content={new Date(nota.hora_termino_operacion).toLocaleString('es-MX')} />
                                <InfoSection label="Diagnóstico Preoperatorio" content={nota.diagnostico_preoperatorio} fullWidth />
                                <InfoSection label="Operación Planeada" content={nota.operacion_planeada} />
                                <InfoSection label="Operación Realizada" content={nota.operacion_realizada} />
                                <InfoSection label="Diagnóstico Postoperatorio" content={nota.diagnostico_postoperatorio} fullWidth />
                                <InfoSection label="Descripción de la Técnica Quirúrgica" content={nota.descripcion_tecnica_quirurgica} fullWidth />
                                <InfoSection label="Hallazgos Transoperatorios" content={nota.hallazgos_transoperatorios} />
                                <InfoSection label="Incidentes y Accidentes" content={nota.incidentes_accidentes} />
                                <InfoSection label="Cuantificación de Sangrado" content={`${nota.cuantificacion_sangrado} ml`} />
                                <InfoSection label="Reporte de Conteo (Gasas/Instrumental)" content={nota.reporte_conteo} />
                            </div>
                        </section>

                        {/* 3. PERSONAL Y TRANSFUSIONES */}
                        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <section className="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                <h3 className="text-xs font-black text-blue-800 uppercase mb-3">Personal en Quirófano</h3>
                                <div className="space-y-2">
                                    {nota.personal_empleados?.map((p: any) => (
                                        <div key={p.id} className="flex justify-between items-center p-2 bg-gray-50 rounded border border-gray-100">
                                            <span className="text-sm font-bold text-gray-700 uppercase">{p.user?.nombre_completo || `${p.user?.nombre} ${p.user?.apellido_paterno}`}</span>
                                            <span className="text-[10px] bg-blue-100 text-blue-700 px-2 py-1 rounded font-black uppercase">{p.cargo}</span>
                                        </div>
                                    ))}
                                </div>
                            </section>

                            <section className="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                                <h3 className="text-xs font-black text-red-800 uppercase mb-3">Transfusiones Realizadas</h3>
                                <div className="space-y-2">
                                    {nota.transfusiones?.length ? nota.transfusiones.map((t: any) => (
                                        <div key={t.id} className="flex justify-between items-center p-2 bg-red-50 rounded border border-red-100 text-red-900">
                                            <span className="text-sm font-bold uppercase">{t.tipo_transfusion}</span>
                                            <span className="text-sm font-black">{t.cantidad} UNID.</span>
                                        </div>
                                    )) : <p className="text-sm text-gray-400 italic">Sin registros de transfusión.</p>}
                                </div>
                            </section>
                        </div>

                        {/* 4. MANEJO POSTOPERATORIO */}
                        <section className="border-t border-gray-300 pt-6">
                            <h3 className="text-sm font-black text-gray-400 uppercase mb-4 tracking-widest">III. Plan de Manejo y Pronóstico</h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <InfoSection label="Estado Postquirúrgico Inmediato" content={nota.estado_postquirurgico} />
                                <InfoSection label="Manejo de Dieta" content={nota.manejo_dieta} />
                                <InfoSection label="Manejo de Soluciones" content={nota.manejo_soluciones} />
                                <InfoSection label="Manejo de Medicamentos" content={nota.manejo_medicamentos} />
                                <InfoSection label="Pronóstico" content={nota.pronostico} />
                                <InfoSection label="Hallazgos de Importancia" content={nota.hallazgos_importancia} />
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    );
};

ShowNotaPostoperatoria.layout = (page: React.ReactElement) => {
    const { estancia } = page.props as Props;
    return (
        <MainLayout 
            pageTitle="Visor de Nota Médica" 
            link="estancias.show" 
            linkParams={estancia.id}
        >
            {page}
        </MainLayout>
    );
};

export default ShowNotaPostoperatoria;