import React from 'react';
import { Head, router } from '@inertiajs/react';
import { HojaEnfermeria, Paciente, HojaMedicamento } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import { Pill, CheckCircle2, AlertTriangle, ArrowLeft } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface Props {
    hoja: HojaEnfermeria;
    paciente: Paciente;
}

const ShowSolicitud = ({ hoja, paciente }: Props) => {
    // Memorizamos los filtros para evitar cálculos innecesarios en cada render
    const solicitados = React.useMemo(() => 
        hoja.hoja_medicamentos?.filter(m => m.estado === 'solicitado') || [], 
    [hoja.hoja_medicamentos]);

    const surtidos = React.useMemo(() => 
        hoja.hoja_medicamentos?.filter(m => m.estado === 'surtido') || [], 
    [hoja.hoja_medicamentos]);

    const handleSurtirMedicamento = (medicamentoId: number) => {
        Swal.fire({
            title: '¿Confirmar surtido?',
            text: "¿Estás seguro de marcar este medicamento como entregado?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981', // Color verde esmeralda (surtido)
            cancelButtonColor: '#6b7280',  
            confirmButtonText: 'Sí, surtir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                router.patch(route('medicamentos.actualizar-estado', { medicamento: medicamentoId }), {
                    estado: 'surtido',
                }, {
                    preserveScroll: true,
                    onSuccess: () => {
                        Swal.fire('¡Surtido!', 'El medicamento ha sido actualizado.', 'success');
                    }
                });
            }
        });
    }

    return (
        <MainLayout link='solicitudes-medicamentos.index'>
            <Head title={`Solicitud - ${paciente.nombre}`} />

            <div className="max-w-5xl mx-auto py-6 px-4">
                

                <div className="mb-8">
                    <h1 className="text-3xl font-black text-gray-900 tracking-tight">Solicitud de Medicamentos</h1>
                    <div className="mt-2 flex items-center gap-2 text-gray-600">
                        <div className="bg-blue-100 p-1.5 rounded-full text-blue-600">
                             <ArrowLeft size={16} className="rotate-180" /> 
                        </div>
                        <p className="text-lg">
                            Paciente: <span className="font-bold text-gray-900">{paciente.nombre} {paciente.apellido_paterno} {paciente.apellido_materno}</span>
                        </p>
                    </div>
                </div>

                {/* Sección Pendientes */}
                <div className="bg-white rounded-2xl shadow-sm overflow-hidden border border-amber-200">
                    <div className="bg-amber-50 px-6 py-4 border-b border-amber-100 flex justify-between items-center">
                        <h2 className="text-lg font-bold text-amber-800 flex items-center gap-2">
                            <Pill size={22} /> Pendientes de surtir
                        </h2>
                        <span className="bg-amber-200 text-amber-800 text-xs font-black px-2.5 py-1 rounded-full">
                            {solicitados.length} PENDIENTES
                        </span>
                    </div>
                    
                    <div className="divide-y divide-gray-100">
                        {solicitados.length > 0 ? solicitados.map((med: HojaMedicamento) => (
                            <div key={med.id} className="p-6 flex flex-col md:flex-row md:justify-between md:items-center gap-6 hover:bg-amber-50/30 transition-colors">
                                <div className="flex-1">
                                    <h3 className="font-black text-gray-900 text-xl uppercase tracking-tight">{med.nombre_medicamento}</h3>
                                    
                                    {!med.producto_servicio_id && (
                                        <div className='flex items-center gap-1.5 mt-1.5 text-red-600 bg-red-50 px-3 py-1 rounded-lg border border-red-100 inline-flex'>
                                            <AlertTriangle size={14} /> 
                                            <span className="text-xs font-bold uppercase">No vinculado a inventario central</span>
                                        </div>
                                    )}

                                    <div className="mt-4 flex flex-wrap gap-3 text-sm">
                                        <span className="bg-white border border-gray-200 px-3 py-1 rounded-md shadow-sm text-gray-700">
                                            <b className="text-gray-400 mr-1 uppercase text-[10px]">Dosis:</b> {med.dosis}
                                        </span>
                                        <span className="bg-white border border-gray-200 px-3 py-1 rounded-md shadow-sm text-gray-700">
                                            <b className="text-gray-400 mr-1 uppercase text-[10px]">Vía:</b> {med.via_administracion}
                                        </span>
                                    </div>
                                </div>
                                
                                <PrimaryButton 
                                    onClick={() => handleSurtirMedicamento(med.id)}
                                    className="w-full md:w-auto px-8 py-3 bg-amber-600 hover:bg-amber-700 justify-center transition-all transform active:scale-95"
                                >
                                    Surtir ahora
                                </PrimaryButton>
                            </div>
                        )) : (
                            <div className="p-12 text-center">
                                <CheckCircle2 className="mx-auto text-green-400 mb-2" size={40} />
                                <p className="text-gray-500 font-medium">Todo surtido. No hay pendientes.</p>
                            </div>
                        )}
                    </div>
                </div>

                {/* Sección Surtidos */}
                <div className="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 mt-10">
                    <div className="bg-gray-50 px-6 py-4 border-b border-gray-100">
                        <h2 className="text-lg font-bold text-gray-600 flex items-center gap-2">
                            <CheckCircle2 size={22} className="text-green-500" /> Historial de entrega (Surtidos)
                        </h2>
                    </div>
                    
                    <div className="divide-y divide-gray-50">
                        {surtidos.length > 0 ? surtidos.map((med: HojaMedicamento) => (
                            <div key={med.id} className="p-6 bg-white opacity-80">
                                <div className="flex justify-between items-center gap-4">
                                    <div>
                                        <p className="font-bold text-gray-400 uppercase line-through">{med.nombre_medicamento}</p>
                                        <p className="text-[11px] text-gray-400 mt-1 flex items-center gap-1 font-medium">
                                            <ClockIcon size={12} />
                                            Entregado el: {med.fecha_hora_surtido_farmacia 
                                                ? new Date(med.fecha_hora_surtido_farmacia).toLocaleString() 
                                                : 'Fecha no registrada'}
                                        </p>
                                    </div>
                                    <div className="bg-green-100 text-green-600 p-2 rounded-xl shadow-inner">
                                        <CheckCircle2 size={24} />
                                    </div>
                                </div>
                            </div>
                        )) : (
                            <div className="p-12 text-center text-gray-400 font-medium">
                                Historial vacío.
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}

// Icono auxiliar rápido
const ClockIcon = ({ size }: { size: number }) => (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
);

export default ShowSolicitud;