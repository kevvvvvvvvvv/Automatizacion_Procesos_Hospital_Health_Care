import React, { useState, useEffect } from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head, useForm } from '@inertiajs/react';
import { Timer, Play, CheckCircle, XCircle, Home, Save, AlertCircle } from 'lucide-react';

export default function Create({ habitaciones = [], habitacion_id, tipo }) {
    
    // 1. Estados para los cronómetros
    const [tiempoEspera, setTiempoEspera] = useState(0);
    const [tiempoActividad, setTiempoActividad] = useState(0);
    
    // El estado inicia en 'idle' si no hay habitación, o 'esperando' si ya viene pre-seleccionada
    const [estado, setEstado] = useState(habitacion_id ? 'esperando' : 'idle'); 

    const { data, setData, post, processing, errors } = useForm({
        habitacion_id: habitacion_id || '',
        tipo_servicio: tipo || 'General',
        resultado_aceptado: null,
        observaciones: '',
        duracion_espera: 0,
        duracion_actividad: 0,
    });

    // 2. Filtrado de habitaciones para "Plan de Ayutla"
    // Buscamos en 'ubicacion' o 'identificador' (ajusta según tus campos de BD)
    const habitacionesFiltradas = habitaciones?.filter(h => 
        h.ubicacion?.toLowerCase().includes('plan de ayutla') || 
        h.identificador?.toLowerCase().includes('plan de ayutla') ||
        h.nombre_sucursal?.toLowerCase().includes('plan de ayutla')
    ) || [];

    // 3. Efecto: Iniciar cronómetro de espera al seleccionar habitación
    useEffect(() => {
        if (data.habitacion_id && estado === 'idle') {
            setEstado('esperando');
        }
    }, [data.habitacion_id]);

    // 4. Lógica de los intervalos (Cronómetros)
    useEffect(() => {
        let intervalo;
        if (estado === 'esperando') {
            intervalo = setInterval(() => setTiempoEspera(t => t + 1), 1000);
        } else if (estado === 'en_progreso') {
            intervalo = setInterval(() => setTiempoActividad(t => t + 1), 1000);
        }
        return () => clearInterval(intervalo);
    }, [estado]);

    const formatTime = (seconds) => {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    };

    const iniciarActividad = () => {
        setData('duracion_espera', tiempoEspera);
        setEstado('en_progreso');
    };

    const finalizarActividad = () => {
        setData('duracion_actividad', tiempoActividad);
        setEstado('finalizado');
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // Antes de enviar, aseguramos que los tiempos finales estén en el form
        post(route('mantenimiento.store'));
    };

    return (
        <MainLayout pageTitle={`Reporte de ${tipo || 'Actividad'}`} link='mantenimiento.index'>
            <Head title="Registrar Actividad" />

            <div className="max-w-3xl mx-auto py-8 px-4">
                <form onSubmit={handleSubmit} className="space-y-6">
                    
                    {/* SECCIÓN DE UBICACIÓN */}
                    <div className="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                        <div className="flex items-center justify-between mb-4">
                            <div className="flex items-center gap-2 text-gray-700">
                                <Home size={20} />
                                <h2 className="font-bold">Ubicación (Plan de Ayutla)</h2>
                            </div>
                            <span className="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold uppercase">
                                {tipo}
                            </span>
                        </div>
                        
                        <select 
                            value={data.habitacion_id}
                            onChange={e => setData('habitacion_id', e.target.value)}
                            disabled={!!habitacion_id || estado === 'en_progreso' || estado === 'finalizado'} 
                            className="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 disabled:bg-gray-100"
                        >
                            <option value="">— Seleccione el área de trabajo —</option>
                            {habitacionesFiltradas.map(h => (
                                <option key={h.id} value={h.id}>
                                    {h.identificador} 
                                </option>
                            ))}
                        </select>
                        {errors.habitacion_id && <p className="text-red-500 text-xs mt-1">{errors.habitacion_id}</p>}
                    </div>

                    {/* ALERTA DE SELECCIÓN */}
                    {!data.habitacion_id && (
                        <div className="flex items-center gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800">
                            <AlertCircle size={20} />
                            <p className="text-sm font-medium">Seleccione una ubicación para iniciar el conteo de tiempo de respuesta.</p>
                        </div>
                    )}

                    {/* CRONÓMETROS */}
                    <div className={`grid grid-cols-1 md:grid-cols-2 gap-4 transition-all duration-500 ${!data.habitacion_id ? 'opacity-30 grayscale pointer-events-none' : 'opacity-100'}`}>
                        {/* Cronómetro de Espera */}
                        <div className={`p-6 rounded-2xl border-2 transition-all ${estado === 'esperando' ? 'bg-white-50 border-white-200 shadow-md ' : 'bg-gray-50 border-transparent'}`}>
                            <p className="text-xs font-bold text-orange-600 uppercase mb-2">Tiempo de Respuesta</p>
                            <div className="text-4xl font-black text-gray-800 mb-4 font-mono">
                                {formatTime(tiempoEspera)}
                            </div>
                            {estado === 'esperando' && (
                                <button 
                                    type="button"
                                    onClick={iniciarActividad}
                                    className="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 shadow-lg"
                                >
                                    <Play size={18} /> Llegué a la ubicación
                                </button>
                            )}
                        </div>

                        {/* Cronómetro de Actividad */}
                        <div className={`p-6 rounded-2xl border-2 transition-all ${estado === 'en_progreso' ? 'bg-white-50 border-white-200 shadow-md ' : 'bg-gray-50 border-transparent'}`}>
                            <p className="text-xs font-bold text-emerald-600 uppercase mb-2">Tiempo de Ejecución</p>
                            <div className="text-4xl font-black text-gray-800 mb-4 font-mono">
                                {formatTime(tiempoActividad)}
                            </div>
                            {estado === 'en_progreso' && (
                                <button 
                                    type="button"
                                    onClick={finalizarActividad}
                                    className="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2 shadow-lg"
                                >
                                    <CheckCircle size={18} /> Finalizar Tarea
                                </button>
                            )}
                        </div>
                    </div>

                    {/* SECCIÓN DE CIERRE Y RESULTADOS */}
                    {estado === 'finalizado' && (
                        <div className="bg-white p-6 rounded-2xl shadow-xl border-2 border-blue-100 animate-in fade-in zoom-in duration-300">
                            <h2 className="font-bold text-gray-800 mb-4">Confirmación del Resultado</h2>
                            
                            <div className="flex gap-4 mb-6">
                                <button
                                    type="button"
                                    onClick={() => setData('resultado_aceptado', true)}
                                    className={`flex-1 py-4 rounded-xl border-2 flex flex-col items-center gap-2 transition-all ${data.resultado_aceptado === true ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-100 text-gray-400'}`}
                                >
                                    <CheckCircle size={32} />
                                    <span className="font-bold text-sm uppercase">Satisfactorio</span>
                                </button>
                                <button
                                    type="button"
                                    onClick={() => setData('resultado_aceptado', false)}
                                    className={`flex-1 py-4 rounded-xl border-2 flex flex-col items-center gap-2 transition-all ${data.resultado_aceptado === false ? 'border-red-500 bg-red-50 text-red-700' : 'border-gray-100 text-gray-400'}`}
                                >
                                    <XCircle size={32} />
                                    <span className="font-bold text-sm uppercase">No Conforme</span>
                                </button>
                            </div>

                            <div className="space-y-2">
                                <label className="text-sm font-bold text-gray-700">Observaciones Finales:</label>
                                <textarea 
                                    value={data.observaciones}
                                    onChange={e => setData('observaciones', e.target.value)}
                                    className="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder={data.resultado_aceptado === false ? "Describa detalladamente por qué no se aceptó el resultado..." : "Notas adicionales del servicio..."}
                                    rows={3}
                                    required={data.resultado_aceptado === false}
                                />
                            </div>

                            <button
                                type="submit"
                                disabled={processing || data.resultado_aceptado === null}
                                className="w-full mt-6 bg-gray-900 text-white font-black py-4 rounded-xl hover:bg-black disabled:bg-gray-300 transition-all flex items-center justify-center gap-2 shadow-xl"
                            >
                                <Save size={20} /> Guardar Reporte Completo
                            </button>
                        </div>
                    )}
                </form>
            </div>
        </MainLayout>
    );
}