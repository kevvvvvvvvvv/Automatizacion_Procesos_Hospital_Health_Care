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

      <div className="max-w-6xl mx-auto p-4 md:p-8">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="md:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Información General</h3>
              <div className="space-y-6">
                <div className="flex items-center">
                  <div className="bg-slate-50 p-2 rounded-lg mr-4"><User className="text-slate-600" size={20} /></div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Médico / Usuario</p>
                    <InfoField label="" value={`${user.nombre} ${user.apellido_paterno}`}/>
                  </div>
                </div>
                <div className="flex items-center">
                  <div className="bg-slate-50 p-2 rounded-lg mr-4"><Calendar className="text-slate-600" size={20} /></div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Fecha</p>
                    <p className="text-sm font-semibold text-gray-900">
                      {new Date(reservacion.fecha).toLocaleDateString("es-MX", { weekday: 'long', day: 'numeric', month: 'long', timeZone: 'UTC' })}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div className="md:col-span-1 space-y-6">
            {reservacion.estatus === 'pendiente' && (
                <div className="bg-amber-50 border border-amber-200 p-4 rounded-2xl">
                    <p className="text-amber-800 text-xs font-bold uppercase flex items-center gap-2">
                        <Eye size={14} /> Reservación Temporal
                    </p>
                    <p className="text-amber-700 text-[11px] mt-1">
                        Los consultorios están apartados. Tienes 10 minutos para completar el pago o se liberarán automáticamente.
                    </p>
                </div>
            )}
            </div>
            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Estado del Pago</h3>
              {reservacion.estatus === 'pagado' ? (
                  <div className="bg-green-50 text-green-700 p-4 rounded-xl text-center font-bold border border-green-200">
                      ¡Reservación Pagada! ✅
                  </div>
              ) : (
                  <>
                      <Elements stripe={stripePromise}>
                          <PaymentForm 
                              reservacione={reservacion.id} 
                              monto={totalPagar} 
                          />
                      </Elements>
                  </>
              )}
            </div>
          </div>

          <div className="md:col-span-2">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              <div className="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <h3 className="font-bold text-gray-700 text-sm">Bloques Horarios</h3>
                <div className="flex gap-2">
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
                    <div key={index} className={`px-6 py-4 flex justify-between items-center transition hover:bg-gray-50`}>
                      <div className="flex items-center">
                        <div className={`w-1 h-10 rounded-full mr-4 ${estilo.text.replace('text', 'bg')}`} />
                        
                        <div className="bg-white border border-gray-200 text-gray-700 font-mono font-bold px-3 py-1.5 rounded-lg text-sm mr-4 shadow-sm">
                          {new Date(h.fecha_hora).toLocaleTimeString("es-MX", { hour: '2-digit', minute: '2-digit' })}
                        </div>
                        <div className="flex flex-col">
                           <span className="text-gray-900 text-sm font-medium">Bloque de consulta</span>
                           <span className={`${estilo.text} text-[10px] font-bold uppercase`}>{idConsultorio}</span>
                        </div>
                      </div>

                      <div className={`flex flex-col items-end px-4 py-2 rounded-xl border ${estilo.bg} ${estilo.border}`}>
                        <span className={`text-[9px] ${estilo.text} font-black uppercase tracking-tighter`}>Consultorio</span>
                        <span className={`font-bold ${estilo.text} text-base`}>
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