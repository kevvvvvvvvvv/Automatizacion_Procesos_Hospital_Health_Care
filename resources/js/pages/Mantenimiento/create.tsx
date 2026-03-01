import React, { useState, useEffect } from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, useForm, router, usePage } from '@inertiajs/react';
import { Play, CheckCircle, XCircle, Home, Save, Clock, Edit3 } from 'lucide-react';
import InputText from '@/components/ui/input-text';
import { Habitacion, Mantenimiento as MantenimientoType, PageProps } from '@/types';
import { usePermission } from '@/hooks/use-permission';
import { route } from 'ziggy-js';
    
interface Props {
    mantenimiento?: MantenimientoType;
    habitaciones: Habitacion[];
    tipo?: string;
}

const MantenimientoCreate: React.FC<Props> = ({ mantenimiento, habitaciones, tipo }) => {  
    const {can, hasRole} = usePermission();
    const {auth} = usePage <PageProps>().props;  
    const isEditing = !!mantenimiento?.id;

    const [tiempoEspera, setTiempoEspera] = useState(mantenimiento?.duracion_espera || 0);
    const [tiempoPausa, setTiempoPausa] = useState(mantenimiento?.duracion_actividad || 0);
    const [tiempoActividad, setTiempoActividad] = useState(mantenimiento?.duracion_actividad || 0);
    
    const [estado, setEstado] = useState(() => {
        if (!mantenimiento) return 'idle';
        if (mantenimiento.resultado_aceptado !== null) return 'finalizado';
        if (mantenimiento.fecha_arregla) return 'en_progreso';
        return 'esperando';
    }); 

    const { data, setData, post, put, processing, errors } = useForm({
        habitacion_id: mantenimiento?.habitacion_id || '',
        tipo_servicio: mantenimiento?.tipo_servicio || tipo || 'General',
        resultado_aceptado: mantenimiento?.resultado_aceptado ?? null,
        observaciones: mantenimiento?.observaciones || '',
        comentarios: mantenimiento?.comentarios || '',
        accion: '', 
    });

    const habitacionesFiltradas = habitaciones?.filter(h => 
        h.identificador?.toLowerCase().includes('plan de ayutla') ||
        h.ubicacion?.toLowerCase().includes('plan de ayutla')
    ) || [];

    useEffect(() => {
        let intervalo: any;
        if (estado === 'esperando') {
            intervalo = setInterval(() => {
                const inicio = new Date(mantenimiento?.fecha_solicita || new Date()).getTime();
                setTiempoEspera(Math.floor((new Date().getTime() - inicio) / 1000));
            }, 1000);
        } else if (estado === 'en_progreso') {
            intervalo = setInterval(() => {
                const llegada = new Date(mantenimiento?.fecha_arregla || new Date()).getTime();
                setTiempoActividad(Math.floor((new Date().getTime() - llegada) / 1000));
            }, 1000);
        }
        return () => clearInterval(intervalo);
    }, [estado, mantenimiento]);

    const formatTime = (seconds: number) => {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    };

    // BOTÓN 1: Inicia el cronómetro y registra en BD
    const handleStartTimer = () => {
        if (!data.habitacion_id) return;
        
        router.post(route('mantenimiento.store'), { 
            ...data, 
            accion: 'iniciar' 
        }, {
            preserveScroll: true,
            onSuccess: () => setEstado('esperando')
        });
    };
    const handlePausa = () => { 
        router.post(route('mantenimiento.update', mantenimiento?.id), { 
            ...data, 
            _method: 'put',
            accion: 'llegada' 
        }, {
            preserveScroll: true,
            onSuccess: () => setEstado('alto')
        }); 
        
    }
    // Acción intermedia para marcar llegada
    const handleArrival = () => {
        router.post(route('mantenimiento.update', mantenimiento?.id), { 
            ...data, 
            _method: 'put',
            accion: 'llegada' 
        }, {
            preserveScroll: true,
            onSuccess: () => setEstado('en_progreso')
        });
    };

    // BOTÓN 2: Guardado final de todas las cosas
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        const url = isEditing 
            ? route('mantenimiento.update', mantenimiento?.id) 
            : route('mantenimiento.store');
        
        if (isEditing) {
            put(url);
        } else {
            post(url);
        }
    };

    return (
        <MainLayout 
            pageTitle={isEditing ? `Reporte #${mantenimiento?.id}` : `Nuevo Reporte`} 
            link='mantenimiento.index'
        >
            <Head title="Mantenimiento" />

            <div className="max-w-3xl mx-auto py-8 px-4">
                <form onSubmit={handleSubmit} className="space-y-6">
                    
                    {isEditing && (
                        <div className="bg-blue-50 border border-blue-200 p-3 rounded-xl flex items-center gap-2 text-blue-700 text-sm font-medium">
                            <Edit3 size={16} /> Registro activo: {data.tipo_servicio}
                        </div>
                    )}

                    <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 space-y-4">
                        <InputText
                            id="comentarios"
                            name= "comentarios"
                            label="Motivo del reporte"
                            value={data.comentarios}
                            onChange={(e) => setData('comentarios', e.target.value)}
                            disabled={estado !== 'idle'}
                            placeholder="¿Qué sucede?"
                        />

                        <div>
                            <label className="block text-sm font-bold text-gray-700 mb-1">Ubicación</label>
                            <select 
                                value={data.habitacion_id}
                                onChange={e => setData('habitacion_id', e.target.value)}
                                disabled={estado !== 'idle'} 
                                className="w-full rounded-xl border-gray-300 focus:ring-blue-500"
                            >
                                <option value="">— Seleccione el área —</option>
                                {habitacionesFiltradas.map((h: Habitacion) => (
                                    <option key={h.id} value={h.id}>{h.identificador} - {h.ubicacion}</option>
                                ))}
                            </select>
                        </div>
                    </div>

                    {/* BOTÓN 1: INICIAR CRONÓMETRO */}
                    {estado === 'idle' && (
                        <button 
                            type="button" 
                            onClick={handleStartTimer} 
                            disabled={!data.habitacion_id || processing}
                            className="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl flex items-center justify-center gap-2 shadow-lg"
                        >
                            <Clock size={24} /> INICIAR CRONÓMETRO
                        </button>
                    )}

                    {/* SECCIÓN DE TIEMPOS INTERMEDIOS */}
                    {(estado === 'esperando' || estado === 'en_progreso' || estado ==='alto') && (
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div className={`p-6 rounded-2xl border-2 ${estado === 'esperando' ? 'bg-orange-50 border-orange-400' : 'bg-gray-50 opacity-60'}`}>
                                <p className="text-xs font-bold text-orange-600 uppercase mb-2">Respuesta (Traslado)</p>
                                <div className="text-4xl font-black text-gray-800 mb-4 font-mono">{formatTime(tiempoEspera)}</div>
                                {estado === 'esperando' && (
                                    <button type="button" onClick={handlePausa} className="w-full bg-orange-500 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2">
                                        <Play size={18} /> Marcar Llegada
                                    </button>
                                )}
                            </div>
                            {can('editar reportes') &&
                            <div className={`p-6 rounded-2xl border-2 ${estado === 'alto' || 'en_progreso' ? 'bg-emerald-50 border-emerald-400' : 'bg-gray-50 opacity-60'}`}>
                                <p className="text-xs font-bold text-emerald-600 uppercase mb-2">Ejecución (Trabajo)</p>
                                <div className="text-4xl font-black text-gray-800 mb-4 font-mono">{formatTime(tiempoActividad)}</div>
                                {estado === 'alto' && (
                                    <button type="button" onClick={handleArrival} className="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2">
                                        <CheckCircle size={18} /> Iniciar Tarea
                                    </button>
                                )}
                                {estado === 'en_progreso' && (
                                    <button type="button" onClick={() => setEstado('finalizado')} className="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2">
                                        <CheckCircle size={18} /> Finalizar Tarea
                                    </button>
                                )}
                            </div>
                            }
                        </div>
                    )}

                    {/* BOTÓN 2: GUARDAR TODAS LAS COSAS */}
                    {estado === 'finalizado' && (
                        <div className="bg-white p-6 rounded-2xl shadow-xl border-2 border-blue-500 space-y-4 animate-in fade-in zoom-in">
                            <h3 className="font-bold text-gray-800">Finalizar Reporte</h3>
                            <div className="flex gap-4">
                                <button type="button" onClick={() => setData('resultado_aceptado', true)}
                                    className={`flex-1 py-3 rounded-xl border-2 flex items-center justify-center gap-2 ${data.resultado_aceptado === true ? 'bg-green-600 border-green-600 text-white' : 'border-gray-200 text-gray-400'}`}>
                                    <CheckCircle size={20} /> Satisfactorio
                                </button>
                                <button type="button" onClick={() => setData('resultado_aceptado', false)}
                                    className={`flex-1 py-3 rounded-xl border-2 flex items-center justify-center gap-2 ${data.resultado_aceptado === false ? 'bg-red-600 border-red-600 text-white' : 'border-gray-200 text-gray-400'}`}>
                                    <XCircle size={20} /> Con Fallas
                                </button>
                            </div>
                            <textarea 
                                value={data.observaciones}
                                onChange={e => setData('observaciones', e.target.value)}
                                className="w-full rounded-xl border-gray-300"
                                placeholder="Escribe aquí las observaciones finales..."
                                rows={3}
                            />
                            <button 
                                type="submit" 
                                disabled={processing || data.resultado_aceptado === null}
                                className="w-full bg-gray-900 hover:bg-black text-white font-black py-4 rounded-xl flex items-center justify-center gap-2 shadow-lg transition-colors"
                            >
                                <Save size={20} /> GUARDAR TODAS LAS COSAS
                            </button>
                        </div>
                    )}
                </form>
            </div>
        </MainLayout>
    );
}

export default MantenimientoCreate;