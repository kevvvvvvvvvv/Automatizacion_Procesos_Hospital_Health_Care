import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { useForm } from '@inertiajs/react';
import SelectInput from '@/components/ui/input-select';
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { ProductoServicio } from '@/types';
// Interface del modelo que te manda Laravel por props


interface Props {
  productoServicio?: ProductoServicio | null; 
}

interface FormularioFormData {
  tipo: string;
  subtipo: string;
  codigo_prestacion: string;
  nombre_prestacion: string;
  importe: number | string | null;
  cantidad: number | string | null;
}

const ProductoServicioForm = ({ productoServicio } : Props) => {
  const isEdit = !!productoServicio;

  const { data, setData, post, put, processing, errors } =
    useForm<FormularioFormData>({
      tipo: productoServicio?.tipo ?? '',
      subtipo: productoServicio?.subtipo ?? '',
      codigo_prestacion: productoServicio?.codigo_prestacion ?? '',
      nombre_prestacion: productoServicio?.nombre_prestacion ?? '',
      importe: productoServicio?.importe ?? null,
      cantidad: productoServicio?.cantidad ?? null,
    });

  const optionsTipo = [
    { value: 'INSUMOS', label: 'INSUMOS' },
    { value: 'SERVICIOS', label: 'SERVICIOS' },
  ];

  const optionsSubtipo = [
    { value: 'MEDICAMENTOS', label: 'MEDICAMENTOS' },
    { value: 'INSUMOS', label: 'INSUMOS' },
    { value: 'SERVICIOS', label: 'SERVICIOS' },
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (isEdit && productoServicio) {
      // EDITAR
      put(route('producto-servicios.update', productoServicio.id));
    } else {
      // CREAR
      post(route('producto-servicios.store'));
    }
  };

  return (
    <FormLayout
      title={
        isEdit
          ? 'Editar Producto o Servicio'
          : 'Registrar Nuevo Producto o Servicio'
      }
      onSubmit={handleSubmit}
      actions={
        <PrimaryButton type="submit" disabled={processing}>
          {processing
            ? isEdit
              ? 'Actualizando...'
              : 'Guardando...'
            : isEdit
            ? 'Actualizar'
            : 'Guardar'}
        </PrimaryButton>
      }
    >
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <SelectInput
          label="Nombre capítulo"
          options={optionsTipo}
          placeholder="Seleccione un capítulo"
          value={data.tipo}
          onChange={(value) =>
            setData('tipo', value as FormularioFormData['tipo'])
          }
          error={errors.tipo}
        />

        <SelectInput
          label="Nombre subcapítulo"
          options={optionsSubtipo}
          placeholder="Seleccione un subcapítulo"
          value={data.subtipo}
          onChange={(value) =>
            setData('subtipo', value as FormularioFormData['subtipo'])
          }
          error={errors.subtipo}
        />

        <InputText
          id="codigo_prestacion"
          name="codigo_prestacion"
          label="Código de prestación"
          value={data.codigo_prestacion}
          onChange={(e) => setData('codigo_prestacion', e.target.value)}
          placeholder="Escriba el código de prestación"
          error={errors.codigo_prestacion}
        />

        <InputText
          id="nombre_prestacion"
          name="nombre_prestacion"
          label="Nombre de prestación"
          value={data.nombre_prestacion}
          onChange={(e) => setData('nombre_prestacion', e.target.value)}
          placeholder="Escriba el nombre de la prestación"
          error={errors.nombre_prestacion}
        />

        <InputText
          id="importe"
          name="importe"
          label="Importe del producto o servicio"
          value={(data.importe ?? '').toString()}
          onChange={(e) => setData('importe', e.target.value)}
          placeholder="Escriba la cantidad del importe"
          error={errors.importe}
        />

        {data.tipo === 'INSUMOS' && (
          <InputText
            id="cantidad"
            name="cantidad"
            label="Cantidad"
            value={(data.cantidad ?? '').toString()}
            onChange={(e) => setData('cantidad', e.target.value)}
            placeholder="Escriba la cantidad del producto disponible"
            error={errors.cantidad}
          />
        )}
      </div>
    </FormLayout>
  );
};

ProductoServicioForm.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Registrar producto o servicio' children={page}/>
    )
}

export default ProductoServicioForm;
