import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { Trash2, Settings, Monitor, ChevronRight } from 'lucide-react';

export default function Index() {
    
    // Configuración de los botones para no repetir código
    const categorias = [
        {
            id: 'limpieza',
            titulo: 'Limpieza',
            descripcion: 'Reportar falta de higiene o solicitud de aseo.',
            color: 'bg-emerald-500',
            icon: <Trash2 size={32} className="text-white" />,
            hover: 'hover:border-emerald-500 hover:bg-emerald-50'
        },
        {
            id: 'mantenimiento',
            titulo: 'Mantenimiento',
            descripcion: 'Reparaciones físicas, luces, plomería o mobiliario.',
            color: 'bg-orange-500',
            icon: <Settings size={32} className="text-white" />,
            hover: 'hover:border-orange-500 hover:bg-orange-50'
        },
        {
            id: 'sistemas',
            titulo: 'Sistemas',
            descripcion: 'Soporte técnico, software, red o equipos de cómputo.',
            color: 'bg-blue-600',
            icon: <Monitor size={32} className="text-white" />,
            hover: 'hover:border-blue-600 hover:bg-blue-50'
        }
    ];

    const handleAction = (tipo) => {
        console.log(`Abriendo formulario para: ${tipo}`);
        // Aquí podrías usar router.get(route('mantenimiento.crear', { tipo }))
    };  

    return (
        <MainLayout pageTitle="Panel de Mantenimiento">
            <Head title="Mantenimiento" />

            <div className="max-w-6xl mx-auto py-10 px-4">
                <div className="text-center mb-12">
                    <h1 className="text-4xl font-black text-gray-900 mb-2">Mantenimiento y Soporte</h1>
                    <p className="text-gray-500">Selecciona el departamento al que deseas dirigir tu solicitud.</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {categorias.map((cat) => (
                        <button
                            key={cat.id}
                            onClick={() => handleAction(cat.id)}
                            className={`group flex flex-col p-8 bg-white border-2 border-transparent rounded-3xl shadow-xl transition-all duration-300 transform hover:-translate-y-2 text-left ${cat.hover}`}
                        >
                            <div className={`${cat.color} w-16 h-16 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform`}>
                                {cat.icon}
                            </div>
                            
                            <h2 className="text-2xl font-black text-gray-800 mb-3">{cat.titulo}</h2>
                            <p className="text-gray-500 mb-8 flex-1">
                                {cat.descripcion}
                            </p>

                            <div className="flex items-center text-sm font-bold uppercase tracking-widest text-gray-400 group-hover:text-gray-800 transition-colors">
                                Generar reporte 
                                <ChevronRight size={18} className="ml-1 group-hover:translate-x-2 transition-transform" />
                            </div>
                        </button>
                    ))}
                </div>

                <div className="mt-16 bg-blue-50 rounded-2xl p-6 border border-blue-100 flex items-center gap-4">
                    <div className="bg-blue-100 p-3 rounded-full text-blue-600 font-bold text-sm">i</div>
                    <p className="text-blue-800 text-sm">
                        <b>Nota importante:</b> Los reportes de sistemas son atendidos bajo prioridad técnica. Para urgencias médicas críticas, contactar directamente por extensión.
                    </p>
                </div>
            </div>
        </MainLayout>
    );
}