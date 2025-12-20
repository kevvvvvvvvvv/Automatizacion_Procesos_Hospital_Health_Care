import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { SolicitudEstudio, User } from '@/types'; // Asegúrate de tener definido SolicitudItem en types

import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import InputDateTime from '@/components/ui/input-date-time';
import SelectInput from '@/components/ui/input-select';

interface Props {
    solicitud_estudio: SolicitudEstudio;
    items_filtrados: any[]; 
    personal: User[];
}

const ResultadosComponent = ({ solicitud_estudio, items_filtrados, personal }: Props) => {

    const { data, setData, put, processing, errors } = useForm({
        items: items_filtrados.map(item => ({
            id: item.id,
            nombre_estudio: item.catalogo_estudio?.nombre || item.otro_estudio,
            fecha_hora: item.fecha_hora || '',
            problema_clinico: item.problemas_clinicos || '', 
            incidentes_accidentes: item.incidentes_accidentes || '',
            resultados: item.resultados || '',
            personal_realizo: item.user_realiza_id || '' 
        }))
    });


    const updateItemField = (index: number, field: string, value: any) => {
        const newItems = [...data.items];
        newItems[index] = { ...newItems[index], [field]: value };
        setData('items', newItems);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('solicitudes.update_resultados', solicitud_estudio.id));
    };

    const optionsPersonal = personal.map(m => ({
        label: `${m.nombre} ${m.apellido_paterno} ${m.apellido_materno}`,
        value: m.id
    }));

    return (
        <MainLayout pageTitle='Entrega de resultados' link='dashboard'>
            <Head title="Resultados de estudios"/>
            
            <FormLayout 
                title={`Solicitud #${solicitud_estudio.id}`} 
                onSubmit={handleSubmit} 
                actions={
                    <PrimaryButton disabled={processing}>
                        {processing ? 'Guardando...' : 'Enviar resultados'} 
                    </PrimaryButton>
                }
            >

                {data.items.length === 0 ? (
                    <p className="text-gray-500 text-center py-4">No hay estudios pendientes para tu área.</p>
                ) : (
                    data.items.map((item, index) => (
                        <div key={item.id} className="mb-8 p-4 border border-gray-200 rounded-lg bg-gray-50">
                            
                            <h3 className="font-bold text-lg text-gray-800 mb-4 border-b pb-2">
                                {index + 1}. {item.nombre_estudio}
                            </h3>

                            <div className="space-y-4">
                                <InputDateTime
                                    id={`fecha_hora_${index}`}
                                    name={`items[${index}].fecha_hora`}
                                    label='Fecha y hora del estudio'
                                    value={item.fecha_hora}
                                    onChange={(val) => updateItemField(index, 'fecha_hora', val)}
                                    error={errors[`items.${index}.fecha_hora` as keyof typeof errors]}
                                />

                                <InputText
                                    id={`problema_clinico_${index}`}
                                    name={`items[${index}].problema_clinico`}
                                    label="Problema clínico en estudio"
                                    value={item.problema_clinico}
                                    onChange={e => updateItemField(index, 'problema_clinico', e.target.value)}
                                    error={errors[`items.${index}.problema_clinico` as keyof typeof errors]}
                                />
                                
                                <InputText
                                    id={`incidentes_${index}`}
                                    name={`items[${index}].incidentes_accidentes`}
                                    label="Incidentes o Accidentes"
                                    value={item.incidentes_accidentes}
                                    onChange={e => updateItemField(index, 'incidentes_accidentes', e.target.value)}
                                    error={errors[`items.${index}.incidentes_accidentes` as keyof typeof errors]}
                                />

                                <InputText
                                    id={`resultados_${index}`}
                                    name={`items[${index}].resultados`}
                                    label="Resultados del estudio"
                                    value={item.resultados}
                                    onChange={e => updateItemField(index, 'resultados', e.target.value)}
                                    error={errors[`items.${index}.resultados` as keyof typeof errors]}
                                />

                                <SelectInput
                                    label='Identificación del personal que realizó el estudio'
                                    options={optionsPersonal}
                                    value={item.personal_realizo}
                                    onChange={(val) => updateItemField(index, 'personal_realizo', val)}
                                />
                            </div>
                        </div>
                    ))
                )}
            </FormLayout>
        </MainLayout>
    );
}

export default ResultadosComponent;