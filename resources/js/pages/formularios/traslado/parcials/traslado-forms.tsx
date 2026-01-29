import React from 'react';
import { useForm } from '@inertiajs/react';
import { Estancia, Paciente, Traslado } from '@/types';

import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import Generalidades from '@/components/forms/generalidades';
import InputTextArea from '@/components/ui/input-text-area';

interface Props{
  traslado: Traslado;      
  paciente: Paciente;
  estancia: Estancia;
  onSubmit: (form:any) => void;
  submitLabel?: string;
}
export const TrasladoForm = ({
    paciente,
    estancia,
    onSubmit,
    traslado,
    submitLabel = 'Guardar'

}: Props) => {
    const form = useForm ({
        unidad_medica_envia: traslado?.unidad_medica_envia || '',
        motivo_translado: traslado?.motivo_translado || '',
        ta: traslado?.ta || '',
        fc: traslado?.fc || '',
        fr: traslado?.fr || '',
        peso: traslado?.peso || '',
        talla: traslado?.talla || '',
        temp: traslado?.temp || '',
        resumen_del_interrogatorio: traslado?.resumen_del_interrogatorio ||  '',
        exploracion_fisica: traslado?.exploracion_fisica || '',
        resultado_estudios: traslado?.resultado_estudios || '',
        tratamiento: traslado?.tratamiento || '',
        diagnostico_o_problemas_clinicos: traslado?.diagnostico_o_problemas_clinicos || '',
        plan_de_estudio: traslado?.plan_de_estudio || '',
        pronostico: traslado?.pronostico || '',
        unidad_medica_recibe: traslado?.unidad_medica_recibe || '',
        impresion_diagnostica: traslado?.impresion_diagnostica || '',
        terapeutica_empleada: traslado?.terapeutica_empleada || '',
        });
        const { data, setData, errors, processing } = form;
        
        const handleSubmit = (e: React.FormEvent) => {
            e.preventDefault();
            onSubmit(form);
        };
    


    return (
    <FormLayout
        title="Registro noja de traslado"
        onSubmit={handleSubmit}
        actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Guardando...' : 'Guardar'}</PrimaryButton>}
      >
        <Generalidades data={data} setData={setData} errors={errors} />

        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Establecimiento de salud</h2>
        <InputText
          id="unidad_medica_envia"
          label="Unidad médica que envía"
          name="unidad_medica_envia"
          value={data.unidad_medica_envia}
          onChange={(e) => setData('unidad_medica_envia', e.target.value)}
          placeholder="Nombre de la unidad que envía"
          error={errors.unidad_medica_envia}
        />
        <InputText
          id="unidad_medica_recibe"
          label="Unidad médica que recibe"
          name="unidad_medica_recibe"
          value={data.unidad_medica_recibe}
          onChange={(e) => setData('unidad_medica_recibe', e.target.value)}
          placeholder="Nombre de la unidad que recibe"
          error={errors.unidad_medica_recibe}
        />

        <h2 className="text-xl font-semibold text-gray-800 mt-6 mb-4 col-span-full">Resumen clínico</h2>

        <InputTextArea
            label="Motivo del Traslado:"
            id="motivo_translado"
            name="motivo_translado"
            value={data.motivo_translado}
            onChange={(e) => setData('motivo_translado', e.target.value)}
            placeholder="Describa el motivo del traslado..."
            rows={3}
            className="col-span-full md:col-span-1"
            error={errors.motivo_translado}
        />

        <InputTextArea
            label="Impresión diagnóstica (incluido abuso y dependencia del tabaco, del alcohol y de otras sustancias psicoactivas):"
            id="impresion_diagnostica"
            name="impresion_diagnostica"
            value={data.impresion_diagnostica}
            onChange={(e) => setData('impresion_diagnostica', e.target.value)}
            placeholder="Describa la impresión diagnóstica"
            rows={4}
            className="col-span-full md:col-span-2"
            error={errors.impresion_diagnostica}
        />

        <InputText
            label="Tratamiento terapéutico administrado:"
            id="terapeutica_empleada"
            name="terapeutica_empleada"
            value={data.terapeutica_empleada}
            placeholder="Describa el tratamiento administrado..."
            onChange={(e) => setData('terapeutica_empleada', e.target.value)}
            error={errors.terapeutica_empleada}
        />


      </FormLayout>
    )
}