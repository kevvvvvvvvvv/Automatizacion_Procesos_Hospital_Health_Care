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
    soluciones: ProductoServicio[];
}

const PlanSoluciones: React.FC<Props> = ({ value, onChange, error, soluciones }) => {
    
    const solucionesOptions = useMemo(() => soluciones.map(s => ({
        value: s.id.toString(),
        label: s.nombre_prestacion 
    })), [soluciones]);

    const [localSolucion, setLocalSolucion] = useState({
        solucion_id: '',
        solucion_nombre: '',
        cantidad: '',
        duracion: '',
    });

    const flujoCalculado = useMemo(() => {
        const cantidad = Number(localSolucion.cantidad);
        const duracion = Number(localSolucion.duracion);
        return (cantidad > 0 && duracion > 0) ? (cantidad / duracion).toFixed(2) : '0.00';
    }, [localSolucion.cantidad, localSolucion.duracion]);

    const handleAddSolucion = () => {
        if (!localSolucion.solucion_id || !localSolucion.cantidad || !localSolucion.duracion) {
            Swal.fire('Campos Incompletos', 'Debe seleccionar solución, cantidad y duración.', 'error');
            return;
        }
        const nuevaLinea = `• ${localSolucion.solucion_nombre} ${localSolucion.cantidad}ml, para ${localSolucion.duracion} hrs (Flujo: ${flujoCalculado} ml/hr).`;
        onChange(value ? `${value}\n${nuevaLinea}` : nuevaLinea);
        
        setLocalSolucion({ solucion_id: '', solucion_nombre: '', cantidad: '', duracion: '' });
    };

    return (
        <div className="p-4 bg-white rounded-lg shadow-sm border mt-4">
            <h4 className="text-lg font-semibold mb-3 border-b pb-2">Plan de Soluciones</h4>
            
            <div className="p-4 border rounded-lg bg-gray-50 space-y-4 mb-4">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                    <SelectInput
                        label="Solución"
                        options={solucionesOptions}
                        value={localSolucion.solucion_id}
                        onChange={(val) => {
                            const sel = solucionesOptions.find(o => o.value === val);
                            setLocalSolucion(prev => ({ ...prev, solucion_id: val, solucion_nombre: sel?.label || '' }));
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
                        <span className="mt-1 p-2 border border-gray-300 rounded-md bg-gray-100 text-sm">{flujoCalculado} ml/hr</span>
                    </div>
                </div>
                <div className="flex justify-end">
                    <PrimaryButton type="button" onClick={handleAddSolucion}>+ Agregar al plan</PrimaryButton>
                </div>
            </div>

            <InputTextArea
                label="Plan de soluciones (campo libre)"
                value={value}
                onChange={(e) => onChange(e.target.value)}
                error={error}
                rows={5}
            />
        </div>
    );
};

export default PlanSoluciones;