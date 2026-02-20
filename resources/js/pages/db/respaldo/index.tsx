import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import MainLayout from '@/layouts/MainLayout';
import { Database, Download, RefreshCw, AlertCircle, CheckCircle, Clock } from 'lucide-react';
import PrimaryButton from '@/components/ui/primary-button';

interface Backup {
    id: number;
    file_name: string;
    status: 'pending' | 'completed' | 'failed';
    size: number;
    created_at: string;
    error_message?: string;
}

interface Props {
    backups: Backup[];
}

const RespaldoIndex = ({ backups }: Props) => {
    const { post, processing } = useForm();

    const handleCreateBackup = (e: React.FormEvent) => {
        e.preventDefault()
        post(route('respaldo.store'));
    };

    const formatSize = (bytes: number) => {
        if (!bytes) return '0 KB';
        const mb = bytes / (1024 * 1024);
        return `${mb.toFixed(2)} MB`;
    };

    return (
        <MainLayout pageTitle="Mantenimiento" link='dashboard'>
            <Head title="Respaldos de sistema" />

            <div className="max-w-6xl mx-auto p-4 md:p-8">
                {/* Encabezado Responsivo */}
                <div className="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
                    <div className="flex flex-col sm:flex-row items-center gap-4">
                        <div className="p-3 bg-blue-100 rounded-lg text-blue-600 hidden sm:block">
                            <Database size={32} />
                        </div>
                        <div>
                            <h2 className="text-xl font-bold text-gray-800">Copia de seguridad</h2>
                            <p className="text-sm text-gray-500">Gestión de base de datos del sistema.</p>
                        </div>
                    </div>
                    
                    <PrimaryButton 
                        onClick={handleCreateBackup} 
                        disabled={processing}
                        className="flex items-center justify-center gap-2 w-full sm:w-auto"
                    >
                        {processing ? <RefreshCw className="animate-spin" size={18} /> : <Database size={18} />}
                        <span className="whitespace-nowrap">Generar respaldo</span>
                    </PrimaryButton>
                </div>
                
                {/* Contenedor de Tabla / Cards */}
                <div className="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
                    {/* Vista para Desktop (Tablas) */}
                    <div className="hidden md:block overflow-x-auto">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Archivo</th>
                                    <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Fecha</th>
                                    <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase italic">Tamaño</th>
                                    <th className="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase italic">Estado</th>
                                    <th className="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase italic">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200 text-sm font-medium">
                                {backups.length > 0 ? (
                                    backups.map((backup) => (
                                        <tr key={backup.id} className="hover:bg-gray-50 transition-colors">
                                            <td className="px-6 py-4 text-gray-900 break-all">{backup.file_name}</td>
                                            <td className="px-6 py-4 text-gray-600">{new Date(backup.created_at).toLocaleString()}</td>
                                            <td className="px-6 py-4 text-gray-600">{formatSize(backup.size)}</td>
                                            <td className="px-6 py-4">
                                                <div className="flex justify-center">
                                                    <StatusBadge status={backup.status} error={backup.error_message} />
                                                </div>
                                            </td>
                                            <td className="px-6 py-4 text-right">
                                                {backup.status === 'completed' && (
                                                    <a href={route('bd.respaldo.download', backup.id)} className="p-2 text-blue-600 hover:bg-blue-100 rounded-full inline-block transition">
                                                        <Download size={20} />
                                                    </a>
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                ) : <EmptyState />}
                            </tbody>
                        </table>
                    </div>

                    {/* Vista para Móviles (Cards) */}
                    <div className="md:hidden divide-y divide-gray-200">
                        {backups.length > 0 ? (
                            backups.map((backup) => (
                                <div key={backup.id} className="p-4 flex flex-col gap-3">
                                    <div className="flex justify-between items-start">
                                        <div className="flex-1 pr-2">
                                            <p className="text-sm font-bold text-gray-900 break-all">{backup.file_name}</p>
                                            <p className="text-xs text-gray-500">{new Date(backup.created_at).toLocaleString()}</p>
                                        </div>
                                        <StatusBadge status={backup.status} error={backup.error_message} />
                                    </div>
                                    <div className="flex justify-between items-center bg-gray-50 p-2 rounded">
                                        <span className="text-xs text-gray-500 font-bold uppercase tracking-wider">Tamaño: {formatSize(backup.size)}</span>
                                        {backup.status === 'completed' && (
                                            <a 
                                                href={route('bd.respaldo.download', backup.id)} 
                                                className="flex items-center gap-1 text-sm text-blue-600 font-bold px-3 py-1 bg-blue-50 rounded-md border border-blue-200"
                                            >
                                                <Download size={16} /> Descargar
                                            </a>
                                        )}
                                    </div>
                                </div>
                            ))
                        ) : <EmptyState />}
                    </div>
                </div>
            </div>
        </MainLayout>
    );
};

/* Sub-componentes para mantener el código limpio */

const StatusBadge = ({ status, error }: { status: string, error?: string }) => {
    if (status === 'completed') return (
        <span className="flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
            <CheckCircle size={14} className="mr-1" /> Completado
        </span>
    );
    if (status === 'pending') return (
        <span className="flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 animate-pulse border border-amber-200">
            <Clock size={14} className="mr-1" /> Procesando
        </span>
    );
    return (
        <span className="flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200" title={error}>
            <AlertCircle size={14} className="mr-1" /> Fallido
        </span>
    );
};

const EmptyState = () => (
    <div className="p-8 text-center text-gray-500 italic md:table-row">
        <div className="md:table-cell md:py-12" colSpan={5}>
            No se han generado respaldos todavía.
        </div>
    </div>
);

export default RespaldoIndex;