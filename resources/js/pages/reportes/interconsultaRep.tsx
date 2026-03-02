import React from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

interface MotivoData {
    motivo: string;
    total: number;
}

interface Props {
    reporte: MotivoData[];
    filtros: { fecha_inicio?: string; fecha_fin?: string };
}

const InterconsultasMotivos = ({ reporte, filtros }: Props) => {
    const { data, setData } = useForm({
        fecha_inicio: filtros.fecha_inicio || '',
        fecha_fin: filtros.fecha_fin || '',
    });

    const maxTotal = reporte.length > 0 ? Math.max(...reporte.map(o => o.total)) : 0;

    const filtrar = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('reporte.motivos.show'), data, { preserveState: true });
    };

    return (
        <MainLayout link='dashboard-reporte'>
        <div className="p-6 bg-gray-100 min-h-screen">
            <Head title="Frecuencia de Motivos" />
            
            <div className="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-lg">
                <div className="flex justify-between items-center mb-6">
                    <h1 className="text-2xl font-bold text-gray-800">Top Motivos de Interconsulta</h1>
                    <button 
                        onClick={() => window.open(route('reporte.motivos.pdf', data), '_blank')}
                        className="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition"
                    >
                        Descargar PDF
                    </button>
                </div>

                <form onSubmit={filtrar} className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <input 
                        type="date" 
                        value={data.fecha_inicio} 
                        onChange={e => setData('fecha_inicio', e.target.value)}
                        className="border-gray-300 rounded-md"
                    />
                    <input 
                        type="date" 
                        value={data.fecha_fin} 
                        onChange={e => setData('fecha_fin', e.target.value)}
                        className="border-gray-300 rounded-md"
                    />
                    <button type="submit" className="bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Filtrar Registros
                    </button>
                </form>

                <div className="space-y-4">
                    {reporte.map((item, index) => (
                        <div key={index} className="relative pt-1">
                            <div className="flex mb-2 items-center justify-between">
                                <div className="text-sm font-semibold text-gray-700 truncate w-3/4">
                                    {item.motivo}
                                </div>
                                <div className="text-right text-sm font-bold text-indigo-600">
                                    {item.total} servicios
                                </div>
                            </div>
                            <div className="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                <div 
                                    style={{ width: `${(item.total / maxTotal) * 100}%` }}
                                    className="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500"
                                ></div>
                            </div>
                        </div>
                    ))}

                    {reporte.length === 0 && (
                        <div className="text-center py-10 text-gray-500">
                            No se encontraron datos en el rango seleccionado.
                        </div>
                    )}
                </div>
            </div>
        </div>
        </MainLayout>
    );
};

export default InterconsultasMotivos;