import React, { useMemo, useState } from 'react';
import { useForm, usePage, router } from '@inertiajs/react';
import { Estancia, CatalogoEstudio, SolicitudEstudio, User, PageProps } from '@/types';
import { route } from 'ziggy-js';

import PrimaryButton from '@/components/ui/primary-button';
import Checkbox from '@/components/ui/input-checkbox';
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';
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

// Configuración de la estructura de la vista
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
            { nombre: 'Hematología', items: ['Biometria hemática', 'Grupo y factor RH', 'Velocidad de sedimentación globular', 'VDRL'] }
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

    const { data, setData, post, processing, reset } = useForm({
        user_solicita_id: auth.user.id,
        estudios_agregados_ids: [] as number[],
        estudios_adicionales: [] as EstudioManual[],
        detallesEstudios: {} as Record<number, { modalidad?: string, via?: string, especificacion?: string }>,
        itemable_id: estancia.id,
        itemable_type: modeloTipo,
    });

    // Función para manejar la lógica de los Checkboxes
    const handleToggleEstudio = (nombre: string, categoria: string, checked: boolean) => {
        // Buscamos si el nombre existe exactamente en el catálogo de la DB
        const estudioDb = catalogoEstudios.find(
            e => e.nombre.toLowerCase().trim() === nombre.toLowerCase().trim()
        );

        if (checked) {
            if (estudioDb) {
                // Si existe en catálogo, agregamos por ID
                if (!data.estudios_agregados_ids.includes(estudioDb.id)) {
                    setData('estudios_agregados_ids', [...data.estudios_agregados_ids, estudioDb.id]);
                }
            } else {
                // Si NO existe, lo agregamos como manual
                setData('estudios_adicionales', [...data.estudios_adicionales, { nombre, departamento: categoria }]);
            }
        } else {
            // Lógica para quitar
            if (estudioDb) {
                setData('estudios_agregados_ids', data.estudios_agregados_ids.filter(id => id !== estudioDb.id));
            } else {
                setData('estudios_adicionales', data.estudios_adicionales.filter(i => i.nombre !== nombre));
            }
        }
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
            onSuccess: () => reset(),
        });
    };

    return (
        <MainLayout pageTitle='Solicitud de Servicios y Paquetes' link='estancias.show' linkParams={estancia.id}>
            <form onSubmit={handleSubmit} className="pb-20">
                <div className="grid grid-cols-1 gap-6">
                    {SECCIONES_DATA.map((seccion) => (
                        <div key={seccion.titulo} className={`bg-white rounded-xl shadow-sm border-t-4 ${seccion.color} p-6`}>
                            <h2 className="text-xl font-bold text-gray-800 mb-4">{seccion.titulo}</h2>
                            
                            {/* Renderizar Subáreas si existen (ej. Laboratorio) */}
                            {seccion.subareas ? (
                                <div className="space-y-6">
                                    {seccion.subareas.map(sub => (
                                        <div key={sub.nombre} className="bg-gray-50 p-4 rounded-lg">
                                            <h3 className="text-sm font-bold text-gray-500 uppercase mb-3 border-b pb-1">{sub.nombre}</h3>
                                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                {sub.items.map(item => (
                                                    <Checkbox 
                                                        key={item}
                                                        label={item}
                                                        id={item}
                                                        checked={isEstudioSelected(item)}
                                                        onChange={(e) => handleToggleEstudio(item, sub.nombre, e.target.checked)}
                                                    />
                                                ))}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                /* Items directos */
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    {seccion.items?.map(item => (
                                        <Checkbox 
                                            key={item}
                                            label={item}
                                            id={item}
                                            checked={isEstudioSelected(item)}
                                            onChange={(e) => handleToggleEstudio(item, seccion.titulo, e.target.checked)}
                                        />
                                    ))}
                                </div>
                            )}
                        </div>
                    ))}

                    {/* Resumen Flotante o Sección de Confirmación */}
                    <div className="bg-gray-800 text-white p-6 rounded-xl shadow-lg sticky bottom-4 flex justify-between items-center border-t-4 border-blue-400">
                        <div>
                            <p className="text-sm opacity-80 font-medium">Servicios seleccionados:</p>
                            <h4 className="text-xl font-bold">
                                {data.estudios_agregados_ids.length + data.estudios_adicionales.length} Ítems
                            </h4>
                        </div>
                        <div className="flex gap-4">
                            <Button type="button" onClick={() => reset()} className="bg-transparent border border-white/30 hover:bg-white/10">
                                Limpiar
                            </Button>
                            <PrimaryButton type="submit" disabled={processing}>
                                {processing ? 'Procesando...' : 'Confirmar Todo'}
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </form>
        </MainLayout>
    );
};

export default SolicitudEstudiosForm;