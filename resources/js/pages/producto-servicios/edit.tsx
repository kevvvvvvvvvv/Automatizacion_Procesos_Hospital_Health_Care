import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, useForm } from '@inertiajs/react'; 
import SelectInput from '@/components/ui/input-select'; 
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { ProductoServicio } from '@/types'; 
import { ProductoServicioForm } from './partials/producto-servicios-form';

interface Props {
    productoServicio: ProductoServicio;
}

const Edit: React.FC<Props> = ({ productoServicio }) => {


    

    const handleSubmit = (form : any) => {
        form.put(route('producto-servicios.update', productoServicio.id));
    };

    return (
        <MainLayout pageTitle='Editar producto y servicios' link='producto-servicios.index'>
            <Head title={`Editar ${productoServicio.nombre_prestacion}`} />
            <ProductoServicioForm
            productoServicio={productoServicio}
            onSubmit={handleSubmit}
            />
            
        </MainLayout>
    );
};



export default Edit;