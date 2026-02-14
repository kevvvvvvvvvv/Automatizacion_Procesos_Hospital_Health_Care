import React from 'react';
import { EncuestaSatisfaccion, Estancia } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { useEffect } from 'react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import TextAreaInput from '@/components/ui/input-text-area';
import RatingInput from '@/components/ui/input-rating';
import BooleanInput from '@/components/ui/input-boolean';

interface Props {
    estancia: Estancia;
    title: string;
    encuesta?: EncuestaSatisfaccion;
    onSubmit: (form: any) => void
}

const EncuestaSatisfaccionForm = ({
    estancia,
    title,
    encuesta,
    onSubmit,
}: Props) => {

    const form = useForm({
        atencion_recpcion: encuesta?.atencion_recpcion || '',
        trato_personal_enfermeria: encuesta?.trato_personal_enfermeria || '', 
        limpieza_comodidad_habitacion: encuesta?.limpieza_comodidad_habitacion || '',
        calidad_comida: encuesta?.calidad_comida || '',
        tiempo_atencion: encuesta?.tiempo_atencion || '',
        informacion_tratamiento: encuesta?.informacion_tratamiento || '',
        atencion_nutricional: encuesta?.atencion_nutricional,
        comentarios: encuesta?.comentarios || '',
    });

    const { data, setData, processing, errors} = form;  

    useEffect(() => {
    if (encuesta) {
        setData({
            // Aseguramos que los ratings sean números. 
            // Si el valor es null, ponemos 0 para que no rompa el componente.
            atencion_recpcion: encuesta.atencion_recpcion ? Number(encuesta.atencion_recpcion) : 0,
            trato_personal_enfermeria: encuesta.trato_personal_enfermeria ? Number(encuesta.trato_personal_enfermeria) : 0,
            limpieza_comodidad_habitacion: encuesta.limpieza_comodidad_habitacion ? Number(encuesta.limpieza_comodidad_habitacion) : 0,
            calidad_comida: encuesta.calidad_comida ? Number(encuesta.calidad_comida) : 0,
            tiempo_atencion: encuesta.tiempo_atencion ? Number(encuesta.tiempo_atencion) : 0,
            informacion_tratamiento: encuesta.informacion_tratamiento ? Number(encuesta.informacion_tratamiento) : 0,
            
            // CONVERSIÓN CRÍTICA: Forzamos a booleano real
            atencion_nutricional: Boolean(encuesta.atencion_nutricional), 
            
            comentarios: encuesta.comentarios || '',
        });
    }
}, [encuesta]);
    const handleSumbit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form)
    }

    return (
        <MainLayout
            pageTitle={title}
            link='estancias.show'
            linkParams={estancia.id}
        >
            <Head title={title}/>
            <PacienteCard
                paciente={estancia.paciente}
                estancia={estancia}
            />
            <FormLayout
                title={title}
                onSubmit={handleSumbit}
                actions={
                    <PrimaryButton type='submit'>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                }
            >
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <RatingInput 
                        label="Atención en Recepción"
                        value={Number(data.atencion_recpcion)}
                        onChange={(val) => setData('atencion_recpcion', val)}
                        error={errors.atencion_recpcion}
                    />
                    <RatingInput 
                        label="Trato Personal de Enfermería"
                        value={Number(data.trato_personal_enfermeria)}
                        onChange={(val) => setData('trato_personal_enfermeria', val)}
                        error={errors.trato_personal_enfermeria}
                    />
                    <RatingInput 
                        label="Limpieza y Comodidad"
                        value={Number(data.limpieza_comodidad_habitacion)}
                        onChange={(val) => setData('limpieza_comodidad_habitacion', val)}
                        error={errors.limpieza_comodidad_habitacion}
                    /> 
                    <RatingInput 
                        label="Calidad de la Comida"
                        value={Number(data.calidad_comida)}
                        onChange={(val) => setData('calidad_comida', val)}
                        error={errors.calidad_comida}
                    />
                    <RatingInput 
                        label="Tiempo de Atención"
                        value={Number(data.tiempo_atencion)}
                        onChange={(val) => setData('tiempo_atencion', val)}
                        error={errors.tiempo_atencion}
                    />
                    <RatingInput 
                        label="Información del Tratamiento"
                        value={Number(data.informacion_tratamiento)}
                        onChange={(val) => setData('informacion_tratamiento', val)}
                        error={errors.informacion_tratamiento}
                    />
                </div>

                <hr className="my-6 border-gray-200" />

                <BooleanInput 
                    label="¿Recibió atención nutricional?"
                    value={data.atencion_nutricional as any}
                    onChange={(val) => setData('atencion_nutricional', val)}
                    error={errors.atencion_nutricional}
                />

               <TextAreaInput
                    label='Comentarios'
                    value={data.comentarios}
                    // Accedemos al valor del target
                    onChange={(e) => setData('comentarios', e.target.value)} 
                    error={errors.comentarios}
                    placeholder='Escriba alguna queja o sugerencia'
                />

            </FormLayout>
        </MainLayout>
    ); 
}

export default EncuestaSatisfaccionForm;