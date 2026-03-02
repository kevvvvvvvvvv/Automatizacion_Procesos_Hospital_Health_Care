import React from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import {route} from 'ziggy-js';


interface EstanciaData {
    tipo: string;
    total: number;
}

interface Props {
    estancias: EstanciaData[];
    filtros: { fecha_inicio?: string; fecha_fin?: string };
}

const EstanciasTipo = ({ estancias, filtros }: Props) => {
    const { data, setData } = useForm({
        fecha_inicio: filtros.fecha_inicio || '',
        fecha_fin: filtros.fecha_fin || '',
    });

    const filtrar = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route('reporte.estancias.show'), data, { preserveState: true });
    };

    const descargarPdf = () => {
        // Generamos la URL con los filtros actuales
        const url = route('reporte.estancias.pdf', data);
        window.open(url, '_blank');
    };

    return (
        <MainLayout link='dashboard-reporte'>
        <div className="p-6 bg-gray-50 min-h-screen">
            <Head title="Reporte de Estancias" />
            
            <div className="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow">
                <h2 className="text-xl font-bold text-gray-800 mb-6">Filtros de Reporte</h2>
                
                <form onSubmit={filtrar} className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end mb-10">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Fecha Inicial</label>
                        <input 
                            type="date" 
                            className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={data.fecha_inicio}
                            onChange={e => setData('fecha_inicio', e.target.value)}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Fecha Final</label>
                        <input 
                            type="date" 
                            className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            value={data.fecha_fin}
                            onChange={e => setData('fecha_fin', e.target.value)}
                        />
                    </div>
                    <div className="flex gap-2">
                        <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-medium">
                            Actualizar Tabla
                        </button>
                        <button type="button" onClick={descargarPdf} className="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition font-medium">
                            Generar PDF
                        </button>
                    </div>
                </form>

                <div className="border rounded-lg overflow-hidden">
                    <table className="w-full">
                        <thead className="bg-gray-100">
                            <tr>
                                <th className="p-4 text-left border-b">Tipo de Estancia</th>
                                <th className="p-4 text-center border-b">Cantidad de Pacientes</th>
                            </tr>
                        </thead>
                        <tbody>
                            {estancias.map((item, i) => (
                                <tr key={i} className="hover:bg-gray-50">
                                    <td className="p-4 border-b font-medium text-gray-700">{item.tipo}</td>
                                    <td className="p-4 border-b text-center text-blue-600 font-bold">{item.total}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </MainLayout>
    );
};

export default EstanciasTipo;