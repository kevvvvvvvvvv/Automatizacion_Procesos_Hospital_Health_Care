import {  useForm } from '@inertiajs/react';
import React, { useState } from "react";
import MainLayout from '@/layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Paciente from '@/types';

import PrimaryButton from '@/components/ui/primary-button';
import { PacienForm}  from './partials/paciente-form';



const PacienteCreate: React.FC = ()  => {
    const handleSubmit = (form: any)=>{
        form.post(route('pacientes.store', {        }))
    };

  return (
    <MainLayout pageTitle='Registro de paciente' link='pacientes.index'>
        <Head title='Crear paciente'/>
        <PacienForm

        onSubmit={handleSubmit}
        submitLabel = "Crear paciente"
        />
         
        
        </MainLayout>
  );

};

export default PacienteCreate;
