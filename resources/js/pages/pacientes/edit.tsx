import React from "react";
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { Paciente } from '@/types'; 
// Si usaste "export const PacienteForm", impórtalo entre llaves:
import {PacienForm} from './partials/paciente-form';

interface Props {
    paciente: Paciente;
}

const Edit = ({ paciente }: Props) => {

    const handleEdit = (form: any) => {
        form.put(route('pacientes.update', {paciente:paciente.id}));
    };

    return (
        <MainLayout pageTitle='Registro de paciente' link='pacientes.index'>
            <Head title='Actualizar paciente' />
            <PacienForm
                paciente={paciente}
                onSubmit={handleEdit}
                submitLabel="Actualizar paciente"
            />
        </MainLayout>
    );
};

export default Edit;