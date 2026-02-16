import React from 'react';
import { EncuestaPersonal, EncuestaSatisfaccion, Estancia } from '@/types';
import { Head, useForm, router} from '@inertiajs/react';
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
    encuesta?: EncuestaPersonal;
    onSubmit: (form: any) => void
}

const EncuestaSatisfaccionForm = ({
    estancia,
    title,
    encuesta,
    onSubmit,
}: Props) => {

    const form = useForm({
        trato_claro: encuesta?.trato_claro || '',
        presentacion_personal: encuesta?.presentacion_personal || '', 
        tiempo_atencion: encuesta?.tiempo_atencion || '',
        informacion_tratamiento: encuesta?.informacion_tratamiento || '',
        comentarios: encuesta?.comentarios || '',
    });

    const { data, setData, processing, errors} = form;  

    useEffect(() => {
    if (encuesta) {
        setData({
            // Aseguramos que los ratings sean números. 
            // Si el valor es null, ponemos 0 para que no rompa el componente.
            trato_claro: encuesta.trato_claro ? Number(encuesta.trato_claro) : 0,
            presentacion_personal: encuesta.presentacion_personal ? Number(encuesta.presentacion_personal) : 0,
            tiempo_atencion: encuesta.tiempo_atencion ? Number(encuesta.tiempo_atencion) : 0,
            informacion_tratamiento: encuesta.informacion_tratamiento ? Number(encuesta.informacion_tratamiento) : 0,
            comentarios: encuesta.comentarios || '',
        });
    }
}, [encuesta]);
    const handleSumbit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form)
    }
    //console.log('estancias', estancia);
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
                        label="Mi trato fue claro amable y concreto, explico todo lo que tenia que  tratar"
                        value={Number(data.trato_claro)}
                        onChange={(val) => setData('trato_claro', val)}
                        error={errors.trato_claro}
                    />
                    <RatingInput 
                        label="Mi presentación personal corresponde al cargo que tengo"
                        value={Number(data.presentacion_personal)}
                        onChange={(val) => setData('presentacion_personal', val)}
                        error={errors.presentacion_personal}
                    />
                    
                  
                    <RatingInput 
                        label="Tiempo de atención (fue rápida mi atención y dedico el tiempo correcto)"
                        value={Number(data.tiempo_atencion)}
                        onChange={(val) => setData('tiempo_atencion', val)}
                        error={errors.tiempo_atencion}
                    />
                    <RatingInput 
                        label="Todo la información que le proporcione fue clara"
                        value={Number(data.informacion_tratamiento)}
                        onChange={(val) => setData('informacion_tratamiento', val)}
                        error={errors.informacion_tratamiento}
                    />
                </div>

                <hr className="my-6 border-gray-200" />

               
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