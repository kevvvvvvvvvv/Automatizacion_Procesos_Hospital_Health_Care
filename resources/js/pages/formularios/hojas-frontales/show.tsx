import React from 'react';
import { Head, Link } from '@inertiajs/react';

import MainLayout from '@/layouts/MainLayout';
import { User, Paciente, Estancia, hojaFrontal } from '@/types'; // Limpié los tipos no usados
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
// ELIMINADO: import estancia from '@/routes/estancia'; <-- Esto causaba el error

interface Props {
    hojaFrontal: hojaFrontal & {
        formularioinstancia?: {
            user?: User;
            estancia?: Estancia & { paciente: Paciente }
        }
    };
    paciente: Paciente;
    estancia: Estancia;
}

const Show = ({ hojaFrontal, paciente, estancia }: Props) => {
    // Nota: Aquí usabas formularioInstancia con "I" mayúscula, 
    // pero en la interfaz está con "i" minúscula. Ten cuidado con eso.
    const { formularioinstancia } = hojaFrontal;

    return (
        <MainLayout
            pageTitle='Hoja Frontal'
            link='estancias.show'
            linkParams={estancia.id}
        >
            <Head title='Detalles de hoja frontal'/>
            
            <InfoCard
                title={`Hoja Frontal para ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}
            > 
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <InfoField 
                        label='Médico asignado' 
                        value={
                            hojaFrontal.medico 
                                ? `${hojaFrontal.medico.nombre} ${hojaFrontal.medico.apellido_paterno} ${hojaFrontal.medico.apellido_materno}`
                                : 'N/A'
                        }
                    />  
                    <InfoField 
                        label='Notas' 
                        value={hojaFrontal.notas || 'N/A'}
                    />
                </div>
            </InfoCard>
        </MainLayout>
    );
}

// ESTO ES VITAL: Si no exportas, Inertia no sabe qué renderizar
export default Show;