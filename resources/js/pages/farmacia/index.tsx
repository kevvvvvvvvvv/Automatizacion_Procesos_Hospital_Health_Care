import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

import { ShoppingCart, User as UserIcon, ChevronRight } from 'lucide-react';

interface Props {
    peticiones: any[];
}

const FarmaciaIndex = ({ peticiones }: Props) => {
    return (
        <MainLayout pageTitle="Panel de surtido de medicamentos" link='dashboard'>
            <Head title="Farmacia - Pendientes" />

            <div className="grid grid-cols-1 gap-4">
                {peticiones.length > 0 ? (
                    <div className="bg-white shadow rounded-lg overflow-hidden">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50 text-gray-600">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Paciente / Estancia</th>
                                    <th className="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider">Medicamentos pendientes</th>
                                    <th className="px-6 py-3 text-center text-xs font-bold uppercase tracking-wider">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {peticiones.map((peticion) => (
                                    <tr key={peticion.estancia_id} className="hover:bg-blue-50 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="flex items-center">
                                                <div className="p-2 bg-indigo-100 rounded-full text-indigo-600 mr-3">
                                                    <UserIcon size={20} />
                                                </div>
                                                <div>
                                                    <div className="text-sm font-bold text-gray-900 uppercase">
                                                        {peticion.paciente.nombre} {peticion.paciente.apellido_paterno}
                                                    </div>
                                                    <div className="text-xs text-gray-500">
                                                        Estancia ID: #{peticion.estancia_id}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex items-center text-amber-600">
                                                <ShoppingCart size={16} className="mr-1" />
                                                <span className="text-sm font-semibold">{peticion.total_items} ítems por surtir</span>
                                            </div>
                                        </td>
                                        
                                        <td className="px-6 py-4 text-center">
                                            <Link
                                                href={route('solicitudes-medicamentos.show', peticion.hoja_enfermeria_id)}
                                                className="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded hover:bg-indigo-700 transition"
                                            >
                                                Surtir pedido <ChevronRight size={14} className="ml-1" />
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <div className="text-center py-12 bg-white rounded-lg border-2 border-dashed border-gray-300">
                        <ShoppingCart className="mx-auto h-12 w-12 text-gray-400" />
                        <h3 className="mt-2 text-sm font-medium text-gray-900">Sin peticiones</h3>
                        <p className="mt-1 text-sm text-gray-500">No hay medicamentos pendientes por surtir en este momento.</p>
                    </div>
                )}
            </div>
        </MainLayout>
    );
};

export default FarmaciaIndex;