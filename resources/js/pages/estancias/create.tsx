import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputDate from '@/components/ui/input-date';
import SelectInput from '@/components/ui/input-select'; 
import InputText from '@/components/ui/input-text';
import { Estancia, Paciente } from '@/types'; 
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';

interface CreateEstanciaProps {
  paciente: Paciente & { estancias: Estancia[] }; 
}

interface EstanciaFormData {
    folio: '';
    paciente_id: number;
    fechaIngreso: Date | null;
    tipo_estancia: 'Hospitalizacion' | 'Interconsulta' | '';
    tipo_ingreso: 'Ingreso' | 'Reingreso' | '';
    num_habitacion: string;
    estancia_referencia_id: number | string; 
}

const optionsTipoEstancia = [
  { value: 'Hospitalizacion', label: 'Hospitalización' },
  { value: 'Interconsulta', label: 'Interconsulta' },
];

const optionsTipoIngreso = [
  { value: 'Ingreso', label: 'Ingreso' },
  { value: 'Reingreso', label: 'Reingreso' },
];

const Create = ({ paciente }: CreateEstanciaProps) => {

  
  const { data, setData, post, processing, errors } = useForm<EstanciaFormData>({
    folio: '',
    paciente_id: paciente.id,
    fechaIngreso: new Date(), 
    tipo_estancia: '',
    tipo_ingreso: 'Ingreso', 
    num_habitacion: '',
    estancia_referencia_id: '',
  });

  
  const optionsEstanciasPrevias = paciente.estancias.map(estancia => ({
    value: estancia.id,
    label: `Folio: ${estancia.folio} - Ingreso: ${estancia.fecha_ingreso}`
  }));

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('pacientes.estancias.store', { paciente: paciente.id }));
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
        <Head title="Registro de Estancia" />
        
        {errors.folio && (
            <div className="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span className="font-medium">Error de duplicado:</span> {errors.folio}
            </div>
        )}
        <InputDate
            description="Fecha de ingreso"
            id="fechaIngreso"
            name="fechaIngreso"
            value={data.fechaIngreso}
            onChange={(date) => setData('fechaIngreso', date)} 
            error={errors.fechaIngreso}
        />

        <SelectInput
            label="Tipo de Estancia"
            options={optionsTipoEstancia}
            value={data.tipo_estancia}
            onChange={(value) => setData('tipo_estancia', value as EstanciaFormData['tipo_estancia'])}
            error={errors.tipo_estancia}
        />

        <SelectInput
            label="Tipo de Ingreso"
            options={optionsTipoIngreso}
            value={data.tipo_ingreso}
            onChange={(value) => setData('tipo_ingreso', value as EstanciaFormData['tipo_ingreso'])}
            error={errors.tipo_ingreso}
        />

        {data.tipo_ingreso === 'Reingreso' && (
            <SelectInput
                label="Estancia de Referencia para Reingreso"
                options={optionsEstanciasPrevias}
                value={data.estancia_referencia_id}
                onChange={(value) => setData('estancia_referencia_id', value)}
                error={errors.estancia_referencia_id}
                placeholder="Selecciona la estancia original..."
            />
        )}
        
        {data.tipo_estancia === 'Hospitalizacion' && (
            <InputText
                id="num_habitacion"
                name="num_habitacion"
                label="Número de habitación"
                value={data.num_habitacion}
                onChange={(e) => setData('num_habitacion', e.target.value)}
                placeholder="Escribe el número de habitación..."
                error={errors.num_habitacion}
            />
        )}

        <PrimaryButton type="submit" disabled={processing}>
        {processing ? 'Guardando...' : 'Guardar Estancia'}
        </PrimaryButton>
    </form>
  );
};

Create.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as CreateEstanciaProps;
    return (
        <MainLayout title={`Registrar Estancia para: ${paciente.nombre}`} children={page} />
    );
};

export default Create;