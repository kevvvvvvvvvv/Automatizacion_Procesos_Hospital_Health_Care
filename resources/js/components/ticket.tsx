import React from 'react';
import '../../../public/css/ticket-styles.css';
import { Venta } from '@/types';

interface Props {
    venta: Venta;
    tipo: 'ORIGINAL' | 'COPIA';
}

export default function Ticket({ 
    venta, 
    tipo,
}: Props) {
    
    const handlePrint = () => {
        window.print();
    };

    return (
        <div>
            <button 
                onClick={handlePrint}
                className="mb-4 bg-blue-600 text-white px-4 py-2 no-print rounded-xl"
            >
                🖨️ Imprimir ticket
            </button>

            <div id="printable-ticket" className="ticket-container text-black font-bold">
                
                <div className="text-center mb-2 border-b border-black pb-2">
                    <img src="/images/Logo_HC_Negativo_2.png" alt="Logo Health Care" className="w-45 mx-auto"/>
                    <p className="text-[10px]">CALLE PLAN DE AYUTLA NÚMERO 13 COLONIA REFORMA</p>
                    <p className="text-[10px]">CUERNAVACA, MORELOS, CÓDIGO POSTAL 62260 TÉLEFONO 777 323 0371</p>
                    <p className="text-[10px] mt-1">
                        {new Date(venta.fecha).toLocaleString()}
                    </p>
                    <p className='text-[10px]'>{tipo}</p>
                </div>

                <div className="text-[10px] mb-2">
                    <p>Folio: #{venta.id}</p>
                    <p>Paciente: {venta.estancia.paciente.nombre} {venta.estancia.paciente.apellido_paterno} {venta.estancia.paciente.apellido_materno}</p>
                </div>

                <table className="w-full text-[10px] mb-2 table-fixed leading-tight">
                    <thead>
                        <tr className="border-b border-dashed border-black">
                            <th className="w-[15%] text-left align-top">Cant.</th>
                            <th className="w-[25%] text-left align-top">CPS</th>
                            <th className="w-[35%] text-left align-top">Desc.</th>
                            <th className="w-[25%] text-right align-top">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        {venta.detalles.length === 0 ? (
                            <tr>
                                <td colSpan={3} className='text-gray-500 text-center py-2'>
                                    Sin artículos registrados
                                </td>
                            </tr>
                        ) : (
                            venta.detalles?.map((detalle) => {
                                const nombreItem = detalle.itemable 
                                    ? (detalle.itemable.nombre_prestacion || detalle.itemable.nombre || 'Sin nombre')
                                    : detalle.nombre_producto_servicio;

                                return (
                                    <tr key={detalle.id}>
                                        <td className="text-left align-top">
                                            {detalle.cantidad}
                                        </td>
                                        <td className="text-left align-top">
                                            {detalle.clave_producto_servicio ? detalle.clave_producto_servicio : ''}
                                        </td>                                        
                                        <td className="text-left align-top break-words pr-1">
                                            {nombreItem}
                                        </td>
                                        
                                        <td className="text-right align-top">
                                            ${Number(detalle.subtotal).toFixed(2)}
                                        </td>
                                    </tr>
                                );
                            })
                        )}
                    </tbody>
                </table>

                <div className="border-t border-black pt-2 text-right text-xs">
                    <p>Subtotal: ${venta.subtotal}</p>
                    <p>IVA: ${venta.total - venta.subtotal}</p>
                    <p className="font-bold text-sm mt-1">TOTAL: ${venta.total}</p>

                    <div className="mt-2 border-t border-dashed border-black pt-1">
                        <p>Pagado: ${venta.total_pagado}</p>
                        
                        {venta.total_pagado > venta.total ? (
                            <p>Cambio: ${venta.cambio}</p>
                        ) : (
                            <p>Pendiente: ${venta.saldo_pendiente}</p>
                        )}
                    </div>
                </div>

                <div className="text-center mt-4 text-[10px]">
                    <p>¡Gracias por su preferencia!</p>
                    <p>Conserve este ticket para aclaraciones.</p>
                </div>
            </div>
        </div>
    );
}