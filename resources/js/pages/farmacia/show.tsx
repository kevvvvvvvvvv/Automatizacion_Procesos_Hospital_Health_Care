import React from 'react';
import { Head, router } from '@inertiajs/react';
import { HojaEnfermeria, Paciente, HojaMedicamento } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import { Pill, CheckCircle2, AlertTriangle, User } from 'lucide-react';

interface Props {
    hoja: HojaEnfermeria;
    paciente: Paciente;
}

const ShowSolicitud = ({ hoja, paciente }: Props) => {
    const solicitados = hoja.hoja_medicamentos?.filter(m => m.estado === 'solicitado') || [];
    const surtidos = hoja.hoja_medicamentos?.filter(m => m.estado === 'surtido') || [];

    const handleSurtirMedicamento = (medicamentoId: number) => {
        Swal.fire({
            title: '¿Confirmar surtido?',
            text: "¿Estás seguro de surtir este medicamento?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33',  
            confirmButtonText: 'Sí, surtir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                router.patch(route('medicamentos.actualizar-estado', { medicamento: medicamentoId }), {
                    estado: 'surtido',
                }, {
                    preserveScroll: true,
                });
            }
        });
    }

    return (
<<<<<<< HEAD
        <MainLayout link='peticiones.index' pageTitle="Detalle de Solicitud">
            <Head title={`Solicitud - ${paciente.nombre}`} />
            
            <div className="max-w-4xl mx-auto p-2 sm:p-4">
                {/* Header Card */}
                <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
                    <div className="flex items-center gap-3 mb-2">
                        <div className="p-2 bg-blue-50 text-blue-600 rounded-lg">
                            <User size={24} />
                        </div>
                        <h1 className="text-xl sm:text-2xl font-bold text-gray-800">Solicitud de medicamentos</h1>
                    </div>
                    <p className="text-gray-600 flex items-center gap-2">
                        Paciente: <span className="font-bold text-gray-900">{paciente.nombre} {paciente.apellido_paterno}</span>
                    </p>
                </div>
=======
         <MainLayout link='solicitudes-medicamentos.index'>
            <Head title={`Solicitud para ${paciente.nombre}`} />
            <h1 className="text-2xl font-bold">Solicitud de medicamentos</h1>
            <p className="mb-4">Paciente: <span className="font-semibold">{paciente.nombre} {paciente.apellido_paterno}</span></p>
>>>>>>> 3554850e322fe1aaab08586af2cb7d80e074be8d

                {/* Sección Pendientes */}
                <div className="bg-white rounded-xl shadow-md overflow-hidden border border-amber-100">
                    <div className="bg-amber-50 px-5 py-3 border-b border-amber-100">
                        <h2 className="text-lg font-bold text-amber-800 flex items-center gap-2">
                            <Pill size={20} /> Pendientes de surtir
                        </h2>
                    </div>
                    
                    <div className="divide-y divide-gray-100">
                        {solicitados.length > 0 ? solicitados.map((med: HojaMedicamento) => (
                            <div key={med.id} className="p-5 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 hover:bg-gray-50 transition-colors">
                                <div className="flex-1">
                                    <p className="font-bold text-gray-900 text-lg">{med.nombre_medicamento}</p>
                                    
                                    {!med.producto_servicio_id && (
                                        <p className='text-red-600 text-xs font-bold flex items-center gap-1 mt-1 bg-red-50 p-1 rounded inline-flex'>
                                            <AlertTriangle size={14} /> No registrado en inventario
                                        </p>
                                    )}

                                    <div className="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-600">
                                        <span className="bg-gray-100 px-2 py-0.5 rounded"><b>Dosis:</b> {med.dosis}</span>
                                        <span className="bg-gray-100 px-2 py-0.5 rounded"><b>Vía:</b> {med.via_administracion}</span>
                                    </div>
                                </div>
                                
                                <PrimaryButton 
                                    onClick={() => handleSurtirMedicamento(med.id)}
                                    className="w-full sm:w-auto justify-center shadow-sm"
                                >
                                    Surtir medicamento
                                </PrimaryButton>
                            </div>
                        )) : (
                            <div className="p-10 text-center text-gray-500 italic">
                                No hay medicamentos pendientes.
                            </div>
                        )}
                    </div>
                </div>

                {/* Sección Surtidos */}
                <div className="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mt-8">
                    <div className="bg-green-50 px-5 py-3 border-b border-green-100">
                        <h2 className="text-lg font-bold text-green-800 flex items-center gap-2">
                            <CheckCircle2 size={20} /> Ya surtidos
                        </h2>
                    </div>
                    
                    <div className="divide-y divide-gray-100">
                        {surtidos.length > 0 ? surtidos.map((med: HojaMedicamento) => (
                            <div key={med.id} className="p-5 bg-gray-50/50">
                                <div className="flex justify-between items-start">
                                    <div>
                                        <p className="font-semibold text-gray-500">{med.nombre_medicamento}</p>
                                        {!med.producto_servicio_id && (
                                            <p className='text-red-400 text-xs font-bold'>No registrado en inventario</p>
                                        )}
                                        <p className="text-xs text-gray-400 mt-1 italic">
                                            Entregado el: {new Date(med.fecha_hora_surtido_farmacia).toLocaleString()}
                                        </p>
                                    </div>
                                    <div className="text-green-600 bg-green-100 p-1 rounded-full">
                                        <CheckCircle2 size={18} />
                                    </div>
                                </div>
                            </div>
                        )) : (
                            <div className="p-10 text-center text-gray-500 italic">
                                Aún no se han surtido medicamentos.
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}

export default ShowSolicitud;