import React,{ useState} from 'react';
import { Head, useForm } from '@inertiajs/react';
import { HojaEnfermeria, NotaPostoperatoria, Paciente, Estancia, User, ProductoServicio, CatalogoEstudio } from '@/types';
import { route } from 'ziggy-js';
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeria;
    nota?: NotaPostoperatoria;
    users: User[];
    soluciones: ProductoServicio[];
    medicamentos: ProductoServicio[];
    estudios: CatalogoEstudio[];
}

type NotaPostoperatoriaComponent = React.FC<Props> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};


const NotaPostoperatoriaForm: NotaPostoperatoriaComponent= ({ paciente, estancia, nota, users, soluciones, medicamentos, estudios }) => {


  

    const handleSubmit = (form : any) => {
        form.post(route('pacientes.estancias.notaspostoperatorias.store', {  
            paciente: paciente.id,
            estancia: estancia.id,
          })); 
    }

    return (
        <>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <Head title="Crear nota postoperatoria" />
           
                <NotaPostoperatoriaForm
                paciente={paciente}
                estancia={estancia}
                users={users}
                soluciones={soluciones}
                medicamentos={medicamentos}
                estudios={estudios}
                onSubmit={handleSubmit}
                />

        </>
    );
}

NotaPostoperatoriaForm.layout = (page: React.ReactElement) =>{
    const { estancia, paciente } = page.props as Props;

  return (
    <MainLayout
      pageTitle={`Creación de nota postoperatoria`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
}

export default NotaPostoperatoriaForm;