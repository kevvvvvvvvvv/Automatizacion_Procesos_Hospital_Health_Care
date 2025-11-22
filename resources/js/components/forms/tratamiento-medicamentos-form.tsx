import React, { useState, useMemo } from 'react';
import { ProductoServicio } from '@/types';
import InputText from '@/components/ui/input-text';
import InputTextArea from '@/components/ui/input-text-area';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import Swal from 'sweetalert2';

interface Props {
    value: string;
    onChange: (value: string) => void;
    error?: string;
    medicamentos: ProductoServicio[];
}

const optionsGramaje = [
    {value: 'mililitros', label: 'Mililitros (ml)'},
    {value: 'gramos', label: 'Gramos (g)'},
    {value: 'miligramos', label: 'Miligramos (mg)'},
    {value: 'microgramos', label: 'Microgramos (mcg)'},
    {value: 'unidades internacionales', label: 'Unidades internacionales (ui)'},
    {value: 'gotas', label: 'Gotas'},
];

const optionsUnidad = [
    { value: 'horas', label: 'Horas' },
    { value: 'minutos', label: 'Minutos'},
    { value: 'dosis unica', label: 'Dosis única'}
];

const opcionesViaMedicamento = [
    { value: 'Vía Oral', label: 'Oral' },
    { value: 'Intravenosa', label: 'Intravenosa' },
    { value: 'Intramuscular', label: 'Intramuscular' },
    { value: 'Subcutánea', label: 'Subcutánea' },
];

const PlanMedicamentos: React.FC<Props> = ({ value, onChange, error, medicamentos }) => {
    
    const medicamentosOptions = useMemo(() => medicamentos.map(m => ({
        value: m.id.toString(),
        label: m.nombre_prestacion
    })), [medicamentos]);

    const [local, setLocal] = useState({
        id: '', nombre: '', dosis: '', gramaje: '', via: '', via_label: '', duracion: '', unidad: 'horas'
    });

    const handleAdd = () => {
        if (!local.id || !local.dosis || !local.gramaje || !local.via || !local.unidad) {
            Swal.fire('Error', 'Complete todos los campos obligatorios.', 'error');
            return;
        }
        
        let texto = `• ${local.nombre} ${local.dosis} ${local.gramaje}, ${local.via_label}`;
        texto += local.unidad === 'dosis unica' ? ', Dosis única.' : `, cada ${local.duracion} ${local.unidad}.`;

        onChange(value ? `${value}\n${texto}` : texto);
        setLocal({ id: '', nombre: '', dosis: '', gramaje: '', via: '', via_label: '', duracion: '', unidad: 'horas' });
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Medicamentos</h4>
            
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 mb-4">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <SelectInput
                        label="Medicamento"
                        options={medicamentosOptions}
                        value={local.id}
                        onChange={(val) => {
                            const sel = medicamentosOptions.find(o => o.value === val);
                            setLocal(prev => ({ ...prev, id: val, nombre: sel?.label || '' }));
                        }}
                    />
                    <InputText
                        label="Dosis"
                        name="med_dosis"
                        id="dosis"
                        type="number"
                        value={local.dosis}
                        onChange={e => setLocal(prev => ({ ...prev, dosis: e.target.value }))}
                    />
                    <SelectInput
                        label="Gramaje"
                        options={optionsGramaje}
                        value={local.gramaje}
                        onChange={val => setLocal(prev => ({ ...prev, gramaje: val }))}
                    />
                </div>
                
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <SelectInput
                        label="Vía"
                        options={opcionesViaMedicamento}
                        value={local.via}
                        onChange={val => {
                            const sel = opcionesViaMedicamento.find(o => o.value === val);
                            setLocal(prev => ({ ...prev, via: val, via_label: sel?.label || '' }));
                        }}
                    />
                    <SelectInput
                        label="Unidad"
                        options={optionsUnidad}
                        value={local.unidad}
                        onChange={val => setLocal(prev => ({ ...prev, unidad: val }))}
                    />
                    {local.unidad !== 'dosis unica' && (
                        <InputText
                            label="Frecuencia"
                            name="med_frecuencia"
                            id="duracion"
                            type="number"
                            value={local.duracion}
                            onChange={e => setLocal(prev => ({ ...prev, duracion: e.target.value }))}
                        />
                    )}
                </div>
                <div className="flex justify-end">
                    <PrimaryButton type="button" onClick={handleAdd}>+ Agregar al plan</PrimaryButton>
                </div>
            </div>

            <InputTextArea
                label="Plan de medicamentos (campo libre)"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                error={error}
                rows={5}
            />
        </div>
    );
};

export default PlanMedicamentos;