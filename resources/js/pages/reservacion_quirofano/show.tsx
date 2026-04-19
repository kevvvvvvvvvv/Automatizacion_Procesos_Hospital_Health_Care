import React from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { Activity, Stethoscope, Briefcase, ClipboardList, AlertCircle, CheckCircle2, Clock } from "lucide-react";
import { ReservacionQuirofano, User } from "@/types";

interface Props {
  quirofano: ReservacionQuirofano;
  user: User;      
  horarios: any[]; 
}

const ShowQuirofano = ({ quirofano, user, horarios }: Props) => {
  if (!quirofano) return <div className="p-10 text-center">Cargando...</div>;

  // Lógica de colores para el Status
  const statusStyles = {
    pendiente: { bg: 'bg-amber-50', text: 'text-amber-700', border: 'border-amber-200', icon: <Clock size={16} /> },
    completada: { bg: 'bg-green-50', text: 'text-green-700', border: 'border-green-200', icon: <CheckCircle2 size={16} /> },
    cancelada: { bg: 'bg-red-50', text: 'text-red-700', border: 'border-red-200', icon: <AlertCircle size={16} /> },
  };

  const currentStatus = statusStyles[quirofano.status as keyof typeof statusStyles] || statusStyles.pendiente;

  const fechaFormateada = new Date(quirofano.fecha).toLocaleDateString("es-MX", { 
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' 
  });

  return (
    <MainLayout pageTitle="Detalles de Cirugía" link="quirofanos.index">
      <Head title={`Cirugía - ${quirofano.paciente}`} />

      <div className="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        {/* Banner de Cancelación (Solo visible si está cancelada) */}
       {quirofano.status === 'cancelada' && (
        <div className="mb-6 flex items-start gap-4 p-5 bg-red-50 border-2 border-red-200 rounded-2xl shadow-sm">
          <div className="bg-red-100 p-3 rounded-full">
            <AlertCircle className="text-red-600 shrink-0" size={28} />
          </div>
          <div className="flex-1">
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
              <h3 className="text-red-800 font-black text-lg uppercase tracking-tight">
                Atención: Cirugía Cancelada
              </h3>
              
            </div>
            
            <p className="text-red-700 text-sm mt-2 leading-relaxed">
              Esta reservación programada para el día <span className="font-bold underline">{fechaFormateada}</span> ha sido cancelada y los horarios han sido liberados.
            </p>
            
            {quirofano.motivo_cancelacion && (
              <div className="mt-3 pt-3 border-t border-red-200">
                <p className="text-red-800 text-xs">
                  <span className="font-black uppercase">Motivo de la cancelación:</span>
                  <br />
                  <span className="italic">"{quirofano.motivo_cancelacion}"</span>
                </p>
              </div>
            )}
          </div>
        </div>
      )}

        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          {/* COLUMNA IZQUIERDA */}
          <div className="lg:col-span-4 space-y-6">
            
            {/* Tarjeta de Estado */}
            <div className={`p-6 rounded-2xl border ${currentStatus.bg} ${currentStatus.border} flex items-center justify-between`}>
                <div>
                    <p className={`text-[11px] font-black uppercase ${currentStatus.text} opacity-70`}>Estado Actual</p>
                    <p className={`text-lg font-bold capitalize ${currentStatus.text}`}>{quirofano.status}</p>
                </div>
                <div className={`${currentStatus.text}`}>
                    {currentStatus.icon}
                </div>
            </div>

            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Personal Asignado</h3>
              <div className="space-y-6">
                <div className="flex items-start">
                  <div className="bg-blue-50 p-2 rounded-lg mr-4 shrink-0"><Stethoscope className="text-blue-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Médico Tratante</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">
                        {quirofano.medico_tratante?.nombre_completo || "No asignado"}
                    </p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div className="bg-indigo-50 p-2 rounded-lg mr-4 shrink-0"><Briefcase className="text-indigo-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Cirujano</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">
                        {quirofano.medico_operacion_rel?.nombre_completo || "No asignado"}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* COLUMNA DERECHA */}
          <div className="lg:col-span-8 space-y-6">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              <div className="px-6 py-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <h3 className="font-bold text-gray-700 text-sm flex items-center gap-2">
                  <Activity size={18} className="text-rose-500" /> Datos del Procedimiento
                </h3>
                <span className="text-xs font-bold text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200">
                  ID: #{quirofano.id}
                </span>
              </div>
              
              <div className="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                  <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Paciente</label>
                  <p className="text-lg font-bold text-gray-900">{quirofano.paciente}</p>
                </div>
                <div>
                  <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Procedimiento</label>
                  <p className="text-lg font-bold text-indigo-600">{quirofano.procedimiento}</p>
                </div>
                <div>
                  <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Fecha Programada</label>
                  <p className="text-sm font-semibold text-gray-700 capitalize">{fechaFormateada}</p>
                </div>
                <div>
                  <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Tiempo Estimado</label>
                  <p className="text-sm font-semibold text-gray-700">{quirofano.tiempo_estimado} Horas</p>
                </div>
              </div>

              <div className="px-6 pb-6">
                <label className="text-[11px] text-gray-400 uppercase font-black block mb-3">Requerimientos y Servicios</label>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <ServiceBadge label="Anestesiólogo" value={quirofano.anestesiologo} />
                  <ServiceBadge label="Instrumentista" value={quirofano.instrumentista} />
                  <ServiceBadge label="Rayos X" value={quirofano.rayosx_detalle} />
                  <ServiceBadge label="Laparoscopia" value={quirofano.laparoscopia_detalle} />
                  <ServiceBadge label="Patología" value={quirofano.patologico_detalle} />
                  <ServiceBadge label="Insumos" value={quirofano.insumos_medicamentos} />
                </div>
              </div>

              {quirofano.comentarios && (
                <div className="px-6 pb-6">
                    <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Comentarios Adicionales</label>
                    <div className="p-3 bg-gray-50 rounded-xl text-sm text-gray-600 border border-gray-100 italic">
                        "{quirofano.comentarios}"
                    </div>
                </div>
              )}
            </div>

            {/* Bloques de Tiempo */}
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              <div className="px-6 py-4 border-b border-gray-50 bg-gray-50/50">
                <h3 className="font-bold text-gray-700 text-sm flex items-center gap-2">
                  <ClipboardList size={18} className="text-cyan-500" /> Bloques Horarios Reservados
                </h3>
              </div>
              <div className="divide-y divide-gray-50">
                {quirofano.horarios?.map((hora: string, idx: number) => (
                  <div key={idx} className={`px-6 py-4 flex items-center justify-between transition-colors ${quirofano.status === 'cancelada' ? 'opacity-50' : 'hover:bg-gray-50'}`}>
                    <div className="flex items-center gap-4">
                      <div className={`w-2 h-2 rounded-full ${quirofano.status === 'cancelada' ? 'bg-gray-300' : 'bg-cyan-400'}`} />
                      <span className="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                        {hora.split(' ')[1].substring(0, 5)} hrs
                      </span>
                      <span className="text-xs text-gray-500 font-medium">Uso de Quirófano</span>
                    </div>
                    <span className={`text-[10px] font-bold uppercase px-2 py-1 rounded border ${
                        quirofano.status === 'cancelada' 
                        ? 'text-gray-400 bg-gray-50 border-gray-200' 
                        : 'text-cyan-600 bg-cyan-50 border-cyan-100'
                    }`}>
                      {quirofano.status === 'cancelada' ? 'Liberado' : 'Reservado'}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
};

const ServiceBadge = ({ label, value }: { label: string, value: string | null }) => {
  const activo = value && value.trim() !== "" && value !== "0" && value.toLowerCase() !== "no";
  return (
    <div className={`flex flex-col p-3 rounded-xl border ${activo ? 'bg-white border-gray-200 shadow-sm' : 'bg-gray-50 border-gray-100 opacity-60'}`}>
      <span className="text-[10px] font-bold text-gray-400 uppercase">{label}</span>
      <span className={`text-xs font-semibold mt-0.5 ${activo ? 'text-gray-900' : 'text-gray-400 italic'}`}>
        {activo ? value : "No solicitado"}
      </span>
    </div>
  );
};

export default ShowQuirofano;