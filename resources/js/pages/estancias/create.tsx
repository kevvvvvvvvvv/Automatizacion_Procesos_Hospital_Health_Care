import React, { useState} from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import InputDate from '@/components/ui/input-date';
import SelectInput from '@/components/ui/input-select'; 
import InputText from '@/components/ui/input-text';
import { Estancia, Paciente, Habitacion, FamiliarResponsable } from '@/types'; 
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';


interface CreateEstanciaProps {
    paciente: Paciente & { 
        estancias: Estancia[],
        familiar_responsables: FamiliarResponsable[]
    }; 
    habitaciones: Habitacion[],
}

interface EstanciaFormData {
    folio: '';
    paciente_id: number;
    fecha_ingreso: Date | null;
    tipo_estancia: 'Hospitalizacion' | 'Interconsulta' | '';
    tipo_ingreso: 'Ingreso' | 'Reingreso' | '';
    modalidad_ingreso: string;
    habitacion_id: number | string |null;
    familiar_responsable_id:number | string |null;
    estancia_referencia_id: number | string | null; 
}

const optionsTipoEstancia = [
    { value: 'Hospitalizacion', label: 'Hospitalización' },
    { value: 'Interconsulta', label: 'Consulta' },
];

const optionsTipoIngreso = [
    { value: 'Ingreso', label: 'Ingreso' },
    { value: 'Reingreso', label: 'Reingreso' },
];

const Create = ({ paciente, habitaciones }: CreateEstanciaProps) => {

  
    const { data, setData, post, processing, errors } = useForm<EstanciaFormData>({
        folio: '',
        paciente_id: paciente.id,
        fecha_ingreso: new Date(), 
        tipo_estancia: '',
        tipo_ingreso: 'Ingreso',
        modalidad_ingreso: '', 
        estancia_referencia_id: null,
        familiar_responsable_id: null,
        habitacion_id: null,
    });

    React.useEffect(() => {
        setData('modalidad_ingreso', 'Particular');
    }, [setData]);
  
    const optionsEstanciasPrevias = paciente.estancias.map(estancia => ({
        value: estancia.id,
        label: `Folio: ${estancia.folio} - Ingreso: ${estancia.fecha_ingreso}`
    }));

    const optionsFamiliarResponsables = paciente.familiar_responsables.map(familiar_responsable => ({
        value: familiar_responsable.id,
        label: familiar_responsable.nombre_completo
    }));

    const optionsHabitaciones = habitaciones.map(habitacion => ({
        value: habitacion.id,
        label: habitacion.identificador
    }));

    const [tipoModalidad, setTipoModalidad] = useState<'Particular' | 'Compania'>('Particular');

    const handleTipoModalidadChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const newTipo = e.target.value as 'Particular' | 'Compania';
        setTipoModalidad(newTipo);

        if (newTipo === 'Particular') {
            setData('modalidad_ingreso', 'Particular');
        } else {
            setData('modalidad_ingreso', '');
        }
    };


    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('pacientes.estancias.store', { paciente: paciente.id }));
    };

  return (
    
    <FormLayout onSubmit={handleSubmit} title='Registro de estancia'
    actions={
        <PrimaryButton disabled={processing}>
            Guardar cambios
        </PrimaryButton>
    }>
        <Head title="Registro de estancia" />
        
        {errors.folio && (
            <div className="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span className="font-medium">Error de duplicado:</span> {errors.folio}
            </div>
        )}
        <InputDate
            description="Fecha de ingreso"
            id="fecha_ingreso"
            name="fecha_ingreso"
            value={data.fecha_ingreso}
            onChange={(date) => setData('fecha_ingreso', date)} 
            error={errors.fecha_ingreso}
        />

        <SelectInput
            label="Tipo de estancia"
            options={optionsTipoEstancia}
            value={data.tipo_estancia}
            onChange={(value) => setData('tipo_estancia', value as EstanciaFormData['tipo_estancia'])}
            error={errors.tipo_estancia}
        />

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
            label="Tipo de ingreso"
            options={optionsTipoIngreso}
            value={data.tipo_ingreso}
            onChange={(value) => setData('tipo_ingreso', value as EstanciaFormData['tipo_ingreso'])}
            error={errors.tipo_ingreso}
        />

        {data.tipo_ingreso === 'Reingreso' && (
            <SelectInput
                label="Estancia de referencia para reingreso"
                options={optionsEstanciasPrevias}
                value={data.estancia_referencia_id}
                onChange={(value) => setData('estancia_referencia_id', value)}
                error={errors.estancia_referencia_id}
                placeholder="Selecciona la estancia original..."
            />
        )}
        
        <SelectInput
            label = "Familiar responsable"
            options= {optionsFamiliarResponsables}
            placeholder='Seleccione el familiar responsable del paciente'
            value = {data.familiar_responsable_id}
            onChange = {(value) => setData('familiar_responsable_id', value)}
            error = {errors.familiar_responsable_id}
        />

        <div className="space-y-2">
            <label className="block font-medium text-sm text-gray-700">Modalidad de ingreso</label>
            <div className="flex items-center space-x-4">
                <label className="flex items-center">
                    <input
                        type="radio"
                        name="tipo_modalidad"
                        value="Particular"
                        checked={tipoModalidad === 'Particular'}
                        onChange={handleTipoModalidadChange}
                        className="text-indigo-600 focus:ring-indigo-500"
                    />
                    <span className="ml-2">Particular</span>
                </label>
                <label className="flex items-center">
                    <input
                        type="radio"
                        name="tipo_modalidad"
                        value="Compania"
                        checked={tipoModalidad === 'Compania'}
                        onChange={handleTipoModalidadChange}
                        className="text-indigo-600 focus:ring-indigo-500"
                    />
                    <span className="ml-2">Compañía Aseguradora</span>
                </label>
            </div>

            {tipoModalidad === 'Compania' && (
                <div className="mt-2">
                    <InputText
                        id="modalidad_ingreso"
                        name="modalidad_ingreso"
                        label="" 
                        value={data.modalidad_ingreso}
                        onChange={(e) => setData('modalidad_ingreso', e.target.value)}
                        placeholder="Escriba el nombre de la aseguradora"
                        error={errors.modalidad_ingreso}
                        required
                    />
                </div>
            )}
            {tipoModalidad !== 'Compania' && errors.modalidad_ingreso && (
                <p className="text-sm text-red-600 mt-2">{errors.modalidad_ingreso}</p>
            )}
        </div>
    </FormLayout>
  );
};

Create.layout = (page: React.ReactElement) => {
    const { paciente } = page.props as CreateEstanciaProps;
    return (
        <MainLayout pageTitle={`Registrar Estancia para: ${paciente.nombre}`} children={page} />
    );
};

export default Create;