import React from 'react';
import {Paciente, Estancia} from '@/types';
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

type PacienteCardProps = {
    paciente: Paciente;
    estancia: Estancia;
}

const PacienteCard: React.FC<PacienteCardProps> = ({paciente, estancia}) => {
    return (
        <InfoCard title={`Paciente: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <InfoField label="Folio" value={estancia.folio} />
                <InfoField label="Sexo" value={paciente.sexo} />
                <InfoField label="Edad" value={`${paciente.age} años`}/>
            </div>
        </InfoCard>
    )
}

export default PacienteCard;