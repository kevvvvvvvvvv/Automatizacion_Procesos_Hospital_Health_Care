import React from "react";
import { Head, useForm } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { route } from "ziggy-js";
import { Calendar, User, Lock, Eye } from "lucide-react";
import InfoField from "@/components/ui/info-field";

import { Elements } from '@stripe/react-stripe-js';
import { stripePromise } from '@/lib/stripe'; 
import PaymentForm from '@/components/payment-form/payment-form';

interface Props {
  reservacion: any;
  user: any;
  horarios: any[];
}

const ShowReservacion = ({ reservacion, user, horarios }: Props) => {
  if (!reservacion) return <div className="p-10 text-center">Cargando...</div>;

  const colorPalette = [
    { bg: 'bg-indigo-50', text: 'text-indigo-600', border: 'border-indigo-200' },
    { bg: 'bg-emerald-50', text: 'text-emerald-600', border: 'border-emerald-200' },
    { bg: 'bg-amber-50', text: 'text-amber-600', border: 'border-amber-200' },
    { bg: 'bg-rose-50', text: 'text-rose-600', border: 'border-rose-200' },
    { bg: 'bg-cyan-50', text: 'text-cyan-600', border: 'border-cyan-200' },
  ];

  const consultoriosUnicos = Array.from(new Set(horarios.map(h => h.habitacion?.identificador)));
  const colorMap: Record<string, typeof colorPalette[0]> = {};
  
  consultoriosUnicos.forEach((id, index) => {
    colorMap[id || "S/A"] = colorPalette[index % colorPalette.length];
  });


  const precioPorBloque = 100; 
  const totalPagar = (horarios?.length || 0) * precioPorBloque;

  return (
    <MainLayout pageTitle="Detalles de Reservación" link="reservaciones.index">
      <Head title={`Reservación #${reservacion.id}`} />

      <div className="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        {/* Cambiamos a grid-cols-12 para mejor control de anchos */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          {/* COLUMNA IZQUIERDA: Información y Pago (Ocupa 4 de 12 en desktop) */}
          {/* En móvil aparece primero. Usamos 'order-1' explícito si fuera necesario */}
          <div className="lg:col-span-4 space-y-6">
            
            {/* Información General */}
            <div className="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Información General</h3>
              <div className="space-y-6">
                <div className="flex items-start">
                  <div className="bg-slate-50 p-2 rounded-lg mr-4 shrink-0"><User className="text-slate-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Médico / Usuario</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">
                       {`${user.nombre} ${user.apellido_paterno}`}
                    </p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div className="bg-slate-50 p-2 rounded-lg mr-4 shrink-0"><Calendar className="text-slate-600" size={20} /></div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Fecha</p>
                    <p className="text-sm font-semibold text-gray-900">
                      {new Date(reservacion.fecha).toLocaleDateString("es-MX", { weekday: 'short', day: 'numeric', month: 'long', timeZone: 'UTC' })}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            {/* Alerta de Estatus Temporal */}
            {reservacion.estatus === 'pendiente' && (
              <div className="bg-amber-50 border border-amber-200 p-4 rounded-2xl">
                <p className="text-amber-800 text-xs font-bold uppercase flex items-center gap-2">
                  <Eye size={14} /> Reservación Temporal
                </p>
                <p className="text-amber-700 text-[11px] mt-1 leading-relaxed">
                  Los consultorios están apartados. Tienes 10 minutos para completar el pago o se liberarán automáticamente.
                </p>
              </div>
            )}

            {/* Estado del Pago */}
            <div className="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Resumen de Pago</h3>
              {reservacion.estatus === 'pagado' ? (
                <div className="bg-green-50 text-green-700 p-4 rounded-xl text-center font-bold border border-green-200 text-sm">
                  ¡Reservación pagada! ✅
                </div>
              ) : (
                <div className="overflow-hidden">
                  <div className="flex justify-between mb-4 px-1">
                    <span className="text-sm text-gray-500">Total a pagar:</span>
                    <span className="text-sm font-bold text-gray-900">${totalPagar}.00</span>
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
              <div className="px-4 sm:px-6 py-4 border-b border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50">
                <h3 className="font-bold text-gray-700 text-sm">Bloques horarios</h3>
                <div className="flex flex-wrap gap-1.5">
                   {consultoriosUnicos.map((id) => (
                     <span key={id} className={`text-[9px] px-2 py-0.5 rounded-full border ${colorMap[id || "S/A"].bg} ${colorMap[id || "S/A"].text} ${colorMap[id || "S/A"].border} font-bold`}>
                       {id}
                     </span>
                   ))}
                </div>
              </div>
              
              <div className="divide-y divide-gray-50">
                {horarios?.map((h: any, index: number) => {
                  const idConsultorio = h.habitacion?.identificador || "S/A";
                  const estilo = colorMap[idConsultorio];

                  return (
                    <div key={index} className="px-4 sm:px-6 py-4 flex justify-between items-center transition hover:bg-gray-50 gap-4">
                      <div className="flex items-center min-w-0">
                        {/* Indicador visual oculto en móviles muy pequeños para ahorrar espacio */}
                        <div className={`hidden xs:block w-1 h-10 rounded-full mr-3 sm:mr-4 ${estilo.text.replace('text', 'bg')}`} />
                        
                        <div className="bg-white border border-gray-200 text-gray-700 font-mono font-bold px-2 sm:px-3 py-1.5 rounded-lg text-xs sm:text-sm mr-3 sm:mr-4 shadow-sm shrink-0">
                          {new Date(h.fecha_hora).toLocaleTimeString("es-MX", { hour: '2-digit', minute: '2-digit' })}
                        </div>
                        
                        <div className="flex flex-col min-w-0">
                           <span className="text-gray-900 text-xs sm:text-sm font-medium truncate">Consulta</span>
                           <span className={`${estilo.text} text-[10px] font-bold uppercase`}>ID: {idConsultorio}</span>
                        </div>
                      </div>

                      <div className={`flex flex-col items-end px-3 sm:px-4 py-1 sm:py-2 rounded-xl border ${estilo.bg} ${estilo.border} shrink-0`}>
                        <span className={`text-[8px] sm:text-[9px] ${estilo.text} font-black uppercase tracking-tighter`}>Sala</span>
                        <span className={`font-bold ${estilo.text} text-sm sm:text-base`}>
                          {idConsultorio}
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