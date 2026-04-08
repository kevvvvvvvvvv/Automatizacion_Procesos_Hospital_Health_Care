import React, {useEffect} from 'react';
import Swal from 'sweetalert2';
import { useState } from 'react';
import { usePage } from '@inertiajs/react';
import { MovimientoCaja, SesionCaja, SolicitudTraspaso } from '@/types';
import { route } from 'ziggy-js';
import { router } from '@inertiajs/react';

import {ModalGastoBoveda} from  '@/components/caja/modal-gasto-boveda';
import { SummaryCard } from '@/components/ui/money/summary-card'; 
import PageButton from '@/components/ui/buttons/page-button';
import ModalOpenButton from '@/components/ui/buttons/modal-open-button';
import MainLayout from '@/layouts/MainLayout';
import SesionesAudit from '@/components/caja/sesion-audit';
import ModalEnviarBovedaAFondo from '@/components/caja/modal-enviar-boveda-a-fondo';
import boveda from '@/routes/boveda';


interface Props {
    solicitudesPendientes: SolicitudTraspaso[];
    movimientosHoy: MovimientoCaja[];
    resumenHoy: {
        ingresos: number;
        egresos: number;
        balance: number;
    };
    cajaId: number;
    fondo: SesionCaja,
    sesion: SesionCaja,
    caja: SesionCaja;
    allSesiones: SesionCaja [];
}

