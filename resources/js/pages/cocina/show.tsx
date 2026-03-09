import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { SolicitudDieta, User } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';
import SelectInput from '@/components/ui/input-select';


interface DietaPendienteRowProps {
    dieta: SolicitudDieta;
    userOptions:{ label: string; value: number }[];
}

const DietaPendienteRow = ({ dieta, userOptions }: DietaPendienteRowProps) => {

    const { data, setData, errors, processing, put } = useForm({
        user_supervisa_id: dieta.hoja_enfermeria.formulario_instancia.user_id || '',
    });

    const handleActualizarEstado = (e: React.FormEvent) => {
        e.preventDefault();

        Swal.fire({
            title: '¿Confirmar entrega?',
            text: "¿Estás seguro de marcar esta dieta como entregada?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                put(route('solicitudes-dietas.update', { solicitud_dieta: dieta.id }), {
                    preserveScroll: true,
                });
            }
        });
    };

    return (
        <form onSubmit={handleActualizarEstado} className="grid grid-cols-1 md:grid-cols-2 items-center py-4">
            <div className="space-y-1">
                <p className="font-bold text-lg text-slate-700">
                    {dieta.hoja_enfermeria?.formulario_instancia?.estancia?.paciente?.nombre_completo}
                </p>
                <p> Habitación del paciente: {dieta.hoja_enfermeria.formulario_instancia.estancia?.habitacion?.identificador ? dieta.hoja_enfermeria.formulario_instancia.estancia?.habitacion?.identificador : 'N/A'}</p>
                <p className='text-emerald-900'>Tipo de dieta: {dieta.dieta.categoria_dieta.categoria}</p>
                <p className="text-blue-600 font-medium">Dieta: {dieta.dieta.alimento}</p>
                <p className="text-sm text-gray-500 italic">
                    Obs: {dieta.observaciones || 'Sin observaciones adicionales'}
                </p>
            
                <p className={dieta.lugar_entrega === 'Área cocina' ? 'text-red-600' : 'text-gray-600'}>
                    Área de entrega: {dieta.lugar_entrega}
                </p>
                <p className='text-sm text-gray-700'>Horario de entrega programada: {dieta.fecha_hora_programada}</p>
            </div>
            <div>
                <SelectInput
                    options={userOptions}
                    label='Personal que supervisa'
                    value={data.user_supervisa_id}
                    onChange={e => setData('user_supervisa_id', e)}
                    error={errors.user_supervisa_id}
                />

                <PrimaryButton 
                    type="submit" 
                    disabled={processing} 
                >
                    {processing ? 'Enviando...' : 'Marcar como surtido'}
                </PrimaryButton>
            </div>
        </form>
    );
};

interface Props {
    solicitud_dietas: SolicitudDieta[];
    users: User[];
}

const Show = ({ 
    solicitud_dietas = [],
    users = [], 
}: Props) => {

    const userOptions = users.map((u) => ({ label: u.nombre_completo, value: u.id }));

    const pendientes = solicitud_dietas.filter(d => d.estado === 'PENDIENTE');
    const completadas = solicitud_dietas.filter(d => d.estado === 'SURTIDA');

    return (
        <MainLayout pageTitle='Gestión de dietas' link='solicitudes-dietas.index'>
            <Head title="Consulta de solicitudes de dietas" />

            <div className="mb-6">
                <h1 className="text-2xl font-bold text-gray-800">Solicitudes de dietas</h1>
                <p className="text-gray-600">Administración y control de alimentación para pacientes.</p>
            </div>

            <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
                <h2 className="text-xl font-semibold mb-4 text-yellow-700 flex items-center">
                    Pendientes de entrega
                </h2>
                <div className="divide-y">
                    {pendientes.length > 0 ? pendientes.map((dieta) => (
                        <DietaPendienteRow 
                            key={dieta.id} 
                            dieta={dieta} 
                            userOptions={userOptions} 
                        />
                    )) : (
                        <p className="text-gray-500 py-2">No hay dietas pendientes de surtir.</p>
                    )}
                </div>
            </div>

            <div className="bg-gray-50 p-6 rounded-lg shadow-sm border-l-4 border-green-500 mt-8">
                <h2 className="text-xl font-semibold mb-4 text-green-700 flex items-center">
                    Recientemente entregadas
                </h2>
                <div className="divide-y">
                    {completadas.length > 0 ? completadas.map((dieta) => (
                        <div key={dieta.id} className="py-3 opacity-75">
                            <p className="font-semibold text-gray-600">
                                {dieta.hoja_enfermeria?.formulario_instancia?.estancia?.paciente?.nombre}
                            </p>
                            <p className="text-sm text-gray-500">
                                {dieta.dieta.categoria_dieta.categoria} — <span className="text-xs">Entregado a las: {new Date(dieta.horario_entrega).toLocaleString()}</span>
                            </p>
                        </div>
                    )) : (
                        <p className="text-gray-500 py-2">Aún no se han registrado entregas hoy.</p>
                    )}
                </div>
            </div>
        </MainLayout>
    );
}

export default Show;