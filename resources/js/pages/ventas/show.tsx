import React, { useState } from 'react';
import { route } from 'ziggy-js';
import { useForm, Head } from '@inertiajs/react';
import { CreditCard, Hash, X } from 'lucide-react'; 
import { MetodoPago, TicketCajero, Venta, Pago, ProductoServicio } from '@/types';
import { usePage } from '@inertiajs/react';
import { useEffect } from 'react';

import Modal from '@/components/modal';
import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import MainLayout from '@/layouts/MainLayout';
import Ticket from '@/components/ticket';
import InputBoolean from '@/components/ui/input-boolean';
import InputSelect from '@/components/ui/input-select';
import TicketPagoCajero from '@/components/tickets/ticket-pago-cajero';
import productoServicios from '@/routes/producto-servicios';

const formatCurrency = (amount: number | string) => {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2
    }).format(Number(amount));
};

const InfoCard = ({ title, children, icon: Icon }: any) => (
    <div className="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-col">
        <div className="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
            {Icon && <div className="p-2 bg-blue-50 text-blue-600 rounded-lg"><Icon size={18} /></div>}
            <h3 className="font-bold text-gray-800 text-lg">{title}</h3>
        </div>
        <div className="p-6 flex-1">
            {children}
        </div>
    </div>
);

const InfoField = ({ label, value }: { label: string, value: React.ReactNode }) => (
    <div className="mb-4 last:mb-0">
        <p className="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">{label}</p>
        <p className="text-gray-900 font-medium text-base">{value || 'N/A'}</p>
    </div>
);

const MoneyRow = ({ label, amount, isTotal = false, isDeduction = false }: any) => {
    let colorClass = "text-gray-900";
    if (isDeduction) colorClass = "text-green-600";

    return (
        <div className={`flex justify-between items-center py-3 ${isTotal ? 'border-t-2 border-gray-100 mt-2 pt-4' : 'border-b border-gray-50 last:border-0'}`}>
            <span className={`${isTotal ? 'font-bold text-gray-800 text-lg' : 'text-gray-500 text-sm'}`}>
                {label}
            </span>
            <span className={`tabular-nums tracking-tight ${isTotal ? 'text-xl font-bold' : 'font-medium'} ${colorClass}`}>
                {isDeduction && '- '}{formatCurrency(amount)}
            </span>
        </div>
    );
};

interface Props {
    venta: Venta; 
    metodosPago: MetodoPago[];
    ticket: TicketCajero;
    pago: Pago;
    productosServicio: ProductoServicio;
}

