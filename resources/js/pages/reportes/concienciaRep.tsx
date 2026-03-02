import React from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import {route} from 'ziggy-js';
import MainLayout from '@/layouts/MainLayout';

interface EscalaData {
    puntaje: string;
    total: number;
}

interface Props {
    reporte: EscalaData[];
    filtros: { escala: string; fecha_inicio?: string; fecha_fin?: string };
}

const EscalasValoracion = ({ reporte, filtros }: Props) => {
    const { data, setData } = useForm({
        escala: filtros.escala || 'escala_glasgow',
        fecha_inicio: filtros.fecha_inicio || '',
        fecha_fin: filtros.fecha_fin || '',
    });

    const actualizarReporte = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('reporte.escalas.show'), data, { preserveState: true });
    };

    return (
        <MainLayout>
        <div className="p-6 bg-gray-50 min-h-screen">
            <Head title="Reporte de Escalas" />
            
            <div className="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
                <h1 className="text-2xl font-bold text-gray-800 mb-6">Frecuencia por Puntaje de Escala</h1>

                <form onSubmit={actualizarReporte} className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 items-end">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Seleccionar Escala</label>
                        <select 
                            value={data.escala} 
                            onChange={e => setData('escala', e.target.value)}
                            className="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        >
                            <option value="escala_glasgow">Glasgow (Conciencia)</option>
                            <option value="escala_braden">Braden (Riesgo de UPP)</option>
                            <option value="escala_ramsey">Ramsey (Sedación)</option>
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Desde</label>
                        <input type="date" value={data.fecha_inicio} onChange={e => setData('fecha_inicio', e.target.value)} className="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Hasta</label>
                        <input type="date" value={data.fecha_fin} onChange={e => setData('fecha_fin', e.target.value)} className="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    </div>
                    <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Consultar
                    </button>
                </form>

                <div className="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p className="text-blue-700 font-medium">
                        Mostrando resultados para: <span className="uppercase">{data.escala.replace('_', ' ')}</span>
                    </p>
                </div>

                <div className="overflow-x-auto">
                    <table className="min-w-full border">
                        <thead className="bg-gray-100">
                            <tr>
                                <th className="p-4 text-left border-b">Valor/Puntaje de la Escala</th>
                                <th className="p-4 text-center border-b">Frecuencia (Veces Registrado)</th>
                            </tr>
                        </thead>
                        <tbody>
                            {reporte.map((row, idx) => (
                                <tr key={idx} className="hover:bg-gray-50">
                                    <td className="p-4 border-b font-bold text-gray-700">{row.puntaje}</td>
                                    <td className="p-4 border-b text-center">
                                        <span className="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold">
                                            {row.total}
                                        </span>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                <div className="mt-6 flex justify-end">
                    <button 
                        onClick={() => window.open(route('reporte.escalas.pdf', data), '_blank')}
                        className="bg-red-500 text-white px-6 py-2 rounded shadow hover:bg-red-600 transition"
                    >
                        Exportar PDF
                    </button>
                </div>
            </div>
        </div>
        </MainLayout>
    );
};

export default EscalasValoracion;