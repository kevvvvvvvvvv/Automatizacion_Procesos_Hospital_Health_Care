import React from 'react';
import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
<<<<<<< HEAD:resources/js/pages/peticiones/index.tsx
import { ShoppingCart, User as UserIcon, ChevronRight, Hash } from 'lucide-react';
=======
import { route } from 'ziggy-js';

import { ShoppingCart, User as UserIcon, ChevronRight } from 'lucide-react';
>>>>>>> 3554850e322fe1aaab08586af2cb7d80e074be8d:resources/js/pages/farmacia/index.tsx

interface Props {
    peticiones: any[];
}

const FarmaciaIndex = ({ peticiones }: Props) => {
    return (
        <MainLayout pageTitle="Panel de surtido de medicamentos" link='dashboard'>
            <Head title="Farmacia - Pendientes" />

            <div className="max-w-7xl mx-auto p-2 sm:p-6">
                {peticiones.length > 0 ? (
<<<<<<< HEAD:resources/js/pages/peticiones/index.tsx
                    <div className="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
                        
                        {/* Vista Desktop: Tabla (Visible en md en adelante) */}
                        <div className="hidden md:block overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Paciente / Estancia</th>
                                        <th className="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Medicamentos Pendientes</th>
                                        <th className="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Acción</th>
=======
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
>>>>>>> 3554850e322fe1aaab08586af2cb7d80e074be8d:resources/js/pages/farmacia/index.tsx
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-100">
                                    {peticiones.map((peticion) => (
                                        <tr key={peticion.estancia_id} className="hover:bg-indigo-50/30 transition-colors group">
                                            <td className="px-6 py-4">
                                                <div className="flex items-center">
                                                    <div className="p-2.5 bg-indigo-100 rounded-lg text-indigo-600 mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                                        <UserIcon size={20} />
                                                    </div>
                                                    <div>
                                                        <div className="text-sm font-extrabold text-gray-900 uppercase tracking-tight">
                                                            {peticion.paciente.nombre} {peticion.paciente.apellido_paterno}
                                                        </div>
                                                        <div className="text-xs text-gray-500 flex items-center gap-1">
                                                            <Hash size={12} /> ID Estancia: {peticion.estancia_id}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4">
                                                <div className="flex items-center text-amber-600 bg-amber-50 w-fit px-3 py-1 rounded-full border border-amber-100">
                                                    <ShoppingCart size={14} className="mr-2" />
                                                    <span className="text-sm font-bold">{peticion.total_items} ítems por surtir</span>
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                <Link
                                                    href={route('farmacia.solicitud.show', peticion.hoja_enfermeria_id)}
                                                    className="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 shadow-sm hover:shadow transition-all active:scale-95"
                                                >
                                                    Surtir Pedido <ChevronRight size={14} className="ml-1" />
                                                </Link>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>

                        {/* Vista Móvil: Lista de Cards (Visible solo en sm/xs) */}
                        <div className="md:hidden divide-y divide-gray-100">
                            {peticiones.map((peticion) => (
                                <div key={peticion.estancia_id} className="p-4 hover:bg-gray-50 active:bg-gray-100 transition-colors">
                                    <div className="flex items-start justify-between mb-4">
                                        <div className="flex items-center gap-3">
                                            <div className="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                                <UserIcon size={20} />
                                            </div>
                                            <div>
                                                <p className="text-sm font-black text-gray-900 uppercase">
                                                    {peticion.paciente.nombre} {peticion.paciente.apellido_paterno}
                                                </p>
                                                <p className="text-[11px] text-gray-500 font-medium">Estancia #{peticion.estancia_id}</p>
                                            </div>
                                        </div>
                                        <div className="bg-amber-100 text-amber-700 px-2 py-1 rounded text-[10px] font-black uppercase">
                                            {peticion.total_items} ITEMS
                                        </div>
                                    </div>
                                    
                                    <Link
                                        href={route('farmacia.solicitud.show', peticion.hoja_enfermeria_id)}
                                        className="flex items-center justify-between w-full px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-indigo-200 shadow-lg"
                                    >
                                        <span>Atender Solicitud</span>
                                        <ChevronRight size={18} />
                                    </Link>
                                </div>
                            ))}
                        </div>

                    </div>
                ) : (
                    /* Estado Vacío Responsivo */
                    <div className="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-gray-200 text-center px-4">
                        <div className="bg-gray-50 p-6 rounded-full mb-4">
                            <ShoppingCart className="h-12 w-12 text-gray-300" />
                        </div>
                        <h3 className="text-lg font-bold text-gray-900">Sin peticiones pendientes</h3>
                        <p className="mt-1 text-sm text-gray-500 max-w-xs">
                            Excelente trabajo, la bandeja está limpia. No hay medicamentos por surtir en este momento.
                        </p>
                    </div>
                )}
            </div>
        </MainLayout>
    );
};

export default FarmaciaIndex;