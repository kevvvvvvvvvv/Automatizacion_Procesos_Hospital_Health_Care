import React from 'react';
import { useForm } from '@inertiajs/react';

interface Props {
    onClose: () => void;
}

const ModalCierreCaja = ({ onClose }: Props) => {
    const { data, setData, post, processing, errors } = useForm({
        monto_declarado: ''
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (!window.confirm('¿Estás seguro de cerrar la caja? Esta acción no se puede deshacer.')) {
            return;
        }

        post('/caja/cerrar', {
            preserveScroll: true,
            onSuccess: () => {
                onClose();
            },
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-60 p-4 backdrop-blur-sm">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl border-t-4 border-red-500">
                
                <h3 className="mb-2 text-xl font-bold text-gray-800">Corte y cierre de caja</h3>
                <p className="mb-6 text-sm text-gray-500">
                    Por favor, cuenta el dinero físico que hay en el cajón y escribe el total. El sistema calculará automáticamente si hay algún faltante o sobrante.
                </p>

                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-bold text-gray-700 mb-1">
                            Total en Efectivo (Billetes y Monedas)
                        </label>
                        <div className="relative">
                            <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span className="text-gray-500 font-bold">$</span>
                            </div>
                            <input 
                                type="number" 
                                step="0.01" 
                                min="0"
                                required
                                autoFocus
                                value={data.monto_declarado}
                                onChange={(e) => setData('monto_declarado', e.target.value)}
                                className={`w-full rounded-lg border-gray-300 pl-8 text-2xl font-bold text-gray-900 shadow-sm focus:border-red-500 focus:ring-red-500 py-3 ${errors.monto_declarado ? 'border-red-500' : ''}`}
                                placeholder="0.00"
                            />
                        </div>
                        {errors.monto_declarado && <p className="mt-1 text-sm text-red-600">{errors.monto_declarado}</p>}
                    </div>

                    <div className="mt-8 flex justify-end space-x-3">
                        <button 
                            type="button" 
                            onClick={onClose}
                            className="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            disabled={processing}
                            className="rounded-lg border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50"
                        >
                            {processing ? 'Procesando Corte...' : 'Confirmar Cierre'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalCierreCaja;