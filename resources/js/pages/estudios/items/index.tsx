import React from 'react';
import { SolicitudEstudio } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { Printer } from 'lucide-react'; 

interface Props {
    solicitud: SolicitudEstudio; 
}

const StatusBadge = ({ estado }: { estado: string }) => {
    const colores: Record<string, string> = {
        'SOLICITADO': 'bg-gray-100 text-gray-800',
        'EN_PROCESO': 'bg-blue-50 text-blue-700 border border-blue-200',
        'TERMINADO': 'bg-green-50 text-green-700 border border-green-200',
        'CANCELADO': 'bg-red-50 text-red-700 border border-red-200',
    };
    return (
        <span className={`px-2.5 py-0.5 rounded-full text-xs font-medium ${colores[estado] || 'bg-gray-100 text-gray-800'}`}>
            {estado}
        </span>
    );
};

const EstudioDetalle = ({ solicitud }: Props) => {

    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('es-MX', {
            year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });
    };

    return (
        <MainLayout link='estancias.show' linkParams={solicitud.formulario_instancia.estancia_id} pageTitle={`Solicitud estudios #${solicitud.id}`}>
            <Head title={`Solicitud #${solicitud.id}`} />

            <div className="py-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                    <div className="bg-gray-50 px-8 py-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h1 className="text-2xl font-bold text-gray-900">Solicitud de estudios</h1>
                            <p className="text-sm text-gray-500 mt-1">
                                Folio interno: <span className="font-mono text-gray-700">#{solicitud.id.toString().padStart(6, '0')}</span>
                            </p>
                        </div>
                        <div className="text-right">
                            <div className="text-sm text-gray-500">Fecha de solicitud</div>
                            <div className="font-medium text-gray-900">{formatDate(solicitud.created_at)}</div>
                        </div>
                    </div>

                    <div className="px-8 py-6 grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-100">
                        
                        <div className="space-y-4">
                            <div>
                                <h3 className="text-xs font-semibold text-gray-400 uppercase tracking-wider">Solicitante</h3>
                                <p className="text-sm font-medium text-gray-900 mt-1">
                                    {solicitud.user_solicita ? 
                                        `${solicitud.user_solicita.nombre} ${solicitud.user_solicita.apellido_paterno|| ''} ${solicitud.user_solicita.apellido_materno|| ''}` 
                                        : 'Sin registrar'}
                                </p>
                            </div>
                            <div>
                                <h3 className="text-xs font-semibold text-gray-400 uppercase tracking-wider">Quién llenó la solicitud</h3>
                                <p className="text-sm text-gray-600 mt-1">
                                    {solicitud.user_llena?.nombre ?
                                        `${solicitud.user_llena.nombre} ${solicitud.user_llena.apellido_paterno|| ''} ${solicitud.user_llena.apellido_materno|| ''}` 
                                        : 'Sistema'}
                                </p>
                            </div>
                        </div>

                        <div className="space-y-4 bg-blue-50 p-4 rounded-md border border-blue-100">
                            <div>
                                <h3 className="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Problemas Clínicos / Diagnóstico</h3>
                                <p className="text-sm text-blue-900 leading-relaxed">
                                    {solicitud.problemas_clinicos || 'Sin especificaciones clínicas registradas.'}
                                </p>
                            </div>
                            {solicitud.incidentes_accidentes && (
                                <div className="pt-2 border-t border-blue-200 mt-2">
                                    <h3 className="text-xs font-bold text-red-800 uppercase tracking-wider mb-1">Incidentes / Accidentes</h3>
                                    <p className="text-sm text-red-900">
                                        {solicitud.incidentes_accidentes}
                                    </p>
                                </div>
                            )}
                        </div>
                    </div>

                    <div className="px-8 py-6">
                        <h3 className="text-lg font-semibold text-gray-800 mb-4">Estudios solicitados</h3>
                        
                        <div className="overflow-x-auto border rounded-lg border-gray-200">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estudio
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Realizado por
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Resultados / Notas
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {(solicitud.solicitud_items || []).length === 0 ? (
                                        <tr>
                                            <td colSpan={4} className="px-6 py-10 text-center text-sm text-gray-500">
                                                No hay items asociados a esta solicitud.
                                            </td>
                                        </tr>
                                    ) : (
                                        solicitud.solicitud_items?.map((item) => (
                                            <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                                                <td className="px-6 py-4">
                                                    <div className="text-sm font-medium text-gray-900">
                                                        {item.catalogo_estudio?.nombre || item.otro_estudio ||'Estudio Desconocido'}
                                                    </div>
                                                    <div className="text-xs text-gray-500 mt-0.5">
                                                        ID Ref: {item.catalogo_estudio_id}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 text-sm text-gray-500">
                                                    {item.user_realiza ? (
                                                        <span className='flex items-center gap-1'>
                                                            <div className="h-2 w-2 rounded-full bg-green-400"></div>
                                                            {item.user_realiza.nombre}
                                                        </span>
                                                    ) : (
                                                        <span className="text-gray-400 italic">--</span>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 text-sm text-gray-600">
                                                    {item.resultados ? (
                                                        <p className="line-clamp-2" title={item.resultados}>
                                                            {item.resultados}
                                                        </p>
                                                    ) : (
                                                        <span className="text-gray-400 italic text-xs">Sin resultados aún</span>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 text-right">
                                                    <StatusBadge estado={item.estado} />
                                                </td>
                                                <td className='text-center'>
                                                    {item.ruta_archivo_resultado ? (
                                                        <a 
                                                            href={`/storage/${item.ruta_archivo_resultado}`} 
                                                            target="_blank" 
                                                            rel="noopener noreferrer"
                                                            className="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 transition-colors"
                                                            title="Ver archivo de resultados"
                                                        >
                                                            <Printer className="w-4 h-4"/>
                                                        </a>
                                                    ) : (
                                                        <span className="text-gray-400 text-xs italic">Sin archivo</span>
                                                    )}
                                                </td> 
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
};

export default EstudioDetalle;