import React from 'react';
import { Head, useForm } from '@inertiajs/react';
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

    const handleCreateBackup = () => {
        post(route('respaldo.store'));
    };

    // Función para formatear el tamaño de bytes a MB
    const formatSize = (bytes: number) => {
        if (!bytes) return '0 KB';
        const mb = bytes / (1024 * 1024);
        return `${mb.toFixed(2)} MB`;
    };

    return (
        <MainLayout pageTitle="Mantenimiento de Base de Datos" link='dashboard'>
            <Head title="Respaldos de Sistema" />

            <div className="max-w-6xl mx-auto p-4 md:p-8">
                {/* Encabezado con Acción */}
                <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div className="flex items-center space-x-4">
                        <div className="p-3 bg-blue-100 rounded-lg text-blue-600">
                            <Database size={32} />
                        </div>
                        <div>
                            <h2 className="text-xl font-bold text-gray-800">Copia de Seguridad</h2>
                            <p className="text-sm text-gray-500">Genera y descarga respaldos completos de la base de datos.</p>
                        </div>
                    </div>
                    
                    <PrimaryButton 
                        onClick={handleCreateBackup} 
                        disabled={processing}
                        className="flex items-center gap-2"
                    >
                        {processing ? <RefreshCw className="animate-spin" size={18} /> : <Database size={18} />}
                        Generar Nuevo Respaldo
                    </PrimaryButton>
                </div>

                {/* Tabla de Respaldos */}
                <div className="bg-white shadow rounded-lg overflow-hidden">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Archivo</th>
                                <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                                <th className="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tamaño</th>
                                <th className="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Estado</th>
                                <th className="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Acción</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200 text-sm">
                            {backups.length > 0 ? (
                                backups.map((backup) => (
                                    <tr key={backup.id} className="hover:bg-gray-50 transition-colors">
                                        <td className="px-6 py-4 font-medium text-gray-900">
                                            {backup.file_name}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {new Date(backup.created_at).toLocaleString()}
                                        </td>
                                        <td className="px-6 py-4 text-gray-600">
                                            {formatSize(backup.size)}
                                        </td>
                                        <td className="px-6 py-4">
                                            <div className="flex justify-center">
                                                {backup.status === 'completed' && (
                                                    <span className="flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <CheckCircle size={14} className="mr-1" /> Completado
                                                    </span>
                                                )}
                                                {backup.status === 'pending' && (
                                                    <span className="flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 animate-pulse">
                                                        <Clock size={14} className="mr-1" /> Procesando
                                                    </span>
                                                )}
                                                {backup.status === 'failed' && (
                                                    <span className="flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800" title={backup.error_message}>
                                                        <AlertCircle size={14} className="mr-1" /> Fallido
                                                    </span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            {backup.status === 'completed' && (
                                                <a
                                                    href={route('bd.respaldo.download', backup.id)}
                                                    className="inline-flex items-center p-2 text-blue-600 hover:bg-blue-100 rounded-full transition"
                                                    title="Descargar SQL"
                                                >
                                                    <Download size={20} />
                                                </a>
                                            )}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={5} className="px-6 py-12 text-center text-gray-500 italic">
                                        No se han generado respaldos todavía.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </MainLayout>
    );
};

export default RespaldoIndex;