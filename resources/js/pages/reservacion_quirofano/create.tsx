import React from "react";
import { Head, useForm, usePage, router } from "@inertiajs/react"; 
import { route } from "ziggy-js";
import { Paciente, Estancia, ReservacionQuirofano } from "@/types";

import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import SelectInput from "@/components/ui/input-select";
 
interface Props {
    quirofanos?: ReservacionQuirofano;
    paciente?: Paciente | null;
    estancia?: Estancia | null;
    limitesDinamicos: Record<string, number>;
    horariosOcupados: string[];
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

const CreateReservacion: React.FC<Props> = ({
    paciente,
    estancia,
    quirofanos,
    horariosOcupados,
    limitesDinamicos,
    medicos = [],
}) => {
    const esExterno = !estancia?.id;

    const medicosOptions = medicos.map((med)=>(
        {value: med.id, label: med.nombre_completo}
    ))
    
    // Obtenemos los errores directamente de la página (Inertia los inyecta aquí)
    const { errors: serverErrors } = usePage().props as any;

    const form = useForm({
        paciente: paciente
            ? `${paciente.nombre} ${paciente.apellido_paterno ?? ""} ${paciente.apellido_materno ?? ""}`.trim()
            : "",
        paciente_id: paciente?.id ?? null,
        estancia_id: estancia?.id ?? null,
        procedimiento: "",
        tratante: "",
        tiempo_estimado: "",
        medico_operacion: "",
        localizacion: "",status: 'pendiente',
        motivo_cancelacion: '',
        fecha: new Date().toISOString().split("T")[0],
        horarios: [] as string[],
        comentarios: "",
        laparoscopia: { activa: false, detalle: "", energia: [] as string[] },
        instrumentista: { activa: false, detalle: "" },
        anestesiologo: { activa: false, detalle: "" },
        insumos_med: { activa: false, detalle: "" },
        esterilizar: { activa: false, detalle: "" },
        rayosx: { activa: false, equipos: [] as string[] },
        patologico: { activa: false, detalle: "" },
    });

    const { data, setData, processing, errors } = form;
    // Funcion para transformar el tiempo entimaso 
    const calcularCantidadBloques = (tiempo: string): number => {
        const num = parseFloat(tiempo);
        if (isNaN(num) || num <= 0) return 1;
        return Math.ceil(num * 2); 
    };
    // Mandar a llamar el controlador
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if (data.horarios.length === 0) {
            alert("Debe seleccionar al menos un horario.");
            return;
        }

        const payload = {
            paciente: data.paciente,
            paciente_id: data.paciente_id,
            estancia_id: data.estancia_id,
            procedimiento: data.procedimiento,
            tratante: data.tratante,
            tiempo_estimado: data.tiempo_estimado,
            medico_operacion: data.medico_operacion,
            status: data.status, 
            motivo_cancelacion: data.motivo_cancelacion,
            fecha: data.fecha,
            horarios: data.horarios,
            comentarios: data.comentarios,
            instrumentista: data.instrumentista.activa ? data.instrumentista.detalle : null,
            anestesiologo: data.anestesiologo.activa ? data.anestesiologo.detalle : null,
            insumos_medicamentos: data.insumos_med.activa ? data.insumos_med.detalle : null,
            esterilizar_detalle: data.esterilizar.activa ? data.esterilizar.detalle : null,
            rayosx_detalle: data.rayosx.activa ? data.rayosx.equipos.join(", ") : null,
            patologico_detalle: data.patologico.activa ? data.patologico.detalle : null,
            laparoscopia_detalle: data.laparoscopia.activa 
                ? `${data.laparoscopia.detalle} (Energía: ${data.laparoscopia.energia.join(", ")})` 
                : null,
        };

        router.post(route("quirofanos.store"), payload, {
            onError: (err) => console.error("Errores específicos:", err),
        });
    };
const toggleHorario = (horaSeleccionada: string) => {
    const bloquesNecesarios = calcularCantidadBloques(data.tiempo_estimado);
    const indiceInicio = horariosLista.findIndex(h => h === horaSeleccionada);

    if (indiceInicio === -1) return;

    const nuevosBloques: string[] = [];
    let rachoOcupadoEncontrado = false;

    for (let i = 0; i < bloquesNecesarios; i++) {
        const indexActual = indiceInicio + i;
        if (horariosLista[indexActual]) {
            const h = horariosLista[indexActual];
            const fullStr = `${data.fecha} ${h}:00`;
            
            // VALIDACIÓN: Si uno de los bloques del rango está ocupado, cancelamos la selección
            if (horariosOcupados.includes(fullStr)) {
                rachoOcupadoEncontrado = true;
                break;
            }
            nuevosBloques.push(fullStr);
        }
    }

    if (rachoOcupadoEncontrado) {
        alert("El rango seleccionado interfiere con una cirugía ya programada.");
        return;
    }

    const primerBloque = `${data.fecha} ${horaSeleccionada}:00`;
    const yaEstaSeleccionado = data.horarios.includes(primerBloque);

    if (yaEstaSeleccionado) {
        setData("horarios", data.horarios.filter(h => !nuevosBloques.includes(h)));
    } else {
        const setUnico = new Set([...data.horarios, ...nuevosBloques]);
        setData("horarios", Array.from(setUnico));
    }
};

