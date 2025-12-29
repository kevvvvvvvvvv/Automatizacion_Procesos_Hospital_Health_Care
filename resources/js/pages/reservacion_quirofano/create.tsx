import React from "react";
import { Head, useForm } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import { route } from "ziggy-js";
import { usePage } from "@inertiajs/react";
import { Paciente, Estancia } from "@/types";
import { MdCalendarMonth } from "react-icons/md";

interface Props {
    paciente?: Paciente | null;
    estancia?: Estancia | null;
    limitesDinamicos: Record<string, number>;
    medicos: Array<{ id: number; nombre_completo: string }>;
}

const generarHorarios = () => {
    const horarios: string[] = [];
    for (let h = 0; h < 24; h++) {
        horarios.push(`${String(h).padStart(2, "0")}:00`);
    }
    return horarios;
};

const horariosLista = generarHorarios();

const CreateReservacion: React.FC<Props> = ({
    paciente,
    estancia,
    limitesDinamicos,
    medicos,
}) => {
    const esExterno = !estancia?.id;

    const { data, setData, post, processing } = useForm({
        paciente_nombre: paciente
            ? `${paciente.nombre} ${paciente.apellido_paterno ?? ""} ${paciente.apellido_materno ?? ""}`.trim()
            : "",
        paciente_id: paciente?.id ?? null,
        estancia_id: estancia?.id ?? null,

        procedimiento: "",
        tratante: "",
        tiempo_estimado: "",
        medico_operacion: "",
        localizacion: "",
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
const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (data.horarios.length === 0) {
        alert("Debe seleccionar al menos un horario.");
        return;
    }

    form
        .transform((data) => ({
            paciente: data.paciente_nombre,
            paciente_id: data.paciente_id,
            estancia_id: data.estancia_id,

            procedimiento: data.procedimiento,
            tratante: data.tratante,
            tiempo_estimado: data.tiempo_estimado,
            medico_operacion: data.medico_operacion,
            localizacion: data.localizacion,
            fecha: data.fecha,
            horarios: data.horarios,
            comentarios: data.comentarios,

            instrumentista: data.instrumentista.activa
                ? data.instrumentista.detalle
                : null,

            anestesiologo: data.anestesiologo.activa
                ? data.anestesiologo.detalle
                : null,

            insumos_medicamentos: data.insumos_med.activa
                ? data.insumos_med.detalle
                : null,

            esterilizar_detalle: data.esterilizar.activa
                ? data.esterilizar.detalle
                : null,

            rayosx_detalle: data.rayosx.activa
                ? data.rayosx.equipos.join(", ")
                : null,

            patologico_detalle: data.patologico.activa
                ? data.patologico.detalle
                : null,

            laparoscopia_detalle: data.laparoscopia.activa
                ? `${data.laparoscopia.detalle} (Energía: ${data.laparoscopia.energia.join(", ")})`
                : null,
        }))
        .post(route("quirofanos.store"));
};



    const toggleHorario = (hora: string) => {
        const horarioCompleto = `${data.fecha} ${hora}:00`;
        setData(
            "horarios",
            data.horarios.includes(horarioCompleto)
                ? data.horarios.filter(h => h !== horarioCompleto)
                : [...data.horarios, horarioCompleto]
        );
    };

    const handleCheckboxArray = (
        key: "rayosx" | "laparoscopia",
        subKey: "equipos" | "energia",
        value: string
    ) => {
        const current = (data[key] as any)[subKey];
        const updated = current.includes(value)
            ? current.filter((v: string) => v !== value)
            : [...current, value];
        setData(key, { ...data[key], [subKey]: updated });
    };
    const { errors } = usePage().props as any;

        {errors && (
            <pre className="bg-red-100 text-red-700 p-2 text-xs">
                {JSON.stringify(errors, null, 2)}
            </pre>
        )}
    const renderCondicional = (
        label: string,
        key:
            | "laparoscopia"
            | "instrumentista"
            | "anestesiologo"
            | "insumos_med"
            | "esterilizar"
            | "rayosx"
            | "patologico"
    ) => {
        const esRayosX = key === "rayosx";
        const esLaparoscopia = key === "laparoscopia";

        return (
            <div className="p-3 border rounded-lg bg-gray-50 mb-3">
                <div className="flex justify-between items-center mb-2">
                    <span className="text-sm font-bold">{label}</span>
                    <div className="flex gap-2">
                        <button
                            type="button"
                            onClick={() => setData(key, { ...data[key], activa: true })}
                            className={`px-3 py-1 text-xs rounded ${
                                data[key].activa ? "bg-indigo-600 text-white" : "bg-gray-200"
                            }`}
                        >
                            SÍ
                        </button>
                        <button
                            type="button"
                            onClick={() => {
                                if (esRayosX) setData(key, { activa: false, equipos: [] });
                                else if (esLaparoscopia)
                                    setData(key, { activa: false, detalle: "", energia: [] });
                                else setData(key, { activa: false, detalle: "" });
                            }}
                            className={`px-3 py-1 text-xs rounded ${
                                !data[key].activa ? "bg-indigo-600 text-white" : "bg-gray-200"
                            }`}
                        >
                            NO
                        </button>
                    </div>
                </div>

                {data[key].activa && (
                    <div className="space-y-2">
                        {esRayosX && (
                            <div className="flex gap-4">
                                {["Arco en C", "Portátil"].map(eq => (
                                    <label key={eq} className="text-xs flex gap-2">
                                        <input
                                            type="checkbox"
                                            checked={data.rayosx.equipos.includes(eq)}
                                            onChange={() =>
                                                handleCheckboxArray("rayosx", "equipos", eq)
                                            }
                                        />
                                        {eq}
                                    </label>
                                ))}
                            </div>
                        )}

                        {esLaparoscopia && (
                            <div className="flex gap-4">
                                {["Ligasure", "Armónico"].map(en => (
                                    <label key={en} className="text-xs flex gap-2">
                                        <input
                                            type="checkbox"
                                            checked={data.laparoscopia.energia.includes(en)}
                                            onChange={() =>
                                                handleCheckboxArray(
                                                    "laparoscopia",
                                                    "energia",
                                                    en
                                                )
                                            }
                                        />
                                        {en}
                                    </label>
                                ))}
                            </div>
                        )}

                        {!esRayosX && (
                            <textarea
                                className="w-full border rounded p-2 text-sm"
                                value={data[key].detalle}
                                placeholder="Especifique..."
                                onChange={e =>
                                    setData(key, { ...data[key], detalle: e.target.value })
                                }
                            />
                        )}
                    </div>
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
                        {processing ? "Asignando..." : "Confirmar Reservación"}
                    </PrimaryButton>
                }
            >
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div className="space-y-4">
                        {/*<div className="flex flex-col">
                            <label className="text-sm font-bold">Localización</label>
                            <select
                                value={data.localizacion}
                                onChange={e => setData("localizacion", e.target.value)}
                                className="border rounded p-2"
                                required
                            >
                                <option value="">Seleccione ubicación...</option>
                                {Object.keys(limitesDinamicos).map(loc => (
                                    <option key={loc} value={loc}>{loc}</option>
                                ))}
                            </select>
                        </div>
*/}
                        <label className="text-sm font-bold">Procedimiento quirurgico</label>
                            <input
                            type="text"
                            placeholder="Procedimiento"
                            value={data.procedimiento}
                            onChange={e => setData("procedimiento", e.target.value)}
                            className="w-full border rounded p-2"
                            required
                        />

                        <div>
                            <label className="text-sm font-bold">Paciente</label>
                            {esExterno ? (
                                <input
                                    type="text"
                                    value={data.paciente_nombre}
                                    onChange={e =>
                                        setData("paciente_nombre", e.target.value)
                                    }
                                    className="w-full border rounded p-2"
                                    required
                                />
                            ) : (
                                <input
                                    type="text"
                                    value={data.paciente_nombre}
                                    readOnly
                                    className="w-full border rounded p-2 bg-gray-100"
                                />
                            )}
                        </div>
                        <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1 text-gray-700">Médico Tratante</label>
                                    <select 
                                        value={data.tratante} 
                                        onChange={e => setData('tratante', e.target.value)}
                                        className="border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                        required
                                        >
                                        <option value="">Seleccione médico...</option>
                                        {medicos.map(m => (
                                            <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>
                                        ))}
                                    </select>
                                </div>

                                <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1 text-gray-700">Cirujano</label>
                                    <select 
                                        value={data.medico_operacion} 
                                        onChange={e => setData('medico_operacion', e.target.value)}
                                        className="border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                        required
                                    >
                                        <option value="">Seleccione cirujano...</option>
                                        {medicos.map(m => (
                                            <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>
                                        ))}
                                    </select>
                                </div>

                                <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1 text-gray-700">Tiempo estimado</label>
                                    <input 
                                        type="text" 
                                        value={data.tiempo_estimado}
                                        onChange={e => setData('tiempo_estimado', e.target.value)}
                                        className="border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                                        placeholder="Ej. 2 horas"
                                        required 
                                    />
                                </div>
                            
                        
                        {renderCondicional("¿Solicita laparoscopia?", "laparoscopia")}
                        {renderCondicional("¿Solicita instrumentista?", "instrumentista")}
                        {renderCondicional("¿Solicita anestesiólogo?", "anestesiologo")}
                        {renderCondicional("¿Solicita Rayos X?", "rayosx")}
                        {renderCondicional("¿Solicita Insumos/Medicamentos?", "insumos_med")}
                        {renderCondicional("¿Solicita Esterilización?", "esterilizar")}
                        {renderCondicional("¿Solicita patalogías transoperatorias?", "patologico")}
 
                    </div>

                    <div className="border rounded p-4">
                        <input
                            type="date"
                            value={data.fecha}
                            onChange={e => {
                                setData("fecha", e.target.value);
                                setData("horarios", []);
                            }}
                            className="w-full mb-4 border rounded p-2"
                        />

                        <div className="grid grid-cols-3 gap-2">
                            {horariosLista.map(h => {
                                const full = `${data.fecha} ${h}:00`;
                                return (
                                    <button
                                        key={h}
                                        type="button"
                                        onClick={() => toggleHorario(h)}
                                        className={`p-2 text-xs rounded ${
                                            data.horarios.includes(full)
                                                ? "bg-indigo-600 text-white"
                                                : "border"
                                        }`}
                                    >
                                        {h}
                                    </button>
                                );
                            })}
                        </div>
                          <div className="mt-8 border-t pt-4">
                                <label className="text-sm font-bold mb-1 block text-gray-700">Comentarios Adicionales</label>
                                <textarea 
                                    className="w-full border border-gray-300 rounded p-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" 
                                    placeholder="Detalles sobre equipo extra, requerimientos del cirujano, etc..." 
                                    value={data.comentarios} 
                                    onChange={e => setData('comentarios', e.target.value)} 
                                    rows={4} 
                                />
                            </div>
                    </div>
                </div>
            </FormLayout>
        </MainLayout>
    );
};


export default CreateReservacion;
