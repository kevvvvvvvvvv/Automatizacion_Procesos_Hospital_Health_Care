import React from 'react';
import '../../../public/css/ticket-styles.css';
import '../../../public/images/Logo_HC_Negativo_2.png';
import { Venta } from '@/types';

export default function Ticket({ venta }:{ venta: Venta}) {
    
    const handlePrint = () => {
        window.print();
    };

    return (
        <div>
            <button 
                onClick={handlePrint}
                className="mb-4 bg-blue-600 text-white px-4 py-2 rounded no-print rounded-xl"
            >
                🖨️ Imprimir ticket
            </button>

            <div id="printable-ticket" className="ticket-container text-black">
                
                <div className="text-center mb-2 border-b border-black pb-2">
                    <img src="/images/Logo_HC_Negativo_2.png" alt="Logo Health Care" className="w-45 mx-auto"/>
                    <p className="text-[10px]">CALLE PLAN DE AYUTLA NÚMERO 13 COLONIA REFORMA</p>
                    <p className="text-[10px]">CUERNAVACA, MORELOS, CÓDIGO POSTAL 62260 TÉLEFONO 777 323 0371</p>
                    <p className="text-[10px] mt-1">
                        {new Date(venta.fecha).toLocaleString()}
                    </p>
                </div>

                <div className="text-[10px] mb-2">
                    <p>Folio: #{venta.id}</p>
                    <p>Paciente: {venta.estancia.paciente.nombre} {venta.estancia.paciente.apellido_paterno} {venta.estancia.paciente.apellido_materno}</p>
                </div>

                <table className="w-full text-[10px] mb-2">
                    <thead>
                        <tr className="border-b border-dashed border-black">
                            <th className="text-left">Cant.</th>
                            <th className="text-left">Desc.</th>
                            <th className="text-right">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        {venta.detalles.length === 0 ?
                            (
                                <tr>
                                    <td className='text-gray'> Sin articulos registrados</td>
                                </tr>
                            ):(
                                venta.detalles?.map((detalle) => {
                                    const nombreItem = detalle.itemable 
                                        ? (detalle.itemable.nombre_prestacion || detalle.itemable.nombre || 'Sin nombre')
                                        : 'Ítem eliminado o no encontrado';
                                        return (
                                        <tr key={detalle.id}>
                                            <td>{detalle.cantidad}</td>
                                            <td>{nombreItem}</td>
                                            <td className="text-right">{detalle.subtotal}</td>
                                        </tr>
                                    );
                                }
                            ))
                        }                     
                    </tbody>
                </table>

                <div className="border-t border-black pt-2 text-right text-xs">
                    <p>Subtotal: ${venta.subtotal}</p>
                    <p>IVA: ${venta.total - venta.subtotal}</p>
                    <p className="font-bold text-sm mt-1">TOTAL: ${venta.total}</p>

                    <div className="mt-2 border-t border-dashed border-black pt-1">
                        <p>Pagado: ${venta.total_pagado}</p>
                        <p>Cambio/Pendiente: ${venta.saldo_pendiente}</p>
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