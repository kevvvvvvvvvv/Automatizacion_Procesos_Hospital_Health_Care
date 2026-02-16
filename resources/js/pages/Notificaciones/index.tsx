import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { Bell, Clock, Inbox, CheckCircle2, FileText } from 'lucide-react';

export default function Index({ notificaciones }) {
    const formatDate = (dateString) => {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit' 
        };
        return new Date(dateString).toLocaleDateString('es-ES', options);
    };

    return (
        <MainLayout pageTitle="Historial de Notificaciones" link='dashboard'>
            <Head title="Mis Notificaciones" />

            <div className="max-w-5xl mx-auto py-8 px-4">
                <div className="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div>
                        <h1 className="text-2xl font-black text-gray-900 flex items-center gap-3">
            
                          <Bell className="text-blue-600" size={28} />
                            Centro de Notificaciones
                        </h1>
                        <p className="text-gray-500 text-sm mt-1">
                            Consulta el historial completo de avisos y alertas del sistema.
                        </p>
                    </div>
                </div>

                <div className="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">
                    {notificaciones.length > 0 ? (
                        <div className="divide-y divide-gray-100">
                            {notificaciones.map((notif) => {
                                const targetUrl = notif.data.action_url 
                                    || (notif.data.hoja_id ? route('solicitudes-medicamentos.show', { hojasenfermeria: notif.data.hoja_id }) : null);

                                return (
                                    <div 
                                        key={notif.id} 
                                        className={`group p-6 transition-all hover:bg-gray-50 ${
                                            !notif.read_at ? 'bg-blue-50/30' : ''
                                        }`}
                                    >
                                        <div className="flex flex-col sm:flex-row justify-between gap-4">
                                            <div className="flex-1">
                                                <div className="flex items-center gap-2 mb-2">
                                                    {!notif.read_at && (
                                                        <span className="flex-shrink-0 w-2.5 h-2.5 bg-blue-600 rounded-full animate-pulse"></span>
                                                    )}
                                                    <span className="text-[10px] font-black uppercase tracking-widest text-blue-600">
                                                        {notif.data.titulo || 'AVISO'}
                                                    </span>
                                                </div>

                                                {/* TÍTULO DE LA NOTIFICACIÓN */}
                                                 <h3 className={`text-lg leading-tight mb-1 ${!notif.read_at ? 'font-bold text-gray-900' : 'font-semibold text-gray-700'}`}>
                                                        {notif.data.mensaje || notif.data.message || 'Notificación sin texto'}
                                                    </h3>
                                                {/* DESCRIPCIÓN DETALLADA (Aquí agregamos el contenido extra) */}
                                                {notif.data.descripcion && (
                                                    <p className="text-sm text-gray-500 leading-relaxed mb-3 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                                        {notif.data.descripcion}
                                                    </p>
                                                )}

                                                <div className="mt-4 flex flex-wrap items-center gap-y-2 gap-x-6">
                                                    <span className="flex items-center gap-1.5 text-xs font-semibold text-gray-400">
                                                        <Clock size={14} />
                                                        {formatDate(notif.created_at)}
                                                    </span>
                                                    
                                                    {notif.read_at && (
                                                        <span className="flex items-center gap-1 text-xs font-bold text-green-500 uppercase">
                                                            <CheckCircle2 size={14} />
                                                            Leída
                                                        </span>
                                                    )}
                                                </div>
                                            </div>

                                            {targetUrl && (
                                                <div className="flex items-center">
                                                    <Link 
                                                        href={targetUrl}
                                                        className="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-100 hover:border-gray-400 transition-all flex items-center gap-2"
                                                    >
                                                        Ver detalle
                                                        <span className="text-gray-400 text-lg">→</span>
                                                    </Link>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="py-24 text-center">
                            <div className="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <Inbox className="text-gray-300" size={40} />
                            </div>
                            <h3 className="text-lg font-bold text-gray-800">Bandeja vacía</h3>
                            <p className="text-gray-500">No tienes notificaciones registradas.</p>
                        </div>
                    )}
                </div>
            </div>
        </MainLayout>
    );
}