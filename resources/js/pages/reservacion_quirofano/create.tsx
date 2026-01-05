import React from "react";
import { Head, useForm, usePage, router } from "@inertiajs/react"; // Importar router
import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import { route } from "ziggy-js";
import { Paciente, Estancia, ReservacionQuirofano } from "@/types";

interface Props {
    quirofanos?: ReservacionQuirofano;
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
    quirofanos,
    limitesDinamicos,
    medicos = [],
}) => {
    const esExterno = !estancia?.id;
    // @ts-ignore
    const { errors: serverErrors } = usePage().props;

    const form = useForm({
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

    const { data, setData, processing } = form;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        if (data.horarios.length === 0) {
            alert("Debe seleccionar al menos un horario.");
            return;
        }

        const payload = {
            paciente: data.paciente_nombre,
            paciente_id: data.paciente_id,
            estancia_id: data.estancia_id,
            procedimiento: data.procedimiento,
            tratante: data.tratante,
            tiempo_estimado: data.tiempo_estimado,
            medico_operacion: data.medico_operacion,
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

        // Enviar usando router para procesar el payload personalizado
        router.post(route("quirofanos.store"), payload, {
            onError: (err) => console.error("Errores específicos:", err),
        });
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

    const handleCheckboxArray = (
        key: "rayosx" | "laparoscopia",
        subKey: "equipos" | "energia",
        value: string
    ) => {
        const current = (data as any)[key][subKey];
        const updated = current.includes(value)
            ? current.filter((v: string) => v !== value)
            : [...current, value];

        setData(key, { ...(data as any)[key], [subKey]: updated });
    };

    const renderCondicional = (
        label: string,
        key: "laparoscopia" | "instrumentista" | "anestesiologo" | "insumos_med" | "esterilizar" | "rayosx" | "patologico"
    ) => {
        const esRayosX = key === "rayosx";
        const esLaparoscopia = key === "laparoscopia";
        const item = (data as any)[key];

        return (
            <div className="p-3 border rounded bg-gray-50 mb-3">
                <div className="flex justify-between mb-2">
                    <span className="font-bold text-sm">{label}</span>
                    <div className="flex gap-2">
                        <button
                            type="button"
                            onClick={() => setData(key, { ...item, activa: true })}
                            className={`px-3 py-1 text-xs rounded ${item.activa ? "bg-indigo-600 text-white" : "bg-gray-200"}`}
                        > SÍ </button>
                        <button
                            type="button"
                            onClick={() => {
                                if (esRayosX) setData(key, { activa: false, equipos: [] });
                                else if (esLaparoscopia) setData(key, { activa: false, detalle: "", energia: [] });
                                else setData(key, { activa: false, detalle: "" });
                            }}
                            className={`px-3 py-1 text-xs rounded ${!item.activa ? "bg-indigo-600 text-white" : "bg-gray-200"}`}
                        > NO </button>
                    </div>
                </div>

                {item.activa && (
                    <>
                        {esRayosX && (
                            <div className="flex gap-4 mb-2">
                                {["Arco en C", "Portátil"].map(eq => (
                                    <label key={eq} className="text-xs flex gap-1">
                                        <input
                                            type="checkbox"
                                            checked={data.rayosx.equipos.includes(eq)}
                                            onChange={() => handleCheckboxArray("rayosx", "equipos", eq)}
                                        /> {eq}
                                    </label>
                                ))}
                            </div>
                        )}
                        {esLaparoscopia && (
                            <div className="flex gap-4 mb-2">
                                {["Ligasure", "Armónico"].map(en => (
                                    <label key={en} className="text-xs flex gap-1">
                                        <input
                                            type="checkbox"
                                            checked={data.laparoscopia.energia.includes(en)}
                                            onChange={() => handleCheckboxArray("laparoscopia", "energia", en)}
                                        /> {en}
                                    </label>
                                ))}
                            </div>
                        )}
                        {!esRayosX && (
                            <textarea
                                className="w-full border rounded p-2 text-sm"
                                placeholder="Especifique..."
                                value={item.detalle}
                                onChange={e => setData(key, { ...item, detalle: e.target.value })}
                            />
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
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label className="font-bold text-sm">Procedimiento</label>
                        <input className="w-full border rounded p-2 mb-3" value={data.procedimiento} onChange={e => setData("procedimiento", e.target.value)} />
                        
                        <label className="font-bold text-sm">Paciente</label>
                        <input className="w-full border rounded p-2 mb-3" value={data.paciente_nombre} readOnly={!esExterno} onChange={e => setData("paciente_nombre", e.target.value)} />

                        <label className="font-bold text-sm">Médico Tratante</label>
                        <select className="w-full border rounded p-2 mb-3" value={data.tratante} onChange={e => setData("tratante", e.target.value)}>
                            <option value="">Seleccione...</option>
                            {medicos.map(m => <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>)}
                        </select>

                        <label className="font-bold text-sm">Cirujano</label>
                        <select className="w-full border rounded p-2 mb-3" value={data.medico_operacion} onChange={e => setData("medico_operacion", e.target.value)}>
                            <option value="">Seleccione...</option>
                            {medicos.map(m => <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>)}
                        </select>

                        <label className="font-bold text-sm">Tiempo estimado</label>
                        <input className="w-full border rounded p-2 mb-4" value={data.tiempo_estimado} onChange={e => setData("tiempo_estimado", e.target.value)} />

                        {renderCondicional("¿Solicita laparoscopia?", "laparoscopia")}
                        {renderCondicional("¿Solicita instrumentista?", "instrumentista")}
                        {renderCondicional("¿Solicita anestesiólogo?", "anestesiologo")}
                        {renderCondicional("¿Solicita Rayos X?", "rayosx")}
                        {renderCondicional("¿Solicita Insumos / Medicamentos?", "insumos_med")}
                        {renderCondicional("¿Solicita Esterilización?", "esterilizar")}
                        {renderCondicional("¿Solicita Patología?", "patologico")}
                    </div>

                    <div className="border rounded p-4">
                        <input
                            type="date"
                            className="w-full border rounded p-2 mb-4"
                            value={data.fecha}
                            onChange={e => {
                                setData("fecha", e.target.value);
                                setData("horarios", []);
                            }}
                        />
                        <div className="grid grid-cols-3 gap-2">
                            {horariosLista.map(h => {
                                const full = `${data.fecha} ${h}:00`;
                                return (
                                    <button
                                        key={h}
                                        type="button"
                                        onClick={() => toggleHorario(h)}
                                        className={`p-2 text-xs rounded ${data.horarios.includes(full) ? "bg-indigo-600 text-white" : "border"}`}
                                    > {h} </button>
                                );
                            })}
                        </div>
                        <textarea className="w-full border rounded p-2 mt-4" placeholder="Comentarios adicionales" value={data.comentarios} onChange={e => setData("comentarios", e.target.value)} />
                    </div>
                </div>
            </FormLayout>
        </MainLayout>
    );
};

export default CreateReservacion;