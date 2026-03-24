import React from 'react';
import { useForm } from '@inertiajs/react';
import Swal from 'sweetalert2';
import MainLayout from '@/layouts/MainLayout';

interface Props {
    solicitudesPendientes: any;
}

export default function DashboardBoveda({ 
    solicitudesPendientes 
}: Props) {
    const { post } = useForm();

    const handleAprobar = (solicitud: any) => {
        Swal.fire({
            title: 'Autorizar Traspaso',
            html: `La caja <b>${solicitud.caja_destino.nombre}</b> está pidiendo efectivo.<br/>Motivo: <i>${solicitud.concepto}</i>`,
            input: 'number',
            inputLabel: '¿Cuánto dinero enviarás realmente?',
            inputValue: solicitud.monto_solicitado, // Le sugerimos lo que pidió
            showCancelButton: true,
            confirmButtonText: 'Autorizar y Enviar Dinero',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#16a34a', // Verde Tailwind
            inputValidator: (value) => {
                if (!value || Number(value) <= 0) return 'Debes ingresar un monto mayor a 0';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Si le da a confirmar, disparamos a Laravel
                post(`/traspasos/${solicitud.id}/responder`, {
                    data: { aprobar: true, monto_aprobado: result.value },
                    preserveScroll: true,
                    onSuccess: () => Swal.fire('¡Transferido!', 'El dinero ya está en la caja destino.', 'success')
                });
            }
        });
    };

    // Función rápida para rechazar
    const handleRechazar = (solicitudId: number) => {
        Swal.fire({
            title: '¿Rechazar solicitud?',
            text: 'La caja no recibirá el dinero.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Sí, rechazar'
        }).then((result) => {
            if (result.isConfirmed) {
                post(`/traspasos/${solicitudId}/responder`, {
                    data: { aprobar: false },
                    preserveScroll: true
                });
            }
        });
    };

    return (
        <MainLayout
            pageTitle='Registro contaduría'
            link='dashboard'
        >
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="flex justify-between items-center mb-8">
                    <div>
                        <h1 className="text-3xl font-black text-gray-900">Tesorería y Fondo</h1>
                        <p className="text-gray-500">Gestión de bóveda y solicitudes de efectivo</p>
                    </div>
                </div>

                <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 className="text-lg font-bold text-gray-800 flex items-center">
                            <span className="bg-red-500 text-white text-xs px-2 py-1 rounded-full mr-2">
                                {solicitudesPendientes?.length || 0}
                            </span>
                            Solicitudes Pendientes
                        </h2>
                    </div>

                    {solicitudesPendientes && solicitudesPendientes.length > 0 ? (
                        <table className="min-w-full divide-y divide-gray-200 text-left">
                            <thead className="bg-white">
                                <tr>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Caja Destino</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Solicitante</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Monto Pedido</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {solicitudesPendientes.map((solicitud: any) => (
                                    <tr key={solicitud.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4">
                                            <p className="font-bold text-gray-900">{solicitud.caja_destino?.nombre}</p>
                                            <p className="text-xs text-gray-500">{solicitud.concepto}</p>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-600">
                                            {solicitud.usuario_solicita?.name}
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <span className="text-lg font-black text-blue-600">
                                                ${Number(solicitud.monto_solicitado).toFixed(2)}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-center space-x-2">
                                            <button 
                                                onClick={() => handleAprobar(solicitud)}
                                                className="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1.5 rounded font-bold text-sm transition-colors"
                                            >
                                                Atender
                                            </button>
                                            <button 
                                                onClick={() => handleRechazar(solicitud.id)}
                                                className="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded font-bold text-sm transition-colors"
                                            >
                                                X
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    ) : (
                        <div className="p-12 text-center">
                            <p className="text-gray-500 text-lg">No hay solicitudes de efectivo pendientes. 🎉</p>
                        </div>
                    )}
                </div>
            </div>
        </MainLayout>
    );
}