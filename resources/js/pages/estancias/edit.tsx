import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputDate from '@/components/ui/input-date';
import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import { Estancia, Paciente, Habitacion, FamiliarResponsable } from '@/types';
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';

interface EditEstanciaProps {
    paciente: Paciente & { 
        estancias: Estancia[];
        familiar_responsables: FamiliarResponsable[];
    };
    habitaciones: Habitacion[];
    estancia: Estancia;
}

interface EstanciaFormData {
    folio: string;
    paciente_id: number;
    fecha_ingreso: Date | null;
    tipo_estancia: 'Hospitalizacion' | 'Interconsulta' | '';
    tipo_ingreso: 'Ingreso' | 'Reingreso' | string;
    modalidad_ingreso: string;
    habitacion_id: number | string | null;
    familiar_responsable_id: number | string | null;
    estancia_anterior_id: number | string | null;
}

const optionsTipoEstancia = [
    { value: 'Hospitalizacion', label: 'Hospitalización' },
    { value: 'Interconsulta', label: 'Interconsulta' },
];

const optionsTipoIngreso = [
    { value: 'Ingreso', label: 'Ingreso' },
    { value: 'Reingreso', label: 'Reingreso' },
];


const Edit = ({ paciente, estancia, habitaciones }: EditEstanciaProps) => {

    const { data, setData, put, processing, errors } = useForm<EstanciaFormData>({
        folio: estancia.folio || '',
        paciente_id: paciente.id,
        fecha_ingreso: estancia.fecha_ingreso ? new Date(estancia.fecha_ingreso) : null,
        tipo_estancia: estancia.tipo_estancia || '',
        tipo_ingreso: estancia.tipo_ingreso || '',
        modalidad_ingreso: estancia.modalidad_ingreso || 'Particular',
        habitacion_id: estancia.habitacion_id || null,
        familiar_responsable_id: estancia.familiar_responsable_id || null,
        estancia_anterior_id: estancia.estancia_anterior_id || null,
    });

    const optionsEstanciasPrevias = paciente.estancias
        .filter(e => e.id !== estancia.id)
        .map(e => ({ value: e.id, label: `Folio: ${e.folio} - Ingreso: ${e.fecha_ingreso}` }));

    const optionsFamiliarResponsables = paciente.familiar_responsables.map(fr => ({ value: fr.id, label: fr.nombre_completo }));
    
    const optionsHabitaciones = habitaciones.map(h => ({ value: h.id, label: h.identificador }));


    const getInitialModalidadType = () => {
        return data.modalidad_ingreso === 'Particular' ? 'Particular' : 'Compania';
    };

    const [tipoModalidad, setTipoModalidad] = useState<'Particular' | 'Compania'>(getInitialModalidadType());

    const handleTipoModalidadChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const newTipo = e.target.value as 'Particular' | 'Compania';
        setTipoModalidad(newTipo);

        if (newTipo === 'Particular') {
            setData('modalidad_ingreso', 'Particular');
        } else {
            if (data.modalidad_ingreso === 'Particular') {
                setData('modalidad_ingreso', '');
            }
        }
    };



    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('estancias.update', { estancia: estancia.id }));
    };

     console.log("ID de habitación actual:", data.habitacion_id);
    console.log("Opciones de habitaciones disponibles:", optionsHabitaciones);

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            <Head title={`Editar Estancia: ${data.folio}`} />

            <InputText id="folio" name="folio" label="Folio (no editable)" value={data.folio} onChange={() => {}} disabled />

            <InputDate
                description="Fecha de ingreso"
                id="fecha_ingreso"
                name="fecha_ingreso"
                value={data.fecha_ingreso}
                onChange={(date) => setData('fecha_ingreso', date)}
                error={errors.fecha_ingreso}
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
                    value={data.estancia_anterior_id}
                    onChange={(value) => setData('estancia_anterior_id', value)}
                    error={errors.estancia_anterior_id}
                    placeholder="Selecciona la estancia original..."
                />
            )}

            {data.tipo_estancia === 'Hospitalizacion' && (
                <SelectInput
                    label="Habitación asignada"
                    options={optionsHabitaciones}
                    value={data.habitacion_id}
                    onChange={(value) => setData('habitacion_id', value)}
                    error={errors.habitacion_id}
                    placeholder="Seleccione la habitación"
                />
            )}

            <SelectInput
                label="Familiar responsable"
                options={optionsFamiliarResponsables}
                placeholder='Seleccione el familiar responsable del paciente'
                value={data.familiar_responsable_id}
                onChange={(value) => setData('familiar_responsable_id', value)}
                error={errors.familiar_responsable_id}
            />

            <div className="space-y-2">
                <label className="block font-medium text-sm text-gray-700">Modalidad de ingreso</label>
                <div className="flex items-center space-x-4">
                    <label className="flex items-center">
                        <input type="radio" name="tipo_modalidad" value="Particular" checked={tipoModalidad === 'Particular'} onChange={handleTipoModalidadChange} className="text-indigo-600 focus:ring-indigo-500" />
                        <span className="ml-2">Particular</span>
                    </label>
                    <label className="flex items-center">
                        <input type="radio" name="tipo_modalidad" value="Compania" checked={tipoModalidad === 'Compania'} onChange={handleTipoModalidadChange} className="text-indigo-600 focus:ring-indigo-500" />
                        <span className="ml-2">Compañía Aseguradora</span>
                    </label>
                </div>

                {tipoModalidad === 'Compania' && (
                    <div className="mt-2">
                        <InputText id="modalidad_ingreso" name="modalidad_ingreso" label="" value={data.modalidad_ingreso} onChange={(e) => setData('modalidad_ingreso', e.target.value)} placeholder="Escriba el nombre de la aseguradora" error={errors.modalidad_ingreso} required />
                    </div>
                )}
                {errors.modalidad_ingreso && (
                    <p className="text-sm text-red-600 mt-2">{errors.modalidad_ingreso}</p>
                )}
            </div>

            <PrimaryButton type="submit" disabled={processing}>
                {processing ? 'Actualizando...' : 'Actualizar Estancia'}
            </PrimaryButton>
        </form>
    );
};

Edit.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as EditEstanciaProps;
    return (
        <MainLayout pageTitle={`Editando Estancia de: ${paciente.nombre}`} children={page} />
    );
};

export default Edit;