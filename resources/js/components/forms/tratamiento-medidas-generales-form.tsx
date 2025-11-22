import React, { useState } from 'react';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';
import PrimaryButton from '@/components/ui/primary-button';

interface Props {
    value: string;
    onChange: (value: string) => void;
    error?: string;
}

const optionsMedidas = [
    'Posición semifowler.', 'Reposo absoluto.', 'Vigilancia de heridas quirúrgicas.',
    'Vigilancia y cuantificación de drenajes.', 'Deambulación.',
];

const PlanMedidasGenerales: React.FC<Props> = ({ value, onChange, error }) => {
    const [horasSignos, setHorasSignos] = useState('');

    const addTexto = (texto: string) => {
        const nuevaLinea = `• ${texto}`;
        onChange(value ? `${value}\n${nuevaLinea}` : nuevaLinea);
    };

    const handleAddHoras = () => {
        addTexto(`Cuidados generales de enfermería y signos vitales cada ${horasSignos || '___'} horas.`);
        setHorasSignos('');
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Medidas Generales</h4>
            
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 mb-4">
                <h5 className="text-sm font-medium text-gray-700">Opciones rápidas:</h5>
                <div className="flex flex-wrap gap-2">
                    {optionsMedidas.map((texto) => (
                        <button
                            key={texto}
                            type="button"
                            onClick={() => addTexto(texto)}
                            className="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 transition"
                        >
                            + {texto}
                        </button>
                    ))}
                </div>
                <div className="flex items-end gap-2 pt-2 border-t">
                    <div className="flex-1">
                        <InputText
                            label="Signos vitales cada (horas)"
                            type="number"
                            name="horas_signos"
                            id="horasSignos"
                            value={horasSignos}
                            onChange={e => setHorasSignos(e.target.value)}
                        />
                    </div>
                    <PrimaryButton type="button" onClick={handleAddHoras}>+ Agregar</PrimaryButton>
                </div>
            </div>

            <InputTextArea
                label="Plan de medidas generales (campo libre)"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                error={error}
                rows={5}
            />
        </div>
    );
};

export default PlanMedidasGenerales;