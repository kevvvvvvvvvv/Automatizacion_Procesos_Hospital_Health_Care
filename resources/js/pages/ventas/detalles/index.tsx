import React from 'react';
import { Head } from '@inertiajs/react';
import { Paciente, Estancia, Venta, DetalleVenta as DetalleVentaType } from '@/types'; 

import MainLayout from '@/layouts/MainLayout'; 
import PacienteCard from '@/components/paciente-card';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    venta: Venta & { detalles: DetalleVentaType[] }; 
}

const DetallesVenta = ({ paciente, estancia, venta }: Props) => {

    const detalles = venta.detalles || [];

    return (
        <MainLayout 
            pageTitle={`Detalles de venta ${venta.id}`} 
            link='pacientes.estancias.ventas.index' 
            linkParams={[paciente.id, estancia.id]}
        >
            <Head title={`Detalles Venta #${venta.id}`} />

            <PacienteCard paciente={paciente} estancia={estancia} />
            
            <div className="p-4 md:p-8 mt-4 bg-white rounded-lg shadow">
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-xl font-semibold">Detalles de la venta #{venta.id}</h2>
                </div>
                <p className="mb-1 text-sm text-gray-600">Fecha: {new Date(venta.fecha).toLocaleDateString('es-MX', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                <p className="mb-4 text-sm text-gray-600">Estado: <span className="font-medium">{venta.estado}</span></p>

                <div className="overflow-x-auto border rounded-lg">
                    <table className="w-full text-sm text-left text-gray-700">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">Producto / Servicio / Estudio</th>
                                <th scope="col" className="px-6 py-3 text-right">Cantidad</th>
                                <th scope="col" className="px-6 py-3 text-right">P. Unitario</th>
                                <th scope="col" className="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        {detalles.map((detalle) => {
                            const nombreItem = detalle.itemable 
                                ? (detalle.itemable.nombre_prestacion || detalle.itemable.nombre || 'Sin nombre')
                                : detalle.nombre_producto_servicio;

                            const esProducto = detalle.itemable_type?.includes('ProductoServicio');
                            const esEstudio = detalle.itemable_type?.includes('CatalogoEstudio');
                            
                            let etiquetaTipo = 'Pendiente de catalogar';
                            if (esProducto) etiquetaTipo = 'Producto';
                            if (esEstudio) etiquetaTipo = 'Estudio';

                            return (
                                <tr key={detalle.id} className="border-b hover:bg-gray-50">
                                    <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <div className="flex flex-col">
                                            <span>{nombreItem}</span>
                                            <span className="w-fit text-[10px] uppercase font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded border mt-1">
                                                {etiquetaTipo}
                                            </span>
                                        </div>
                                    </td>
                                    <td className="px-6 py-4 text-right">{detalle.cantidad}</td>
                                    <td className="px-6 py-4 text-right">
                                        ${Number(detalle.precio_unitario).toLocaleString('es-MX', { minimumFractionDigits: 2 })}
                                    </td>
                                    <td className="px-6 py-4 text-right">
                                        ${Number(detalle.subtotal).toLocaleString('es-MX', { minimumFractionDigits: 2 })}
                                    </td>
                                </tr>
                            );
                        })}
                            {detalles.length === 0 && (
                                <tr>
                                    <td colSpan={4} className="px-6 py-4 text-center text-gray-500">No hay detalles para esta venta.</td>
                                </tr>
                            )}
                        </tbody>

                        {detalles.length > 0 && (
                            <tfoot className="text-gray-900">
                                <tr className="font-semibold border-t">
                                    <th scope="row" colSpan={3} className="px-6 py-3 text-base text-right">Subtotal</th>
                                    <td className="px-6 py-3 text-right">${Number(venta.subtotal).toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                                <tr className="font-semibold">
                                    <th scope="row" colSpan={3} className="px-6 py-3 text-base text-right">Descuento</th>
                                    <td className="px-6 py-3 text-right text-red-600">-${Number(venta.descuento).toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                                <tr className="font-bold bg-gray-50 text-lg">
                                    <th scope="row" colSpan={3} className="px-6 py-3 text-base text-right">Total</th>
                                    <td className="px-6 py-3 text-right">${Number(venta.total).toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                            </tfoot>
                        )}
                    </table>
                </div>
            </div>
        </MainLayout>
    );
}

export default DetallesVenta;