import React, { useState } from 'react';
import { ProductoServicio, MedicamentoAgregado } from '@/types';
import Swal from 'sweetalert2';

import InputBoolean from '@/components/ui/input-boolean';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import TextAreaInput from '../ui/input-text-area';

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

interface Props {
    medicamentos: ProductoServicio[];
    medicamentosAgregados: MedicamentoAgregado[]; 
    onChange: (medicamentos: MedicamentoAgregado[]) => void; 
}

const PlanMedicamentos: React.FC<Props> = ({ medicamentos, medicamentosAgregados, onChange }) => {

    const [local, setLocal] = useState({
        id: '', nombre: '', dosis: '', gramaje: '', via: '', via_label: '', duracion: '', unidad: 'horas', razon_necesaria: false,
    });

    const handleAdd = () => {
        if (!local.id || !local.dosis || !local.gramaje || !local.via || !local.unidad) {
            Swal.fire('Error', 'Complete todos los campos obligatorios.', 'error');
            return;
        }
        
        // 2. Creamos el objeto estructurado
        const nuevoMedicamento = {
            medicamento_id: local.id,
            nombre: local.nombre,
            dosis: local.dosis,
            gramaje: local.gramaje,
            via: local.via,
            via_label: local.via_label,
            duracion: local.duracion,
            unidad: local.unidad,
            razon_necesaria: local.razon_necesaria,
            temp_id: crypto.randomUUID(),
        };

        onChange([...medicamentosAgregados, nuevoMedicamento]);
        setLocal({ id: '', nombre: '', dosis: '', gramaje: '', via: '', via_label: '', duracion: '', unidad: 'horas', razon_necesaria: false });
    };


    const textoGenerado = medicamentosAgregados.map(med => `• ${med.nombre} ${med.dosis}...`).join('\n');

    const medicamentosOptions = medicamentos.map( med => (
        { label: med.nombre_prestacion, value: med.id}
    ))

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

                    <InputBoolean
                        label='Razón necesaria'
                        value={local.razon_necesaria}
                        onChange={(e) => setLocal(prev => ({ ...prev, razon_necesaria: e }))}
                    />
                </div>
                <div>
                    <TextAreaInput
                        label = 'Tratamiento de medicamentos'
                        value ={textoGenerado} 
                    />
                </div>
                <div className="flex justify-end">
                    <PrimaryButton type="button" onClick={handleAdd}>+ Agregar al plan</PrimaryButton>
                </div>
            </div>
            

        </div>
    );
};

export default PlanMedicamentos;