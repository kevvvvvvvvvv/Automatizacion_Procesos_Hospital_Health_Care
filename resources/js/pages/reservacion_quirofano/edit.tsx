import React from "react";
import { Head, useForm, usePage, router } from "@inertiajs/react"; 
import { route } from "ziggy-js";
import { Paciente, Estancia, ReservacionQuirofano } from "@/types";

import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import SelectInput from "@/components/ui/input-select";

interface Props {
    quirofano: ReservacionQuirofano; 
    paciente?: Paciente | null;
    estancia?: Estancia | null;
    limitesDinamicos: Record<string, number>;
    medicos: Array<{ id: number; nombre_completo: string }>;
}

const generarHorarios = () => {
    const horarios: string[] = [];
    for (let h = 0; h < 24; h++) {
        const horaFormateada = String(h).padStart(2, "0");
        horarios.push(`${horaFormateada}:00 - ${horaFormateada}:29`);
        horarios.push(`${horaFormateada}:30 - ${horaFormateada}:59`);
    }
    return horarios;
};

const horariosLista = generarHorarios();

const EditReservacion: React.FC<Props> = ({
    paciente,
    estancia,
    quirofano, // Este es el objeto que trae los datos de la DB
    medicos = [],
}) => {
    //const esExterno = !quirofano.estancia_id;
    const medicosOptions = medicos.map((med) => ({ value: med.id, label: med.nombre_completo }));
    const { errors: serverErrors } = usePage().props as any;

    // --- INICIALIZACIÓN DEL FORMULARIO CON DATOS EXISTENTES ---
    const form = useForm({
        paciente: quirofano.paciente || "",
        paciente_id: quirofano.paciente || null,
        estancia_id: quirofano.estancia_id || null,
        procedimiento: quirofano.procedimiento || "",
        tratante: quirofano.tratante || "",
        tiempo_estimado: quirofano.tiempo_estimado || "",
        medico_operacion: quirofano.medico_operacion || "",
        fecha: quirofano.fecha || new Date().toISOString().split("T")[0],
        horarios: Array.isArray(quirofano.horarios) 
        ? quirofano.horarios.map(h => h.length === 5 ? `${quirofano.fecha} ${h}:00` : h) 
        : [] as string[], // Aquí se cargan los bloques azules
        comentarios: quirofano.comentarios || "",
        
        laparoscopia: { 
            activa: !!quirofano.laparoscopia_detalle, 
            detalle: quirofano.laparoscopia_detalle || "" 
        },
        instrumentista: { 
            activa: !!quirofano.instrumentista, 
            detalle: quirofano.instrumentista || "" 
        },
        anestesiologo: { 
            activa: !!quirofano.anestesiologo, 
            detalle: quirofano.anestesiologo || "" 
        },
        insumos_med: { 
            activa: !!quirofano.insumos_medicamentos, 
            detalle: quirofano.insumos_medicamentos || "" 
        },
        esterilizar: { 
            activa: !!quirofano.esterilizar_detalle, 
            detalle: quirofano.esterilizar_detalle || "" 
        },
        rayosx: { 
            activa: !!quirofano.rayosx_detalle, 
            equipos: quirofano.rayosx_detalle ? quirofano.rayosx_detalle.split(", ") : [] 
        },
        patologico: { 
            activa: !!quirofano.patologico_detalle, 
            detalle: quirofano.patologico_detalle || "" 
        },
    });

    const { data, setData, processing } = form;

    const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    // Creamos el objeto con los nombres exactos que espera la base de datos
    const payload = {
        ...data,
        instrumentista: data.instrumentista.activa ? data.instrumentista.detalle : null,
        anestesiologo: data.anestesiologo.activa ? data.anestesiologo.detalle : null,
        insumos_medicamentos: data.insumos_med.activa ? data.insumos_med.detalle : null, // Nombre corregido
        esterilizar_detalle: data.esterilizar.activa ? data.esterilizar.detalle : null,
        rayosx_detalle: data.rayosx.activa ? data.rayosx.equipos.join(", ") : null,
        patologico_detalle: data.patologico.activa ? data.patologico.detalle : null,
        laparoscopia_detalle: data.laparoscopia.activa ? data.laparoscopia.detalle : null,
    };

    // CRITICAL: Enviamos 'payload', no 'data'
    router.put(route("quirofanos.update", quirofano.id), payload);
};

    const toggleHorario = (hora: string) => {
        const full = `${data.fecha} ${hora}:00`;
        setData(
            "horarios",
            data.horarios.includes(full)
                ? data.horarios.filter(h => h !== full)
                : [...data.horarios, full]
        );
    };

    const getError = (key: string) => serverErrors?.[key] || form.errors[key];

    const handleCheckboxArray = (key: "rayosx", subKey: "equipos", value: string) => {
        const current = (data as any)[key][subKey];
        const updated = current.includes(value) ? current.filter((v: string) => v !== value) : [...current, value];
        setData(key, { ...(data as any)[key], [subKey]: updated });
    };

    const renderCondicional = (label: string, key: keyof typeof data) => {
        if (typeof data[key] === 'string') return null; // Guard clause
        const item = data[key] as any;
        const esRayosX = key === "rayosx";

        return (
            <div className="p-3 border rounded bg-gray-50 mb-3 shadow-sm">
                <div className="flex justify-between mb-2">
                    <span className="font-bold text-sm text-gray-700">{label}</span>
                    <div className="flex gap-2">
                        <button type="button" onClick={() => setData(key, { ...item, activa: true })} className={`px-3 py-1 text-xs font-semibold rounded ${item.activa ? "bg-indigo-600 text-white shadow" : "bg-gray-200 text-gray-600"}`}> SÍ </button>
                        <button type="button" onClick={() => setData(key, { ...item, activa: false, detalle: esRayosX ? "" : "", equipos: esRayosX ? [] : undefined })} className={`px-3 py-1 text-xs font-semibold rounded ${!item.activa ? "bg-indigo-600 text-white shadow" : "bg-gray-200 text-gray-600"}`}> NO </button>
                    </div>
                </div>
                {item.activa && (
                    <div className="mt-2 animate-in fade-in duration-300">
                        {esRayosX ? (
                            <div className="flex gap-4">
                                {["Arco en C", "Portátil"].map(eq => (
                                    <label key={eq} className="text-xs flex items-center gap-1 cursor-pointer">
                                        <input type="checkbox" className="rounded text-indigo-600" checked={item.equipos.includes(eq)} onChange={() => handleCheckboxArray("rayosx", "equipos", eq)} /> {eq}
                                    </label>
                                ))}
                            </div>
                        ) : (
                            <textarea className="w-full border rounded p-2 text-sm focus:ring-indigo-500" placeholder="Especifique detalles..." value={item.detalle} onChange={e => setData(key, { ...item, detalle: e.target.value })} />
                        )}
                    </div>
                )}
            </div>
        );
    };

    return (
        <MainLayout pageTitle="Editar Reservación de Quirófano" link="quirofanos.index">
            <Head title="Editar Reservación" />
            <FormLayout
                title={`Editando Reservación #${quirofano.id}`}
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? "Actualizando..." : "Guardar Cambios"}
                    </PrimaryButton>
                }
            >
                {/*{serverErrors && Object.keys(serverErrors).length > 0 && (
                    <div className="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                        <b>Error:</b> Por favor llene todos los campos obligatorios marcados en rojo.
                    </div>
                )} */}

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div className="space-y-4">
                        <section>
                            <label className="font-bold text-xs uppercase text-gray-500">Datos Generales</label>
                            <div className="mt-2 space-y-3">
                                <div>
                                    <label className="text-sm font-medium">Procedimiento</label>
                                    <input className={`w-full border rounded p-2 ${getError('procedimiento') ? 'border-red-500' : ''}`} value={data.procedimiento} onChange={e => setData("procedimiento", e.target.value)} />
                                </div>
                                <div>
                                    <label className="text-sm font-medium">Paciente</label>
                                    <input 
                                        type="text"
                                        className={`w-full border rounded p-2 transition-colors ${
                                            data.estancia_id 
                                                ? 'bg-gray-100 text-gray-500 cursor-not-allowed'
                                                : 'bg-white text-gray-900 border-gray-300'      
                                        } ${getError('paciente') ? 'border-red-500' : ''}`} 
                                        value={data.paciente} 
                                        onChange={e => setData("paciente", e.target.value)} 
                                        placeholder="Nombre del paciente"
                                        readOnly={!!data.estancia_id} 
                                    />
                                    {getError('paciente') && (
                                        <span className="text-red-500 text-xs">{getError('paciente')}</span>
                                    )}
                                </div>
                                <SelectInput label='Médico tratante' options={medicosOptions} value={data.tratante} onChange={e => setData("tratante", e)} error={form.errors.tratante} />
                                <SelectInput label='Cirujano' options={medicosOptions} value={data.medico_operacion} onChange={e => setData('medico_operacion', e)} error={form.errors.medico_operacion} />
                                 <label className="font-bold text-sm">Tiempo estimado</label>
                        <input 
                            className={`w-full border rounded p-2 ${getError('tiempo_estimado') ? 'border-red-500' : 'mb-4'}`} 
                            value={data.tiempo_estimado} 
                            onChange={e => setData("tiempo_estimado", e.target.value)} 
                        />
                        {getError('tiempo_estimado') && <div className="text-red-500 text-xs mb-4">{getError('tiempo_estimado')}</div>}

                            </div>
                        </section>

                        <section>
                            <label className="font-bold text-xs uppercase text-gray-500">Requerimientos Especiales</label>
                            <div className="mt-2">
                                {renderCondicional("Laparoscopia", "laparoscopia")}
                                {renderCondicional("Instrumentista", "instrumentista")}
                                {renderCondicional("Anestesiólogo", "anestesiologo")}
                                {renderCondicional("Rayos X", "rayosx")}
                                {renderCondicional("Insumos / Medicamentos", "insumos_med")}
                                {renderCondicional("Esterilización", "esterilizar")}
                                {renderCondicional("Patología", "patologico")}
                            </div>
                        </section>
                    </div>

                    <div className="border rounded-lg p-5 bg-white shadow-sm h-fit">
                        <label className="font-bold text-sm block mb-2">Selección de Horario</label>
                        <input type="date" className="w-full border rounded p-2 mb-4" value={data.fecha} onChange={e => setData("fecha", e.target.value)} />
                        
                        <div className="grid grid-cols-3 sm:grid-cols-4 gap-5">
                            {horariosLista.map(h => {
                                const horaConSegundo = `${h}:00`;
                                const full = `${data.fecha} ${horaConSegundo}`;
                                const isSelected = data.horarios.some(item => 
                                    item === full || 
                                    item === horaConSegundo || 
                                    item.includes(` ${horaConSegundo}`)
                                );
                                return (
                                    <button
                                        key={h}
                                        type="button"
                                        onClick={() => toggleHorario(h)}
                                        className={`p-2 text-xs font-medium rounded-md transition-all ${
                                            isSelected 
                                            ? "bg-indigo-600 text-white shadow-md scale-105 ring-2 ring-indigo-300" 
                                            : "border border-gray-200 text-gray-600 hover:bg-gray-50"
                                        }`}
                                    > {h} </button>
                                );
                            })}
                        </div>
                        
                        <div className="mt-6">
                            <label className="text-sm font-medium">Comentarios adicionales</label>
                            <textarea className="w-full border rounded p-2 mt-1 h-24" placeholder="..." value={data.comentarios} onChange={e => setData("comentarios", e.target.value)} />
                        </div>
                    </div>
                </div>
            </FormLayout>
        </MainLayout>
    );
};

export default EditReservacion; 