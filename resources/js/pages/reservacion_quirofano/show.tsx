import React from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { Calendar, User, Activity, Stethoscope, Briefcase, ClipboardList } from "lucide-react";

// Estructura de Props
interface Props {
  quirofano: any; // La reservación principal
  user: any;      // Usuario que reservó
  horarios: any[]; // Bloques horarios asociados
}

const ShowQuirofano = ({ quirofano, user, horarios }: Props) => {
  if (!quirofano) return <div className="p-10 text-center">Cargando...</div>;

  // Paleta de colores para la sala asignada
  const salaColor = { bg: 'bg-cyan-50', text: 'text-cyan-600', border: 'border-cyan-200' };

  // Formateo de fecha
  const fechaFormateada = new Date(quirofano.fecha).toLocaleDateString("es-MX", { 
    weekday: 'long', 
    day: 'numeric', 
    month: 'long', 
    year: 'numeric',
    timeZone: 'UTC' 
  });

  return (
    <MainLayout pageTitle="Detalles de Cirugía" link="quirofanos.index">
      <Head title={`Cirugía - ${quirofano.paciente}`} />

      <div className="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
          
          {/* COLUMNA IZQUIERDA: Información del Paciente y Médico (4 de 12) */}
          <div className="lg:col-span-4 space-y-6">
            
            {/* Tarjeta: Información General */}
            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Personal Asignado</h3>
              <div className="space-y-6">
                <div className="flex items-start">
                  <div className="bg-blue-50 p-2 rounded-lg mr-4 shrink-0"><Stethoscope className="text-blue-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Médico Tratante</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">{quirofano.tratante}</p>
                  </div>
                </div>

                <div className="flex items-start">
                  <div className="bg-indigo-50 p-2 rounded-lg mr-4 shrink-0"><Briefcase className="text-indigo-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Cirujano</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">{quirofano.medico_operacion}</p>
                  </div>
                </div>

                {/*<div className="flex items-start">
                  <div className="bg-slate-50 p-2 rounded-lg mr-4 shrink-0"><User className="text-slate-600" size={20} /></div>
                  <div className="min-w-0 flex-1">
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Registrado por</p>
                    <p className="text-sm font-semibold text-gray-900 truncate">{`${user.nombre} ${user.apellido_paterno}`}</p>
                  </div>
                </div>*/}

              </div>
            </div>

            {/* Tarjeta: Sala Asignada 
            <div className={`p-6 rounded-2xl border ${salaColor.bg} ${salaColor.border}`}>
              <p className={`text-[11px] font-black uppercase ${salaColor.text} mb-1`}>Ubicación Asignada</p>
              <h4 className={`text-2xl font-bold ${salaColor.text} mb-2`}>
                {quirofano.habitacion?.identificador || "Pendiente"}
              </h4>
              <p className={`text-xs ${salaColor.text} opacity-80 uppercase font-bold`}>
                {quirofano.localizacion}
              </p>
            </div>
            */}
          </div>

          {/* COLUMNA DERECHA: Detalles del Procedimiento y Horarios (8 de 12) */}
          <div className="lg:col-span-8 space-y-6">
            
            {/* Detalles de la Cirugía */}
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
                <div className="md:col-span-2">
                  <label className="text-[11px] text-gray-400 uppercase font-black block mb-1">Fecha Programada</label>
                  <p className="text-sm font-semibold text-gray-700 capitalize">{fechaFormateada}</p>
                </div>
              </div>

              {/* Servicios Especiales */}
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
                  <div key={idx} className="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div className="flex items-center gap-4">
                      <div className="w-2 h-2 rounded-full bg-cyan-400" />
                      <span className="font-mono text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-lg">
                        {hora.split(' ')[1].substring(0, 5)} hrs
                      </span>
                      <span className="text-xs text-gray-500 font-medium">Uso de Quirófano</span>
                    </div>
                    <span className="text-[10px] font-bold text-cyan-600 uppercase bg-cyan-50 px-2 py-1 rounded border border-cyan-100">
                      Confirmado
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

// Sub-componente para los requerimientos (badges)
const ServiceBadge = ({ label, value }: { label: string, value: string | null }) => {
  const activo = value && value.trim() !== "" && value !== "0";
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