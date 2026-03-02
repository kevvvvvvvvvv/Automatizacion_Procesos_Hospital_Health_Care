import React from 'react';
import { Head, router } from '@inertiajs/react';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';
import MainLayout from '@/layouts/MainLayout';
import {route} from 'ziggy-js';
interface Props {
    registros: any[];
    paciente: any;
    listaPacientes: any[];
}

const SeguimientoPaciente = ({ registros, paciente, listaPacientes }: Props) => {

    const seleccionarPaciente = (id: string) => {
        router.get(route('reporte.vitales.seguimiento'), { paciente_id: id });
    };

    return (
        <MainLayout link='dashboard-reporte'>
        <div className="p-6 bg-gray-100 min-h-screen">
            <Head title="Seguimiento de Signos" />

            <div className="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 className="text-2xl font-bold mb-4 text-gray-800">Gráfica de Evolución de Signos Vitales</h1>

                {/* Buscador de Paciente */}
                <div className="mb-8 border-b pb-6">
                    <label className="block text-sm font-medium text-gray-700 mb-2">Seleccionar Paciente:</label>
                    <select 
                        className="w-full md:w-1/3 border-gray-300 rounded-md"
                        onChange={(e) => seleccionarPaciente(e.target.value)}
                        value={paciente?.id || ''}
                    >
                        <option value="">-- Seleccione un paciente --</option>
                        {listaPacientes.map(p => (
                            <option key={p.id} value={p.id}>{p.nombre_completo}</option>
                        ))}
                    </select>
                </div>

                {paciente ? (
                    <>
                        <div className="mb-4">
                            <h2 className="text-lg font-semibold text-blue-600">Paciente: {paciente.nombre_completo}</h2>
                        </div>

                        {/* Gráfica de Frecuencia Cardíaca */}
                        <div className="h-80 w-full mb-10">
                            <h3 className="text-center font-bold text-gray-600 mb-2">Frecuencia Cardíaca (BPM)</h3>
                            <ResponsiveContainer width="100%" height="100%">
                                <LineChart data={registros}>
                                    <CartesianGrid strokeDasharray="3 3" />
                                    <XAxis dataKey="fecha" />
                                    <YAxis domain={[40, 160]} />
                                    <Tooltip />
                                    <Legend />
                                    <Line type="monotone" dataKey="fc" name="FC" stroke="#ef4444" strokeWidth={3} />
                                </LineChart>
                            </ResponsiveContainer>
                        </div>

                        {/* Gráfica de Temperatura */}
                        <div className="h-80 w-full">
                            <h3 className="text-center font-bold text-gray-600 mb-2">Temperatura (°C)</h3>
                            <ResponsiveContainer width="100%" height="100%">
                                <LineChart data={registros}>
                                    <CartesianGrid strokeDasharray="3 3" />
                                    <XAxis dataKey="fecha" />
                                    <YAxis domain={[34, 42]} />
                                    <Tooltip />
                                    <Legend />
                                    <Line type="monotone" dataKey="temp" name="Temperatura" stroke="#3b82f6" strokeWidth={3} />
                                </LineChart>
                            </ResponsiveContainer>
                        </div>
                    </>
                ) : (
                    <div className="py-20 text-center text-gray-400">
                        Seleccione un paciente para visualizar sus gráficas de tendencia.
                    </div>
                )}
            </div>
        </div>
        </MainLayout>
    );
};

export default SeguimientoPaciente;