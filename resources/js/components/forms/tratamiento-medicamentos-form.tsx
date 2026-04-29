import React, { useState } from 'react';
import { ProductoServicio, MedicamentoAgregado } from '@/types';
import Swal from 'sweetalert2';

import InputBoolean from '@/components/ui/input-boolean';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';

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
        if (!local.id || !local.dosis || !local.gramaje || !local.via || !local.unidad || (local.unidad !== 'dosis unica' && !local.duracion)) {
            Swal.fire('Error', 'Complete todos los campos obligatorios.', 'warning');
            return;
        }
        
        const nuevoMedicamento: MedicamentoAgregado = {
            medicamento_id: local.id,
            nombre: local.nombre,
            dosis: local.dosis,
            gramaje: local.gramaje,
            via: local.via,
            via_label: local.via_label,
            duracion: local.unidad === 'dosis unica' ? '0' : local.duracion,
            unidad: local.unidad,
            razon_necesaria: local.razon_necesaria,
            temp_id: crypto.randomUUID(),
        };

        onChange([...medicamentosAgregados, nuevoMedicamento]);
        setLocal({ id: '', nombre: '', dosis: '', gramaje: '', via: '', via_label: '', duracion: '', unidad: 'horas', razon_necesaria: false });
    };

    const handleRemove = (temp_id: string) => {
        onChange(medicamentosAgregados.filter(med => med.temp_id !== temp_id));
    };

    const medicamentosOptions = medicamentos.map( med => (
        { label: med.nombre_prestacion, value: med.id.toString() } // Aseguramos que el value sea string
    ));

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Medicamentos</h4>
            
            
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 mb-6">
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

                    {local.unidad !== 'dosis unica' ? (
                        <InputText
                            label="Frecuencia"
                            name="med_frecuencia"
                            id="duracion"
                            type="number"
                            value={local.duracion}
                            onChange={e => setLocal(prev => ({ ...prev, duracion: e.target.value }))}
                        />
                    ) : (
                        <div></div> 
                    )}

                    <InputBoolean
                        label='Razón necesaria'
                        value={local.razon_necesaria}
                        onChange={(e) => setLocal(prev => ({ ...prev, razon_necesaria: e }))}
                    />
                </div>
                
                <div className="flex justify-end pt-2">
                    <PrimaryButton type="button" onClick={handleAdd}>
                        + Agregar al plan
                    </PrimaryButton>
                </div>
            </div>
            {medicamentosAgregados.length > 0 && (
                <div className="mb-6">
                    <h5 className="font-medium text-gray-700 mb-3 px-1">Medicamentos Indicados:</h5>
                    <ul className="space-y-3">
                        {medicamentosAgregados.map((med) => (
                            <li key={med.temp_id} className="flex justify-between items-center bg-white p-3 border border-blue-100 rounded-lg shadow-sm hover:border-blue-300 transition-colors">
                                <div>
                                    <span className="font-semibold text-gray-800">{med.nombre}</span>
                                    <p className="text-sm text-gray-600 mt-0.5">
                                        {med.dosis} {med.gramaje} - Vía {med.via_label} 
                                        {med.unidad !== 'dosis unica' ? ` c/${med.duracion} ${med.unidad}` : ' (Dosis única)'}
                                        {med.razon_necesaria && <span className="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Por Razón Necesaria</span>}
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    onClick={() => handleRemove(med.temp_id)}
                                    className="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-md text-sm font-medium transition-colors border border-transparent hover:border-red-100"
                                >
                                    Eliminar
                                </button>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default PlanMedicamentos;