    // Función auxiliar para leer errores de serverErrors o del form
    const getError = (key: string) => serverErrors?.[key] || form.errors[key];

    // ... (Mantengo tus funciones handleCheckboxArray y renderCondicional igual)
    const handleCheckboxArray = (key: "rayosx" | "laparoscopia", subKey: "equipos" | "energia", value: string) => {
        const current = (data as any)[key][subKey];
        const updated = current.includes(value) ? current.filter((v: string) => v !== value) : [...current, value];
        setData(key, { ...(data as any)[key], [subKey]: updated });
    };

    const renderCondicional = (label: string, key: "laparoscopia" | "instrumentista" | "anestesiologo" | "insumos_med" | "esterilizar" | "rayosx" | "patologico") => {
        const esRayosX = key === "rayosx";
        const esLaparoscopia = key === "laparoscopia";
        const item = (data as any)[key];
        return (
            <div className="p-3 border rounded bg-gray-50 mb-3">
                <div className="flex justify-between mb-2">
                    <span className="font-bold text-sm">{label}</span>
                    <div className="flex gap-2">
                        <button type="button" onClick={() => setData(key, { ...item, activa: true })} className={`px-3 py-1 text-xs rounded ${item.activa ? "bg-indigo-600 text-white" : "bg-gray-200"}`}> SÍ </button>
                        <button type="button" onClick={() => {
                            if (esRayosX) setData(key, { activa: false, equipos: [] });
                            else if (esLaparoscopia) setData(key, { activa: false, detalle: "", energia: [] });
                            else setData(key, { activa: false, detalle: "" });
                        }} className={`px-3 py-1 text-xs rounded ${!item.activa ? "bg-indigo-600 text-white" : "bg-gray-200"}`}> NO </button>
                    </div>
                </div>
                {item.activa && (
                    <>
                        {esRayosX && (
                            <div className="flex gap-4 mb-2">
                                {["Arco en C", "Portátil"].map(eq => (
                                    <label key={eq} className="text-xs flex gap-1">
                                        <input type="checkbox" checked={data.rayosx.equipos.includes(eq)} onChange={() => handleCheckboxArray("rayosx", "equipos", eq)} /> {eq}
                                    </label>
                                ))}
                            </div>
                        )}
                        {!esRayosX && (
                            <textarea className="w-full border rounded p-2 text-sm" placeholder="Especifique..." value={item.detalle} onChange={e => setData(key, { ...item, detalle: e.target.value })} />
                        )}
                    </>
                )}
            </div>
        );
    };

