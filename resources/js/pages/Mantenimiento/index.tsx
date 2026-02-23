import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, router, Link, usePage } from '@inertiajs/react';
import { Trash2, Settings, Monitor, ChevronRight, Clock, PlayCircle, CheckCircle2, Pencil, Eye } from 'lucide-react';
import { Mantenimiento, PageProps } from '@/types';
import { usePermission } from '@/hooks/use-permission';

interface Props {
    mantenimientos: Mantenimiento[];
}

export default function Index({ mantenimientos }: Props) {
    const {can, hasRole} = usePermission();
    const {auth} = usePage<PageProps>().props;
    
    const categorias = [
        {
            id: 'limpieza',
            titulo: 'Limpieza',
            descripcion: 'Reportar falta de higiene o solicitud de aseo.',
            color: 'bg-emerald-500',
            icon: <Trash2 size={32} className="text-white" />,
        },
        {
            id: 'mantenimiento',
            titulo: 'Mantenimiento',
            descripcion: 'Reparaciones físicas, luces, plomería o mobiliario.',
            color: 'bg-gray-500',
            icon: <Settings size={32} className="text-white" />,
        },
        {
            id: 'sistemas',
            titulo: 'Sistemas',
            descripcion: 'Soporte técnico, software, red o equipos de cómputo.',
            color: 'bg-blue-600',
            icon: <Monitor size={32} className="text-white" />,
        }
    ];

    const handleAction = (tipo: string) => {
        router.get(route('mantenimiento.create', { tipo: tipo }));
    };

    return (
        <MainLayout pageTitle="Panel de Mantenimiento" link='dashboard'>
            <Head title="Mantenimiento" />

            <div className="max-w-6xl mx-auto py-10 px-4 space-y-16">
                {/* SECCIÓN DE CATEGORÍAS */}
                <section>
                    <div className="text-center mb-12">
                        <h1 className="text-4xl font-black text-gray-900 mb-2">Mantenimiento y Soporte</h1>
                        <p className="text-gray-500">Selecciona el departamento al que deseas dirigir tu solicitud.</p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {categorias.map((cat) => (
                            <button
                                key={cat.id}
                                onClick={() => handleAction(cat.id)}
                                className="group flex flex-col p-8 bg-white border-2 border-transparent rounded-3xl shadow-xl transition-all duration-300 transform hover:-translate-y-2 text-left"
                            >
                                <div className={`${cat.color} w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform`}>
                                    {cat.icon}
                                </div>
                                <h2 className="text-2xl font-black text-gray-800 mb-3">{cat.titulo}</h2>
                                <p className="text-gray-500 mb-8 flex-1">{cat.descripcion}</p>
                                <div className="flex items-center text-sm font-bold uppercase tracking-widest text-gray-400 group-hover:text-gray-800 transition-colors">
                                    Generar reporte 
                                    <ChevronRight size={18} className="ml-1 group-hover:translate-x-2 transition-transform" />
                                </div>
                            </button>
                        ))}
                    </div>
                </section>

                {/* TABLA DE REGISTROS RECIENTES / ACTIVOS */}
                <section className="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div className="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 className="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <Clock className="text-blue-500" /> Folios Recientes
                        </h3>
                    </div>

                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-gray-50 text-gray-400 text-xs uppercase tracking-widest font-bold">
                                    <th className="px-6 py-4">Folio / Área</th>
                                    <th className="px-6 py-4">Servicio</th>
                                    <th className="px-6 py-4">Estado</th>
                                    <th className="px-6 py-4">Inicio</th>
                                    <th className="px-6 py-4 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-gray-100">
                                {mantenimientos.length > 0 ? mantenimientos.map((m) => (
                                    <tr key={m.id} className="hover:bg-gray-50 transition-colors group">
                                        <td className="px-6 py-4">
                                            <div className="font-bold text-gray-900">#{m.id}</div>
                                            <div className="text-sm text-gray-500">Habitacion: {m.habitacion_id}</div>
                                        </td>
                                        <td className="px-6 py-4 text-sm">
                                            <span className="px-3 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">
                                                {m.tipo_servicio}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4">
                                            {m.resultado_aceptado !== null ? (
                                                <div className="flex items-center gap-1 text-green-600 text-sm font-bold">
                                                    <CheckCircle2 size={16} /> Finalizado
                                                </div>
                                            ) : (
                                                <div className="flex items-center gap-1 text-amber-500 text-sm font-bold animate-pulse">
                                                    <PlayCircle size={16} /> En curso...
                                                </div>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-500">
                                            {new Date(m.fecha_solicita).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                        </td>
                                       <td className="px-6 py-4">
                                            <div className="flex items-center justify-center gap-4">
                                                
                                                {can ('editar reportes') && 
                                                
                                                <Link
                                                    href={route('mantenimiento.create', { id: m.id })}
                                                    className="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition-colors"
                                                    title="Editar o Continuar"
                                                    onClick={(e) => e.stopPropagation()} 
                                                >
                                                    <Pencil size={18} />
                                                </Link>
                                                }
                                                {can ('consultar reportes') &&
                                                
                                                <Link
                                                    href={route('mantenimiento.show', m.id)}
                                                    className="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition-colors"
                                                    title="Ver Detalles"
                                                    onClick={(e) => e.stopPropagation()} 
                                                >
                                                    <Eye size={18} />
                                                </Link>
                                                }
                                            </div>
                                        </td>
                                        
                                    </tr>
                                )) : (
                                    <tr>
                                        <td colSpan={5} className="px-6 py-10 text-center text-gray-400 italic">
                                            No hay folios registrados hoy.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </MainLayout>
    );
}