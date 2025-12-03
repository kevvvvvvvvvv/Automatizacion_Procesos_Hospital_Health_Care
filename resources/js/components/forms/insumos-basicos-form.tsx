import React from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeriaQuirofano, ProductoServicio } from '@/types';
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
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (!data.material_id || !data.cantidad) {
            Swal.fire('Error', 'Selecciona material y cantidad', 'warning');
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
                        <SelectInput
                            label="Seleccionar insumo"
                            options={materialesOptions} 
                            value={data.material_id}
                            onChange={(value) => setData('material_id', value as string)}
                            error={errors.material_id}
                        />
                    </div>
                    
                    <div className="md:col-span-3">
                        <InputText 
                            id="cantidad_new"
                            name="cantidad"
                            label="Cantidad" 
                            type="number"
                            value={data.cantidad} 
                            onChange={e => setData('cantidad', e.target.value)} 
                            error={errors.cantidad}
                        />
                    </div>
                    
                    <div className="md:col-span-2 mb-1">
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
                                hoja.hoja_insumos_basicos.map((item: any) => (
                                    <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4 text-sm font-medium text-gray-900">
                                            {item.producto_servicio 
                                                ? item.producto_servicio.nombre_prestacion 
                                                : 'Cargando nombre...'}
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