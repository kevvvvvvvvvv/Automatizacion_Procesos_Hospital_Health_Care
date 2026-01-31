import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { HojaEnfermeria, NotaPostanestesica, Paciente, Estancia } from '@/types';
import { route } from 'ziggy-js';

// Componentes de UI
import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';
import PacienteCard from '@/components/paciente-card'; 
import MainLayout from '@/layouts/MainLayout';
import Generalidades from '@/components/forms/generalidades'; 
import InputTextArea from '@/components/ui/input-text-area';
import InputTime from '@/components/ui/input-time';
import pacientes from '@/routes/pacientes';



interface Props {
    paciente: Paciente;
    estancia: Estancia;
    nota?: NotaPostanestesica | null;
    onSubmit: (from: any) => void;
}
export const PostanestesicaForm = ({
    paciente, 
    estancia,
    nota,
    onSubmit,
}: Props) =>{
    //console.log('Datos recibidos en nota:', nota);
    const form = useForm({
        ta: nota?.ta || '',
        fc: nota?.fc?.toString() || '',
        fr: nota?.fr?.toString() || '',
        temp: nota?.temp?.toString() || '',
        peso: nota?.peso?.toString() || '',
        talla: nota?.talla?.toString() || '',
        resumen_del_interrogatorio: nota?.resumen_del_interrogatorio || '',
        exploracion_fisica: nota?.exploracion_fisica || '',
        plan_de_estudio: nota?.plan_de_estudio || '',
        diagnostico_o_problemas_clinicos: nota?.diagnostico_o_problemas_clinicos || '',
        pronostico: nota?.pronostico || '',
        tratamiento: nota?.tratamiento || '',
        resultado_estudios: nota?.resultado_estudios || '',
        tecnica_anestesica: nota?.tecnica_anestesica || '',
        farmacos_administrados: nota?.farmacos_administrados || '',
        duracion_anestesia: nota?.duracion_anestesia || '',
        incidentes_anestesia: nota?.incidentes_anestesia || '',
        balance_hidrico: nota?.balance_hidrico || '',
        estado_clinico: nota?.estado_clinico || '',
        plan_manejo: nota?.plan_manejo || '',
    });
    const { data, setData, processing, errors } = form;
     const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form);
    }
    return(
        <>
             <FormLayout 
                title=''
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : (nota ? 'Actualizar Nota' : 'Crear nota postanestésica')}
                    </PrimaryButton>
                }
            >

                <Generalidades
                    data={data} 
                    setData={setData}
                    errors={errors} 
                />

                    <InputTextArea
                        id="tecnica_anestesica"
                        label="Técnica anestésica utilizada"
                        value={data.tecnica_anestesica} // <--- Ahora sí es reactivo
                        onChange={(e) => setData('tecnica_anestesica', e.target.value)}
                        rows={3}
                        error={errors.tecnica_anestesica}
                    />
                    
                    <InputTextArea
                        id="farmacos_administrados"
                        label="Fármacos y medicamentos administrados"
                        value={data.farmacos_administrados ?? ''}
                        onChange={(e) => setData('farmacos_administrados', e.target.value)}
                        rows={4}
                        error={errors.farmacos_administrados}
                    />

                    <InputTime
                        id="duracion_anestesia"
                        label="Duración de la anestesia"
                        value={data.duracion_anestesia ?? ''}
                        onChange={(e) => setData('duracion_anestesia', e)}
                        error={errors.duracion_anestesia}
                    />

                    <InputTextArea
                        id="incidentes_anestesia"
                        label="Contingencias, accidentes e incidentes atribuibles a la anestesia"
                        value={data.incidentes_anestesia ?? ''}
                        onChange={(e) => setData('incidentes_anestesia', e.target.value)}
                        rows={3}
                        error={errors.incidentes_anestesia}
                    />

                    <InputTextArea
                        id="balance_hidrico"
                        label="Balance hídrico"
                        value={data.balance_hidrico ?? ''}
                        onChange={(e) => setData('balance_hidrico', e.target.value)}
                        rows={2}
                        error={errors.balance_hidrico}
                    />
                    
                    <InputTextArea
                        id="estado_clinico"
                        label="Estado clínico del paciente a su egreso del quirófano"
                        value={data.estado_clinico ?? ''}
                        onChange={(e) => setData('estado_clinico', e.target.value)}
                        rows={3}
                        error={errors.estado_clinico}
                    />

                    <InputTextArea
                        id="plan_manejo"
                        label="Plan de manejo y tratamiento inmediato, incluyendo protocolo de analgesia y control de signos y
                            síntomas asociados a la anestesia"
                        value={data.plan_manejo ?? ''}
                        onChange={(e) => setData('plan_manejo', e.target.value)}
                        rows={4}
                        error={errors.plan_manejo}
                    />
            </FormLayout>
        </>
    );
}