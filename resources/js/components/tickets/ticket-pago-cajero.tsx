import { Pago, TicketCajero } from '@/types';
import React from 'react';

interface Props {
    ticket: TicketCajero;
    pago: Pago;
}

const TicketPagoCajero = ({
    ticket,
    pago,
}: Props) => {

    const handleImprimir = () => {
        window.print();
    };

    return (
        <div className="flex flex-col items-center p-6 bg-white rounded-lg shadow-md max-w-sm mx-auto border border-gray-200">
            {/* Encabezado del Ticket */}
            <div className="text-center mb-6">
                <h2 className="text-2xl font-bold text-gray-800">Pase a Caja</h2>
                <p className="text-sm text-gray-500 mt-1">Automatización de Procesos - Hospital</p>
            </div>

            {/* Datos del Paciente y Folio */}
            <div className="w-full border-b border-dashed border-gray-300 pb-4 mb-4 text-sm text-gray-600">
                <div className="flex justify-between mb-1">
                    <span className="font-semibold">Folio:</span>
                    <span>{pago.folio}</span>
                </div>
                <div className="flex justify-between mb-1">
                    <span className="font-semibold">Paciente:</span>
                    {/* <span>{pago.venta.estancia.paciente.nombre_completo}</span> */}
                </div>
                <div className="flex justify-between mt-3 text-lg text-gray-800">
                    <span className="font-bold">Total a Pagar:</span>
                   {/*  <span className="font-bold">${pago.monto_restante.toFixed(2)}</span> */}
                </div>
            </div>

            {/* Sección del QR */}
            <div className="flex flex-col items-center w-full">
                <p className="text-xs text-gray-500 mb-2 text-center">
                    Escanea este código en el cajero automático para realizar tu pago
                </p>
                
                <img 
                    src={`data:image/png;base64,${ticket.qr_base64}`} 
                    alt="Código QR de Pago" 
                    className="w-48 h-48 object-contain border-2 border-gray-100 rounded-lg p-2 mb-3"
                />

                <p className="text-sm text-gray-600">
                    Código manual: <span className="font-mono font-bold text-gray-900 tracking-wider"></span>
                </p>
            </div>

            {/* Botón de Acción (Oculto al imprimir) */}
            <button 
                onClick={handleImprimir}
                className="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-colors print:hidden"
            >
                🖨️ Imprimir Ticket
            </button>
        </div>        
    );
}

export default TicketPagoCajero;