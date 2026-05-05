import { Head, useForm, usePage, router } from "@inertiajs/react"; 
import { route } from "ziggy-js";
import { Paciente, Estancia, ReservacionQuirofano } from "@/types";
import React, { useEffect } from "react";
import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import SelectInput from "@/components/ui/input-select";

interface Props {
    quirofano: ReservacionQuirofano; 
    paciente?: Paciente | null;
    estancia?: Estancia | null;
    horariosOcupados: string[];
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
    horariosOcupados,
    quirofano, 
    medicos = [],
}) => {
    //const esExterno = !quirofano.estancia_id;
    const medicosOptions = medicos.map((med) => ({ value: med.id, label: med.nombre_completo }));
    const { errors: serverErrors } = usePage().props as any;

    const form = useForm({
        
        paciente: quirofano.paciente || "",
        paciente_id: quirofano.paciente || null,
        estancia_id: quirofano.estancia_id || null,
        procedimiento: quirofano.procedimiento || "",
        tratante: quirofano.tratante || "",
        tiempo_estimado: quirofano.tiempo_estimado || "",
        status: quirofano.status || 'pendiente', 
        motivo_cancelacion: quirofano.motivo_cancelacion || '',

        medico_operacion: quirofano.medico_operacion || "",
        fecha: quirofano.fecha || new Date().toISOString().split("T")[0],
        horarios: Array.isArray(quirofano.horarios) 
        ? quirofano.horarios.map(h => h.length === 5 ? `${quirofano.fecha} ${h}:00` : h) 
        : [] as string[], 
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

    const { data, setData, processing, errors } = form;

    const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault(); 
        if (data.status !== 'cancelada' && data.horarios.length === 0) {
                alert("Por favor seleccione al menos un horario si la cirugía no está cancelada.");
                return;
            }

    const payload = {
        ...data,
        instrumentista: data.instrumentista.activa ? data.instrumentista.detalle : null,
        anestesiologo: data.anestesiologo.activa ? data.anestesiologo.detalle : null,
        insumos_medicamentos: data.insumos_med.activa ? data.insumos_med.detalle : null, // Nombre corregido
        esterilizar_detalle: data.esterilizar.activa ? data.esterilizar.detalle : null,
        rayosx_detalle: data.rayosx.activa ? data.rayosx.equipos.join(", ") : null,
        patologico_detalle: data.patologico.activa ? data.patologico.detalle : null,
        laparoscopia_detalle: data.laparoscopia.activa ? data.laparoscopia.detalle : null,
        status: data.status,
        motivo_cancelacion: data.status === 'cancelada' ? data.motivo_cancelacion : null,
    };

    // CRITICAL: Enviamos 'payload', no 'data'
    router.put(route("quirofanos.update", quirofano.id), payload);
};

const calcularCantidadBloques = (tiempo: string): number => {
    const num = parseFloat(tiempo);
    if (isNaN(num) || num <= 0) return 1;
    return Math.ceil(num * 2); 
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
        const isFirstRender = React.useRef(true);

        useEffect(() => {
            if (isFirstRender.current) {
                isFirstRender.current = false;
                return; // No borramos nada la primera vez que carga la página
            }

            setData("horarios", []); // Borramos solo en cambios manuales de fecha
            
            router.reload({ 
                data: { fecha: data.fecha }, 
                only: ['horariosOcupados'] 
            });
        }, [data.fecha]);
    const getError = (key: string) => serverErrors?.[key] || form.errors[key];

    const handleCheckboxArray = (key: "rayosx", subKey: "equipos", value: string) => {
        const current = (data as any)[key][subKey];
        const updated = current.includes(value) ? current.filter((v: string) => v !== value) : [...current, value];
        setData(key, { ...(data as any)[key], [subKey]: updated });
    };
    useEffect(() => {
        if (data.status === 'cancelada') {
            setData("horarios", []); // Vaciamos los bloques seleccionados
        }
    }, [data.status]);
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
                                  <label className="font-bold text-sm">Tiempo estimado (en horas 1 o 1.5)</label>
                                <input 
                                    placeholder="Ej: 1.5 para 90 min"
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
                        <input 
                            type="date" 
                            className="w-full border rounded p-2 mb-4" 
                            value={data.fecha} 
                            onChange={e => {
                                const nuevaFecha = e.target.value;
                                setData("fecha", nuevaFecha); 

                                router.get(
                                    route("quirofanos.edit", quirofano.id), 
                                    { fecha: nuevaFecha }, 
                                    { 
                                        preserveState: true, 
                                        preserveScroll: true,
                                        only: ['horariosOcupados'], 
                                    }
                                );
                            }}
                        />
                        <div className={`grid grid-cols-3 sm:grid-cols-4 gap-5 ${data.status === 'cancelada' ? 'opacity-50 pointer-events-none' : ''}`}>
                        {horariosLista.map(h => {
                            const horaConSegundo = `${h}:00`;
                            const full = `${data.fecha} ${horaConSegundo}`;
                            
                            const isSelected = data.horarios.includes(full);
                            const isOccupiedByOther = horariosOcupados.includes(full);

                            let buttonClass = "";
                            let isButtonDisabled = false;

                            if (isOccupiedByOther) {
                                buttonClass = "bg-red-50 text-red-400 border border-red-200 cursor-not-allowed opacity-60";
                                isButtonDisabled = true;
                            } else if (isSelected) {
                                buttonClass = "bg-indigo-600 text-white shadow-md scale-105 ring-2 ring-indigo-300";
                            } else {
                                buttonClass = "border border-gray-200 text-gray-600 hover:bg-gray-50";
                            }

                            return (
                                <button
                                    key={h}
                                    type="button"
                                    disabled={isButtonDisabled}
                                    onClick={() => toggleHorario(h)}
                                    className={`p-2 text-xs font-medium rounded-md transition-all ${buttonClass}`}
                                > 
                                    {h}
                                    {isOccupiedByOther && <span className="block text-[8px] uppercase font-bold text-red-500">Bloqueado</span>}
                                    {(isSelected && quirofano.horarios.includes(full)) && <span className="block text-[8px] uppercase font-bold text-indigo-200">Actual</span>}
                                </button>
                            );
                        })}</div>
                        <div className="mt-6 p-4 border rounded-lg bg-gray-50 space-y-4">
                            <div>
                        <div className="flex flex-col gap-4">
                           {/* <div className="flex gap-4 mb-3 text-[10px] uppercase font-bold">
                                <div className="flex items-center gap-1">
                                    <div className="w-3 h-3 bg-gray-200 border rounded"></div>
                                    <span>Disponible</span>
                                </div>
                                <div className="flex items-center gap-1">
                                    <div className="w-3 h-3 bg-red-100 border border-red-200"></div>
                                    <span>Ocupado</span>
                                </div>
                                <div className="flex items-center gap-1">
                                    <div className="w-3 h-3 bg-indigo-600"></div>
                                    <span>Tu Selección</span>
                                </div>
                            </div>*/}
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

                        {data.status === 'cancelada' && (
                            <div className="mt-2 transition-all duration-300">
                                <label className="text-red-600 font-semibold">Motivo de Cancelación</label>
                                <textarea
                                    value={data.motivo_cancelacion}
                                    onChange={(e) => setData('motivo_cancelacion', e.target.value)}
                                    className="w-full border-red-300 rounded p-2 focus:ring-red-500"
                                    placeholder="Explique brevemente por qué se canceló..."
                                    required={data.status === 'cancelada'} 
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

export default EditReservacion; 