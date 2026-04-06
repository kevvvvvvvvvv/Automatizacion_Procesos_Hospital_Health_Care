import React from 'react';
import { ConteoMaterialQuirofano, HojaEnfermeriaQuirofano } from '@/types'; 
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';


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
        put(route('hojas-quirofano.actualizar-conteo', hoja.id), {
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

    const handleRemoveRow = (index: number) => {
        const nuevosMateriales = data.conteo_materiales.filter((_, i) => i !== index);
        setData('conteo_materiales', nuevosMateriales);
    };

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
                <div className="overflow-x-auto">
                    <table className="w-full text-sm text-left">
                        <thead className="text-xs text-gray-600 uppercase bg-gray-50 border-b">
                            <tr>
                                <th className="px-4 py-3">Material</th>
                                <th className="px-4 py-3 text-center w-24">Inicial</th>
                                <th className="px-4 py-3 text-center w-24">Agregadas</th>
                                <th className="px-4 py-3 text-center w-24 bg-gray-100">Esperado</th>
                                <th className="px-4 py-3 text-center w-28">Final</th>
                                <th className="px-4 py-3 text-center w-16">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            {data.conteo_materiales.map((item: ConteoMaterialQuirofano, index: number) => {
                                const esperado = (item.cantidad_inicial || 0) + (item.cantidad_agregada || 0);
                                const cuentaCuadra = esperado > 0 && esperado === item.cantidad_final;
                                const tieneFaltante = item.cantidad_final > 0 && esperado !== item.cantidad_final;

                                return (
                                    <tr key={index} className="border-b hover:bg-gray-50">
                                        <td className="px-4 py-2">
                                            <SelectInput
                                                value={item.tipo_material}
                                                options={materialQuirofanoOptions}
                                                onChange={(e) => handleUpdateRow(index, 'tipo_material', e.target.value)}
                                            />
                                        </td>
                                        <td className="px-4 py-2">
                                            <TextInput
                                                name=''
                                                id=''
                                                label=''
                                                type="number"
                                                value={String(item.cantidad_inicial)}
                                                onChange={(e) => handleUpdateRow(index, 'cantidad_inicial', e.target.value)}
                                            />
                                        </td>
                                        <td className="px-4 py-2">
                                            <TextInput
                                                name=''
                                                id=''
                                                label=''
                                                type='number'
                                                value={String(item.cantidad_agregada)}
                                                onChange={(e) => handleUpdateRow(index, 'cantidad_agregada', e.target.value)}
                                            />
                                        </td>
                                        <td className="px-4 py-2 bg-gray-100 text-center font-bold text-gray-700">
                                            {esperado}
                                        </td>
                                        <td className="px-4 py-2">
                                            <div className="relative">
                                                <input
                                                    type="number"
                                                    min="0"
                                                    value={item.cantidad_final}
                                                    onChange={(e) => handleUpdateRow(index, 'cantidad_final', e.target.value)}
                                                    className={`w-full text-center rounded-md shadow-sm text-sm pr-6
                                                        ${cuentaCuadra ? 'border-green-500 bg-green-50 text-green-700' : ''}
                                                        ${tieneFaltante ? 'border-red-500 bg-red-50 text-red-700' : 'border-gray-300'}
                                                    `}
                                                />
                                                {cuentaCuadra && <span className="absolute right-2 top-2 text-green-500">✓</span>}
                                                {tieneFaltante && <span className="absolute right-2 top-2 text-red-500" title="La cuenta no cuadra">!</span>}
                                            </div>
                                        </td>
                                        <td className="px-4 py-2 text-center">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveRow(index)}
                                                className="text-red-500 hover:text-red-700 font-bold"
                                            >
                                                ✕
                                            </button>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </div>
            )}

            <div className="flex justify-end pt-4 border-t mt-2">
                <PrimaryButton></PrimaryButton>
            </div>
        </div>
    );
};

export default MaterialQuirofano;