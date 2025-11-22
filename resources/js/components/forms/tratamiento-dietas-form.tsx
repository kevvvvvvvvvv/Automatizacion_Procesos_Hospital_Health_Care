import React, { useState } from 'react';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';

interface Props {
    value: string;
    onChange: (value: string) => void;
    error?: string;
}

const PlanDieta: React.FC<Props> = ({ value, onChange, error }) => {
    const [dietaPreset, setDietaPreset] = useState<'ayuno' | 'liquida' | 'manual' | null>(null);
    const [horasDietaLiquida, setHorasDietaLiquida] = useState('');

    const handleSetDietaAyuno = () => {
        onChange("Ayuno estricto.");
        setDietaPreset('ayuno');
        setHorasDietaLiquida('');
    };

    const handleSetDietaLiquida = () => {
        setDietaPreset('liquida');
        const horas = horasDietaLiquida || '__';
        onChange(`Iniciar dieta líquida progresar a blanda en cuanto tiempo ${horas} horas.`);
    };

    const handleHorasChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const horas = e.target.value;
        setHorasDietaLiquida(horas);
        if (dietaPreset === 'liquida') {
            onChange(`Iniciar dieta líquida progresar a blanda en ${horas || '__'} horas.`);
        }
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border">
            <h3 className="text-lg font-semibold mb-4 border-b pb-2">Plan de dieta</h3>
            
            <div className="flex flex-wrap gap-2 mb-2">
                <button
                    type="button"
                    onClick={handleSetDietaAyuno}
                    className={`text-xs px-3 py-1 rounded-full ${dietaPreset === 'ayuno' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                >
                    Ayuno estricto
                </button>
                <button
                    type="button"
                    onClick={handleSetDietaLiquida}
                    className={`text-xs px-3 py-1 rounded-full ${dietaPreset === 'liquida' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                >
                    Dieta líquida progresiva
                </button>
            </div>

            {dietaPreset === 'liquida' && (
                <div className="max-w-xs my-2">
                    <InputText
                        label="Iniciar en (horas)"
                        type="number"
                        id="horas_dieta_liquida"
                        name="horas_dieta_liquida"
                        value={horasDietaLiquida}
                        onChange={handleHorasChange}
                    />
                </div>
            )}

            <InputTextArea
                label="Descripción de la dieta (campo libre)"
                value={value}
                onChange={(e) => {
                    onChange(e.target.value);
                    setDietaPreset('manual');
                }}
                error={error}
                rows={4}
            />
        </div>
    );
};

export default PlanDieta;