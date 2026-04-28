import React from 'react';
import { ConteoMaterialQuirofano, HojaEnfermeriaQuirofano } from '@/types'; 
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import PrimaryButton from '@/components/ui/primary-button';
import SelectInput from '@/components/ui/input-select';
import TextInput from '@/components/ui/input-text';

const materialQuirofanoOptions = [
    { value: 'gasas_con_trama', label: 'Gasas con trama' },
    { value: 'compresas', label: 'Compresas' },
    { value: 'puchitos', label: 'Puchitos' },
    { value: 'cotonoides', label: 'Cotonoides' },
    { value: 'agujas', label: 'Agujas' },
];

interface Props {
    hoja: HojaEnfermeriaQuirofano;
}

const MaterialQuirofano = ({ hoja }: Props) => {

    const { data, setData, put, processing } = useForm({
        conteo_materiales: hoja.conteo_material_quirofano || [] 
    });

    const guardarConteo = () => {
        put(route('conteo-material-quirofano', hoja.id), {
            preserveScroll: true,
        });
    };    

    const handleAddRow = () => {
        const nuevoMaterial: ConteoMaterialQuirofano = {
            tipo_material: '',
            cantidad_inicial: 0,
            cantidad_agregada: 0,
            cantidad_final: 0
        };
        setData('conteo_materiales', [...data.conteo_materiales, nuevoMaterial]);
    };

    const handleUpdateRow = (index: number, field: keyof ConteoMaterialQuirofano, value: string | number) => {
        const nuevosMateriales = [...data.conteo_materiales];
        
        if (field.includes('cantidad')) {
            nuevosMateriales[index][field] = Number(value) as never; 
        } else {
            nuevosMateriales[index][field] = value as never;
        }
        
        setData('conteo_materiales', nuevosMateriales);
    };

/*     const handleRemoveRow = (index: number) => {
        const nuevosMateriales = data.conteo_materiales.filter((_, i) => i !== index);
        setData('conteo_materiales', nuevosMateriales);
    }; */

return (
    <div className="border shadow-sm rounded-lg p-6 mb-4 bg-white flex flex-col gap-4">
        
        <div className="flex justify-between items-center border-b pb-2">
            <h3 className="text-lg font-semibold text-gray-800">
                Conteo de material
            </h3>
            <button
                type="button"
                onClick={handleAddRow}
                className="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-md text-sm font-medium transition-colors"
            >
                + Agregar insumo
            </button>
        </div>

        {data.conteo_materiales.length === 0 ? (
            <div className="text-center py-6 text-gray-400 text-sm italic">
                No hay materiales registrados. Haga clic en "Agregar insumo" para comenzar.
            </div>
        ) : (
            <div className="flex flex-col gap-4">
                {data.conteo_materiales.map((item, index) => {
                    const esperado = (Number(item.cantidad_inicial) || 0) + (Number(item.cantidad_agregada) || 0);
                    const cuentaCuadra = esperado > 0 && esperado === Number(item.cantidad_final);
                    const tieneFaltante = Number(item.cantidad_final) > 0 && esperado !== Number(item.cantidad_final);
                    
                    return (
                        <div key={index} className="border rounded-lg p-4 bg-gray-50 shadow-sm">
                            <div className="mb-4">
                                <SelectInput
                                    label="Material / Insumo"
                                    value={item.tipo_material} 
                                    options={materialQuirofanoOptions} 
                                    onChange={(valor) => handleUpdateRow(index, 'tipo_material', valor)}
                                />
                            </div>

                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 items-end">
                                <TextInput
                                    id={`inicial-${index}`}
                                    name="cantidad_inicial"
                                    label="Inicial"
                                    type="number"
                                    value={String(item.cantidad_inicial)}
                                    onChange={(e) => handleUpdateRow(index, 'cantidad_inicial', e.target.value)}
                                />
                                <TextInput
                                    id={`agregada-${index}`}
                                    name="cantidad_agregada"
                                    label="Agregadas"
                                    type="number"
                                    value={String(item.cantidad_agregada)}
                                    onChange={(e) => handleUpdateRow(index, 'cantidad_agregada', e.target.value)}
                                />
                                <TextInput
                                    id={`esperado-${index}`}
                                    name="esperado"
                                    label="Esperado"
                                    value={String(esperado)}
                                    disabled={true}
                                />
                                <TextInput
                                    id={`final-${index}`}
                                    name="cantidad_final"
                                    label="Final"
                                    value={String(item.cantidad_final)}
                                    type="number"
                                    onChange={(e) => handleUpdateRow(index, 'cantidad_final', e.target.value)}
                                    className={`${cuentaCuadra ? 'border-green-500 bg-green-50' : ''} ${tieneFaltante ? 'border-red-500 bg-red-50' : ''}`}
                                />
                            </div>
                        </div>
                    ); 
                })} 
            </div> 
        )}

        <div className="flex justify-end pt-4 border-t mt-2">
            <PrimaryButton
                type='button'
                disabled={processing}
                onClick={guardarConteo}
            >   
                {processing ? 'Guardando...' : 'Guardar'}
            </PrimaryButton>
        </div>
    </div>
);
};

export default MaterialQuirofano;