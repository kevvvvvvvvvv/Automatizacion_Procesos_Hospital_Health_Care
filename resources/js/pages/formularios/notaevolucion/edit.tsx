import React from 'react';
import { useForm, Head } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { CatalogoEstudio, Estancia, Paciente, ProductoServicio, notasEvoluciones } from '@/types';  
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import { EvolucionForm } from './partials/evolucion-form';
import PlanSoluciones from '@/components/forms/tratamiento-soluciones-form';
import medicamentos from '@/routes/medicamentos';
import InputText from '@/components/ui/input-text';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  evolucion:notasEvoluciones;
  soluciones: ProductoServicio[]; 
  medicamentos: ProductoServicio[]; 
  estudios: CatalogoEstudio []; 

};
const Edit = ({ evolucion, paciente, estancia, soluciones, estudios, medicamentos }: Props) => {
    //console.log("informacion de la evolucion", evolucion)
    const handleEdit = (form : any) => {
    form.put(route('notasevoluciones.update', { 
        paciente: paciente.id,
        estancia: estancia.id,
        notasevolucione: evolucion.id 
    }));
};

    return (
        <MainLayout
            pageTitle='Edición de la nota de evolución'
            link='estancias.show'
            linkParams={estancia.id}
        >
            <div className='space-y-6'>
                <Head title={`Editar nota de evolución: ${paciente.nombre}`} />
                
                <PacienteCard
                    paciente={paciente}
                    estancia={estancia}
                />
                
                <EvolucionForm
                    onSubmit={handleEdit}
                    evolucion={evolucion} // Esto es vital: EvolucionForm debe usar esto para llenar el estado inicial
                    paciente={paciente}
                    estancia={estancia}
                    soluciones={soluciones}
                    medicamentos={medicamentos}
                    estudios={estudios}
                    submitLabel='Actualizar nota de evolución'
                />
            </div>
        </MainLayout>
    );
}
export default Edit;