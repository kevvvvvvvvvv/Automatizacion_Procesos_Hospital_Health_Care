import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import { Paciente, Estancia, NotaPreAnestesica } from '@/types';
import { route } from 'ziggy-js';
import { Preanestesicaform } from '../notapreanestesica/partials/preanestesica-form';

interface Props {
  paciente: Paciente;
  estancia: Estancia;
  preanestesica: NotaPreAnestesica;
}



const CreateNotaPreanestesica: React.FC<Props> = ({ paciente, estancia, preanestesica}) => {
  const handleEdit = (form : any) => {
  form.put(
    route('notaspreanestesicas.update', {
      notaspreanestesica: preanestesica.id // Cambiado de 'preanestesica' a 'notaspreanestesica'
    })
  );
};

 
  return (
    <>
      <Head title="Nota Preanestésica" />

      <MainLayout
      pageTitle={`Edición de nota preanestesica`}
      link="estancias.show"
      
      linkParams={estancia.id} >
        <PacienteCard paciente={paciente} estancia={estancia} />
      <Preanestesicaform

        onSubmit={handleEdit}
        paciente={paciente}
        estancia={estancia}
        preanestesica={preanestesica}
        submitLabel='guardar'
      />
        
      </MainLayout>
    </>
  );
};

export default CreateNotaPreanestesica;
