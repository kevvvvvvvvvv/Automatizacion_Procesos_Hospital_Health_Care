// resources/js/Pages/quirofanos/Edit.tsx
import React from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { QuirofanoForm } from "./partials/quirofano-forms";
import { route } from "ziggy-js";
import { ReservacionQuirofano, Paciente, Estancia } from "@/types";

interface Props {
    quirofano: ReservacionQuirofano;
    medicos: any[];
}

const Edit = ({ quirofano, medicos }: Props) => {
    
    const handleEdit = (form: any) => {
        form.put(route("quirofanos.update", { quirofano: quirofano.id }));
    };

    return (
        <MainLayout pageTitle="Editar Reservación" link="quirofanos.index">
            <Head title="Editar Quirófano" />
            <QuirofanoForm 
                quirofano={quirofano}
                medicos={medicos}
                onSubmit={handleEdit}
                submitLabel="Actualizar Reservación"
            />
        </MainLayout>
    );
};

export default Edit;