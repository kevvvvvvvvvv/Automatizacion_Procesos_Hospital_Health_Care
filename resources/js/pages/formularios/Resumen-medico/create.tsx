import { route } from "ziggy-js";
import MainLayout from "@/layouts/MainLayout";
import { Estancia, Paciente, ResumenMedico } from "@/types";
import React from "react";

import PacienteCard from "@/components/paciente-card";
import { Head } from "@inertiajs/react";
import { ResumenForm } from "./partials/resumen-form";

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    resumen: ResumenMedico;

}
const CreateResumen: React.FC<Props> = ({ paciente, estancia, resumen }) => {
    const handleCreate = (form : any) => {
        form.post(route('paciente.estancias.resumenmedico.store', {
            paciente: paciente.id,
            estancia: estancia.id,
        }));
    };
    return (
        <MainLayout
        pageTitle={`Creación del resumen médico`}
        link="estancias.show"
        linkParams={estancia.id}
        >
        <PacienteCard
        paciente={paciente}
        estancia={estancia}/>
        <Head title="Crear resumen médico" />
        <ResumenForm
            paciente = { paciente }
            estancia = {estancia}
            resumen={resumen}
            onSubmit = {handleCreate}
            submitLabel="Crear resumen medico"
        />

        </MainLayout>
    )
}
export default CreateResumen;