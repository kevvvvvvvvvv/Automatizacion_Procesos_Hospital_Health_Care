import { Menu, Transition } from '@headlessui/react';
import { Fragment } from 'react';
import { route } from 'ziggy-js'
import { Link } from '@inertiajs/react';
import { 
    Plus, ChevronDown, Activity, FileText, 
    Stethoscope, FileSignature, UserCheck,
    Syringe
} from 'lucide-react';
import { Estancia, Paciente } from '@/types';
import { usePermission } from '@/hooks/use-permission';

interface Props{
    paciente: Paciente;
    estancia: Estancia;
}

export default function DropdownDocumentos({ 
    paciente, 
    estancia 
} : Props) {
    
    const { can } = usePermission();

    const notasMedicas = [
        { name: 'Historia clínica', route: 'historiasclinicas.create' },
        { name: 'Interconsulta', route: 'interconsultas.create' },
        { name: 'Nota de evolución', route: 'notasevoluciones.create' },
        { name: 'Nota de urgencias', route: 'notasurgencias.create' },
        { name: 'Nota de traslado', route: 'traslados.create' },
        { name: 'Nota preoperatoria', route: 'preoperatorias.create' },
        { name: 'Nota postoperatoria', route: 'notaspostoperatorias.create' },
        { name: 'Nota preanestésica', route: 'notaspreanestesicas.create' },
        { name: 'Nota postanestésica', route: 'notaspostanestesicas.create' },
        { name: 'Nota de egreso', route: 'notasegresos.create' },
    ];

    const notasEnfermeria = [
        { name: 'Hoja de enfermería en hospitalización', route: 'pacientes.estancias.hojasenfermerias.create', method: 'get'},
        { name: 'Hoja de enfermería en quirófano', route: 'pacientes.estancias.hojasenfermeriasquirofanos.store', method: 'post'},
        { name: 'Hoja de enfermería de recién nacido', route: 'pacientes.estancias.reciennacido.create', method:'get'},
    ];

    const encuestas = [
        { name: 'Encuesta de satisfacción', route: 'estancias.encuesta-satisfaccions.create' },
        { name: 'Encuesta de trato de personal', route: 'estancias.encuestapersonal.create' },
    ]

    const solicitudes = [
        { name: 'Estudios', route: 'estancia.solicitudes-estudios.create'},
    ];

    return (
        <div className="relative inline-block text-left">
            <Menu as="div">
                <Menu.Button className="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
                    <Plus size={18} className="mr-2"/>
                    Añadir documento
                    <ChevronDown size={18} className="ml-2 -mr-1 opacity-70" />
                </Menu.Button>

                <Transition
                    as={Fragment}
                    enter="transition ease-out duration-100"
                    enterFrom="transform opacity-0 scale-95"
                    enterTo="transform opacity-100 scale-100"
                    leave="transition ease-in duration-75"
                    leaveFrom="transform opacity-100 scale-100"
                    leaveTo="transform opacity-0 scale-95"
                >
                    <Menu.Items className="absolute right-0 w-80 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50 max-h-[80vh] overflow-y-auto custom-scrollbar">
                        
                        {/* Enfermería */}
                        {can('crear hojas enfermerias') && (
                            <div className="p-2">
                                <div className="px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
                                    Área de Enfermería
                                </div>
                                {notasEnfermeria.map((item,index) => (
                                <Menu.Item key={index}>
                                    {({ active }) => (
                                        <Link href={route(item.route, { paciente: paciente.id, estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`} method={item.method === 'post' ? 'post' : 'get'}>
                                            <Activity size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                            {item.name}
                                        </Link>
                                    )}
                                </Menu.Item>
                                ))}
                            </div>
                        )}

                        {/* Documentos generales */}
                        <div className="p-2 bg-gray-50/50">
                            <div className="px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
                                Documentos generales
                            </div>
                            <Menu.Item>
                                {({ active }) => (
                                    <Link href={route('pacientes.estancias.hojasfrontales.create', { paciente: paciente.id, estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`}>
                                        <FileText size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                        Hoja frontal
                                    </Link>
                                )}
                            </Menu.Item>
                            
                            {can('crear consentimientos') && (
                                <Menu.Item>
                                    {({ active }) => (
                                        <Link href={route('pacientes.estancias.consentimientos.create', { paciente: paciente.id, estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`}>
                                            <FileSignature size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                            Consentimientos
                                        </Link>
                                    )}
                                </Menu.Item>
                            )}
                        </div>

                        {/* Documentos médicos */}
                        {can('crear documentos medicos') && (
                            <div className="p-2">
                                <div className="px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
                                    Notas médicas
                                </div>
                                {notasMedicas.map((item, index) => (
                                    <Menu.Item key={index}>
                                        {({ active }) => (
                                            <Link href={route(`pacientes.estancias.${item.route}`, { paciente: paciente.id, estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`}>
                                                <Stethoscope size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                                {item.name}
                                            </Link>
                                        )}
                                    </Menu.Item>
                                ))}
                            </div>
                        )}
                            <div className="p-2">
                                <div className="px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
                                    Encuestas
                                </div>
                                {encuestas.map((item, index) => (
                                    <Menu.Item key={index}>
                                        {({ active }) => (
                                            <Link href={route(`${item.route}`, { paciente: paciente.id, estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`}>
                                                <UserCheck size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                                {item.name}
                                            </Link>
                                        )}
                                    </Menu.Item>
                                ))}
                            </div>

                            <div className="p-2">
                                <div className="px-3 py-2 text-xs font-bold tracking-wider text-gray-400 uppercase">
                                    Solucitudes
                                </div>
                                {solicitudes.map((item, index) => (
                                    <Menu.Item key={index}>
                                        {({ active }) => (
                                            <Link href={route(`${item.route}`, { estancia: estancia.id })} className={`${active ? 'bg-blue-50 text-blue-700' : 'text-gray-700'} group flex rounded-lg items-center w-full px-3 py-2 text-sm transition-colors`}>
                                                <Syringe size={16} className={`mr-3 ${active ? 'text-blue-600' : 'text-gray-400'}`} />
                                                {item.name}
                                            </Link>
                                        )}
                                    </Menu.Item>
                                ))}
                            </div>

                    </Menu.Items>
                </Transition>
            </Menu>
        </div>
    );
}