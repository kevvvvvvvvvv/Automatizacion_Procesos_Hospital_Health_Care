import React from 'react';
import { Paciente, Estancia } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import PacienteCard from '@/components/paciente-card';
import SelectInput from '@/components/ui/input-select'; 
import InputTextArea from '@/components/ui/input-text-area';
import TextInput from '@/components/ui/input-text'; // Asegúrate de tener este componente
import { route } from 'ziggy-js';

interface CreateProps {
    paciente: Paciente;
    estancia: Estancia;
}

const areas = [
    { value: 'quirofano', label: 'Quirófano'},
    { value: 'hospitalizacion', label: 'Hospitalización'},
];

const sexos = [
    { value: 'MASCULINO', label: 'Masculino'},
    { value: 'FEMENINO', label: 'Femenino'},
    { value: 'INDETERMINADO', label: 'Indeterminado'},
];

const Create: React.FC<CreateProps> = ({ paciente, estancia }) => {
    const { data, setData, post, processing, errors } = useForm({
        area: 'hospitalizacion', // Cambiado de 'areas' a 'area' para coincidir con la migración
        nombre_rn: '',
        fecha_rn: '',
        hora_rn: '',
        sexo: '',
        peso: '',
        talla: '',
        observaciones: '',
        estado: 'ACTIVO', // Agregado ya que está en tu migración
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // Asegúrate de poner el nombre correcto de tu ruta en route('')
        post(route('pacientes.estancias.reciennacido.store', {
            paciente: paciente.id,
            estancia: estancia.id
        }));
    };

    return (
        <MainLayout pageTitle='Hoja de enfermería de recién nacidos' link='estancias.show' linkParams={estancia.id}>
            <Head title='Inicio de hoja de enfermería' />
            
            <PacienteCard
                paciente={paciente}
                estancia={estancia} 
            />

            <FormLayout 
                title='Iniciar hoja de enfermería Recién Nacido'
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type='submit' disabled={processing}>
                        {processing ? 'Iniciando...' : 'Iniciar turno'}
                    </PrimaryButton>
                }
            >
                <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
                    
                    {/* Área */}
                    <SelectInput
                        label='Área'
                        options={areas}
                        value={data.area}
                        onChange={(value) => setData('area', value as string)}
                        error={errors.area}
                    />

                    {/* Nombre del RN */}
                    <TextInput
                        id='nombre_rn'
                        name='nombre_rn'
                        label='Nombre del Recién Nacido'
                        value={data.nombre_rn}
                        onChange={(e) => setData('nombre_rn', e.target.value)}
                        error={errors.nombre_rn}
                        placeholder="Nombre completo"
                    />

                    {/* Sexo */}
                    <SelectInput
                        label='Sexo'
                        options={sexos}
                        value={data.sexo}
                        onChange={(value) => setData('sexo', value as string)}
                        error={errors.sexo}
                    />

                    {/* Fecha de Nacimiento */}
                    <TextInput
                        id='fecha_rn'
                        name='fecga'
                        type="date"
                        label='Fecha de Nacimiento'
                        value={data.fecha_rn}
                        onChange={(e) => setData('fecha_rn', e.target.value)}
                        error={errors.fecha_rn}
                    />

                    {/* Hora de Nacimiento */}
                    <TextInput
                        id='hora_rn'
                        name='hora_rn'
                        type="time"
                        label='Hora de Nacimiento'
                        value={data.hora_rn}
                        onChange={(e) => setData('hora_rn', e.target.value)}
                        error={errors.hora_rn}
                    />

                    {/* Peso (Float en migración) */}
                    <TextInput
                        id='peso'
                        name='peso'
                        type="number"
                        step="0.001"
                        label='Peso (kg)'
                        value={data.peso}
                        onChange={(e) => setData('peso', e.target.value)}
                        error={errors.peso}
                        placeholder="Ej: 3.500"
                    />

                    {/* Talla (Integer en migración) */}
                    <TextInput
                        id='talla'
                        name='talla'
                        type="number"
                        label='Talla (cm)'
                        value={data.talla}
                        onChange={(e) => setData('talla', e.target.value)}
                        error={errors.talla}
                        placeholder="Ej: 50"
                    />

                    {/* Observaciones (Ocupa dos columnas en desktop) */}
                    <div className="md:col-span-2 lg:col-span-3">
                        <InputTextArea
                            label='Observaciones iniciales'
                            value={data.observaciones}
                            onChange={(e) => setData('observaciones', e.target.value)}
                            error={errors.observaciones}
                            rows={3}
                        />
                    </div>
                </div>
            </FormLayout>
        </MainLayout>
    );
};

export default Create;