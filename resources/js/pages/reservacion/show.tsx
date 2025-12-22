import React from "react";
import { Head, Link } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { route } from "ziggy-js";
import { Pencil, ArrowLeft, Calendar, MapPin, User, Clock } from "lucide-react";

import InfoField from "@/components/ui/info-field";

interface Props {
  reservacion: any;
  user: any;
  horarios: any[];
}

const ShowReservacion = ({ reservacion, user, horarios }: Props) => {
  // Manejo de carga o datos inexistentes
  if (!reservacion) return <div className="p-10 text-center">Cargando...</div>;

  return (
    <MainLayout pageTitle="Detalles de Reservación" link="reservaciones.index">
      <Head title={`Reservación #${reservacion.id}`} />

      <div className="max-w-4xl mx-auto p-4 md:p-8">
        
        {/* Barra de Acciones Superior */}
        <div className="flex justify-between items-center mb-8">
   
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          
          {/* Columna Izquierda: Tarjeta de Información */}
          <div className="md:col-span-1 space-y-6">
            <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
              <h3 className="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">
                Información General
              </h3>
              
              <div className="space-y-6">
                <div className="flex items-center">
                  <div className="bg-indigo-50 p-2 rounded-lg mr-4">
                    <User className="text-indigo-600" size={20} />
                  </div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Médico / Usuario</p>
                    <InfoField label="Nombre: " value={`${user.nombre} ${user.apellido_paterno}`}/>
                    
                  </div>
                </div>

                <div className="flex items-center">
                  <div className="bg-indigo-50 p-2 rounded-lg mr-4">
                    <Calendar className="text-indigo-600" size={20} />
                  </div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Fecha de Reserva</p>
                    <p className="text-sm font-semibold text-gray-900">
                      {new Date(reservacion.fecha).toLocaleDateString("es-MX", {
                        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                      })}
                    </p>
                  </div>
                </div>

                <div className="flex items-center">
                  <div className="bg-indigo-50 p-2 rounded-lg mr-4">
                    <MapPin className="text-indigo-600" size={20} />
                  </div>
                  <div>
                    <p className="text-[11px] text-gray-400 uppercase font-bold">Ubicación</p>
                    <p className="text-sm font-semibold text-gray-900">{reservacion.localizacion}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Columna Derecha: Listado de Bloques */}
          <div className="md:col-span-2">
            <div className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              <div className="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                <h3 className="font-bold text-gray-700 text-sm">Bloques de Horario Asignados</h3>
                <span className="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-1 rounded-full font-bold">
                  {horarios?.length || 0} BLOQUES
                </span>
              </div>
              
              <div className="divide-y divide-gray-50">
                {horarios && horarios.length > 0 ? (
                  horarios.map((h: any, index: number) => (
                    <div key={index} className="px-6 py-4 flex justify-between items-center hover:bg-gray-50/50 transition">
                      <div className="flex items-center">
                        <div className="bg-white border border-gray-200 text-gray-700 font-mono font-bold px-3 py-1.5 rounded-lg text-sm mr-4 shadow-sm">
                          {new Date(h.fecha_hora).toLocaleTimeString("es-MX", {
                            hour: '2-digit', minute: '2-digit'
                          })}
                        </div>
                        <div className="flex flex-col">
                           <span className="text-gray-900 text-sm font-medium">Bloque de consulta</span>
                           <span className="text-gray-400 text-[10px] uppercase tracking-tighter">Duración: 30 minutos</span>
                        </div>
                      </div>
                      <div className="text-right">
                        <span className="text-[10px] text-gray-400 block font-bold uppercase">Consultorio</span>
                        <span className="font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded text-sm">
                          {h.habitacion?.identificador || "S/A"}
                        </span>
                      </div>
                    </div>
                  ))
                ) : (
                  <div className="p-10 text-center text-gray-400 text-sm italic">
                    No hay horarios registrados.
                  </div>
                )}
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </MainLayout>
  );
};

export default ShowReservacion;