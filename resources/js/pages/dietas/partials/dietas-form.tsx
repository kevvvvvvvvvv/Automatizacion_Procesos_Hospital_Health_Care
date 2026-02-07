// resources/js/Pages/dietas/Partials/DietasForm.tsx
import React from 'react';
import { useForm } from '@inertiajs/react';
import { CategoriaDieta, Dieta } from '@/types/index';

import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import SelectInput from '@/components/ui/input-select';
import InputTextArea from '@/components/ui/input-text-area';
import InputText from '@/components/ui/input-text';



interface Props {
    categoria_dietas: CategoriaDieta[];
    onSubmit: (form: any) => void;
    dieta?: Dieta; 
    submitLabel?: string;
}


export const DietasForm = ({ 
    categoria_dietas, 
    onSubmit, 
    dieta, 
    submitLabel = 'Guardar' 
}: Props) => {
    
    const categoriaDietasOptions = categoria_dietas.map((c) => ({ 
        value: c.id, 
        label: c.categoria 
    }));

    const form = useForm({
        categoria_dieta_id: dieta?.categoria_dieta_id || '',
        alimento: dieta?.alimento || '',
        costo: dieta?.costo || '',
    });

    const { data, setData, errors, processing } = form;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form); 
    };
    
    return (
        <FormLayout title='' onSubmit={handleSubmit} actions={
            <PrimaryButton disabled={processing} type='submit'>
                {processing ? 'Procesando...' : submitLabel}
            </PrimaryButton>
        }>
            <SelectInput
                options={categoriaDietasOptions}
                label='Categoría de la dieta'
                value={data.categoria_dieta_id}
                onChange={(e) => setData('categoria_dieta_id', e)}
                error={errors.categoria_dieta_id}
            />

            <InputTextArea
                label='Descripción de los alimentos ofrecidos'
                value={data.alimento}
                onChange={(e) => setData('alimento', e.target.value)}
                error={errors.alimento}
            />

            <InputText
                id='costo'
                name='costo'
                label='Precio'
                type="number" 
                value={data.costo.toString()}
                onChange={(e) => setData('costo', e.target.value)}
                error={errors.costo}
            />
        </FormLayout>
    );
}