export default function DashboardBoveda({ 
    cajaId,
    solicitudesPendientes = [],
    movimientosHoy = [],
    resumenHoy,
    fondo,
    sesion,
    caja,
    allSesiones
}: Props) {
    type FilterType = 'todos' | 'boveda' | 'operativo';

    const [filtroActivo, setFiltroActivo] = useState<FilterType>('todos');

    const { url } = usePage();

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const tabDesdeUrl = params.get('tab');

        if (tabDesdeUrl === 'sesiones') {
            setVistaActiva('sesiones');
        } else if (tabDesdeUrl === 'diario') {
            setVistaActiva('diario');
        }
        
    }, [url]);

    useEffect(() => {
        window.Echo.channel(`caja.${cajaId}`)
            .listen('NuevoMovimientoCaja', () => {

                router.reload({
                    only: [
                        'solicitudesPendientes', 
                        'movimientosHoy', 
                        'resumenHoy'
                    ],
                });
                
            });
        return () => {
            window.Echo.leave(`caja.${cajaId}`);
        };
    }, [cajaId]);

    const [vistaActiva, setVistaActiva] = useState<'solicitudes' | 'diario' | 'sesiones'>('solicitudes');
    const [isEnviarDineroFondo, setIsEnviarDineroFondo] = useState(false);
    const [isGastoModalOpen, setIsGastoModalOpen] = useState(false);

    const formatMoney = (amount: number) => {
        return Number(amount || 0).toLocaleString('es-MX', { minimumFractionDigits: 2 });
    };

    const handleAprobar = (solicitud: SolicitudTraspaso) => {
        Swal.fire({
            title: 'Autorizar traspaso',
            html: `La caja <b>${solicitud.caja_destino.nombre}</b> está pidiendo efectivo.<br/>Motivo: <i>${solicitud.concepto}</i>`,
            input: 'number',
            inputLabel: '¿Cuánto dinero enviarás realmente?',
            inputValue: solicitud.monto_solicitado, 
            showCancelButton: true,
            confirmButtonText: 'Autorizar y enviar dinero',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#16a34a', 
            inputValidator: (value) => {
                if (!value || Number(value) <= 0) return 'Debes ingresar un monto mayor a 0';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                router.post(route('traspasos.responder',{solicitud: solicitud.id}), {
                    aprobar: true, 
                    monto_aprobado: result.value
                },{
                    preserveScroll: true,
                });
            }
        });
    };

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
                router.post(route('traspasos.responder', {solicitud: solicitudId}), 
                {
                     aprobar: false 
                },
                {
                    preserveScroll: true
                });
            }
        });
    };

    const filteredMovimientos = movimientosHoy.filter((mov: MovimientoCaja) => {
        const tipoCaja = mov.sesion_caja?.caja?.tipo;

        if (filtroActivo === 'boveda') {
            return tipoCaja === 'boveda';
        }
        
        if (filtroActivo === 'operativo') {
            return tipoCaja === 'fondo' || tipoCaja === 'operativo'; 
        }

        return true; 
    });

    return (
        <MainLayout
            pageTitle='Registro contaduría'
            link='dashboard'
        >
             <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <SummaryCard
                    label='Caja'
                    amount={caja?.monto_esperado ? caja.monto_esperado : 0}
                />

                <SummaryCard
                    label="Fondo"
                    amount={fondo?.monto_esperado ? fondo.monto_esperado : 0}
                />  

                <SummaryCard
                    label='Boveda'
                    amount={sesion?.monto_esperado ? sesion.monto_esperado : 0}
                /> 
            </div>
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div className="flex flex-col md:flex-row justify-between items-end mb-6 border-b border-gray-200 pb-4">
                    <div>
                        <h1 className="text-3xl font-black text-gray-900">Contaduría</h1>
                        <p className="text-gray-500">Gestión de bóveda y movimiento de caja</p>
                    </div>
                    
                    <div className="flex space-x-2 mt-4 md:mt-0">
                        <PageButton
                            active={vistaActiva === 'solicitudes'}
                            onClick={()=>setVistaActiva('solicitudes')}
                        >
                            Solicitudes
                            {solicitudesPendientes?.length > 0 && (
                                <span className="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                                    {solicitudesPendientes.length}
                                </span>
                            )}
                        </PageButton>

                        <PageButton
                            onClick={()=>setVistaActiva('diario')}
                            active={vistaActiva === 'diario'}
                        >
                            Movimientos (hoy)
                        </PageButton>

                        <PageButton
                            onClick={()=>setVistaActiva('sesiones')}
                            active={vistaActiva === 'sesiones'}
                        >  
                            Sesiones
                        </PageButton>

                        <ModalOpenButton
                            onClick={()=>setIsGastoModalOpen(true)}
                            variant='danger'
                        >
                            Registrar egreso
                        </ModalOpenButton>   
                        <ModalOpenButton
                            onClick={()=>setIsEnviarDineroFondo(true)}
                            variant='success'
                        >
                            Enviar dinero a fondo
                        </ModalOpenButton>
                    </div>
                </div>
                {vistaActiva === 'solicitudes' && (
                <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h2 className="text-lg font-bold text-gray-800 flex items-center">
                            <span className="bg-red-500 text-white text-xs px-2 py-1 rounded-full mr-2">
                                {solicitudesPendientes?.length || 0}
                            </span>
                            Solicitudes pendientes
                        </h2>
                    </div>

                    {solicitudesPendientes && solicitudesPendientes.length > 0 ? (
                        <table className="min-w-full divide-y divide-gray-200 text-left">
                            <thead className="bg-white">
                                <tr>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Caja destino</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Solicitante</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Monto pedido</th>
                                    <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {solicitudesPendientes.map((solicitud: SolicitudTraspaso) => (
                                    <tr key={solicitud.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4">
                                            <p className="font-bold text-gray-900">{solicitud.caja_destino?.nombre}</p>
                                            <p className="text-xs text-gray-500">{solicitud.concepto}</p>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-600">
                                            {solicitud.usuario_solicita?.nombre_completo}
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
                )}
                {vistaActiva === 'diario' && (
                    <>
                    <div className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <SummaryCard
                                label='Total ingresos hoy'
                                amount={resumenHoy.ingresos}
                                theme='success'
                            />
                            <SummaryCard
                                label='Total egresos hoy'
                                amount={resumenHoy.egresos}
                                theme='danger'
                            />
                            <SummaryCard
                                label='Flujo neto del día'
                                amount={resumenHoy.balance}
                                theme='default'
                            />
                        </div>

                        <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <h2 className="text-lg font-bold text-gray-800">Todos los movimientos ({new Date().toLocaleDateString()})</h2>
                            </div>
                            <div className="mb-4 flex space-x-2 border-b border-gray-200 p-2">
                                <button
                                    onClick={() => setFiltroActivo('todos')}
                                    className={`px-4 py-2 text-sm font-medium rounded-lg transition-colors ${
                                        filtroActivo === 'todos' 
                                        ? 'bg-blue-100 text-blue-700' 
                                        : 'text-gray-500 hover:bg-gray-100'
                                    }`}
                                >
                                    Todos
                                </button>
                                <button
                                    onClick={() => setFiltroActivo('boveda')}
                                    className={`px-4 py-2 text-sm font-medium rounded-lg transition-colors ${
                                        filtroActivo === 'boveda' 
                                        ? 'bg-purple-100 text-purple-700' 
                                        : 'text-gray-500 hover:bg-gray-100'
                                    }`}
                                >
                                    Solo Bóveda
                                </button>
                                <button
                                    onClick={() => setFiltroActivo('operativo')}
                                    className={`px-4 py-2 text-sm font-medium rounded-lg transition-colors ${
                                        filtroActivo === 'operativo' 
                                        ? 'bg-green-100 text-green-700' 
                                        : 'text-gray-500 hover:bg-gray-100'
                                    }`}
                                >
                                    Caja y Fondo
                                </button>
                            </div>
                            
                            {movimientosHoy && movimientosHoy.length > 0 ? (
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200 text-left">
                                        <thead className="bg-white">
                                            <tr>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Hora</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Caja / Origen</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Área</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Concepto</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Descripción</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Paciente</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Método de pago</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Usuario</th>
                                                <th className="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody className="divide-y divide-gray-100">
                                            {filteredMovimientos.map((mov: MovimientoCaja) => (
                                                <tr key={mov.id} className="hover:bg-gray-50 transition-colors">
                                                    <td className="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                        {new Date(mov.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {mov.sesion_caja?.caja?.nombre || 'Caja Desconocida'}
                                                        </span>
                                                    </td>
                                                     <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        {mov?.area ?  mov.area : ''} 
                                                    </td>                                                   
                                                    <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        {mov.concepto}
                                                    </td>
                                                    <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        {mov?.descripcion}
                                                    </td>
                                                    <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        {mov?.nombre_paciente}
                                                    </td>
                                                    <td className="px-6 py-4 text-sm text-gray-900 font-medium">
                                                        {mov.metodo_pago?.nombre ? mov.metodo_pago.nombre : ''}
                                                    </td>
                                                    <td className="px-6 py-4 text-sm text-gray-500">
                                                        {mov.user?.nombre_completo || 'Sistema'}
                                                    </td>
                                                    <td className="px-6 py-4 text-right whitespace-nowrap">
                                                        <span className={`text-sm font-bold ${mov.tipo === 'ingreso' ? 'text-green-600' : 'text-red-600'}`}>
                                                            {mov.tipo === 'ingreso' ? '+' : '-'}${formatMoney(mov.monto)}
                                                        </span>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            ) : (
                                <div className="p-12 text-center text-gray-500">
                                    No hay ningún movimiento registrado el día de hoy.
                                </div>
                            )}
                        </div>
                    </div>
                    </>
                )}
            </div>

            { vistaActiva === 'sesiones' && <SesionesAudit sesiones={allSesiones} />}
            {isEnviarDineroFondo && <ModalEnviarBovedaAFondo onClose={() => setIsEnviarDineroFondo(false)} boveda={sesion} fondo={fondo}/>}
            {isGastoModalOpen && <ModalGastoBoveda onClose={() => setIsGastoModalOpen(false)} sesionBovedo={sesion}/>}
        </MainLayout>
    );
}