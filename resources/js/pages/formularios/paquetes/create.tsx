import React, { useMemo, useState } from 'react';
import { useForm, usePage, router } from '@inertiajs/react';
import { Estancia, CatalogoEstudio, SolicitudEstudio, User, PageProps } from '@/types';
import { route } from 'ziggy-js';

import PrimaryButton from '@/components/ui/primary-button';
import Checkbox from '@/components/ui/input-checkbox';
import InputText from '@/components/ui/input-text';
import Button from '@/components/button';
import MainLayout from '@/layouts/MainLayout';

interface Props {
    estancia: Estancia;
    catalogoEstudios: CatalogoEstudio[];
    solicitudesAnteriores: SolicitudEstudio[];
    medicos: User[];
    modeloId: number;
    modeloTipo: string;
}

interface EstudioManual {
    nombre: string;
    departamento: string;
}

const SECCIONES_DATA = [
    {
        titulo: 'Paquetes Cirugía',
        color: 'border-red-500',
        items: ['Colecistectomía por laparo', 'HTA', 'Cesarea', 'Vasectomía', 'RTUP', 'Herminiplastia umbilical', 'Hernia inguinal', 'Quiste de ovario', 'Hernioplastia bilateral', 'Fractura']
    },
    {
        titulo: 'Estudios de Laboratorio',
        color: 'border-blue-500',
        subareas: [
            { nombre: 'Estudios de orina', items: ['Examen general de orina', 'Proteína totales en orina', 'Depuración de cretinina en orina', 'Calcio en orina'] },
            { nombre: 'Pruebas de hemostasia y trombosis', items: ['Tiempo de protrombina', 'Tiempo de tromboplastina parcial activa(APTT)', 'Coagulograma básico(TP, TTP, TS, TC, BH)', 'Tiempo de sangrado', 'Tiempo de coagulación'] },
            { nombre: 'Hematología', items: ['Biometria hemática', 'Grupo y factor RH', 'Velocidad de sedimentación globular', 'VDRL'] },
            { nombre: 'Quimica clínica', items: ['Hemoglobina glicosada', 'Quìmica sanguinea de 6 elementos', 'Acido Urico en suero', 'Creatina en suero', 'Quìmica sanguinea de 36 elemtos', 'Electrolitos', 'Perfil heaptico', 'Reacciones febriles' ]}
        ]
    },
    {
        titulo: 'Estudios de Ultra sonido',
        color: 'border-green-500',
        items: ['Abdomen completo', 'Hígado y vias biliares', 'Renal y vias excretoras', 'Pelvico ginecologico', 'Tras-vaginal', 'Tras-rectal', 'Partes blandas', 'Articular(rodilla, hombro, tobillo)', 'Inguinal', 'Doppler color', 'Cariotidas', 'MPI arterial', 'MPI venoso']
    },
    {
        titulo: 'Rayos X',
        color: 'border-purple-500',
        items: ['Tele de torax', 'Columna lumbar OA y lateral', 'Dorsal', 'Hombro', 'Muñeca', 'Creaneo', 'Senos paranasales']
    },
    {
        titulo: 'Consulta de Especialidad',
        color: 'border-orange-500',
        items: ['Ginecología', 'Urología', 'Oncología', 'Cirugía general', 'Internista', 'Interconsulta']
    }
];

