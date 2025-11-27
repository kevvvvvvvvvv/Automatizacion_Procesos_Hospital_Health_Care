import React, { useState, useMemo } from 'react';
import { CatalogoEstudio } from '@/types';
import InputTextArea from '@/components/ui/input-text-area';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import Swal from 'sweetalert2';

interface Props {
    value: string;
    onChange: (value: string) => void;
    error?: string;
    estudios: CatalogoEstudio[];
}

const PlanLaboratorios: React.FC<Props> = ({ value, onChange, error, estudios }) => {
    
    const optionsEstudios = useMemo(() => 
    estudios && Array.isArray(estudios) ? estudios.map(estudio => ({
        value: estudio.id.toString(),
        label: `${estudio.nombre} (${estudio.departamento || estudio.tipo_estudio})`
    })): [], [estudios]);

    const [localEstudio, setLocalEstudio] = useState({ id: '', nombre: '' });

    const handleAdd = () => {
        if (!localEstudio.id) {
            Swal.fire('Error', 'Debe seleccionar un estudio.', 'error');
            return;
        }
        const nuevaLinea = `• ${localEstudio.nombre}`;
        onChange(value ? `${value}\n${nuevaLinea}` : nuevaLinea);
        setLocalEstudio({ id: '', nombre: '' });
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Laboratorios y Gabinetes</h4>
            
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 mb-4">
                <div className="flex items-end gap-2">
                    <div className="flex-1">
                        <SelectInput
                            label="Seleccionar Estudio"
                            options={optionsEstudios}
                            value={localEstudio.id}
                            onChange={(val) => {
                                const sel = optionsEstudios.find(o => o.value === val);
                                setLocalEstudio({ id: val, nombre: sel?.label || '' });
                            }}
                        />
                    </div>
                    <PrimaryButton type="button" onClick={handleAdd}>+ Agregar al plan</PrimaryButton>
                </div>
            </div>

            <InputTextArea
                label="Plan de laboratorios (campo libre)"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                error={error}
                rows={5}
            />
        </div>
    );
};

export default PlanLaboratorios;