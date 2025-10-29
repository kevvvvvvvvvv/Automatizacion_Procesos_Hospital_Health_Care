import React from 'react';
import { Head } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout'; 
import PacienteCard from '@/components/paciente-card';
import { Paciente, Estancia, Venta, DetalleVenta } from '@/types'; 

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    venta: Venta;
}

const DetallesVenta: React.FC<Props> & { layout: any } = ({ paciente, estancia, venta }) => {

    const detalles = venta.detalles || [];

    return (
        <>
            <Head title={`Detalles Venta #${venta.id}`} />

            <PacienteCard paciente={paciente} estancia={estancia} />

            <div className="p-4 md:p-8 mt-4 bg-white rounded-lg shadow">
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-xl font-semibold">Detalles de la Venta #{venta.id}</h2>
                </div>
                <p className="mb-1 text-sm text-gray-600">Fecha: {new Date(venta.fecha).toLocaleDateString('es-MX', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                <p className="mb-4 text-sm text-gray-600">Estado: <span className="font-medium">{venta.estado}</span></p>

                <div className="overflow-x-auto border rounded-lg">
                    <table className="w-full text-sm text-left text-gray-700">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">Producto/Servicio</th>
                                <th scope="col" className="px-6 py-3 text-right">Cantidad</th>
                                <th scope="col" className="px-6 py-3 text-right">P. Unitario</th>
                                <th scope="col" className="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {detalles.map((detalle: DetalleVenta) => (
                                <tr key={detalle.id} className="border-b hover:bg-gray-50">
                                    <td className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {detalle.producto_servicio?.nombre_prestacion || 'Producto no encontrado'}
                                    </td>
                                    <td className="px-6 py-4 text-right">{detalle.cantidad}</td>
                                    <td className="px-6 py-4 text-right">
                                        ${detalle.precio_unitario.toLocaleString('es-MX', { minimumFractionDigits: 2 })}
                                    </td>
                                    <td className="px-6 py-4 text-right">
                                        ${detalle.subtotal.toLocaleString('es-MX', { minimumFractionDigits: 2 })}
                                    </td>
                                </tr>
                            ))}
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
                                    <td className="px-6 py-3 text-right">${venta.subtotal.toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                                <tr className="font-semibold">
                                    <th scope="row" colSpan={3} className="px-6 py-3 text-base text-right">Descuento</th>
                                    <td className="px-6 py-3 text-right text-red-600">-${venta.descuento.toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                                <tr className="font-bold bg-gray-50 text-lg">
                                    <th scope="row" colSpan={3} className="px-6 py-3 text-base text-right">Total</th>
                                    <td className="px-6 py-3 text-right">${venta.total.toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                                </tr>
                            </tfoot>
                        )}
                    </table>
                </div>
            </div>
        </>
    );
}

DetallesVenta.layout = (page: React.ReactElement) => <MainLayout children={page} pageTitle="Detalles de Venta" />;
export default DetallesVenta;