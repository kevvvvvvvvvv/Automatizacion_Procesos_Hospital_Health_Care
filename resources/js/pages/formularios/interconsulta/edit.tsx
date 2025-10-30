import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { Interconsulta, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';

interface EditInterconsultaProps {
    interconsulta: Interconsulta;
    paciente: Paciente;
    estancia: Estancia;
}

interface InterconsultaFormData {
    ta: string;
    fc: number | null;
    fr: number | null;
    temp: number | null;
    peso: number | null;
    talla: number | null;
    criterio_diagnostico: string;
    plan_de_estudio: string;
    sugerencia_diagnostica: string;
    resumen_del_interrogatorio: string;
    exploracion_fisica: string;
    estado_mental: string;
    resultados_relevantes_del_estudio_diagnostico: string;
    tratamiento_y_pronostico: string;
    motivo_de_la_atencion_o_interconsulta: string;
    diagnostico_o_problemas_clinicos: string;
}

const Edit = ({ interconsulta, paciente, estancia }: EditInterconsultaProps) => {
    const { data, setData, put, processing, errors } = useForm<InterconsultaFormData>({
        ta: interconsulta.ta || '',
        fc: interconsulta.fc || null,
        fr: interconsulta.fr || null,
        temp: interconsulta.temp || null,
        peso: interconsulta.peso || null,
        talla: interconsulta.talla || null,
        criterio_diagnostico: interconsulta.criterio_diagnostico || '',
        plan_de_estudio: interconsulta.plan_de_estudio || '',
        sugerencia_diagnostica: interconsulta.sugerencia_diagnostica || '',
        resumen_del_interrogatorio: interconsulta.resumen_del_interrogatorio || '',
        exploracion_fisica: interconsulta.exploracion_fisica || '',
        estado_mental: interconsulta.estado_mental || '',
        resultados_relevantes_del_estudio_diagnostico: interconsulta.resultados_relevantes_del_estudio_diagnostico || '',
        tratamiento_y_pronostico: interconsulta.tratamiento_y_pronostico || '',
        motivo_de_la_atencion_o_interconsulta: interconsulta.motivo_de_la_atencion_o_interconsulta || '',
        diagnostico_o_problemas_clinicos: interconsulta.diagnostico_o_problemas_clinicos || '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('pacientes.estancias.interconsultas.update', { paciente: paciente.id, estancia: estancia.id, interconsulta: interconsulta.id }));
    };

    return (
        <>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />
            <Head title={`Editar Interconsulta: ${paciente.nombre}`} />
            <FormLayout
                title="Editar Interconsulta"
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Actualizando...' : 'Actualizar Interconsulta'}
                    </PrimaryButton>
                }
            >
                <InputText
                    id="ta"
                    name="ta"
                    label="Tensión Arterial"
                    value={data.ta}
                    onChange={(e) => setData('ta', e.target.value)}
                    error={errors.ta}
                />

                <InputText
                    id="fc"
                    name="fc"
                    label="Frecuencia Cardíaca"
                    type="number"
                    value={data.fc?.toString() || ''}
                    onChange={(e) => setData('fc', e.target.value ? parseInt(e.target.value) : null)}
                    error={errors.fc}
                />

                <InputText
                    id="fr"
                    name="fr"
                    label="Frecuencia Respiratoria"
                    type="number"
                    value={data.fr?.toString() || ''}
                    onChange={(e) => setData('fr', e.target.value ? parseInt(e.target.value) : null)}
                    error={errors.fr}
                />

                <InputText
                    id="temp"
                    name="temp"
                    label="Temperatura"
                    type="number"
                    step="0.01"
                    value={data.temp?.toString() || ''}
                    onChange={(e) => setData('temp', e.target.value ? parseFloat(e.target.value) : null)}
                    error={errors.temp}
                />

                <InputText
                    id="peso"
                    name="peso"
                    label="Peso"
                    type="number"
                    step="0.01"
                    value={data.peso?.toString() || ''}
                    onChange={(e) => setData('peso', e.target.value ? parseFloat(e.target.value) : null)}
                    error={errors.peso}
                />

                <InputText
                    id="talla"
                    name="talla"
                    label="Talla"
                    type="number"
                    step="0.01"
                    value={data.talla?.toString() || ''}
                    onChange={(e) => setData('talla', e.target.value ? parseFloat(e.target.value) : null)}
                    error={errors.talla}
                />

                <InputText
                    id="criterio_diagnostico"
                    name="criterio_diagnostico"
                    label="Criterio Diagnóstico"
                    value={data.criterio_diagnostico}
                    onChange={(e) => setData('criterio_diagnostico', e.target.value)}
                    error={errors.criterio_diagnostico}
                />

                <InputText
                    id="plan_de_estudio"
                    name="plan_de_estudio"
                    label="Plan de Estudio"
                    value={data.plan_de_estudio}
                    onChange={(e) => setData('plan_de_estudio', e.target.value)}
                    error={errors.plan_de_estudio}
                />

                <InputText
                    id="sugerencia_diagnostica"
                    name="sugerencia_diagnostica"
                    label="Sugerencia Diagnóstica"
                    value={data.sugerencia_diagnostica}
                    onChange={(e) => setData('sugerencia_diagnostica', e.target.value)}
                    error={errors.sugerencia_diagnostica}
                />

                <InputText
                    id="resumen_del_interrogatorio"
                    name="resumen_del_interrogatorio"
                    label="Resumen del Interrogatorio"
                    value={data.resumen_del_interrogatorio}
                    onChange={(e) => setData('resumen_del_interrogatorio', e.target.value)}
                    error={errors.resumen_del_interrogatorio}
                />

                <InputText
                    id="exploracion_fisica"
                    name="exploracion_fisica"
                    label="Exploración Física"
                    value={data.exploracion_fisica}
                    onChange={(e) => setData('exploracion_fisica', e.target.value)}
                    error={errors.exploration_fisica}
                />

                <InputText
                    id="estado_mental"
                    name="estado_mental"
                    label="Estado Mental"
                    value={data.estado_mental}
                    onChange={(e) => setData('estado_mental', e.target.value)}
                    error={errors.estado_mental}
                />

                <InputText
                    id="resultados_relevantes_del_estudio_diagnostico"
                    name="resultados_relevantes_del_estudio_diagnostico"
                    label="Resultados Relevantes del Estudio Diagnóstico"
                    value={data.resultados_relevantes_del_estudio_diagnostico}
                    onChange={(e) => setData('resultados_relevantes_del_estudio_diagnostico', e.target.value)}
                    error={errors.resultados_relevantes_del_estudio_diagnostico}
                />

                <InputText
                    id="tratamiento_y_pronostico"
                    name="tratamiento_y_pronostico"
                    label="Tratamiento y Pronóstico"
                    value={data.tratamiento_y_pronostico}
                    onChange={(e) => setData('tratamiento_y_pronostico', e.target.value)}
                    error={errors.tratamiento_y_pronostico}
                />

                <InputText
                    id="motivo_de_la_atencion_o_interconsulta"
                    name="motivo_de_la_atencion_o_interconsulta"
                    label="Motivo de la Atención o Interconsulta"
                    value={data.motivo_de_la_atencion_o_interconsulta}
                    onChange={(e) => setData('motivo_de_la_atencion_o_interconsulta', e.target.value)}
                    error={errors.motivo_de_la_atencion_o_interconsulta}
                    required
                />

                <InputText
                    id="diagnostico_o_problemas_clinicos"
                    name="diagnostico_o_problemas_clinicos"
                    label="Diagnóstico o Problemas Clínicos"
                    value={data.diagnostico_o_problemas_clinicos}
                    onChange={(e) => setData('diagnostico_o_problemas_clinicos', e.target.value)}
                    error={errors.diagnostico_o_problemas_clinicos}
                    required
                />
            </FormLayout>
        </>
    );
};

Edit.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as EditInterconsultaProps;
    return (
        <MainLayout pageTitle={`Editando Interconsulta de: ${paciente.nombre}`} children={page} />
    );
};

export default Edit;
