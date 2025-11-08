import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { HojaEnfermeria, HojaPostoperatoria, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';

import InputDateTime from '@/components/ui/input-date-time';
import InputTextArea from '@/components/ui/input-text-area';
//import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeria;
    nota?: HojaPostoperatoria; 
}

type NotaPostoperatoriaComponent = React.FC<Props> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const NotaPostoperatoriaForm: NotaPostoperatoriaComponent= ({ paciente, estancia, nota }) => {

    const { data, setData, post, patch, processing, errors } = useForm({
        hora_inicio_operacion: nota?.hora_inicio_operacion || '',
        hora_termino_operacion: nota?.hora_termino_operacion || '',
        diagnostico_preoperatorio: nota?.diagnostico_preoperatorio || '',
        operacion_planeada: nota?.operacion_planeada || '',
        operacion_realizada: nota?.operacion_realizada || '',
        diagnostico_postoperatorio: nota?.diagnostico_postoperatorio || '',
        descripcion_tecnica_quirurgica: nota?.descripcion_tecnica_quirurgica || '',
        hallazgos_transoperatorios: nota?.hallazgos_transoperatorios || '',
        reporte_conteo: nota?.reporte_conteo || '',
        incidentes_accidentes: nota?.incidentes_accidentes || '',
        cuantificacion_sangrado: nota?.cuantificacion_sangrado || '',
        estudios_transoperatorios: nota?.estudios_transoperatorios || '',
        ayudantes: nota?.ayudantes || '',
        envio_piezas: nota?.envio_piezas || '',
        estado_postquirurgico: nota?.estado_postquirurgico || '',
        manejo_tratamiento: nota?.manejo_tratamiento || '',
        pronostico: nota?.pronostico || '',
        hallazgos_importancia: nota?.hallazgos_importancia || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (nota) {
            patch(route('pacientes.estancias.notaspostoperatorias.update', { 
                nota: nota.id 
            }), {
                preserveScroll: true,
            });
        } else {
            post(route('pacientes.estancias.notaspostoperatorias.store',{
                paciente: paciente.id,
                estancia: estancia.id
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <Head title="Crear interconsulta" />
            <FormLayout 
            title='Registrar nota postoperatoria   '
            onSubmit={handleSubmit}
            actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear nota postoperatoria'}</PrimaryButton>}>
                <div className="p-4 bg-white rounded-lg shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4 border-b pb-2">Datos de la cirugía</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <InputDateTime
                            id='hora_inicio'
                            name='hora_inicio'
                            label="Hora de inicio de la operación"
                            value={data.hora_inicio_operacion}
                            onChange={val => setData('hora_inicio_operacion', val as string)}
                            error={errors.hora_inicio_operacion}
                        />
                        <InputDateTime
                            id='hora_termino'
                            name='hora_termino'
                            label="Hora de término de la operación"
                            value={data.hora_termino_operacion}
                            onChange={val => setData('hora_termino_operacion', val as string)}
                            error={errors.hora_termino_operacion}
                        />
                        
                        <InputTextArea
                            label="Diagnóstico preoperatorio"
                            value={data.diagnostico_preoperatorio}
                            onChange={e => setData('diagnostico_preoperatorio', e.target.value)}
                            error={errors.diagnostico_preoperatorio}
                            rows={3}
                        />

                        <InputTextArea
                            label="Operación planeada"
                            value={data.operacion_planeada}
                            onChange={e => setData('operacion_planeada', e.target.value)}
                            error={errors.operacion_planeada}
                            rows={3}
                        />

                        <InputTextArea
                            label="Operación realizada"
                            value={data.operacion_realizada}
                            onChange={e => setData('operacion_realizada', e.target.value)}
                            error={errors.operacion_realizada}
                            rows={3}
                        />

                        <InputTextArea
                            label="Diagnóstico postoperatorio"
                            value={data.diagnostico_postoperatorio}
                            onChange={e => setData('diagnostico_postoperatorio', e.target.value)}
                            error={errors.diagnostico_postoperatorio}
                            rows={3}
                        />
                        

                    </div>
                </div>

                <div className="p-4 bg-white rounded-lg shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4 border-b pb-2">Descripción transoperatoria</h3>
                    <div className="space-y-4">
                        <InputTextArea
                            label="Descripción de la técnica quirúrgica"
                            value={data.descripcion_tecnica_quirurgica}
                            onChange={e => setData('descripcion_tecnica_quirurgica', e.target.value)}
                            error={errors.descripcion_tecnica_quirurgica}
                            rows={5}
                        />
                        <InputTextArea
                            label="Hallazgos transoperatorios"
                            value={data.hallazgos_transoperatorios}
                            onChange={e => setData('hallazgos_transoperatorios', e.target.value)}
                            error={errors.hallazgos_transoperatorios}
                            rows={4}
                        />
                    </div>
                </div>

                <div className="p-4 bg-white rounded-lg shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4 border-b pb-2">Reportes y sucesos</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <InputTextArea
                            label="Reporte del conteo de gasas, compresas y de instrumental quirúrgico"
                            value={data.reporte_conteo}
                            onChange={e => setData('reporte_conteo', e.target.value)}
                            error={errors.reporte_conteo}
                            rows={3}
                        />
                        <InputTextArea
                            label="Incidentes y accidentes"
                            value={data.incidentes_accidentes}
                            onChange={e => setData('incidentes_accidentes', e.target.value)}
                            error={errors.incidentes_accidentes}
                            rows={3}
                        />
                        <InputTextArea
                            label="Cuantificación de sangrado, si lo hubo y en su caso transfusiones"
                            value={data.cuantificacion_sangrado}
                            onChange={e => setData('cuantificacion_sangrado', e.target.value)}
                            error={errors.cuantificacion_sangrado}
                            rows={2}
                        />
                        <InputTextArea
                            label="Estudios de servicios auxiliares de diagnóstico y tratamiento transoperatorios"
                            value={data.estudios_transoperatorios}
                            onChange={e => setData('estudios_transoperatorios', e.target.value)}
                            error={errors.estudios_transoperatorios}
                            rows={2}
                        />
                        <InputTextArea
                            label=" Ayudantes, instrumentistas, anestesiólogo y circulante"
                            value={data.ayudantes}
                            onChange={e => setData('ayudantes', e.target.value)}
                            error={errors.ayudantes}
                            rows={2}
                        />
                        <InputTextArea
                            label="Envío de piezas o biopsias quirúrgicas para examen macroscópico e histopatológico"
                            value={data.envio_piezas}
                            onChange={e => setData('envio_piezas', e.target.value)}
                            error={errors.envio_piezas}
                            rows={2}
                        />
                    </div>
                </div>

                <div className="p-4 bg-white rounded-lg shadow-sm border">
                    <h3 className="text-lg font-semibold mb-4 border-b pb-2">Estado y plan postoperatoria</h3>
                    <div className="space-y-4">
                        <InputTextArea
                            label="Estado postquirúrgico inmediato"
                            value={data.estado_postquirurgico}
                            onChange={e => setData('estado_postquirurgico', e.target.value)}
                            error={errors.estado_postquirurgico}
                            rows={3}
                        />
                        <InputTextArea
                            label="Plan de manejo y tratamiento postoperatorio inmediato"
                            value={data.manejo_tratamiento}
                            onChange={e => setData('manejo_tratamiento', e.target.value)}
                            error={errors.manejo_tratamiento}
                            rows={4}
                        />
                        <InputTextArea
                            label="Pronóstico"
                            value={data.pronostico}
                            onChange={e => setData('pronostico', e.target.value)}
                            error={errors.pronostico}
                            rows={2}
                        />
                        <InputTextArea
                            label="Otros hallazgos de importancia para el paciente, relacionados con el quehacer médico"
                            value={data.hallazgos_importancia}
                            onChange={e => setData('hallazgos_importancia', e.target.value)}
                            error={errors.hallazgos_importancia}
                            rows={2}
                        />
                    </div>
                </div>
            </FormLayout>
        </>
    );
}

NotaPostoperatoriaForm.layout = (page: React.ReactElement) =>{
    return (
        <MainLayout pageTitle="Creación nota postoperatoria" children={page}/>
    )
}

export default NotaPostoperatoriaForm;