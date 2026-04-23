import React, { useEffect, useState } from 'react';
import Swal from 'sweetalert2';
import { usePage, router } from '@inertiajs/react';
import { MovimientoCaja, SesionCaja, SolicitudTraspaso } from '@/types';
import { route } from 'ziggy-js';
import * as XLSX from 'xlsx';

import { ModalGastoBoveda } from '@/components/caja/modal-gasto-boveda';
import { SummaryCard } from '@/components/ui/money/summary-card';
import PageButton from '@/components/ui/buttons/page-button';
import ModalOpenButton from '@/components/ui/buttons/modal-open-button';
import MainLayout from '@/layouts/MainLayout';
import SesionesAudit from '@/components/caja/sesion-audit';
import ModalEnviarBovedaAFondo from '@/components/caja/modal-enviar-boveda-a-fondo';

interface Props {
    solicitudesPendientes: SolicitudTraspaso[];
    movimientosHoy: MovimientoCaja[];
    resumenHoy: {
        ingresos: number;
        egresos: number;
        balance: number;
    };
    cajaId: number;
    fondos: SesionCaja[];
    sesion: SesionCaja;
    caja: SesionCaja;
    allSesiones: SesionCaja[];
    fechaFiltro: string; 
}

export default function DashboardBoveda({
    cajaId,
    solicitudesPendientes = [],
    movimientosHoy = [],
    resumenHoy,
    fondos,
    sesion,
    caja,
    allSesiones,
    fechaFiltro
}: Props) {
    type FilterType = 'todos' | 'boveda' | 'operativo';

    const [filtroActivo, setFiltroActivo] = useState<FilterType>('todos');
    const [vistaActiva, setVistaActiva] = useState<'solicitudes' | 'diario' | 'sesiones'>('solicitudes');
    const [isEnviarDineroFondo, setIsEnviarDineroFondo] = useState(false);
    const [isGastoModalOpen, setIsGastoModalOpen] = useState(false);
    const [mostrarDineroBoveda] = useState(false);

    const { url } = usePage();

    const exportarExcel = (movimientos: MovimientoCaja[]) => {
        const datosExcel = movimientos.map((mov: MovimientoCaja) => ({
            'Hora': new Date(mov.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            'Caja': mov.sesion_caja.caja?.nombre,
            'Nombre del personal': mov.user.nombre_completo,
            'Área': mov.area || '',
            'Concepto': mov.concepto,
            'Descripción': mov.descripcion || '',
            'Nombre del paciente': mov.nombre_paciente || '',
            'Método pago': mov.metodo_pago?.nombre || '',
            'Factura': mov.factura ? 'SÍ' : 'NO',
            'Monto': mov.tipo === 'ingreso' ? Number(mov.monto) : -Number(mov.monto)
        }));

        const worksheet = XLSX.utils.json_to_sheet(datosExcel);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Movimientos de Caja");

        const wscols = [
            { wch: 10 }, 
            { wch: 15 },
            { wch: 25 },
            { wch: 15 }, 
            { wch: 25 }, 
            { wch: 30 }, 
            { wch: 25 }, 
            { wch: 15 }, 
            { wch: 10 }, 
            { wch: 10 }, 
            { wch: 12 }, 
        ];
        worksheet['!cols'] = wscols;
        XLSX.writeFile(workbook, `Reporte_Movimientos_${new Date().toISOString().split('T')[0]}.xlsx`);
    }

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const tabDesdeUrl = params.get('tab');
        if (tabDesdeUrl === 'sesiones') setVistaActiva('sesiones');
        else if (tabDesdeUrl === 'diario') setVistaActiva('diario');
    }, [url]);

    useEffect(() => {
        window.Echo.channel(`caja.${cajaId}`)
            .listen('NuevoMovimientoCaja', () => {
                router.reload({ only: ['solicitudesPendientes', 'movimientosHoy', 'resumenHoy'] });
            });
        return () => window.Echo.leave(`caja.${cajaId}`);
    }, [cajaId]);

    const formatMoney = (amount: number) => {
        return Number(amount || 0).toLocaleString('es-MX', { minimumFractionDigits: 2 });
    };

    const handleFechaChange = (nuevaFecha: string) => {
        router.get(route('contaduria.index'), 
            { fecha: nuevaFecha, tab: 'diario' }, 
            { preserveState: true, replace: true }
        );
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
                router.post(route('traspasos.responder', { solicitud: solicitud.id }), {
                    aprobar: true,
                    monto_aprobado: result.value
                }, { preserveScroll: true });
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
                router.post(route('traspasos.responder', { solicitud: solicitudId }), 
                { aprobar: false }, { preserveScroll: true });
            }
        });
    };

    const filteredMovimientos = movimientosHoy.filter((mov: MovimientoCaja) => {
        const tipoCaja = mov.sesion_caja?.caja?.tipo;
        if (filtroActivo === 'boveda') return tipoCaja === 'boveda';
        if (filtroActivo === 'operativo') return tipoCaja === 'fondo' || tipoCaja === 'operativo';
        return true;
    });

    return (
        <MainLayout pageTitle='Registro contaduría' link='dashboard'>
            {/* Resumen de Saldos Actuales */}
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <SummaryCard label='Caja Operativa' amount={caja?.monto_esperado || 0} />
                
                <SummaryCard 
                    label='Bóveda Principal' 
                    amount={sesion?.monto_esperado || 0} 
                    theme="success" 
                    mostrarValor={mostrarDineroBoveda}
                />
            </div>
            <div className='grid grid-cols-1 md:grid-cols-4 gap-4'>
                {fondos.map((fondo) => (
                    <SummaryCard
                        label={fondo.caja?.nombre ?? 'Nombre'}
                        amount={fondo.monto_esperado}    
                        theme='danger'   
                    />
                ))}
            </div>

            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                <div className="flex flex-col md:flex-row justify-between items-end mb-6 border-b border-gray-200 pb-4">
                    <div>
                        <h1 className="text-3xl font-black text-gray-900">Contaduría</h1>
                        <p className="text-gray-500">Gestión de bóveda y flujo de efectivo</p>
                    </div>

                    <div className="flex flex-wrap gap-2 mt-4 md:mt-0 justify-end">
                        <PageButton active={vistaActiva === 'solicitudes'} onClick={() => setVistaActiva('solicitudes')}>
                            Solicitudes {solicitudesPendientes.length > 0 && (
                                <span className="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{solicitudesPendientes.length}</span>
                            )}
                        </PageButton>
                        <PageButton active={vistaActiva === 'diario'} onClick={() => setVistaActiva('diario')}>Diario</PageButton>
                        <PageButton active={vistaActiva === 'sesiones'} onClick={() => setVistaActiva('sesiones')}>Auditoría</PageButton>
                        
                        <div className="flex gap-2 ml-4">
                            <ModalOpenButton onClick={() => setIsGastoModalOpen(true)} variant='danger'>Gasto Bóveda</ModalOpenButton>
                            <ModalOpenButton onClick={() => setIsEnviarDineroFondo(true)} variant='success'>Enviar a Fondo</ModalOpenButton>
                        </div>
                    </div>
                </div>

                {/* VISTA: SOLICITUDES */}
                {vistaActiva === 'solicitudes' && (
                    <div className="bg-white rounded-2xl shadow-sm border border-gray-200 ">
                        <div className="bg-gray-50 px-6 py-4 border-b border-gray-200 font-bold text-gray-800">
                            Solicitudes de efectivo pendientes ({solicitudesPendientes.length})
                        </div>
                        {solicitudesPendientes.length > 0 ? (
                            <table className="min-w-full text-left">
                                <thead className="bg-white text-xs font-bold text-gray-500 uppercase">
                                    <tr>
                                        <th className="px-6 py-3">Destino / Concepto</th>
                                        <th className="px-6 py-3">Solicitante</th>
                                        <th className="px-6 py-3 text-right">Monto</th>
                                        <th className="px-6 py-3 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-100">
                                    {solicitudesPendientes.map((sol) => (
                                        <tr key={sol.id} className="hover:bg-gray-50">
                                            <td className="px-6 py-4">
                                                <div className="font-bold">{sol.caja_destino?.nombre}</div>
                                                <div className="text-xs text-gray-500">{sol.concepto}</div>
                                            </td>
                                            <td className="px-6 py-4 text-sm">{sol.usuario_solicita?.nombre_completo}</td>
                                            <td className="px-6 py-4 text-right font-black text-blue-600">${formatMoney(sol.monto_solicitado)}</td>
                                            <td className="px-6 py-4 text-center space-x-2">
                                                <button onClick={() => handleAprobar(sol)} className="bg-green-600 text-white px-3 py-1 rounded text-sm font-bold">Atender</button>
                                                <button onClick={() => handleRechazar(sol.id)} className="text-red-600 px-3 py-1 font-bold">Rechazar</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        ) : (
                            <div className="p-20 text-center text-gray-400">No hay solicitudes pendientes.</div>
                        )}
                    </div>
                )}

                {/* VISTA: DIARIO DE MOVIMIENTOS */}
                {vistaActiva === 'diario' && (
                    <div className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <SummaryCard label='Ingresos' amount={resumenHoy.ingresos} theme='success' mostrarValor={false}/>
                            <SummaryCard label='Egresos' amount={resumenHoy.egresos} theme='danger' mostrarValor={false}/>
                            <SummaryCard label='Neto' amount={resumenHoy.balance} mostrarValor={false}/>
                        </div>

                        <div className="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                            {/* Navegación por fecha */}
                            <div className="flex items-center justify-between p-4 border-b border-gray-200 bg-gray-50">
                                <h2 className="font-bold text-gray-800">Movimientos del día</h2>
                                <div className="flex items-center gap-2">
                                    <button 
                                        onClick={() => {
                                            const d = new Date(fechaFiltro + 'T00:00:00');
                                            d.setDate(d.getDate() - 1);
                                            handleFechaChange(d.toISOString().split('T')[0]);
                                        }}
                                        className="p-2 hover:bg-gray-200 rounded"
                                    >◀</button>
                                    <input 
                                        type="date" 
                                        value={fechaFiltro}
                                        onChange={(e) => handleFechaChange(e.target.value)}
                                        className="border-gray-300 rounded-lg text-sm font-bold text-blue-600"
                                    />
                                    <button 
                                        onClick={() => {
                                            const d = new Date(fechaFiltro + 'T00:00:00');
                                            d.setDate(d.getDate() + 1);
                                            handleFechaChange(d.toISOString().split('T')[0]);
                                        }}
                                        className="p-2 hover:bg-gray-200 rounded"
                                    >▶</button>
                                </div>
                            </div>

                            {/* Filtros de tipo de caja */}
                            <div className="p-2 flex gap-2 border-b border-gray-100">
                                {(['todos', 'boveda', 'operativo'] as const).map((f) => (
                                    <button
                                        key={f}
                                        onClick={() => setFiltroActivo(f)}
                                        className={`px-4 py-1.5 rounded-lg text-xs font-bold uppercase transition-colors ${
                                            filtroActivo === f ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'
                                        }`}
                                    >
                                        {f === 'todos' ? 'Ver todo' : f === 'boveda' ? 'Solo Bóveda' : 'Caja y Fondo'}
                                    </button>
                                ))}
                            </div>

                            {filteredMovimientos.length > 0 ? (
                                <>
                                <div className="overflow-x-auto">
                                    <table className="min-w-full text-left">
                                        <thead className="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                                            <tr>
                                                <th className="px-6 py-3">Hora</th>
                                                <th className="px-6 py-3">Caja</th>
                                                <th className="px-6 py-3">Nombre del personal</th>
                                                <th className="px-6 py-3">Área</th>
                                                <th className="px-6 py-3">Concepto</th>
                                                <th className="px-6 py-3">Descripción</th>
                                                <th className="px-6 py-3">Factura</th>
                                                <th className="px-6 py-3">Paciente</th>
                                                <th className="px-6 py-3 text-right">Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody className="divide-y divide-gray-100">
                                            {filteredMovimientos.map((mov) => (
                                                <tr key={mov.id} className="hover:bg-gray-50 text-sm">
                                                    <td className="px-6 py-4 text-gray-400">
                                                        {new Date(mov.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                                    </td>
                                                    <td className="px-6 py-4 font-bold justify-center text-center">
                                                        <span className="inline-block px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm text-center">
                                                            {mov.sesion_caja?.caja?.nombre}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4 text-xs text-gray-500">{mov.user.nombre_completo || '-'}</td>
                                                    <td className="px-6 py-4 text-xs text-gray-500">{mov.area || '-'}</td>
                                                    <td className="px-6 py-4">
                                                        <div className="font-medium">{mov.concepto}</div>
                                                        <div className="text-[10px] text-gray-400 uppercase">{mov.metodo_pago?.nombre}</div>
                                                    </td>
                                                    <td className="px-6 py-4 font-bold">
                                                        {mov.descripcion}
                                                    </td>
                                                    <td className={`px-6 py-4 ${mov.factura ? 'text-green-600' : 'text-red-600'}`}>
                                                        <span className={`inline-block px-3 py-1 rounded-full bg-gray-100 ${mov.factura ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100'} text-sm`}>
                                                        {mov.factura ? 'Sí' : 'No'}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4">{mov.nombre_paciente || '-'}</td>
                                                    <td className={`px-6 p  y-4 text-right font-bold ${mov.tipo === 'ingreso' ? 'text-green-600' : 'text-red-600'}`}>
                                                        {mov.tipo === 'ingreso' ? '+' : '-'}${formatMoney(mov.monto)}
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                                <div className="flex justify-end mb-4">
                                    <button
                                        onClick={()=>exportarExcel(filteredMovimientos)}
                                        className="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-colors shadow-sm"
                                    >
                                        <svg className="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Exportar a Excel
                                    </button>
                                </div>
                            </>
                            ) : (
                                <div className="p-20 text-center text-gray-400 italic">No hay registros para la fecha {fechaFiltro}.</div>
                            )}
                        </div>
                    </div>
                )}

                {vistaActiva === 'sesiones' && <SesionesAudit sesiones={allSesiones} />}
            </div>

            {/* Modales */}
            {isEnviarDineroFondo && <ModalEnviarBovedaAFondo onClose={() => setIsEnviarDineroFondo(false)} boveda={sesion} fondos={fondos}/>}
            {isGastoModalOpen && <ModalGastoBoveda onClose={() => setIsGastoModalOpen(false)} sesionBovedo={sesion}/>}
        </MainLayout>
    );
}