import React, { useMemo, useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react'; 
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import InfoField from '@/components/ui/info-field';
import SelectInput from '@/components/ui/input-select'; 
import { route } from 'ziggy-js';
import { Venta, Paciente, Estancia, DetalleVenta } from '@/types';
import Swal from 'sweetalert2';

const IconEdit = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="text-blue-600">
        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
    </svg>
);

const IconTrash = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="text-red-500">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
    </svg>
);

const IconSave = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="text-green-600">
        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
        <polyline points="17 21 17 13 7 13 7 21"></polyline>
        <polyline points="7 3 7 8 15 8"></polyline>
    </svg>
);

const IconCancel = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="text-gray-500">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
);

interface CatalogoOption {
    value: string;
    label: string;
    precio: number;
    type: string;
    real_id: number;
}

interface EditVentaProps {
    venta: Venta & { detalles: DetalleVenta[] }; 
    paciente: Paciente;
    estancia: Estancia;
    catalogoOptions: CatalogoOption[]; 
}

const EditVenta = ({ venta, paciente, estancia, catalogoOptions }: EditVentaProps) => {
  
  const { data: dataVenta, setData: setDataVenta, put, processing: processingVenta, errors: errorsVenta } = useForm({
    descuento: venta.descuento ?? 0,
    descuento_tipo: 'monto' as 'monto' | 'porcentaje',
  });


    const { descuentoMonto, totalCalculado } = useMemo(() => {
        if (dataVenta.descuento_tipo === 'porcentaje') {
        const pct = Number(dataVenta.descuento) || 0;
        const monto = Number((venta.subtotal * (pct / 100)).toFixed(2));
        const total = Number((venta.subtotal - monto).toFixed(2));
        return { descuentoMonto: monto, totalCalculado: total, porcentaje: pct };
        } else {
        const monto = Number(dataVenta.descuento) || 0;
        const total = Number((venta.subtotal - monto).toFixed(2));
        const pct = venta.subtotal > 0 ? Number(((monto / venta.subtotal) * 100).toFixed(2)) : 0;
        return { descuentoMonto: monto, totalCalculado: total, porcentaje: pct };
        }
    }, [dataVenta.descuento, dataVenta.descuento_tipo, venta.subtotal]);

    const handleUpdateVenta = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('ventas.update', { venta: venta.id }), {
        preserveScroll: true,
        data: {
            descuento: dataVenta.descuento,
            descuento_tipo: dataVenta.descuento_tipo,
        },
        });
    };


    const { data: dataItem, setData: setDataItem, post: postItem, reset: resetItem, processing: processingItem } = useForm({
        id: '',       
        tipo: '',     
        cantidad: 1,
        value_select: '' 
    });

    const handleAddItem = (e: React.FormEvent) => {
        e.preventDefault();
        if (!dataItem.id) return;

        postItem(route('pacientes.estancias.ventas.detallesventas.store', { paciente: paciente.id, estancia: estancia.id ,venta: venta.id}), {
            preserveScroll: true,
            onSuccess: () => resetItem()
        });
    };

    const [editingId, setEditingId] = useState<number | null>(null);
    const [editingValues, setEditingValues] = useState({ cantidad: 1, precio: 0 });

    const startEditing = (detalle: DetalleVenta) => {
        setEditingId(detalle.id);
        setEditingValues({
            cantidad: detalle.cantidad,
            precio: Number(detalle.precio_unitario) 
        });
    };

    const saveEditing = (detalleId: number) => {
        router.put(route('detallesventas.update', detalleId), {
            cantidad: editingValues.cantidad,
            precio_unitario: editingValues.precio 
        }, {
            preserveScroll: true,
            onSuccess: () => setEditingId(null)
        });
    };

    const deleteItem = (detalleId: number) => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará este ítem y se recalculará el total de la venta.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280', 
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route('detallesventas.destroy', detalleId), {
                    preserveScroll: true,
                    onSuccess: () => {
                        Swal.fire(
                            '¡Eliminado!',
                            'El ítem ha sido eliminado correctamente.',
                            'success'
                        );
                    },
                    onError: () => {
                        Swal.fire(
                            'Error',
                            'Hubo un problema al eliminar el ítem.',
                            'error'
                        );
                    }
                });
            }
        });
    };


    return (
        <MainLayout
            pageTitle={`Gestión de venta: ${venta.id}`}
            link="pacientes.estancias.ventas.index"      
            linkParams={{ paciente: paciente.id, estancia: estancia.id, venta: venta.id }}
        >
            <div className="space-y-6">
                <Head title="Editar venta" />
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div className="lg:col-span-1 space-y-6">
                        <div className="bg-white shadow rounded-lg p-6 border-t-4 border-blue-500">
                            <h3 className="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Configuración de venta</h3>
                            
                            <form onSubmit={handleUpdateVenta} className="space-y-4">
                                <InfoField label="Subtotal Actual" value={`$ ${Number(venta.subtotal).toLocaleString('es-MX', {minimumFractionDigits: 2})}`} />
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">Tipo de descuento</label>
                                    <div className="flex space-x-4">
                                        <label className="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="dto_type" checked={dataVenta.descuento_tipo === 'monto'} onChange={() => setDataVenta('descuento_tipo', 'monto')} />
                                            <span>Monto ($)</span>
                                        </label>
                                        <label className="flex items-center space-x-2 cursor-pointer">
                                            <input type="radio" name="dto_type" checked={dataVenta.descuento_tipo === 'porcentaje'} onChange={() => setDataVenta('descuento_tipo', 'porcentaje')} />
                                            <span>Porcentaje (%)</span>
                                        </label>
                                    </div>
                                </div>

                                <InputText
                                    id="descuento"
                                    name="descuento"
                                    label={dataVenta.descuento_tipo === 'porcentaje' ? 'Porcentaje (%)' : 'Monto a descontar ($)'}
                                    type="number"
                                    value={String(dataVenta.descuento)}
                                    onChange={(e) => setDataVenta('descuento', Number(e.target.value))}
                                    error={errorsVenta.descuento}
                                />


                                <div className="bg-gray-50 p-3 rounded text-sm space-y-1">
                                    <div className="flex justify-between">
                                        <span className="text-gray-600">Descuento aplicado:</span>
                                        <span className="font-semibold text-red-600">- ${descuentoMonto.toFixed(2)}</span>
                                    </div>
                                    <div className="flex justify-between text-lg font-bold border-t pt-1 mt-1">
                                        <span>Total Final:</span>
                                        <span>${totalCalculado.toFixed(2)}</span>
                                    </div>
                                </div>

                                <PrimaryButton disabled={processingVenta} type='submit' className="w-full justify-center">
                                    {processingVenta ? 'Guardando...' : 'Actualizar venta'}
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>

                    <div className="lg:col-span-2 space-y-6">
                        <div className="bg-white shadow rounded-lg p-6 border-t-4 border-indigo-500">
                            <h3 className="text-lg font-bold text-gray-800 mb-4">Agregar productos / servicios / estudios</h3>
                            
                            <form onSubmit={handleAddItem} className="flex flex-col md:flex-row gap-3 items-end">
                                <div className="flex-grow w-full">
                                    <SelectInput
                                        label="Buscar ítem"
                                        options={catalogoOptions}
                                        value={dataItem.value_select}
                                        onChange={(val) => {
                                            const selected = catalogoOptions.find(opt => opt.value === val);
                                            if(selected) {
                                                setDataItem(prev => ({
                                                    ...prev,
                                                    value_select: val,
                                                    id: String(selected.real_id),
                                                    tipo: selected.type
                                                }));
                                            }
                                        }}
                                        placeholder="Seleccione un producto..."
                                    />
                                </div>
                                <div className="w-full md:w-32">
                                    <InputText 
                                        id='cantidad'
                                        label="Cant." 
                                        name="cantidad" 
                                        type="number" 
                                        value={String(dataItem.cantidad)} 
                                        onChange={e => setDataItem('cantidad', Number(e.target.value))}
                                    />
                                </div>
                                <PrimaryButton disabled={processingItem} type="submit" className="h-[42px] mb-[2px]">
                                    Agregar
                                </PrimaryButton>
                            </form>

                            {dataItem.value_select && (
                                <p className="text-sm text-gray-500 mt-2">
                                    Precio unitario: <span className="font-bold text-green-600">${catalogoOptions.find(o => o.value === dataItem.value_select)?.precio}</span>
                                </p>
                            )}
                        </div>

                        <div className="bg-white shadow rounded-lg overflow-hidden">
                            <div className="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                                <h3 className="text-lg font-bold text-gray-800">Detalle de la cuenta</h3>
                                <span className="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                                    {venta.detalles.length} ítems
                                </span>
                            </div>
                            
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm text-left text-gray-700">
                                    <thead className="bg-gray-100 text-xs uppercase font-semibold text-gray-600">
                                        <tr>
                                            <th className="px-6 py-3">Descripción</th>
                                            <th className="px-6 py-3 text-center">Cant.</th>
                                            <th className="px-6 py-3 text-right">P. Unit</th>
                                            <th className="px-6 py-3 text-right">Subtotal</th>
                                            <th className="px-6 py-3 text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200">
                                        {venta.detalles.map((detalle) => {
                                            const isEditing = editingId === detalle.id;

                                            const nombreItem = detalle.itemable 
                                                ? (detalle.itemable.nombre_prestacion || detalle.itemable.nombre || 'Sin nombre')
                                                : detalle.nombre_producto_servicio;

                                            return (
                                                <tr key={detalle.id} className="hover:bg-gray-50 transition">
                                                    <td className="px-6 py-4">
                                                        <div className="font-medium text-gray-900">{nombreItem}</div>
                                                        <div className="text-xs text-gray-500 uppercase">
                                                            {detalle.itemable_type 
                                                                ? (detalle.itemable_type.includes('Producto') ? 'Producto' : 'Estudio') 
                                                                : 'Pendiente de catalogar'
                                                            }
                                                        </div>
                                                    </td>
                                                    <td className="px-6 py-4 text-center">
                                                        {isEditing ? (
                                                            <input 
                                                                type="number" 
                                                                min="1"
                                                                className="w-16 text-center border rounded py-1 px-2 focus:ring-blue-500 focus:border-blue-500"
                                                                value={editingValues.cantidad}
                                                                onChange={(e) => setEditingValues({...editingValues, cantidad: Number(e.target.value)})}
                                                            />
                                                        ) : (
                                                            <span className="font-bold">{detalle.cantidad}</span>
                                                        )}
                                                    </td>

                                                    <td className="px-6 py-4 text-right">
                                                        {isEditing ? (
                                                            <div className="flex justify-end items-center">
                                                                <span className="text-gray-500 mr-1">$</span>
                                                                <input 
                                                                    type="number" 
                                                                    min="0"
                                                                    step="0.01" 
                                                                    className="w-24 text-right border rounded py-1 px-2 focus:ring-blue-500 focus:border-blue-500"
                                                                    value={editingValues.precio}
                                                                    onChange={(e) => setEditingValues({...editingValues, precio: Number(e.target.value)})}
                                                                />
                                                            </div>
                                                        ) : (
                                                            `$${Number(detalle.precio_unitario).toLocaleString(undefined, {minimumFractionDigits: 2})}`
                                                        )}
                                                    </td>
                                                    <td className="px-6 py-4 text-right font-bold text-gray-900">
                                                        ${Number(detalle.subtotal).toLocaleString()}
                                                    </td>

                                                    <td className="px-6 py-4 text-center space-x-2">
                                                        {isEditing ? (
                                                            <>
                                                                <button onClick={() => saveEditing(detalle.id)} title="Guardar cambios" className="hover:bg-green-100 p-1 rounded"><IconSave /></button>
                                                                <button onClick={() => setEditingId(null)} title="Cancelar" className="hover:bg-gray-100 p-1 rounded"><IconCancel /></button>
                                                            </>
                                                        ) : (
                                                            <>
                                                                <button onClick={() => startEditing(detalle)} title="Editar cantidad" className="hover:bg-blue-100 p-1 rounded"><IconEdit /></button>
                                                                <button onClick={() => deleteItem(detalle.id)} title="Eliminar ítem" className="hover:bg-red-100 p-1 rounded"><IconTrash /></button>
                                                            </>
                                                        )}
                                                    </td>
                                                </tr>
                                            );
                                        })}
                                        {venta.detalles.length === 0 && (
                                            <tr>
                                                <td colSpan={5} className="text-center py-8 text-gray-500 italic">
                                                    No hay productos agregados aún.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                    <tfoot className="bg-gray-50 font-bold text-gray-900">
                                        <tr>
                                            <td colSpan={3} className="px-6 py-4 text-right">Total acumulado:</td>
                                            <td className="px-6 py-4 text-right text-lg">${Number(venta.total).toLocaleString()}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
};



export default EditVenta;