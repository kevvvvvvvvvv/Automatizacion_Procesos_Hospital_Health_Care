import React, { useState } from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeriaQuirofano, ProductoServicio } from '@/types';
import { route } from 'ziggy-js';

// Componentes UI
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import PrimaryButton from '@/components/ui/primary-button';
import Swal from 'sweetalert2';


interface MaterialAgregado {
    id: string;
    nombre: string;
    cantidad: string; 
    temp_id: string; 
}

interface Props {
    hoja: HojaEnfermeriaQuirofano;
    materiales: ProductoServicio[]; 
}

const MaterialesForm: React.FC<Props> = ({ hoja, materiales }) => {


    const materialesOptions = materiales.map(m => ({
        value: m.id.toString(),
        label: m.nombre_prestacion
    }));

    const [localData, setLocalData] = useState({
        material_id: '',
        material_nombre: '',
        cantidad: '',
    });


    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        materiales_agregados: [] as MaterialAgregado[],
    });

    const handleAddToList = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault(); 
        
        if (!localData.material_id || !localData.cantidad) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Debes seleccionar un material y especificar la cantidad.',
                timer: 3000
            });
            return;
        }

        const newItem: MaterialAgregado = {
            id: localData.material_id,
            nombre: localData.material_nombre,
            cantidad: localData.cantidad,
            temp_id: crypto.randomUUID(),
        };

        setData('materiales_agregados', [...data.materiales_agregados, newItem]);

        setLocalData({
            material_id: '',
            material_nombre: '',
            cantidad: '',
        });
    }

    const handleRemoveFromList = (temp_id: string) => {
        setData('materiales_agregados',
            data.materiales_agregados.filter((item) => item.temp_id !== temp_id)
        );
    }

    const handleSubmitList = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasmateriales.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => reset(), 
        });
    }

    const handleRemoveSavedItem = (itemId: number) => {
        if (confirm('¿Seguro que deseas eliminar este material?')) {
            router.delete(route('hojasmateriales.destroy', { 
                hojaenfermeria: hoja.id,
                material: itemId
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <div>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                <SelectInput
                    label="Material / Medicamento"
                    options={materialesOptions} 
                    value={localData.material_id}
                    onChange={(value) => {
                        const sel = materialesOptions.find(o => o.value === value);
                        setLocalData(d => ({
                            ...d,
                            material_id: value as string,
                            material_nombre: sel ? sel.label : ''
                        }));
                    }}
                    // Asumiendo que validas el array en el backend
                    error={errors['materiales_agregados.0.id']}
                />
                
                <div className="flex gap-4 items-end">
                    <div className="flex-1">
                        <InputText 
                            id="material_cantidad"
                            name="cantidad"
                            label="Cantidad" 
                            type="number"
                            value={localData.cantidad} 
                            onChange={e => setLocalData(d => ({...d, cantidad: e.target.value}))} 
                            error={errors['materiales_agregados.0.cantidad']}
                        />
                    </div>
                    <div className="mb-1">
                        <PrimaryButton type="button" onClick={handleAddToList}>
                            Agregar
                        </PrimaryButton>
                    </div>
                </div>
            </div>

            {/* --- Tabla de Pendientes --- */}
            <form onSubmit={handleSubmitList} className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Materiales Pendientes por Guardar</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Materiales guardados correctamente.</div>}
                
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Nombre</th>
                                <th className="px-4 py-3">Cantidad</th>
                                <th className="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.materiales_agregados.length === 0 ? (
                                <tr>
                                    <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay materiales en la lista.
                                    </td>
                                </tr>
                            ) : (
                                data.materiales_agregados.map((item) => (
                                    <tr key={item.temp_id}>
                                        <td className="px-4 py-3 text-sm text-gray-900">{item.nombre}</td>
                                        <td className="px-4 py-3 text-sm text-gray-500">{item.cantidad}</td>
                                        <td className="px-4 py-3 text-sm">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveFromList(item.temp_id)}
                                                className="text-yellow-600 hover:text-yellow-900"
                                            >
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
                <div className="flex justify-end mt-4">
                    <PrimaryButton type="submit" disabled={processing || data.materiales_agregados.length === 0}>
                        {processing ? 'Guardando...' : 'Guardar Lista'}
                    </PrimaryButton>
                </div>
            </form>

            {/* --- Tabla de Historial (Guardados) --- */}
            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Materiales Guardados</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Nombre</th>
                                <th className="px-4 py-3">Cantidad</th>
                                <th className="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {/* Ajusta la propiedad 'hoja.materiales_usados' según tu relación en el modelo */}
                            {(!hoja.materiales_usados || hoja.materiales_usados.length === 0) ? (
                                <tr>
                                    <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay materiales registrados.
                                    </td>
                                </tr>
                            ) : (
                                hoja.materiales_usados.map((item: any) => ( // Usa tu tipo correcto aquí
                                    <tr key={item.id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">
                                            {item.producto_servicio?.nombre_prestacion || '...'}
                                        </td>
                                        {/* Asumiendo que guardas la cantidad en 'dosis' o un campo 'cantidad' */}
                                        <td className="px-4 py-4 text-sm text-gray-500">{item.cantidad || item.dosis}</td>
                                        <td className="px-4 py-4 text-sm space-x-2 whitespace-nowrap">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveSavedItem(item.id)}
                                                className="text-red-600 hover:text-red-900"
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