const Show = ({ 
    venta,
    metodosPago,
}: Props) => { 

    const [showModal, setShowModal] = useState(false);
    const [ticketCajero, setTicketCajero] = useState<TicketCajero | null>(null);
    const [pagoReciente, setPagoReciente] = useState<Pago | null>(null);
    const [montoTicket, setMontoTicket] = useState<number>(0);  
    
    const metodoPagoOptions = metodosPago.map((mp) => ({label: mp.nombre, value: mp.id}));
    
    const { data, setData, post, processing, errors, reset } = useForm({
        requiere_factura: venta.requiere_factura || false, 
        metodo_pago_id: '',
        detalles_pago: venta.detalles?.map(detalle => ({
            detalle_venta_id: detalle.id,
            monto_aplicado: ''
        })) || [],
        generar_qr: false,
    });

    const handlePagarTotal = (index: number) => {
        const nuevosDetalles = [...data.detalles_pago];
        const saldoItem = Number(venta.detalles[index].saldo_pendiente);
        nuevosDetalles[index].monto_aplicado = String(saldoItem);
        setData('detalles_pago', nuevosDetalles);
    }

    const handleDetalleChange = (index: number, value: string) => {
        const nuevosDetalles = [...data.detalles_pago];
        nuevosDetalles[index].monto_aplicado = value;
        setData('detalles_pago', nuevosDetalles);
    };

    const totalAbonoActual = data.detalles_pago.reduce((sum, item) => {
        return sum + (Number(item.monto_aplicado) || 0);
    }, 0);

    const handleSubmitPago = (e: React.FormEvent) => {
        e.preventDefault();
        if (totalAbonoActual <= 0) return alert('Debes ingresar un monto a pagar');
        post(route('ventas.pagar', venta.id), {
            onSuccess: (page) => {
                setShowModal(false); 
                
                const flash = page.props.flash as any;
                
                if (flash && flash.ticket && flash.ticket.success) {
                    setTicketCajero(flash.ticket);
                    setMontoTicket(totalAbonoActual); 
                }

                reset();
                const detallesLimpios = data.detalles_pago.map(detalle => ({
                    ...detalle,
                    monto_aplicado: '' 
                }));
                setData('detalles_pago', detallesLimpios);
            }
        });
    }

    const { props } = usePage();
    const flash = props.flash as any;

    useEffect(() => {
        if (flash && flash.success) {
            if (flash.ticket && flash.ticket.success) {
                setTicketCajero(flash.ticket);
                setPagoReciente(flash.pago);
                setMontoTicket(flash.pago?.monto || totalAbonoActual); 
            }
        }
    }, [flash]);
    const IVA = .16;
    const ivaCalculado = ( venta.total -venta.subtotal ) ;

    return (
        <MainLayout 
            pageTitle={`Consulta venta #${venta.id}`}  
            link="pacientes.estancias.ventas.index"      
            linkParams={{ paciente: venta.estancia.paciente.id, estancia: venta.estancia.id, venta: venta.id }}
        >
            

            <Head title={`Consulta de venta #${venta.id}`}/>
           <div className={`max-w-5xl mx-auto space-y-6 pb-10 ${ticketCajero ? 'print:hidden' : ''}`}>
                <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div>
                        <div className="flex items-center gap-3 mb-1">
                            <span className="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full border border-indigo-200">
                                VENTA #{venta.id.toString().padStart(6, '0')}
                            </span>
                            <span className={`px-3 py-1 text-xs font-bold rounded-full border ${
                                venta.saldo_pendiente > 0 
                                ? 'bg-yellow-100 text-yellow-800 border-yellow-200' 
                                : 'bg-green-100 text-green-800 border-green-200'
                            }`}>
                                {venta.estado.toUpperCase()}
                            </span>
                        </div>
                        <h1 className="text-2xl font-bold text-gray-900">Detalle de operación</h1>
                        
                    </div>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <InfoCard title="Datos de la transacción" icon={Hash}>
                        <div className="grid grid-cols-1 gap-6">
                            <InfoField 
                                label="Fecha y hora de creación" 
                                value={new Date(venta.fecha).toLocaleString('es-MX', { dateStyle: 'long', timeStyle: 'short' })} 
                            />
                            <div className="grid grid-cols-2 gap-4">
                                <InfoField label="Folio de estancia" value={venta.estancia.folio} />
                                
                            </div>
                            <InfoField label="Cliente/Paciente" value={`${venta.estancia.paciente.nombre} ${venta.estancia.paciente.apellido_paterno} ${venta.estancia.paciente.apellido_materno}`} />
                        </div>
                    </InfoCard>
                    <InfoCard title="Resumen económico" icon={CreditCard}>

                        <div className="bg-gray-50 p-6 rounded-lg border border-gray-100 mb-6 flex flex-col items-center justify-center text-center">
                            <span className="text-sm font-semibold text-gray-400 uppercase tracking-wider">Monto Total a Cubrir</span>
                            <span className="text-4xl font-extrabold text-gray-900 mt-2 tracking-tight">
                                {formatCurrency(venta.total)}
                            </span>
                        </div>
                        <div className="space-y-1 px-2">
                            <MoneyRow label="Subtotal" amount={venta.subtotal} />
                            {Number(venta.descuento) > 0 && (
                                <MoneyRow label="Descuento" amount={venta.descuento} isDeduction />
                            )}
                            <MoneyRow label="Impuestos (IVA)" amount={ivaCalculado} />
                            <MoneyRow label="Total Neto" amount={venta.total} isTotal />

                            <div className="border-t border-dashed border-gray-300 my-4"></div>

                            <MoneyRow label="Pagado / Abonado" amount={venta.total_pagado} isDeduction />

                            <div className={`mt-4 p-4 rounded-lg flex justify-between items-center ${
                                venta.saldo_pendiente > 0 ? 'bg-red-50 border border-red-100' : 'bg-green-50 border border-green-100'
                            }`}>
                                <span className={`font-bold ${venta.saldo_pendiente > 0 ? 'text-red-700' : 'text-green-700'}`}>
                                    {venta.saldo_pendiente > 0 ? 'PENDIENTE' : 'LIQUIDADO'}
                                </span>
                                <span className={`text-xl font-bold ${venta.saldo_pendiente > 0 ? 'text-red-700' : 'text-green-700'}`}>
                                    {formatCurrency(venta.saldo_pendiente)}
                                </span>
                            </div>
                        </div>
                        {Number(venta.saldo_pendiente) > 0 && (
                            <div className="mt-6 pt-6 border-t border-gray-100">
                                <PrimaryButton 
                                    onClick={() => setShowModal(true)}
                                    className="w-full justify-center h-12 text-base shadow-lg shadow-indigo-200"
                                >
                                    Registrar nuevo pago
                                </PrimaryButton>
                            </div>
                        )}
                    </InfoCard>
                </div>

               <Modal show={showModal} onClose={() => setShowModal(false)} maxWidth="2xl">
                <div className="p-6">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-lg font-bold text-gray-900">Registrar abono por concepto</h2>
                        <button onClick={() => setShowModal(false)} className="text-gray-400 hover:text-gray-600">
                            <X size={20} />
                        </button>
                    </div>

                    <form onSubmit={handleSubmitPago}>
                        <div className="mb-6 max-h-64 overflow-y-auto pr-2">
                            <table className="w-full text-sm text-left text-gray-500">
                                <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th className="px-4 py-3">Concepto</th>
                                        <th className="px-4 py-3 text-right">Saldo pendiente</th>
                                        <th className="px-4 py-3 text-right w-40">Abonar ahora</th>
                                        <th>Operaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {venta.detalles?.map((detalle, index) => {
                                        
                                        const saldoItem = Number(detalle.saldo_pendiente);
                                        if (saldoItem <= 0) return null;

                                        return (
                                            <tr key={detalle.id} className="border-b">
                                                <td className="px-4 py-3 font-medium text-gray-900">
                                                    {detalle.nombre_producto_servicio}
                                                </td>
                                                <td className="px-4 py-3 text-right text-red-600 font-medium">
                                                    {formatCurrency(saldoItem)}
                                                </td>
                                                <td className="px-4 py-3">
                                                    <InputText
                                                        id={`monto_${detalle.id}`}
                                                        name={`monto_${detalle.id}`}
                                                        label=''
                                                        value={data.detalles_pago[index].monto_aplicado}
                                                        onChange={(e) => handleDetalleChange(index, e.target.value)}
                                                        type="number"
                                                        placeholder="0.00"
                                                        error={errors.detalles_pago}
                                                        max={saldoItem} 
                                                    />
                                                </td>
                                                <td className="px-4 py-3 text-center align-middle">
                                                    <button 
                                                        type="button" 
                                                        onClick={() => handlePagarTotal(index)}
                                                        className="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded hover:bg-blue-200"
                                                    >
                                                        Liquidar
                                                    </button>
                                                </td>
                                            </tr>
                                        )
                                    })}
                                </tbody>
                            </table>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                            <div>
                                <InputSelect
                                    options={metodoPagoOptions}
                                    label='Método de pago'
                                    value={data.metodo_pago_id}
                                    onChange={e=>setData('metodo_pago_id',e)}
                                    error={errors.metodo_pago_id}
                                />
                                <div className="mt-4">
                                    <InputBoolean
                                        label='Requiere factura'
                                        value={data.requiere_factura}
                                        onChange={e=>setData('requiere_factura',e)}
                                        error={errors.requiere_factura}
                                    />
                                </div>
                                <div>
                                    <InputBoolean
                                        label='Generar código QR'
                                        value={data.generar_qr}
                                        onChange={e=>setData('generar_qr',e)}
                                        error={errors.generar_qr}
                                    />
                                </div>
                            </div>
                            <div className="flex flex-col justify-center items-end bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <span className="text-sm font-semibold text-blue-800">Total a cobrar ahora:</span>
                                <span className="text-3xl font-bold text-blue-900">{formatCurrency(totalAbonoActual)}</span>
                            </div>
                        </div>

                        <div className="flex justify-end gap-3 mt-6">
                            <PrimaryButton type="submit" disabled={processing || totalAbonoActual <= 0}>
                                {processing ? 'Procesando...' : 'Confirmar pago'}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>
                <Modal show={!!ticketCajero} onClose={() => setTicketCajero(null)} maxWidth="sm">
                    <div className="p-6 relative">
                        <button 
                            onClick={() => setTicketCajero(null)} 
                            className="absolute top-4 right-4 text-gray-400 hover:text-gray-600 print:hidden"
                        >
                            <X size={20} />
                        </button>
                        
                        {ticketCajero && pagoReciente && (
                            <TicketPagoCajero
                                ticket={ticketCajero}
                                pago={pagoReciente}
                            />
                        )}
                    </div>
                </Modal>
            </div>

            <InfoCard title="Historial de recibos / pagos" icon={CreditCard}>
                {venta.pagos && venta.pagos.length > 0 ? (
                    <div className="space-y-4">
                        {venta.pagos.map((pago) => (
                            <div key={pago.id} className="flex justify-between items-center p-4 border border-gray-200 rounded-lg bg-white shadow-sm">
                                <div>
                                    <div className="flex items-center gap-2">
                                        <span className="font-bold text-gray-800">{pago.folio}</span>
                                        <span className="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                            {pago.metodo_pago?.nombre}
                                        </span>
                                    </div>
                                    <p className="text-sm text-gray-500 mt-1">
                                        {new Date(pago.created_at).toLocaleDateString('es-MX')} - {pago.detalles?.length} concepto(s)
                                    </p>
                                    <span className="font-bold text-green-600 text-lg">
                                        + {formatCurrency(pago.monto)}
                                    </span>
                                </div>
                                

                               <Ticket 
                                    pago={pago} 
                                />
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="text-center p-6 text-gray-400">
                        No hay pagos registrados para esta venta.
                    </div>
                )}
            </InfoCard>

        </MainLayout>
    );
}

export default Show;