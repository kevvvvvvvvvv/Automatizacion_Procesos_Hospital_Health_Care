import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { CatalogoEstudio, Estancia, Paciente, ProductoServicio, notasEvoluciones } from '@/types';  
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import { EvolucionForm } from './partials/evolucion-form';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  evolucion? :notasEvoluciones;
  soluciones: ProductoServicio[]; 
  medicamentos: ProductoServicio[]; 
  estudios: CatalogoEstudio []; 
};

const CreateNotaEvolucion: React.FC<Props> = ({ paciente, estancia, soluciones, medicamentos, estudios, evolucion}) => {
  
  

  const handleCreate = (form : any) => {
    form.post(route('pacientes.estancias.notasevoluciones.store', {  
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  
  return (
    <MainLayout
    pageTitle={`Creación de nota de evolución`}
      link="estancias.show"
      
      linkParams={estancia.id} >
      <PacienteCard
        paciente={paciente}
        estancia={estancia}
      />
      <Head title="Crear Nota de Evolución" />
      <EvolucionForm 
      paciente = { paciente }
      estancia = { estancia }
      evolucion =  { evolucion }
      soluciones = {soluciones}
      medicamentos={ medicamentos}
      estudios={ estudios}
      onSubmit={ handleCreate} 
      submitLabel='Crear nota de evolución'
      />

      
    </MainLayout>
  );
};

export default CreateNotaEvolucion;
