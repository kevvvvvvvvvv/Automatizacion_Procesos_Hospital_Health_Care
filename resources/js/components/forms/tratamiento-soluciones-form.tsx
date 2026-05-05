import React, { useState, useMemo } from 'react';
import { ProductoServicio, TerapiaIVAgregado, TerapiaIVMedicamentoAgregado } from '@/types'; // Asegúrate de importar MedicamentoAgregado
import Swal from 'sweetalert2';

import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';

const optionsUnidadMedida = [
    { value: 'mg', label: 'Miligramos (mg)' },
    { value: 'g', label: 'Gramos (g)' },
    { value: 'ml', label: 'Mililitros (ml)' },
    { value: 'mcg', label: 'Microgramos (mcg)' },
    { value: 'UI', label: 'Unidades Int. (UI)' },
    { value: 'amp', label: 'Ámpulas (amp)' },
];

interface Props {
    soluciones: ProductoServicio[];
    medicamentos: ProductoServicio[]; 
    solucionesAgregadas: TerapiaIVAgregado[]; 
    onChange: (soluciones: TerapiaIVAgregado[]) => void;
}

const PlanSoluciones: React.FC<Props> = ({ soluciones, medicamentos, solucionesAgregadas, onChange }) => {
    
    const solucionesOptions = useMemo(() => 
        soluciones && Array.isArray(soluciones) ? soluciones.map(s => ({
            value: s.id.toString(),
            label: s.nombre_prestacion 
        })) : [], 
    [soluciones]);

    const medicamentosOptions = useMemo(() => 
        medicamentos && Array.isArray(medicamentos) ? medicamentos.map(m => ({
            value: m.id.toString(),
            label: m.nombre_prestacion 
        })) : [], 
    [medicamentos]);
        
    const [localSolucion, setLocalSolucion] = useState({
        solucion_id: '',
        nombre_solucion: '',
        cantidad: '',
        duracion: '',
        medicamentos_actuales: [] as TerapiaIVMedicamentoAgregado[], 
    });

    const [tempMedicamento, setTempMedicamento] = useState({
        id: '',
        nombre: '',
        dosis: '',
        unidad: 'mg', 
    });

    const flujoCalculado = useMemo(() => {
        const cantidad = Number(localSolucion.cantidad);
        const duracion = Number(localSolucion.duracion);
        return (cantidad > 0 && duracion > 0) ? (cantidad / duracion).toFixed(2) : '0.00';
    }, [localSolucion.cantidad, localSolucion.duracion]);

    const agregarMedicamentoALaSolucion = () => {
        if (!tempMedicamento.id || !tempMedicamento.dosis) {
            Swal.fire("Error", "Seleccione un medicamento e indique la dosis.", "warning");
            return;
        }
        
        setLocalSolucion(prev => ({
            ...prev,
            medicamentos_actuales: [...prev.medicamentos_actuales, {
                id: tempMedicamento.id,
                producto_servicio_id: +tempMedicamento.id,

                medicamento_id: tempMedicamento.id, 
                nombre_medicamento: tempMedicamento.nombre,
                dosis: +tempMedicamento.dosis,
                unidad_medida: tempMedicamento.unidad,
                es_manual: false,

                temp_id: crypto.randomUUID(),
            } as TerapiaIVMedicamentoAgregado] 
        }));
        
        setTempMedicamento({ id: '', nombre: '', dosis: '', unidad: 'mg' });
    };

    const removerMedicamentoDeSolucion = (temp_id: string) => {
        setLocalSolucion(prev => ({
            ...prev,
            medicamentos_actuales: prev.medicamentos_actuales.filter(m => m.temp_id !== temp_id)
        }));
    };

    const handleAddSolucion = () => {
        if (!localSolucion.solucion_id || !localSolucion.cantidad || !localSolucion.duracion) {
            Swal.fire('Campos Incompletos', 'Debe seleccionar solución base, cantidad y duración.', 'warning');
            return;
        }

        const nuevaSolucion: TerapiaIVAgregado = {
            solucion_id: localSolucion.solucion_id,
            nombre_solucion: localSolucion.nombre_solucion,
            cantidad: Number(localSolucion.cantidad),
            duracion: Number(localSolucion.duracion),
            flujo: Number(flujoCalculado),
            medicamentos: localSolucion.medicamentos_actuales, 
            fecha_hora_inicio: '', 
            es_manual: false,
            temp_id: crypto.randomUUID(),
        };

        onChange([...solucionesAgregadas, nuevaSolucion]);
        
        setLocalSolucion({ solucion_id: '', nombre_solucion: '', cantidad: '', duracion: '', medicamentos_actuales: [] });
    };

    const handleRemove = (temp_id: string) => {
        onChange(solucionesAgregadas.filter(sol => sol.temp_id !== temp_id));
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Soluciones Base e Infusiones</h4>

            <div className="p-4 border rounded-t-lg bg-gray-50 space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                     <SelectInput
                        label="Solución Base"
                        options={solucionesOptions} 
                        value={localSolucion.solucion_id}
                        onChange={(val) => {
                            const sel = solucionesOptions.find(o => o.value === val);
                            setLocalSolucion(prev => ({ ...prev, solucion_id: val, nombre_solucion: sel?.label || '' }));
                        }}
                    />
                    <InputText
                        label="Cantidad (ml)"
                        id="cantidad"
                        type="number"
                        name="sol_cantidad"
                        value={localSolucion.cantidad}
                        onChange={e => setLocalSolucion(prev => ({ ...prev, cantidad: e.target.value }))}
                    />
                    <InputText
                        label="Duración (hrs)"
                        type="number"
                        id="sol_duracion"
                        name="sol_duracion"
                        value={localSolucion.duracion}
                        onChange={e => setLocalSolucion(prev => ({ ...prev, duracion: e.target.value }))}
                    />
                    <div className="flex flex-col">
                        <label className="block text-sm font-medium text-gray-700">Flujo</label>
                        <span className="mt-1 p-2 border border-blue-200 rounded-md bg-blue-50 text-blue-800 font-semibold text-sm">
                            {flujoCalculado} ml/hr
                        </span>
                    </div>
                </div>
            </div>

            <div className="bg-white p-4 border-x border-b rounded-b-lg mb-6 shadow-inner">
                <h4 className="font-bold text-sm text-gray-700 mb-3 border-b pb-1">Agregar medicamentos a la solución (Opcional)</h4>
                
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4 items-end bg-gray-50 p-3 rounded-md border">
                    <div className="md:col-span-2">
                        <SelectInput
                            label="Medicamento"
                            options={medicamentosOptions}
                            value={tempMedicamento.id}
                            onChange={(val) => {
                                const med = medicamentosOptions.find(o => o.value === val);
                                setTempMedicamento(prev => ({ ...prev, id: val, nombre: med ? med.label : '' }));
                            }}
                        />
                    </div>
                    <InputText 
                        label="Dosis" 
                        id="dosis_med"
                        name='dosis_med'
                        type="number" 
                        value={tempMedicamento.dosis} 
                        onChange={e => setTempMedicamento(prev => ({ ...prev, dosis: e.target.value }))}
                    />
                    <SelectInput 
                        label="Unidad" 
                        options={optionsUnidadMedida} 
                        value={tempMedicamento.unidad}
                        onChange={val => setTempMedicamento(prev => ({ ...prev, unidad: val }))}
                    />
                    <div className="md:col-span-4 flex justify-end">
                        <button 
                            type="button" 
                            onClick={agregarMedicamentoALaSolucion}
                            className="bg-indigo-50 text-indigo-600 border border-indigo-200 hover:bg-indigo-100 hover:text-indigo-700 px-4 py-1.5 rounded-md text-sm font-medium transition-colors"
                        >
                            + Añadir fármaco a la mezcla
                        </button>
                    </div>
                </div>

                {localSolucion.medicamentos_actuales.length > 0 && (
                    <div className="mt-4 pl-2 border-l-2 border-indigo-200">
                        <p className="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mezcla actual:</p>
                        <ul className="space-y-1">
                            {localSolucion.medicamentos_actuales.map((m) => (
                                <li key={m.temp_id} className="text-sm text-gray-700 flex justify-between items-center bg-gray-50 px-3 py-1.5 rounded">
                                    <span>💊 {m.nombre_medicamento} <span className="font-semibold ml-1">{m.dosis} {m.unidad_medida}</span></span>
                                    <button 
                                        type="button"
                                        onClick={() => removerMedicamentoDeSolucion(m.temp_id)} 
                                        className="text-red-400 hover:text-red-600 font-bold px-2"
                                        title="Quitar de la mezcla"
                                    >
                                        &times;
                                    </button>
                                </li>
                            ))}
                        </ul>
                    </div>
                )}

                <div className="flex justify-end pt-6 border-t mt-4">
                    <PrimaryButton type="button" onClick={handleAddSolucion}>
                        Guardar Solución e Infusión
                    </PrimaryButton>
                </div>
            </div>

            {solucionesAgregadas.length > 0 && (
                <div className="mb-6">
                    <h5 className="font-medium text-gray-700 mb-3 px-1">Soluciones Indicadas:</h5>
                    <ul className="space-y-3">
                        {solucionesAgregadas.map((sol) => (
                            <li key={sol.temp_id} className="flex flex-col bg-white border border-indigo-100 rounded-lg shadow-sm hover:border-indigo-300 transition-colors overflow-hidden">
                                <div className="p-3 flex justify-between items-center bg-gray-50 border-b">
                                    <div>
                                        <span className="font-semibold text-gray-800">{sol.nombre_solucion}</span>
                                        <p className="text-sm text-gray-600 mt-0.5">
                                            Volumen: <span className="font-medium">{sol.cantidad} ml</span> | 
                                            Para: <span className="font-medium">{sol.duracion} hrs</span>
                                            <span className="ml-3 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-100 text-indigo-800">
                                                Flujo: {sol.flujo} ml/hr
                                            </span>
                                        </p>
                                    </div>
                                    <button
                                        type="button"
                                        onClick={() => handleRemove(sol.temp_id)}
                                        className="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-md text-sm font-medium transition-colors"
                                    >
                                        Eliminar
                                    </button>
                                </div>
                                
                                {sol.medicamentos && sol.medicamentos.length > 0 && (
                                    <div className="p-3 bg-white">
                                        <p className="text-xs font-medium text-gray-500 mb-1">Medicamentos aforados:</p>
                                        <ul className="space-y-1">
                                            {sol.medicamentos.map(med => (
                                                <li key={med.temp_id} className="text-sm text-gray-700 flex items-center before:content-['+'] before:mr-2 before:text-gray-400">
                                                    {med.nombre_medicamento} <span className="font-medium ml-1 bg-gray-100 px-1 rounded">{med.dosis} {med.unidad_medida}</span>
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                )}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default PlanSoluciones;