const SolicitudEstudiosForm = ({ estancia, catalogoEstudios = [], modeloTipo }: Props) => {
    const { auth } = usePage<PageProps>().props;
    const [otrosInputs, setOtrosInputs] = useState<Record<string, string>>({});

    const { data, setData, post, processing, reset } = useForm({
        user_solicita_id: auth.user.id,
        estudios_agregados_ids: [] as number[],
        estudios_adicionales: [] as EstudioManual[],
        detallesEstudios: {} as Record<number, { modalidad?: string, via?: string, especificacion?: string }>,
        itemable_id: estancia.id,
        itemable_type: modeloTipo,
    });

    const handleToggleEstudio = (nombre: string, categoria: string, checked: boolean) => {
        const estudioDb = catalogoEstudios.find(e => e.nombre.toLowerCase().trim() === nombre.toLowerCase().trim());

        if (checked) {
            if (estudioDb) {
                if (!data.estudios_agregados_ids.includes(estudioDb.id)) {
                    setData('estudios_agregados_ids', [...data.estudios_agregados_ids, estudioDb.id]);
                }
            } else {
                setData('estudios_adicionales', [...data.estudios_adicionales, { nombre, departamento: categoria }]);
            }
        } else {
            if (estudioDb) {
                setData('estudios_agregados_ids', data.estudios_agregados_ids.filter(id => id !== estudioDb.id));
            } else {
                setData('estudios_adicionales', data.estudios_adicionales.filter(i => i.nombre !== nombre));
            }
        }
    };

    const addOtroEstudio = (categoria: string) => {
        const nombre = otrosInputs[categoria];
        if (!nombre || nombre.trim() === '') return;

        // Evitar duplicados
        if (!data.estudios_adicionales.some(e => e.nombre === nombre && e.departamento === categoria)) {
            setData('estudios_adicionales', [...data.estudios_adicionales, { nombre: nombre.trim(), departamento: categoria }]);
        }
        
        // Limpiar solo el input de esa categoría
        setOtrosInputs({ ...otrosInputs, [categoria]: '' });
    };

    const removeEstudioManual = (nombre: string) => {
        setData('estudios_adicionales', data.estudios_adicionales.filter(i => i.nombre !== nombre));
    };

    const isEstudioSelected = (nombre: string) => {
        const estudioDb = catalogoEstudios.find(e => e.nombre.toLowerCase().trim() === nombre.toLowerCase().trim());
        if (estudioDb) return data.estudios_agregados_ids.includes(estudioDb.id);
        return data.estudios_adicionales.some(i => i.nombre === nombre);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('estancia.solicitudes-estudios.store', { estancia: estancia.id }), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                setOtrosInputs({});
            },
        });
    };

    // Componente interno para renderizar los "badges" de lo que se va escribiendo en otros
    const OtrosBadges = ({ categoria }: { categoria: string }) => {
        const manualesDeEstaArea = data.estudios_adicionales.filter(e => e.departamento === categoria);
        if (manualesDeEstaArea.length === 0) return null;

        return (
            <div className="flex flex-wrap gap-2 mt-2">
                {manualesDeEstaArea.map((est, idx) => (
                    <span key={idx} className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {est.nombre}
                        <button 
                            type="button" 
                            onClick={() => removeEstudioManual(est.nombre)}
                            className="ml-1.5 inline-flex text-blue-400 hover:text-blue-600"
                        >
                            &times;
                        </button>
                    </span>
                ))}
            </div>
        );
    };

    return (
        <MainLayout>
            <form onSubmit={handleSubmit} className="pb-20 max-w-7xl mx-auto p-4">
                <div className="grid grid-cols-1 gap-6">
                    {SECCIONES_DATA.map((seccion) => (
                        <div key={seccion.titulo} className={`bg-white rounded-xl shadow-sm border-t-4 ${seccion.color} p-6`}>
                            <h2 className="text-xl font-bold text-gray-800 mb-4">{seccion.titulo}</h2>
                            
                            {seccion.subareas ? (
                                <div className="space-y-6">
                                    {seccion.subareas.map(sub => (
                                        <div key={sub.nombre} className="bg-gray-50 p-4 rounded-lg">
                                            <h3 className="text-sm font-bold text-gray-500 uppercase mb-3 border-b pb-1">{sub.nombre}</h3>
                                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                                {sub.items.map(item => (
                                                    <Checkbox 
                                                        key={item}
                                                        label={item}
                                                        id={`${sub.nombre}-${item}`}
                                                        checked={isEstudioSelected(item)}
                                                        onChange={(e) => handleToggleEstudio(item, sub.nombre, e.target.checked)}
                                                    />
                                                ))}
                                            </div>
                                            {/* Campo OTROS por SUB-ÁREA */}
                                            <div className="mt-2">
                                                <InputText
                                                    id='sub-area-otros'
                                                    label='Otros'
                                                    name='sub-area-otros' 
                                                    placeholder="Otro estudio de esta área... (Enter para agregar)"
                                                    value={otrosInputs[sub.nombre] || ''}
                                                    onChange={(e) => setOtrosInputs({...otrosInputs, [sub.nombre]: e.target.value})}
                                                    onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), addOtroEstudio(sub.nombre))}
                                                />
                                                <OtrosBadges categoria={sub.nombre} />
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="space-y-4">
                                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        {seccion.items?.map(item => (
                                            <Checkbox 
                                                key={item}
                                                label={item}
                                                id={`${seccion.titulo}-${item}`}
                                                checked={isEstudioSelected(item)}
                                                onChange={(e) => handleToggleEstudio(item, seccion.titulo, e.target.checked)}
                                            />
                                        ))}
                                    </div>
                                    {/* Campo OTROS por SECCIÓN GENERAL */}
                                    <div className="pt-2 border-t border-gray-100">
                                        <InputText 
                                            id='otros'
                                            name='otros'
                                            label='Otros'
                                            placeholder={`Otro de ${seccion.titulo}... (Enter para agregar)`}
                                            value={otrosInputs[seccion.titulo] || ''}
                                            onChange={(e) => setOtrosInputs({...otrosInputs, [seccion.titulo]: e.target.value})}
                                            onKeyDown={(e) => e.key === 'Enter' && (e.preventDefault(), addOtroEstudio(seccion.titulo))}
                                        />
                                        <OtrosBadges categoria={seccion.titulo} />
                                    </div>
                                </div>
                            )}
                        </div>
                    ))}

                    {/* Resumen Flotante */}
                    <div className="bg-gray-800 text-white p-6 rounded-xl shadow-lg sticky bottom-4 flex justify-between items-center border-t-4 border-blue-400 z-10">
                        <div>
                            <p className="text-sm opacity-80 font-medium">Seleccionados:</p>
                            <h4 className="text-xl font-bold">
                                {data.estudios_agregados_ids.length + data.estudios_adicionales.length} Servicios
                            </h4>
                        </div>
                        <div className="flex gap-4">
                            <Button type="button" onClick={() => {reset(); setOtrosInputs({});}} className="bg-transparent border border-white/30 hover:bg-white/10">
                                Limpiar
                            </Button>
                            <PrimaryButton type="submit" disabled={processing} className="px-8">
                                {processing ? 'Enviando...' : 'Confirmar Solicitud'}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </form>
        </MainLayout>
    );
};

export default SolicitudEstudiosForm;