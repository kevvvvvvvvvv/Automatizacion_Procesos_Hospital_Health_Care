import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Plus } from 'lucide-react'; 
import { route } from 'ziggy-js';
import { Printer } from 'lucide-react'; 
import MainLayout from '@/layouts/MainLayout';
import { Estancia, Paciente, User, FormularioInstancia, Habitacion, FamiliarResponsable} from '@/types'; 
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';
import AddButton from '@/components/ui/add-button';

interface ShowEstanciaProps {
    estancia: Estancia & {
        paciente: Paciente;
        creator: User | null;
        updater: User | null;
        familiar_responsable: FamiliarResponsable | null;
        habitacion: Habitacion | null;

        formulario_instancias: (FormularioInstancia & {
            catalogo: { nombre_formulario: string };
            user: User;
        })[];
    };
}

const Show = ({ estancia }: ShowEstanciaProps) => {

    console.log("Datos completos de la estancia que llegan a React:", estancia);
    const { paciente, creator, updater, formulario_instancias } = estancia;

    const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };

    return (
        <>
            <Head title={`Detalles de estancia: ${estancia.folio}`} />

            <InfoCard title={`Estancia para: ${paciente.nombre} ${paciente.apellido_paterno}`}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <InfoField label="Folio" value={estancia.folio} />
                    <InfoField label="Tipo de estancia" value={estancia.tipo_estancia} />
                    <InfoField 
                        label="Fecha de Ingreso" 
                        value={new Date(estancia.fecha_ingreso).toLocaleString('es-MX', dateOptions)} 
                    />
                    <InfoField 
                        label="Fecha de egreso" 
                        value={estancia.fecha_egreso 
                            ? new Date(estancia.fecha_egreso).toLocaleString('es-MX', dateOptions) 
                            : 'Aún hospitalizado(a)'} 
                    />
                    <InfoField label="Número de habitación" value={estancia.habitacion?.identificador ?? 'N/A'} />
                    <InfoField label="Creado por" value={creator ? creator.nombre : 'N/A'} />
                    <InfoField 
                        label="Última actualización por" 
                        value={updater ? updater.nombre : 'N/A'} 
                    />

                    <InfoField 
                        label="Familiar resposable" 
                        value={estancia.familiar_responsable?.nombre_completo ?? 'N/A'} 
                    />
                </div>
            </InfoCard>

            <div className="mt-8">
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-xl font-semibold">Formularios Registrados</h2>
                    <Link
                        href={route('pacientes.estancias.hojasfrontales.create', { paciente: paciente.id, estancia: estancia.id })}
                        className="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
                    >
                        <Plus size={16} className="mr-2"/>
                        Añadir Hoja Frontal
                    </Link>
                    {/* BOTÓN CORREGIDO: Usa la ruta anidada con parámetros paciente y estancia */}
                 <AddButton 
                    href={route('pacientes.estancias.interconsultas.create', {
                        paciente: paciente.id,  // Asegúrate de que estos parámetros coincidan con lo que espera la ruta
                        estancia: estancia.id
                    })} 
                    className="ml-4"
                >
                    Agregar Interconsulta
                </AddButton>
                </div>
                
                <div className="space-y-4">
                    {formulario_instancias && formulario_instancias.length > 0 ? (
                        formulario_instancias.map((formulario) => (
                            <div key={formulario.id} className="p-4 border rounded-md bg-gray-50 flex justify-between items-center">
                                <div>
                                    <p className="font-semibold text-indigo-600">
                                        {formulario.catalogo.nombre_formulario}
                                    </p>
                                    <p className="text-sm text-gray-600">
                                        Registrado por: {formulario.user.nombre}
                                    </p>
                                    <p className="text-xs text-gray-500">
                                        {new Date(formulario.fecha_hora).toLocaleString('es-MX', dateOptions)}
                                    </p>
                                </div>
                                <div className="flex items-center space-x-2">
                                    {/*<Link 
                                        href={route('hoja-frontales.show', formulario.id)}
                                        className="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition"
                                        title="Ver detalles del formulario"
                                    >
                                        <Eye size={18} />
                                    </Link>*/}
                                </div>
                                    <a 
                                        href={route('hojasfrontales.pdf', formulario.id)}
                                        target="_blank"
                                        className="p-2 text-red-500 hover:bg-red-100 hover:text-red-700 rounded-full transition"
                                        title="Imprimir / Descargar PDF"
                                    >
                                        <Printer size={18} />
                                    </a>
                            </div>
                        ))
                    ) : (
                        <p className="text-gray-500 italic text-center py-4">No hay formularios registrados para esta estancia.</p>
                    )}
                      {/* NUEVA SECCIÓN: Lista de Interconsultas */}
        {estancia.interconsultas && estancia.interconsultas.length > 0 ? (
            <>
                <h3 className="text-lg font-semibold mt-8 mb-4">Interconsultas Registradas</h3>
                {estancia.interconsultas.map((interconsulta) => (
                    <div key={interconsulta.id} className="p-4 border rounded-md bg-blue-50 flex justify-between items-center">
                        <div>
                            <p className="font-semibold text-blue-600">
                                Interconsulta para {paciente.nombre} {paciente.apellido_paterno}
                            </p>
                            <p className="text-sm text-gray-600">
                                Creada por: {interconsulta.creator ? interconsulta.creator.nombre : 'N/A'}
                            </p>
                            <p className="text-xs text-gray-500">
                                {new Date(interconsulta.created_at).toLocaleString('es-MX', dateOptions)}
                            </p>
                        </div>
                        <div className="flex items-center space-x-2">
                            {/* BOTÓN PARA IR A LA PÁGINA DE DETALLES */}
                            <Link 
                                href={route('pacientes.estancias.interconsultas.show', {
                                    paciente: paciente.id,
                                    estancia: estancia.id,
                                    interconsulta: interconsulta.id
                                })}
                                className="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded-md hover:bg-blue-700 transition"
                                title="Ver detalles de la interconsulta"
                            >
                                Ver Detalles
                            </Link>
                            <a 
                                href={route('interconsultas.pdf', interconsulta.id)}  // Asumiendo ruta para PDF
                                target="_blank"
                                className="p-2 text-red-500 hover:bg-red-100 hover:text-red-700 rounded-full transition"
                                title="Imprimir / Descargar PDF"
                            >
                                <Printer size={18} />
                            </a>
                        </div>
                    </div>
                ))}
            </>
        ) : (
            <p className="text-gray-500 italic text-center py-4 mt-8">No hay interconsultas registradas para esta estancia.</p>
        )}
                </div>
            </div>
        </>
        
    );
};

Show.layout = (page: React.ReactElement) => {                   
    const { estancia } = page.props as ShowEstanciaProps;
    return (
        <MainLayout pageTitle={`Detalles de estancia de ${estancia.paciente.nombre}`} children={page} />
    );
};

export default Show;
