import React from 'react';
import { Head, router } from '@inertiajs/react';
import { HojaEnfermeria, Paciente, HojaMedicamento } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

interface Props {
    hoja: HojaEnfermeria;
    paciente: Paciente;
}

const ShowSolicitud: React.FC<Props> & { layout: any } = ({ hoja, paciente }) => {

    const solicitados = hoja.hoja_medicamentos?.filter(m => m.estado === 'solicitado') || [];
    const surtidos = hoja.hoja_medicamentos?.filter(m => m.estado === 'surtido') || [];

    const handleSurtirMedicamento = (medicamentoId: number) => {
        Swal.fire({
            title: '¿Confirmar Surtido?',
            text: "¿Estás seguro de surtir este medicamento? Esta acción registrará el cargo.",
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
        <>
            <Head title={`Solicitud para ${paciente.nombre}`} />
            <h1 className="text-2xl font-bold">Solicitud de Medicamentos</h1>
            <p className="mb-4">Paciente: <span className="font-semibold">{paciente.nombre} {paciente.apellido_paterno}</span></p>

            <div className="bg-white p-6 rounded-lg shadow-md">
                <h2 className="text-xl font-semibold mb-3">Pendientes de Surtir</h2>
                <ul className="divide-y">
                    {solicitados.length > 0 ? solicitados.map((med: HojaMedicamento) => (
                        <li key={med.id} className="flex justify-between items-center py-3">
                            <div>
                                <p className="font-semibold">{med.producto_servicio?.nombre_prestacion}</p>
                                <p className="text-sm text-gray-600">
                                    Dosis: {med.dosis} | Vía: {med.via_administracion}
                                </p>
                            </div>
                            <PrimaryButton 
                                onClick={() => handleSurtirMedicamento(med.id)}
                            >
                                Marcar como Surtido
                            </PrimaryButton>
                        </li>
                    )) : <p className="text-gray-500">No hay medicamentos pendientes.</p>}
                </ul>
            </div>

            <div className="bg-white p-6 rounded-lg shadow-md mt-6">
                <h2 className="text-xl font-semibold mb-3 text-green-700">Ya Surtidos</h2>
                <ul className="divide-y">
                    {surtidos.length > 0 ? surtidos.map((med: HojaMedicamento) => (
                        <li key={med.id} className="py-3">
                            <p className="font-semibold text-gray-500">{med.producto_servicio?.nombre_prestacion}</p>
                            <p className="text-sm text-gray-400">
                                Surtido: {new Date(med.fecha_hora_surtido_farmacia).toLocaleString()}
                            </p>
                        </li>
                    )) : <p className="text-gray-500">Aún no se han surtido medicamentos.</p>}
                </ul>
            </div>
        </>
    );
}

ShowSolicitud.layout = (page: React.ReactElement) => <MainLayout children={page} />;
export default ShowSolicitud;