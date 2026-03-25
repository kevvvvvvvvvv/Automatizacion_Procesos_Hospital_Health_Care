import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeriaQuirofano, HojaInsumosBasicos, ProductoServicio } from '@/types';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

// Componentes UI
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import PrimaryButton from '@/components/ui/primary-button';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
    materiales: ProductoServicio[]; 
}

const MaterialesForm: React.FC<Props> = ({ hoja, materiales }) => {

    const materialesOptions = materiales.map(m => ({
        value: m.id.toString(),
        label: m.nombre_prestacion
    }));

    const { data, setData, post, processing, errors } = useForm({
        material_id: '',
        cantidad: '',
        es_manual: false,
        nombre_insumo: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if (data.es_manual && !data.nombre_insumo.trim()) {
            Swal.fire("Error", "Escriba el nombre del insumo manual.");
            return;
        }
        if (!data.es_manual && !data.material_id) {
            Swal.fire("Error","Seleccione un insumo del inventario.");
            return;
        }

        post(route('hojasinsumosbasicos.store', { hojasenfermeriasquirofano: hoja.id }), {
            preserveScroll: true,
        });
    }

    
    const handleUpdateCantidad = (materialId: number, nuevaCantidad: string, cantidadAnterior: string) => {
        if (nuevaCantidad === cantidadAnterior) return;

        router.patch(route('hojasinsumosbasicos.update', { 
            hojasinsumosbasico: materialId 
        }), {
            cantidad: nuevaCantidad
        }, {
            preserveScroll: true,
        });
    }

    const handleRemoveSavedItem = (itemId: number) => {
        Swal.fire({
            title: '¿Eliminar material?',
            text: "Se quitará del registro de esta hoja.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('hojasinsumosbasicos.destroy', { 
                    hojasinsumosbasico: itemId
                }), {
                    preserveScroll: true,
                });
            }
        });
    }

    return (

        <div>
            <form onSubmit={handleSubmit} className="bg-gray-50 p-4 rounded-lg border mb-8">
                <h3 className="text-md font-bold mb-4 text-gray-700">Agregar insumos</h3>
                
                <div className="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div className="md:col-span-7">
                        <div className="flex justify-between items-center mb-1">
                            <label className="block font-medium text-sm text-gray-700">
                                {data.es_manual ? "Escribir insumo" : "Seleccionar insumo"}
                            </label>
                            <button 
                                type="button"
                                onClick={() => setData('es_manual', !data.es_manual)}
                                className="text-xs text-blue-600 font-semibold hover:text-blue-800 transition-colors cursor-pointer"
                            >
                                {data.es_manual ? "← Buscar en catálogo" : "Escribir manual →"}
                            </button>
                        </div>

                        {!data.es_manual ? (
                            <SelectInput
                                options={materialesOptions} 
                                value={data.material_id}
                                onChange={(value) => {
                                    const insumoSeleccionado = materiales.find(m => m.id == value);
                                    setData(d => ({
                                        ...d,
                                        material_id: value,
                                        nombre_insumo: insumoSeleccionado?.nombre_prestacion ?? '',
                                    }))
                                }}
                                error={errors.material_id}
                            />
                        ) : (
                            <InputText
                                id=''
                                name=''
                                label=''
                                value={data.nombre_insumo}
                                onChange={e => setData('nombre_insumo', e.target.value)}
                                error={errors.nombre_insumo}
                                placeholder="Nombre del insumo..."
                            />
                        )}
                    </div>
 
                    <div className="md:col-span-3">
                        <InputText 
                            name=""
                            id="cantidad_new"
                            label="Cantidad" 
                            type="number"
                            value={data.cantidad} 
                            onChange={e => setData('cantidad', e.target.value)} 
                            error={errors.cantidad}
                        />
                    </div>
                    
                    <div className="md:col-span-2">
                        <PrimaryButton type="submit" disabled={processing} className="w-full justify-center">
                            {processing ? '...' : 'Agregar +'}
                        </PrimaryButton>
                    </div>
                </div>
            </form>

            <div>
                <h3 className="text-lg font-semibold mb-2">Insumos registrados</h3>
                <div className="overflow-x-auto border rounded-lg shadow-sm">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-white">
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase tracking-wider'>
                                <th className="px-6 py-3">Nombre del insumo</th>
                                <th className="px-6 py-3 w-32">Cantidad</th>
                                <th className="px-6 py-3 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {(!hoja.hoja_insumos_basicos || hoja.hoja_insumos_basicos.length === 0) ? (
                                <tr>
                                    <td colSpan={3} className="px-6 py-10 text-sm text-gray-400 text-center italic">
                                        No se han registrado materiales aún.
                                    </td>
                                </tr>
                            ) : (
                                hoja.hoja_insumos_basicos.map((item: HojaInsumosBasicos) => (
                                    <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4 text-sm font-medium text-gray-900">
                                            {item.nombre_insumo}
                                        </td>
                                        
                                        <td className="px-6 py-2">
                                            <input 
                                                type="number"
                                                className="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center"
                                                defaultValue={item.cantidad} 
                                                onBlur={(e) => handleUpdateCantidad(item.id, e.target.value, item.cantidad.toString())}
                                                onKeyDown={(e) => {
                                                    if (e.key === 'Enter') e.currentTarget.blur();
                                                }}
                                            />
                                        </td>

                                        <td className="px-6 py-4 text-sm text-right">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveSavedItem(item.id)}
                                                className="text-red-500 hover:text-red-700 font-medium transition-colors p-2 hover:bg-red-50 rounded-full"
                                            >
                                            Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};

export default MaterialesForm;