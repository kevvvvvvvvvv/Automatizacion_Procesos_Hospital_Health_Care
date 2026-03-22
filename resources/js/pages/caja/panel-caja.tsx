import React, { useState } from 'react';
import { SesionCaja } from '@/types'; 

import ModalCierreCaja from '@/components/caja/modal-cierre-caja';
import ModalGasto from '@/components/caja/modal-gasto';

interface Props {
    sesion: SesionCaja; 
}

export const PanelCaja = ({ 
    sesion 
}: Props) => {
    const [isGastoModalOpen, setIsGastoModalOpen] = useState(false);
    const [isCierreModalOpen, setIsCierreModalOpen] = useState(false);

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

            {/* Tarjetas de Estadísticas */}
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

                {/* Esta tarjeta resalta porque es lo que el cajero debe cuidar */}
                <div className="bg-blue-50 p-5 rounded-xl shadow-sm border border-blue-100 ring-1 ring-blue-500 ring-opacity-50">
                    <p className="text-sm font-bold text-blue-700 uppercase tracking-wider">Efectivo esperado</p>
                    <p className="text-3xl font-black text-blue-900 mt-1">
                        ${formatMoney(sesion.monto_esperado)}
                    </p>
                </div>
            </div>

            {/* Acciones Rápidas */}
            <div className="flex space-x-4">
                <button 
                    onClick={() => setIsGastoModalOpen(true)}
                    className="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center"
                >
                    <span className="text-lg font-bold mr-2">+</span> Registrar gasto / Retiro
                </button>
            </div>

            {/* Tabla de Movimientos (Placeholder) */}
            <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="px-6 py-4 border-b border-gray-100">
                    <h3 className="text-lg font-medium text-gray-800">Últimos movimientos en efectivo</h3>
                </div>
                <div className="p-6 text-center text-gray-500 text-sm bg-gray-50">
                    Aquí renderizaremos la tabla de ventas y gastos cuando conectemos esa relación.
                </div>
            </div>

            {/* AQUÍ IRÁN LOS MODALES */}
            {isGastoModalOpen && <ModalGasto onClose={() => setIsGastoModalOpen(false)} />} 
            {isCierreModalOpen && <ModalCierreCaja onClose={() => setIsCierreModalOpen(false)} />}
        </div>
    );
};