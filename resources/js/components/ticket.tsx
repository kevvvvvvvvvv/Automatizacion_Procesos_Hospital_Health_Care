import React from 'react';
import '../../../public/css/ticket-styles.css';
import { Pago } from '@/types';

interface Props {
    pago: Pago; 
    tipo: 'ORIGINAL' | 'COPIA';
}

const formatter = new Intl.NumberFormat('es-MX', {
    style: 'currency',
    currency: 'MXN',
    minimumFractionDigits: 2
});

export default function TicketPago({ 
    pago, 
    tipo,
}: Props) {
    
    const handlePrint = () => {
        window.print();
    };

    const venta = pago.venta;

    console.log(pago);

    return (
        <div>
            <button 
                onClick={handlePrint}
                className="mb-4 bg-blue-600 text-white px-4 py-2 no-print rounded-xl"
            >
                🖨️ Imprimir recibo
            </button>

            <div id={`printable-ticket-${pago.id}`} className="ticket-container printable-ticket text-black font-bold">
                
                <div className="text-center mb-2 border-b border-black pb-2">
                    <img src="/images/Logo_HC_Negativo_2.png" alt="Logo Health Care" className="w-45 mx-auto"/>
                    <p className="text-[10px]">CALLE PLAN DE AYUTLA NÚMERO 13 COLONIA REFORMA</p>
                    <p className="text-[10px]">CUERNAVACA, MORELOS, CÓDIGO POSTAL 62260 TÉLEFONO 777 323 0371</p>
                    <p className="text-[10px] mt-1">
                        {new Date(pago.created_at).toLocaleString('es-MX')}
                    </p>
                    <p className='text-[10px] mt-1 font-extrabold'>RECIBO DE PAGO</p>
                    <p className='text-[10px]'>{tipo}</p>
                </div>

                <div className="text-[10px] mb-2">
                    <p>Folio Recibo: <span className="font-extrabold">{pago.folio}</span></p>
                    <p>Cuenta General: #{venta?.id}</p>
                    <p>Paciente: {venta?.estancia?.paciente?.nombre} {venta?.estancia?.paciente?.apellido_paterno} {venta?.estancia?.paciente?.apellido_materno}</p>
                </div>

                <table className="w-full text-[10px] mb-2 table-fixed leading-tight">
                    <thead>
                        <tr className="border-b border-dashed border-black">
                            <th className="w-[15%] text-left align-top">Cant.</th>
                            <th className="w-[25%] text-left align-top">CPS</th>
                            <th className="w-[35%] text-left align-top">Concepto</th>
                            <th className="w-[25%] text-right align-top">Abono</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!pago.detalles || pago.detalles.length === 0 ? (
                            <tr>
                                <td colSpan={4} className='text-gray-500 text-center py-2'>
                                    Sin detalles registrados
                                </td>
                            </tr>
                        ) : (
                            pago.detalles.map((detallePago) => {
                                const detalleVenta = pago.venta?.detalles?.find(
                                    (dv) => dv.id === detallePago.detalle_venta_id
                                );


                                const nombreItem = detalleVenta?.itemable 
                                    ? (detalleVenta.itemable.nombre_prestacion || detalleVenta.itemable.nombre || 'Sin nombre')
                                    : (detalleVenta?.nombre_producto_servicio || 'Concepto');

                                return (
                                    <tr key={detallePago.id}>
                                        <td className="text-left align-top">1</td>
                                        <td className="text-left align-top">
                                            {detalleVenta?.clave_producto_servicio || ''}
                                        </td>                                     
                                        <td className="text-left align-top break-words pr-1">
                                            {nombreItem}
                                        </td>
                                        <td className="text-right align-top">
                                            {formatter.format(detallePago.monto_aplicado)}
                                        </td>
                                    </tr>
                                );
                            })
                        )}
                    </tbody>
                </table>

                <div className="border-t border-black pt-2 text-right text-xs">
                    <p className="font-bold text-sm mt-1">SU PAGO: {formatter.format(pago.monto)}</p>

                    <div className="mt-2 border-t border-dashed border-black pt-1 text-[10px]">
                        <p>Método de pago: {pago.metodo_pago?.nombre || 'N/A'}</p>
                    </div>
                    {venta && (
                        <div className="mt-2 border-t border-dashed border-black pt-1 text-[10px]">
                            <p>Total de la cuenta: {formatter.format(venta.total)}</p>
                            <p>Restante por pagar: {formatter.format(venta.saldo_pendiente)}</p>
                        </div>
                    )}
                </div>

                <div className="text-center mt-4 text-[10px]">
                    <p>¡Gracias por su preferencia!</p>
                    <p>Conserve este recibo para aclaraciones.</p>
                </div>
                <div className='text-left mt-2 text-[10px]'>
                    {venta?.requiere_factura ? (
                        <>
                            <p>Tiene 72 horas para el envío de la siguiente información al número 7779756696 o al correo cmc1.facturacion@gmail.com </p> 
                            <p>1. Nombre/Razón social, 2. RFC, 3. Código postal, 4. Regimen fiscal, 5. Uso de CFDI, 6. Correo electrónico, 7. Número de teléfono, 8. Copia de este comprobante</p>
                        </>
                    ):(
                        <p>El cliente no solicitó factura para esta cuenta.</p>
                    )}
                </div>
            </div>
        </div>
    );
}