    return (
        <MainLayout pageTitle="Programación de Quirófano" link="quirofanos.index">
            <Head title="Reservar Quirófano" />
            <FormLayout
                title="Detalles de la Cirugía"
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? "Guardando..." : "Confirmar Reservación"}
                    </PrimaryButton>
                }
            >
                {/* Alerta general si hay errores en serverErrors */}
                {serverErrors && Object.keys(serverErrors).length > 0 && (
                    <div className="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                        <b>Error:</b> Por favor llene todos los campos obligatorios marcados en rojo.
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label className="font-bold text-sm">Procedimiento</label>
                        <input 
                            className={`w-full border rounded p-2 ${getError('procedimiento') ? 'border-red-500' : 'mb-3'}`} 
                            value={data.procedimiento} 
                            onChange={e => setData("procedimiento", e.target.value)} 
                        />
                        {getError('procedimiento') && <div className="text-red-500 text-xs mb-3">{getError('procedimiento')}</div>}
                        
                        <label className="font-bold text-sm">Paciente</label>
                        <input 
                            className={`w-full border rounded p-2 ${getError('paciente') ? 'border-red-500' : 'mb-3'} ${!esExterno ? 'bg-gray-100' : ''}`} 
                            value={data.paciente} 
                            readOnly={!esExterno} 
                            onChange={e => setData("paciente", e.target.value)} 
                        />
                        {getError('paciente') && <div className="text-red-500 text-xs mb-3">{getError('paciente_nombre')}</div>}

                        <SelectInput
                            label='Médico tratante'
                            options={medicosOptions}
                            value={data.tratante}
                            onChange={e => setData("tratante",e)}
                            error={errors.tratante}
                        />

                        <SelectInput
                            label='Cirujano'
                            options={medicosOptions}
                            value={data.medico_operacion}
                            onChange={e => setData('medico_operacion', e)}
                            error={errors.medico_operacion}
                        />

                       <label className="font-bold text-sm">Tiempo estimado (en horas 1 o 1.5)</label>
                        <input 
                            placeholder="Ej: 1.5 para 90 min"
                            className={`w-full border rounded p-2 ${getError('tiempo_estimado') ? 'border-red-500' : 'mb-4'}`} 
                            value={data.tiempo_estimado} 
                            onChange={e => setData("tiempo_estimado", e.target.value)} 
                        />
                        {getError('tiempo_estimado') && <div className="text-red-500 text-xs mb-4">{getError('tiempo_estimado')}</div>}

                        {renderCondicional("¿Solicita laparoscopia?", "laparoscopia")}
                        {renderCondicional("¿Solicita instrumentista?", "instrumentista")}
                        {renderCondicional("¿Solicita anestesiólogo?", "anestesiologo")}
                        {renderCondicional("¿Solicita Rayos X?", "rayosx")}
                        {renderCondicional("¿Solicita Insumos / Medicamentos?", "insumos_med")}
                        {renderCondicional("¿Solicita Esterilización?", "esterilizar")}
                        {renderCondicional("¿Solicita Patología?", "patologico")}
                    </div>
                    

                   <div className="border rounded-lg p-5 bg-white shadow-sm h-fit">
                        <label className="font-bold text-sm block mb-2">Selección de Horario</label>
                        <input 
                            type="date" 
                            className="w-full border rounded p-2 mb-4" 
                            value={data.fecha} 
                            onChange={e => {
                                setData("fecha", e.target.value);
                                setData("horarios", []); // Es vital limpiar horarios al cambiar de día
                            }}
                        />
                        <div className="grid grid-cols-3 sm:grid-cols-4 gap-5">
                        {horariosLista.map(h => {
                            const horaConSegundo = `${h}:00`;
                            const full = `${data.fecha} ${horaConSegundo}`;
                            
                            const isSelected = data.horarios.includes(full);
                            const isOccupied = horariosOcupados.includes(full);

                            return (
                                <button
                                    key={h}
                                    type="button"
                                    disabled={isOccupied} // Bloqueamos el click
                                    onClick={() => toggleHorario(h)}
                                    className={`p-2 text-xs font-medium rounded-md transition-all ${
                                        isOccupied
                                            ? "bg-red-50 text-red-400 border border-red-200 cursor-not-allowed opacity-60" // Estilo para Ocupado
                                            : isSelected 
                                                ? "bg-indigo-600 text-white shadow-md scale-105 ring-2 ring-indigo-300" 
                                                : "border border-gray-200 text-gray-600 hover:bg-gray-50" 
                                    }`}
                                > 
                                    {h}
                                    {isOccupied && <span className="block text-[8px] uppercase font-bold">Ocupado</span>}
                                </button>
                            );
                        })}
                    </div>
                    <div className="mt-6 p-4 border rounded-lg bg-gray-50 space-y-4">
                            <div>
                        <div className="flex flex-col gap-4">
                        <label className="font-bold">Estado de la Cirugía</label>
                        <select 
                            value={data.status}
                            onChange={(e) => setData('status', e.target.value)}
                            className="border rounded p-2"
                        >
                            <option value="pendiente">Pendiente</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>

                        {/* Renderizado condicional: El campo solo existe en el DOM si el estado es cancelada */}
                        {data.status === 'cancelada' && (
                            <div className="mt-2 transition-all duration-300">
                                <label className="text-red-600 font-semibold">Motivo de Cancelación</label>
                                <textarea
                                    value={data.motivo_cancelacion}
                                    onChange={(e) => setData('motivo_cancelacion', e.target.value)}
                                    className="w-full border-red-300 rounded p-2 focus:ring-red-500"
                                    placeholder="Explique brevemente por qué se canceló..."
                                    required={data.status === 'cancelada'} // HTML5 validation
                                />
                                {errors.motivo_cancelacion && <span className="text-red-500 text-xs">{errors.motivo_cancelacion}</span>}
                            </div>
                        )}
                    </div>
                    </div>
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

export default CreateReservacion;