import { Pago, TicketCajero } from '@/types';
import React from 'react';
import '../../../../public/css/tickets/ticket-cajero-styles.css';

interface Props {
    ticket: TicketCajero;
    pago: Pago;
}

const TicketPagoCajero = ({
    ticket,
    pago,
}: Props) => {

const handleImprimir = () => {
        const ventana = window.open('', 'PRINT', 'height=600,width=400');
        
        if (!ventana) {
            alert("Por favor, permite las ventanas emergentes para imprimir el ticket.");
            return;
        }

        ventana.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Ticket Cajero</title>
                <style>
                    @page { margin: 0; }
                    
                    body {
                        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                        color: #000;
                        margin: 0;
                        padding: 0;
                        width: 80mm;
                        margin-top: 25mm; 
                    }
                    
                    .ticket {
                        width: 72mm; 
                        margin: 0 auto;
                        padding: 4mm 0;
                        text-align: center;
                    }

                    h2 { margin: 0 0 4px 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }
                    p { margin: 2px 0; font-size: 12px; }
                    .divisor { border-top: 1px dashed #000; margin: 6px 0; }
                    
                    .fila-datos {
                        display: flex;
                        justify-content: space-between;
                        font-size: 12px;
                        margin: 2px 0;
                    }

                    .qr-container { margin: 8px 0; }
                    .qr-container img {
                        width: 48mm; /* Tamaño perfecto para que el lector del cajero no batalle */
                        height: 48mm;
                        display: block;
                        margin: 0 auto;
                    }
                    
                    .codigo {
                        font-size: 16px;
                        font-weight: bold;
                        font-family: monospace;
                        letter-spacing: 2px;
                        margin-top: 4px;
                    }
                    
                    .footer { font-size: 10px; margin-top: 10px; text-align: center; }
                </style>
            </head>
            <body>
                <div class="ticket">
                    <h2>Hospitalidad Health Care</h2>
                    <p>PASE A CAJA</p>
                    
                    <div class="divisor"></div>
                    
                    <div class="fila-datos">
                        <strong>Folio:</strong> 
                        <span>${pago.folio}</span>
                    </div>
                    <div class="fila-datos">
                        <strong>Fecha:</strong> 
                        <span>${new Date().toLocaleDateString('es-MX')}</span>
                    </div>
                    
                    <div class="divisor"></div>
                    
                    <p><strong>TOTAL A PAGAR:</strong></p>
                    <h2 style="font-size: 20px;">$${Number(pago.monto || 0).toFixed(2)}</h2>
                    
                    <div class="divisor"></div>
                    
                    <p>Escanee este código<br>en el cajero automático:</p>
                    
                    <div class="qr-container">
                        <img src="data:image/png;base64,${ticket.qr_base64}" alt="QR" />
                    </div>

                    <div class="divisor"></div>
                    <p class="footer">Este ticket es exclusivo para<br>uso en cajeros Empática.</p>
                </div>

                <script>
                    window.onload = function() {
                        setTimeout(function() {
                            window.focus();
                            window.print();
                            window.close();
                        }, 250);
                    };
                </script>
            </body>
            </html>
        `);

        ventana.document.close();
    };

    return (
        <div id="area-ticket-cajero" className="flex flex-col items-center p-6 bg-white rounded-lg shadow-md max-w-sm mx-auto border border-gray-200">
            
            <div className="text-center mb-6">
                <h2 className="text-2xl font-bold text-gray-800">Pase a caja</h2>
            </div>

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

            <div className="flex flex-col items-center w-full">
                <p className="text-xs text-gray-500 mb-2 text-center">
                    Escanea este código en el cajero automático para realizar tu pago
                </p>
                
                <img 
                    src={`data:image/png;base64,${ticket.qr_base64}`} 
                    alt="Código QR de Pago" 
                    className="w-48 h-48 object-contain border-2 border-gray-100 rounded-lg p-2 mb-3"
                />
            </div>

            <button 
                onClick={handleImprimir}
                className="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition-colors print:hidden"
            >
                Imprimir ticket
            </button>
        </div>        
    );
}

export default TicketPagoCajero;