import React from 'react';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';

interface EnvioPiezaData {
    estudio_solicitado?: string;
    biopsia_pieza_quirurgica?: string;
    revision_laminillas?: string;
    estudios_especiales?: string;
    pcr?: string;
    pieza_remitida?: string;
    datos_clinicos?: string;
    empresa_enviar?: string;
    contenedores_enviados?: string;
    [key: string]: any; 
}


interface EnvioPiezaProps {
    data: EnvioPiezaData;
    setData: (field: string, value: string) => void;
    errors: Record<string, string | undefined>;
}

const EnvioPieza: React.FC<EnvioPiezaProps> = ({ data, setData, errors }) => {
    
    return (
        <>
            <h4 className="text-md font-semibold mb-3 col-span-full text-gray-800">
                Envío de piezas (patología)
            </h4>
                        
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 col-span-full">                         
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <InputText
                        label='Contendores enviados'
                        id='contenedores_enviados'
                        name='contenedores_enviados'
                        value={data.contenedores_enviados || ''}
                        onChange={(e)=>setData('contenedores_enviados',e.target.value)}
                        error={errors.contenedores_enviados}
                        type='number'
                    />

                    <InputText
                        label="Estudio solicitado"
                        id='estudio_solicitado'
                        name='estudio_solicitado'
                        value={data.estudio_solicitado || ''}
                        onChange={(e) => setData('estudio_solicitado', e.target.value)}
                        error={errors.estudio_solicitado}
                    />
                    <InputText
                        label="Biopsia o pieza quirúrgica"
                        id='biopsia_pieza_quirurgica'
                        name='biopsia_pieza_quirurgica'
                        value={data.biopsia_pieza_quirurgica || ''}
                        onChange={(e) => setData('biopsia_pieza_quirurgica', e.target.value)}
                        error={errors.biopsia_pieza_quirurgica}
                    />

                    <InputText
                        label="Revisión de laminillas"
                        id='revision_laminillas'
                        name='revision_laminillas'
                        value={data.revision_laminillas || ''}
                        onChange={(e) => setData('revision_laminillas', e.target.value)}
                        error={errors.revision_laminillas}
                    />

                    <InputText
                        label="Estudios especiales"
                        id='estudios_especiales'
                        name='estudios_especiales'
                        value={data.estudios_especiales || ''}
                        onChange={(e) => setData('estudios_especiales', e.target.value)}
                        error={errors.estudios_especiales}
                    />
                    <InputText
                        label="PCR"
                        id='pcr'
                        name='pcr'
                        value={data.pcr || ''}
                        onChange={(e) => setData('pcr', e.target.value)}
                        error={errors.pcr}
                    />
                    <InputText
                        label="Pieza remitida"
                        id='pieza_remitida'
                        name='pieza_remitida'
                        value={data.pieza_remitida || ''}
                        onChange={(e) => setData('pieza_remitida', e.target.value)}
                        error={errors.pieza_remitida}
                    />
                </div>

                <InputTextArea
                    label="Datos clínicos (anotar registro previo si existe)"
                    id="datos_clinicos"
                    name="datos_clinicos"
                    value={data.datos_clinicos || ''}
                    onChange={e => setData('datos_clinicos', e.target.value)}
                    error={errors.datos_clinicos}
                    rows={3}
                />

                <InputText
                    id="empresa_enviar"
                    name="empresa_enviar"
                    label="Empresa a enviar la solicitud de patología"
                    value={data.empresa_enviar || ''}
                    onChange={e => setData('empresa_enviar', e.target.value)}
                    error={errors.empresa_enviar}
                />
            </div>
        </>
    )
}

export default EnvioPieza;