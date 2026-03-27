import React, { useState } from 'react';
import { MovimientoCaja, SesionCaja } from '@/types'; 

import ModalCierreCaja from '@/components/caja/modal-cierre-caja';
import ModalGasto from '@/components/caja/modal-gasto';
import { ModalSolicitudFondo } from '@/components/caja/modal-solicitud-fondos';

interface Props {
    sesion: SesionCaja; 
}

export const PanelCaja = ({ 
    sesion 
}: Props) => {
    const [isGastoModalOpen, setIsGastoModalOpen] = useState(false);
    const [isCierreModalOpen, setIsCierreModalOpen] = useState(false);
    const [isSolicitudModalOpen, setIsSolicitudModalOpen] = useState(false);

    const formatMoney = (amount: number | string | undefined) => {
        const num = Number(amount);
        return isNaN(num) ? '0.00' : num.toFixed(2);
    };

    

    return (
        <div className="p-6 max-w-7xl mx-auto space-y-6">
            <div className="flex justify-between items-center">
                <div>
                    <h1 className="text-2xl font-bold text-gray-800">Caja activa</h1>
                    <p className="text-sm text-gray-500">
                        Turno abierto: {new Date(sesion.fecha_apertura).toLocaleString()}
                    </p>
                </div>
                <button 
                    className="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm"
                    onClick={() => setIsCierreModalOpen(true)}
                >
                    Realizar corte de caja
                </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div className="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p className="text-sm font-medium text-gray-500">Fondo inicial</p>
                    <p className="text-2xl font-bold text-gray-800 mt-1">
                        ${formatMoney(sesion.monto_inicial)}
                    </p>
                </div>
                
                <div className="bg-white p-5 rounded-xl shadow-sm border border-green-50">
                    <p className="text-sm font-medium text-green-600">Ingresos (+)</p>
                    <p className="text-2xl font-bold text-gray-800 mt-1">
                        ${formatMoney(sesion.total_ingresos_efectivo)}
                    </p>
                </div>

                <div className="bg-white p-5 rounded-xl shadow-sm border border-red-50">
                    <p className="text-sm font-medium text-red-600">Egresos (-)</p>
                    <p className="text-2xl font-bold text-gray-800 mt-1">
                        ${formatMoney(sesion.total_egresos_efectivo)}
                    </p>
                </div>

                <div className="bg-blue-50 p-5 rounded-xl shadow-sm border border-blue-100 ring-1 ring-blue-500 ring-opacity-50">
                    <p className="text-sm font-bold text-blue-700 uppercase tracking-wider">Efectivo esperado</p>
                    <p className="text-3xl font-black text-blue-900 mt-1">
                        ${formatMoney(sesion.monto_esperado)}
                    </p>
                </div>
            </div>

            <div className="flex space-x-4">
                <button 
                    onClick={() => setIsGastoModalOpen(true)} 
                    className="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center"
                >
                    + Registrar gasto / retiro
                </button>
                
                <button 
                    onClick={() => setIsSolicitudModalOpen(true)}
                    className="bg-yellow-50 border border-yellow-200 text-yellow-800 hover:bg-yellow-100 px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-sm flex items-center"
                >
                    Retirar efectivo de fondo
                </button>
            </div>      

            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 className="text-lg font-medium text-gray-800">Últimos movimientos en efectivo</h3>
                </div>
                
                {sesion.movimientos && sesion.movimientos.length > 0 ? (
                    <div className="overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200 text-left">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                    <th className="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto</th>
                                    <th className="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th className="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-right tracking-wider">Monto</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {sesion.movimientos.map((mov: MovimientoCaja) => (
                                    <tr key={mov.id} className="hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {new Date(mov.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {mov.concepto}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm">
                                            <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                mov.tipo === 'ingreso' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                            }`}>
                                                {mov.tipo.toUpperCase()}
                                            </span>
                                        </td>
                                        <td className={`px-6 py-4 whitespace-nowrap text-sm text-right font-bold ${
                                            mov.tipo === 'ingreso' ? 'text-green-600' : 'text-red-600'
                                        }`}>
                                            {mov.tipo === 'ingreso' ? '+' : '-'}${formatMoney(mov.monto)}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="p-8 text-center bg-gray-50">
                        <svg className="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 className="mt-2 text-sm font-medium text-gray-900">Sin movimientos</h3>
                        <p className="mt-1 text-sm text-gray-500">No se han registrado ingresos ni retiros extra en este turno.</p>
                    </div>
                )}
            </div>

            {isGastoModalOpen && <ModalGasto onClose={() => setIsGastoModalOpen(false)} />} 
            {isCierreModalOpen && <ModalCierreCaja onClose={() => setIsCierreModalOpen(false)} />}
                {isSolicitudModalOpen && <ModalSolicitudFondo onClose={() => setIsSolicitudModalOpen(false)} sesionActiva={sesion} />}
        </div>
    );
};