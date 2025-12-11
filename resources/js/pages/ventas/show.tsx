import React, { useState } from 'react';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/react';
import { CreditCard, Hash, X } from 'lucide-react'; 

import Modal from '@/components/modal';
import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import MainLayout from '@/layouts/MainLayout';


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


const Show = ({ venta }: { venta: any }) => { 

    const [showModal, setShowModal] = useState(false);
    
    const { data, setData, post, processing, errors, reset } = useForm({
        total_pagado: ''
    });

    const handleSubmitPago = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('ventas.pagar', venta.id), {
            onSuccess: () => {
                setShowModal(false);
                reset();
            }
        });
    };

    const ivaCalculado = Number(venta.total) - Number(venta.subtotal);

    return (
        <MainLayout pageTitle={`Consulta venta #${venta.id}`}  >
        <div className="max-w-5xl mx-auto space-y-6 pb-10">
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

            <Modal show={showModal} onClose={() => setShowModal(false)} maxWidth="md">
                <div className="p-6">
                    <div className="flex justify-between items-center mb-4">
                        <h2 className="text-lg font-bold text-gray-900">Registrar abono</h2>
                        <button onClick={() => setShowModal(false)} className="text-gray-400 hover:text-gray-600">
                            <X size={20} />
                        </button>
                    </div>

                    <div className="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <p className="text-sm text-blue-800 mb-1">Saldo pendiente actual:</p>
                        <p className="text-2xl font-bold text-blue-900">{formatCurrency(venta.saldo_pendiente)}</p>
                    </div>
                    <form onSubmit={handleSubmitPago}>
                        <div className="mb-4">
                            <label className="block text-sm font-medium text-gray-700 mb-1">
                                Cantidad a recibir ahora:
                            </label>
                        
                            <p className="text-xs text-gray-500 mb-2">
                                Ingresa el monto que el cliente está pagando en este momento. 
                                Puede ser menor al total para dejarlo como anticipo.
                            </p>

                            <InputText
                                id='total_pagado'
                                name='total_pagado'
                                label="Monto a pagar"
                                value={data.total_pagado}
                                onChange={value=>setData('total_pagado',value.target.value)}
                                type='number'
                                error={errors.total_pagado}
                            />
                        </div>

                        <div className="flex justify-end gap-3 mt-6">

                            <PrimaryButton type="submit" disabled={processing}>
                                {processing ? 'Procesando...' : 'Confirmar pago'}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
        </MainLayout>
    );
}

export default Show;