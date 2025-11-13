import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Plus,ChevronDown, Pencil, Eye } from 'lucide-react'; 
import { Menu } from '@headlessui/react';
import { route } from 'ziggy-js';
import { Printer } from 'lucide-react'; 
import MainLayout from '@/layouts/MainLayout';
import { Estancia, Paciente, User, FormularioInstancia, Habitacion, FamiliarResponsable} from '@/types'; 
import InfoCard from '@/components/ui/info-card';
import InfoField from '@/components/ui/info-field';

interface ShowEstanciaProps {
    estancia: Estancia & {
        paciente: Paciente;
        creator: User | null;
        updater: User | null;
        familiar_responsable: FamiliarResponsable | null;
        habitacion: Habitacion | null;

        formulario_instancias: (FormularioInstancia & {
            catalogo: { 
                nombre_formulario: string,
                route_prefix: string,
             };
            user: User;
        })[];
    };
}

const Show = ({ estancia }: ShowEstanciaProps) => {

    const { paciente, creator, updater, formulario_instancias } = estancia;

    const dateOptions: Intl.DateTimeFormatOptions = {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit',
    };

    return (
        <>
            <Head title={`Detalles de estancia: ${estancia.folio}`} />
            <Link
                href={route('pacientes.estancias.ventas.index', { paciente, estancia })}
            >
                Ir a Ventas
            </Link>

            <InfoCard title={`Estancia para: ${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <InfoField label="Folio" value={estancia.folio} />
                    <InfoField label="Tipo de estancia" value={estancia.tipo_estancia} />
                    <InfoField 
                        label="Fecha de Ingreso" 
                        value={new Date(estancia.fecha_ingreso).toLocaleString('es-MX', dateOptions)} 
                    />
                    { estancia.tipo_estancia === 'Hospitalizacion' && (
                    <InfoField 
                        label="Fecha de egreso" 
                        value={estancia.fecha_egreso 
                            ? new Date(estancia.fecha_egreso).toLocaleString('es-MX', dateOptions) 
                            : 'Aún hospitalizado(a)'} 
                    />
                    )}
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
                    <div className="relative inline-block text-left">
                        <Menu as="div">
                            <Menu.Button className="inline-flex items-center justify-center w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                <Plus size={16} className="mr-2"/>
                                Añadir Documento
                                <ChevronDown size={16} className="ml-2 -mr-1" />
                            </Menu.Button>

                            <Menu.Items className="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div className="px-1 py-1">
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.hojasfrontales.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir hoja frontal
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.historiasclinicas.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir historia clínica
                                            </Link>
                                        )}
                                    </Menu.Item>
                                   <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.interconsultas.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir interconsulta
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.hojasenfermerias.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir hoja de enfermería
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.traslados.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir traslado
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.preoperatorias.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir preoperatoria
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                 className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir nota postoperatoria
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.notasurgencias.create', { paciente: paciente.id, estancia: estancia.id })}
                                                className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir Nota de Urgencias
                                            </Link>
                                        )}
                                    </Menu.Item>
                                    <Menu.Item>
                                        {({ active }) => (
                                            <Link
                                                href={route('pacientes.estancias.notasegresos.create', { paciente: paciente.id, estancia: estancia.id })}
                                                 className={`${
                                                    active ? 'bg-blue-500 text-white' : 'text-gray-900'
                                                } group flex rounded-md items-center w-full px-2 py-2 text-sm`}
                                            >
                                                Añadir Nota de egreso
                                             
                                            </Link>
                                        )}
                                    </Menu.Item>
                                </div>
                            </Menu.Items>
                        </Menu>
                    </div>
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
                                    
                                    <Link
                                        href={route(`${formulario.catalogo.route_prefix}.edit`, formulario.id)}
                                        className="p-2 text-blue-500 hover:bg-blue-100 hover:text-blue-700 rounded-full transition"
                                        title="Editar Hoja Frontal"
                                    >
                                        <Pencil size={18} />
                                    </Link>

                                    <Link 
                                        href={route(`${formulario.catalogo.route_prefix}.show`, formulario.id)}
                                        className="p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-800 rounded-full transition"
                                        title="Ver detalles del formulario"
                                    >
                                        <Eye size={18} />
                                    </Link>

                                    <a 
                                        href={route(`${formulario.catalogo.route_prefix}.pdf`, formulario.id)}
                                        target="_blank"
                                        className="p-2 text-red-500 hover:bg-red-100 hover:text-red-700 rounded-full transition"
                                        title="Imprimir / Descargar PDF"
                                    >
                                        <Printer size={18} />
                                    </a>
                                </div>
                            </div>
       
                        ))
                    ) : (
                        <p className="text-gray-500 italic text-center py-4">No hay formularios registrados para esta estancia.</p>
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
