import React from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { Calendar, User, Clock , MapPin } from "lucide-react";
import { route } from 'ziggy-js'

import { Elements } from '@stripe/react-stripe-js';
import { stripePromise } from '@/lib/stripe'; 
import PaymentForm from '@/components/payment-form/payment-form';
import { Reservacion } from "@/types";

interface Props {
    reservacion: Reservacion;
    expira_en?: string; 
}

const ShowReservacion = ({ reservacion,expira_en  }: Props) => {
    if (!reservacion) return <div className="p-10 text-center">Cargando...</div>;

    const totalPagar = Number(reservacion.pago_total); 

    const consultoriosUnicos = Array.from(
        new Set(reservacion.horarios.map(h => h.habitacion_precio.habitacion.identificador || "General"))
    );

    const colorPalette = [
        { bg: 'bg-indigo-50', text: 'text-indigo-600', border: 'border-indigo-200' },
        { bg: 'bg-emerald-50', text: 'text-emerald-600', border: 'border-emerald-200' },
        { bg: 'bg-amber-50', text: 'text-amber-600', border: 'border-amber-200' },
        { bg: 'bg-rose-50', text: 'text-rose-600', border: 'border-rose-200' },
    ];

    const colorMap: Record<string, typeof colorPalette[0]> = {};
    consultoriosUnicos.forEach((id, index) => {
        colorMap[id] = colorPalette[index % colorPalette.length];
    });

    const tiempoAgotado = expira_en ? new Date(expira_en) < new Date() : false;


    return (
        <MainLayout pageTitle="Detalles de Reservación" link="reservaciones.index">
            <Head title={`Reservación #${reservacion.id}`} />

            <div className="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    <div className="lg:col-span-4 space-y-6">
                        <div className="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Información General</h3>
                            <div className="space-y-6">
                                <div className="flex items-start">
                                    <div className="bg-slate-50 p-2 rounded-lg mr-4 shrink-0"><User className="text-slate-600" size={20} /></div>
                                    <div className="min-w-0 flex-1">
                                        <p className="text-[11px] text-gray-400 uppercase font-bold">Cliente</p>
                                        <p className="text-sm font-semibold text-gray-900 truncate">
                                            {`${reservacion.user.nombre} ${reservacion.user.apellido_paterno} ${reservacion.user.apellido_materno}`}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-start">
                                    <div className="bg-slate-50 p-2 rounded-lg mr-4 shrink-0"><Calendar className="text-slate-600" size={20} /></div>
                                    <div>
                                        <p className="text-[11px] text-gray-400 uppercase font-bold">Fecha Reservada</p>
                                        <p className="text-sm font-semibold text-gray-900 capitalize">
                                            {new Date(reservacion.fecha + "T00:00:00").toLocaleDateString("es-MX", { weekday: 'long', day: 'numeric', month: 'long' })}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div className="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Estado de Cuenta</h3>
                            
                            {reservacion.estatus === 'pagado' ? (
                                <div className="bg-green-50 text-green-700 p-4 rounded-xl text-center font-bold border border-green-200 text-sm flex flex-col items-center gap-2">
                                    <span>¡Reservación Pagada! ✅</span>
                                    <span className="text-xs font-normal opacity-80">Monto: ${totalPagar.toFixed(2)}</span>
                                </div>
                            ) : tiempoAgotado || reservacion.estatus === 'expirada' ? (
                                <div className="bg-red-50 text-red-600 p-6 rounded-xl text-center border border-red-100 flex flex-col items-center gap-3">
                                    <div className="bg-white p-2 rounded-full shadow-sm">
                                        <Clock size={24} className="text-red-500" />
                                    </div>
                                    <div>
                                        <p className="font-bold text-sm">El tiempo de espera terminó</p>
                                        <p className="text-xs opacity-80 mt-1">
                                            Los horarios han sido liberados para otros usuarios.
                                        </p>
                                    </div>
                                    <a 
                                        href={route('reservaciones.create')} 
                                        className="mt-2 text-xs bg-red-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-700 transition"
                                    >
                                        Intentar de nuevo
                                    </a>
                                </div>
                            ) : (
                                <div className="overflow-hidden">
                                    <div className="flex justify-between items-end mb-6 px-1 border-b pb-4 border-dashed border-gray-200">
                                        <span className="text-sm text-gray-500">Total a pagar:</span>
                                        <span className="text-2xl font-black text-gray-900">${totalPagar.toFixed(2)}</span>
                                    </div>

                                    <Elements stripe={stripePromise}>
                                        <PaymentForm reservacione={reservacion.id} monto={totalPagar} />
                                    </Elements>
                                </div>
                            )}
                        </div>
                    </div>
                    <div className="lg:col-span-8">
                        <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div className="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div className="flex items-center gap-3">
                                    <h3 className="font-bold text-gray-700 text-sm">Resumen de salas</h3>
                                    <span className="bg-white border border-gray-200 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        {reservacion.horarios.length/2} hrs
                                    </span>
                                </div>
                                <div className="flex flex-wrap gap-2">
                                    {consultoriosUnicos.map((id) => {
                                        const estilo = colorMap[id] || colorPalette[0];
                                        return (
                                            <span key={id} className={`text-[10px] px-2 py-1 rounded-md border ${estilo.bg} ${estilo.text} ${estilo.border} font-bold uppercase tracking-wide`}>
                                                {id}
                                            </span>
                                        );
                                    })}
                                </div>
                            </div>
                            <div className="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                                <h3 className="font-bold text-gray-700 text-sm">Desglose de horarios</h3>
                                <span className="bg-white border border-gray-200 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-md uppercase">
                                    {reservacion.horarios.length} Bloques
                                </span>
                            </div>
                            
                            <div className="divide-y divide-gray-50">
                                {reservacion.horarios.map((h) => {
                                    const nombreConsultorio = h.habitacion_precio.habitacion.identificador || "Consultorio";
                                    const horaInicio = h.habitacion_precio.horario_inicio;
                                    const estilo = colorMap[nombreConsultorio] || colorPalette[0];

                                    return (
                                        <div key={h.id} className="px-6 py-4 flex justify-between items-center transition hover:bg-gray-50 gap-4 group">
                                            <div className="flex items-center min-w-0">
                                                {/* Hora */}
                                                <div className="bg-white border border-gray-200 text-gray-700 font-mono font-bold px-3 py-2 rounded-lg text-sm mr-4 shadow-sm shrink-0 group-hover:border-indigo-300 transition-colors">
                                                    {horaInicio.slice(0, 5)} hrs
                                                </div>
                                                
                                                <div className="flex flex-col min-w-0">
                                                    <span className="text-gray-900 text-sm font-medium truncate flex items-center gap-2">
                                                        Consulta general
                                                    </span>
                                                    <span className={`${estilo.text} text-[10px] font-bold uppercase flex items-center gap-1 mt-0.5`}>
                                                        <MapPin size={10} /> {h.habitacion_precio.habitacion.ubicacion}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className={`flex flex-col items-end px-4 py-2 rounded-xl border ${estilo.bg} ${estilo.border} shrink-0`}>
                                                <span className={`text-[8px] ${estilo.text} font-black uppercase tracking-tighter opacity-70`}>Asignado a</span>
                                                <span className={`font-bold ${estilo.text} text-sm`}>
                                                    {nombreConsultorio}
                                                </span>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </MainLayout>
    );
};

export default ShowReservacion;