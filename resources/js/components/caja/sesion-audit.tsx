import { SesionCaja } from '@/types';
import React, { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import TextInput from '@/components/ui/input-text'; 

interface Props {
    sesiones: SesionCaja[];
}

const SesionesAudit = ({ sesiones }: Props) => {
    // Este estado controla qué sesión estamos auditando
    const [sesionSeleccionada, setSesionSeleccionada] = useState<SesionCaja | null>(null);

    // Configuración del formulario de Inertia
    const { data, setData, post, processing, reset, errors } = useForm({
        monto_ajuste: '',
        observacion_auditoria: '',
    });

    const handleCerrar = () => {
        setSesionSeleccionada(null);
        reset();
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (!sesionSeleccionada) return;

        post(route('sesiones.auditar', sesionSeleccionada.id), {
            onSuccess: () => handleCerrar(),
        });
    };

    return (
        <div className="space-y-4">
            <div className="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Sesión</th>
                            <th className="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Sistema (Esperado)</th>
                            <th className="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Cajero (Declarado)</th>
                            <th className="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Diferencia</th>
                            <th className="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Auditoría</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-gray-100">
                        {sesiones.map((s) => {
                            const diferencia = Number(s.monto_declarado) - Number(s.monto_esperado);
                            const tieneError = s.estado === 'cerrada' && diferencia !== 0;

                            return (
                                <tr key={s.id} className={`${s.auditada ? 'bg-gray-50/50' : ''} hover:bg-gray-50 transition-colors`}>
                                    <td className="px-6 py-4">
                                        <p className="text-sm font-bold text-gray-900">{s.user?.nombre_completo}</p>
                                        <p className="text-xs text-gray-500">{s.caja?.nombre} • {new Date(s.fecha_apertura).toLocaleDateString()}</p>
                                    </td>
                                    
                                    <td className="px-6 py-4 text-right text-sm font-mono text-gray-600">
                                        ${Number(s.monto_esperado).toFixed(2)}
                                    </td>

                                    <td className="px-6 py-4 text-right text-sm font-mono font-bold text-gray-900">
                                        {s.estado === 'cerrada' ? `$${Number(s.monto_declarado).toFixed(2)}` : 'Abierta...'}
                                    </td>

                                    <td className="px-6 py-4 text-right">
                                        {s.estado === 'cerrada' && (
                                            <span className={`text-sm font-bold ${diferencia === 0 ? 'text-green-600' : 'text-red-600'}`}>
                                                {diferencia === 0 ? '✓' : `$${diferencia.toFixed(2)}`}
                                            </span>
                                        )}
                                    </td>

                                    <td className="px-6 py-4 text-center">
                                        {s.auditada ? (
                                            <div className="group relative cursor-help flex justify-center">
                                                <span className="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-bold">
                                                    Auditada
                                                </span>
                                                <div className="absolute bottom-full mb-2 hidden group-hover:block w-48 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-10">
                                                    <strong>Ajuste: ${s.monto_ajuste}</strong><br/>
                                                    "{s.observacion_auditoria}"
                                                </div>
                                            </div>
                                        ) : tieneError ? (
                                            <button 
                                                onClick={() => setSesionSeleccionada(s)}
                                                className="bg-amber-50 border border-amber-200 text-amber-700 hover:bg-amber-100 px-3 py-1 rounded-lg text-xs font-bold transition-colors"
                                            >
                                                Resolver
                                            </button>
                                        ) : (
                                            <span className="text-gray-300 text-xs">-</span>
                                        )}
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>

            {/* --- MODAL DE AUDITORÍA --- */}
            {sesionSeleccionada && (
                <div className="fixed inset-0 z-60 flex items-center justify-center bg-black/50 p-4">
                    <div className="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                        <h3 className="text-xl font-bold text-gray-800 mb-2">Auditar Sesión</h3>
                        <p className="text-sm text-gray-500 mb-6">
                            Estás revisando el descuadre de <strong>{sesionSeleccionada.user?.nombre_completo}</strong> en la caja <strong>{sesionSeleccionada.caja?.nombre}</strong>.
                        </p>

                        <form onSubmit={handleSubmit} className="space-y-4">
                            <div className="bg-amber-50 p-3 rounded-lg border border-amber-100 text-sm mb-4">
                                <div className="flex justify-between text-amber-800">
                                    <span>Monto Esperado:</span>
                                    <span className="font-mono font-bold">${Number(sesionSeleccionada.monto_esperado).toFixed(2)}</span>
                                </div>
                                <div className="flex justify-between text-amber-800">
                                    <span>Monto Declarado:</span>
                                    <span className="font-mono font-bold">${Number(sesionSeleccionada.monto_declarado).toFixed(2)}</span>
                                </div>
                            </div>

                            <TextInput
                                id=''
                                name=''
                                label="Monto de Ajuste (Recuperado)"
                                type="number"
                                value={data.monto_ajuste}
                                onChange={e => setData('monto_ajuste', e.target.value)}
                                error={errors.monto_ajuste}
                                placeholder="0.00"
                            />

                            <div>
                                <label className="block text-xs font-bold text-gray-500 uppercase mb-1">
                                    Observación de Auditoría
                                </label>
                                <textarea
                                    className="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500"
                                    rows={3}
                                    placeholder="Explica la razón de la discrepancia..."
                                    value={data.observacion_auditoria}
                                    onChange={e => setData('observacion_auditoria', e.target.value)}
                                />
                                {errors.observacion_auditoria && (
                                    <p className="text-xs text-red-600 mt-1">{errors.observacion_auditoria}</p>
                                )}
                            </div>

                            <div className="flex justify-end space-x-3 pt-4">
                                <button
                                    type="button"
                                    onClick={handleCerrar}
                                    className="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 disabled:opacity-50 transition-colors"
                                >
                                    {processing ? 'Guardando...' : 'Finalizar Auditoría'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
};

export default SesionesAudit;