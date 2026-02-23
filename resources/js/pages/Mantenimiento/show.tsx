import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { Clock, Timer, CheckCircle2, AlertCircle,  } from 'lucide-react';
import { Mantenimiento } from '@/types';

interface Props {
    mantenimiento: Mantenimiento;
}

export default function Show({ mantenimiento }: Props) {
    
    // Función para formatear segundos a texto legible
    const formatDuration = (secondsValue: any): string => {
    const seconds = Number(secondsValue);

    if (isNaN(seconds)) return "00:00:00";

    const isNegative = seconds < 0;
    const totalSeconds = Math.abs(seconds);

    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const secs = Math.floor(totalSeconds % 60);

    const formatted = [
        hours.toString().padStart(2, "0"),
        minutes.toString().padStart(2, "0"),
        secs.toString().padStart(2, "0"),
    ].join(":");

    return isNegative ? `${formatted}` : formatted;
};
    const formatDate = (dateString: string | null) => {
        if (!dateString) return "--:--";
        return new Date(dateString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    };
    //console.log('timepo', mantenimiento);
    return (
        <MainLayout pageTitle={`Detalle de Folio #${mantenimiento.id}`} link='mantenimiento.index'>
            <Head title={`Reporte ${mantenimiento.id}`} />
                <div className="max-w-5xl mx-auto py-8 px-4">
            

                {/* --- CABECERA DE ESTADO --- */}
                <div className="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div className="flex items-center gap-4">
                        <div className={`p-4 rounded-2xl ${mantenimiento.resultado_aceptado ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'}`}>
                            {mantenimiento.resultado_aceptado ? <CheckCircle2 size={32} /> : <AlertCircle size={32} />}
                        </div>
                        <div>
                            <h1 className="text-2xl font-black text-gray-900">Folio #{mantenimiento.id}</h1>
                            <p className="text-gray-500 font-medium">{mantenimiento.tipo_servicio} • Habitación {mantenimiento.habitacion_id}</p>
                        </div>
                    </div>
                    <div className="text-right">
                        <span className={`px-4 py-2 rounded-full text-sm font-black uppercase tracking-widest ${mantenimiento.resultado_aceptado ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`}>
                            {mantenimiento.resultado_aceptado ? 'Satisfactorio' : 'Con Fallas'}
                        </span>
                    </div>
                </div>

                {/* --- TARJETAS DE TIEMPOS (LO QUE PEDISTE) --- */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {/* Tiempo 1: Llegada */}
                    <div className="bg-white p-8 rounded-3xl shadow-xl border-b-8 border-orange-400 relative overflow-hidden">
                        <Clock className="absolute -right-4 -top-4 text-orange-100" size={120} />
                        <p className="text-orange-600 font-black uppercase text-xs tracking-widest mb-2 relative">Tiempo de Respuesta</p>
                        <h2 className="text-4xl font-black text-gray-800 relative">
                            {formatDuration(mantenimiento.duracion_espera)}
                        </h2>
                        <p className="text-gray-400 text-sm mt-2 relative">
                            Desde la solicitud ({formatDate(mantenimiento.fecha_solicita)}) hasta la llegada ({formatDate(mantenimiento.fecha_arregla)}).
                        </p>
                    </div>

                    {/* Tiempo 2: Realización */}
                    <div className="bg-white p-8 rounded-3xl shadow-xl border-b-8 border-emerald-500 relative overflow-hidden">
                        <Timer className="absolute -right-4 -top-4 text-emerald-100" size={120} />
                        <p className="text-emerald-600 font-black uppercase text-xs tracking-widest mb-2 relative">Tiempo de Ejecución</p>
                        <h2 className="text-4xl font-black text-gray-800 relative">
                            {formatDuration(mantenimiento.duracion_actividad )}
                        </h2>
                        <p className="text-gray-400 text-sm mt-2 relative">
                            Tiempo efectivo de trabajo en el sitio.
                        </p>
                    </div>
                </div>

                {/* --- DETALLES ADICIONALES --- */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div className="md:col-span-2 space-y-6">
                        <div className="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3 className="font-black text-gray-800 flex items-center gap-2 mb-6">
                                 Notas del Servicio
                            </h3>
                            <div className="space-y-6">
                                <div>
                                    <p className="text-xs font-bold text-gray-400 uppercase mb-1">Motivo / Problema:</p>
                                    <p className="text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 italic">
                                        "{mantenimiento.comentarios || 'Sin comentarios iniciales'}"
                                    </p>
                                </div>
                                <div>
                                    <p className="text-xs font-bold text-gray-400 uppercase mb-1">Observaciones Finales:</p>
                                    <p className="text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 italic">
                                        "{mantenimiento.observaciones || 'Sin observaciones registradas'}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="space-y-6">
                        <div className="bg-white p-8 rounded-3xl text-white shadow-xl">
                            <h3 className="font-bold text-gray-400 text-xs uppercase mb-4">Resumen Total</h3>
                            <div className="space-y-4">
                                <div className="flex justify-between border-b border-gray-800 pb-2">
                                    <span className="text-gray-400 text-sm">Traslado</span>
                                    <span className="text-gray-800 font-mono">{formatDuration(mantenimiento.duracion_espera)}</span>
                                </div>
                                <div className="flex justify-between border-b border-gray-800 pb-2">
                                    <span className="text-gray-400 text-sm">Trabajo</span>
                                    <span className="text-gray-800 font-mono">{formatDuration(mantenimiento.duracion_actividad)}</span>
                                </div>
                                <div className="flex justify-between pt-2">
                                    <span className="font-bold">Total Invertido</span>
                                    <span className="text-xl font-black text-blue-400">
                                        {formatDuration(mantenimiento.duracion_espera + mantenimiento.duracion_actividad)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}