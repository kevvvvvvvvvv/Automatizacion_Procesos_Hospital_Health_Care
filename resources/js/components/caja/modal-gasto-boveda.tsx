import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js'

interface Props {
    onClose: () => void;
}

export const ModalGastoBoveda = ({ onClose }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        caja_origen_id: 3, //ID por defecto de la boveda
        monto: '',
        concepto: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        post(route('boveda.registrarGasto'), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                onClose();
            },
        });
    };

    return (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div className="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
                <div className="bg-red-600 px-6 py-4 flex justify-between items-center">
                    <h3 className="text-lg font-bold text-white">Registrar Pago / Gasto Externo</h3>
                    <button onClick={onClose} className="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 space-y-4">
                    
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">¿De dónde sale el dinero?</label>
                        <select
                            value={data.caja_origen_id}
                            onChange={e => setData('caja_origen_id', Number(e.target.value))}
                            className="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                        >
                            <option value={3}>Bóveda Principal</option> {/* Pon el ID real */}
                            <option value={2}>Fondo / Morralla</option> {/* Pon el ID real */}
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Concepto (Ej. Pago Nómina, Compra Jeringas)</label>
                        <input
                            type="text"
                            required
                            value={data.concepto}
                            onChange={e => setData('concepto', e.target.value)}
                            className="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                        />
                        {errors.concepto && <p className="text-red-500 text-xs mt-1">{errors.concepto}</p>}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">Monto a pagar</label>
                        <div className="relative">
                            <span className="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input
                                type="number"
                                step="0.01"
                                required
                                value={data.monto}
                                onChange={e => setData('monto', e.target.value)}
                                className="w-full pl-7 rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                            />
                        </div>
                        {errors.monto && <p className="text-red-500 text-xs mt-1">{errors.monto}</p>}
                    </div>

                    <div className="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" onClick={onClose} className="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                            Cancelar
                        </button>
                        <button type="submit" disabled={processing} className="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 font-bold shadow-sm">
                            {processing ? 'Registrando...' : 'Confirmar Pago'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};