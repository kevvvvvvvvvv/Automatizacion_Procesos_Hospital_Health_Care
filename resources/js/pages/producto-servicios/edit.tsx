import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, useForm } from '@inertiajs/react'; 
import SelectInput from '@/components/ui/input-select'; 
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { ProductoServicio } from '@/types'; 

interface Props {
    productoServicio: ProductoServicio;
}

const Edit = ({ productoServicio }: Props) => {

    const {data, setData, put, processing, errors} = useForm({
        tipo: productoServicio.tipo,
        subtipo: productoServicio.subtipo,
        codigo_prestacion: productoServicio.codigo_prestacion,
        nombre_prestacion: productoServicio.nombre_prestacion,
        importe: productoServicio.importe,
        cantidad: productoServicio.cantidad,
    });

    const optionsTipo = [
        {value: 'INSUMOS', label: 'INSUMOS'},
        {value: 'SERVICIOS', label: 'SERVICIOS'},
    ];

    const optionsSubtipo = [
        {value: 'MEDICAMENTOS', label: 'MEDICAMENTOS'},
        {value: 'INSUMOS', label: 'INSUMOS'},
        {value: 'SERVICIOS', label: 'SERVICIOS'},
    ];

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('producto-servicios.update', productoServicio.id));
    };

    return (
        <>
            <Head title={`Editar ${productoServicio.nombre_prestacion}`} />

            <FormLayout
                title="Editar producto o servicio" 
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Actualizando...' : 'Guardar Cambios'}
                    </PrimaryButton>
                }
            >
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <SelectInput
                        label = "Nombre capítulo"
                        options= {optionsTipo}
                        placeholder='Seleccione un capítulo'
                        value = {data.tipo}
                        onChange = {(value) => setData('tipo', value as string)}
                        error = {errors.tipo}
                    />

                    <SelectInput
                        label = "Nombre subcapítulo"
                        options= {optionsSubtipo}
                        placeholder='Seleccione un subcapítulo'
                        value = {data.subtipo}
                        onChange = {(value) => setData('subtipo', value as string)}
                        error = {errors.subtipo}
                    />

                    <InputText
                        id="codigo_prestacion"
                        name="codigo_prestacion"
                        label="Código de prestacion" 
                        value={data.codigo_prestacion}
                        onChange={(e) => setData('codigo_prestacion', e.target.value)}
                        placeholder="Escriba el codigo de prestacion"
                        error={errors.codigo_prestacion}
                    />

                    <InputText
                        id="nombre_prestacion"
                        name="nombre_prestacion"
                        label="Nombre de prestacion" 
                        value={data.nombre_prestacion}
                        onChange={(e) => setData('nombre_prestacion', e.target.value)}
                        placeholder="Escriba el nombre de la prestacion"
                        error={errors.nombre_prestacion}
                    />

                    <InputText
                        id="importe"
                        name="importe"
                        label="Escriba el importe del producto o servicio" 
                        value={(data.importe ?? '').toString()}
                        onChange={(e) => {
                            const value = e.target.value;
                            setData('importe', parseFloat(value || '0'));
                        }}
                        placeholder="Escriba la cantidad del importe"
                        error={errors.importe}
                        type="number"
                    />

                    {(data.tipo === "INSUMO") && (
                    <InputText
                        id="cantidad"
                        name="cantidad"
                        label="Cantidad" 
                        value={(data.cantidad ?? '').toString()}
                        onChange={(e) => {
                            const value = e.target.value;
                            setData('cantidad', value === '' ? null : parseFloat(value));
                        }}
                        placeholder="Escriba la cantidad del producto disponible"
                        error={errors.cantidad}
                        type= "number"
                    />
                    )}
                </div>
            </FormLayout>
        </>
    );
};

Edit.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Editar producto o servicio' children={page}/>
    );
}

export default Edit;