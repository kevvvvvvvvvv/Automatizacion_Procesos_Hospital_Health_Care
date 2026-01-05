// resources/js/Pages/quirofanos/Partials/QuirofanoForm.tsx
import React from "react";
import { useForm } from "@inertiajs/react";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import { Paciente, Estancia, ReservacionQuirofano } from "@/types";

interface Props {
    paciente?: Paciente | null;
    estancia?: Estancia | null;
    quirofano?: ReservacionQuirofano | null;
    medicos: Array<{ id: number; nombre_completo: string }>;
    onSubmit: (form: any) => void;
    submitLabel?: string;
}

const generarHorarios = () => {
    const horarios: string[] = [];
    for (let h = 0; h < 24; h++) {
        horarios.push(`${String(h).padStart(2, "0")}:00`);
    }
    return horarios;
};

const horariosLista = generarHorarios();

export const QuirofanoForm = ({
    paciente,
    estancia,
    quirofano,
    medicos,
    onSubmit,
    submitLabel = "Guardar"
}: Props) => {
    const esExterno = !estancia?.id && !quirofano?.estancia_id;

    // Inicialización del formulario con consistencia de nombres
    const form = useForm({
        paciente: quirofano?.paciente || (paciente ? `${paciente.nombre} ${paciente.apellido_paterno ?? ""}`.trim() : ""),
        
        estancia_id: quirofano?.estancia_id || estancia?.id || null,
        procedimiento: quirofano?.procedimiento || "",
        tratante: quirofano?.tratante || "",
        tiempo_estimado: quirofano?.tiempo_estimado || "",
        medico_operacion: quirofano?.medico_operacion || "",
        fecha: quirofano?.fecha || new Date().toISOString().split("T")[0],
        horarios: quirofano?.horarios || [] as string[],
        comentarios: quirofano?.comentarios || "",
        
        // Estructuras de objetos corregidas para el renderCondicional
        laparoscopia: { activa: false, detalle: "", energia: [] },
        instrumentista: { activa: false, detalle: "" },
        anestesiologo: { activa: false, detalle: "" },
        insumos_medicamentos: { activa: false, detalle: "" }, // <--- DEBE SER ESTE NOMBRE
        esterilizar: { activa: false, detalle: "" },
        rayosx: { activa: false, equipos: [] },
        patologico: { activa: false, detalle: "" },
    });

    const { data, setData, processing, errors } = form;

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form);
    };

    const toggleHorario = (hora: string) => {
        const full = `${data.fecha} ${hora}:00`;
        setData("horarios", data.horarios.includes(full) 
            ? data.horarios.filter(h => h !== full) 
            : [...data.horarios, full]
        );
    };

    const handleCheckboxArray = (key: "rayosx" | "laparoscopia", subKey: "equipos" | "energia", value: string) => {
        const current = (data as any)[key][subKey];
        const updated = current.includes(value)
            ? current.filter((v: string) => v !== value)
            : [...current, value];
        setData(key, { ...(data as any)[key], [subKey]: updated });
    };

    const renderCondicional = (
        label: string,
        key: "laparoscopia" | "instrumentista" | "anestesiologo" | "insumos_medicamentos" | "esterilizar" | "rayosx" | "patologico"
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
                                    <label key={eq} className="text-xs flex gap-1 items-center">
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
                                    <label key={en} className="text-xs flex gap-1 items-center">
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
                                placeholder="Especifique detalles..."
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
        <FormLayout 
            title="" 
            onSubmit={handleSubmit} 
            actions={
                <PrimaryButton type="submit" disabled={processing}>
                    {processing ? "Procesando..." : submitLabel}
                </PrimaryButton>
            }
        >
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label className="font-bold text-sm">Procedimiento</label>
                    <input className="w-full border rounded p-2 mb-3" value={data.procedimiento} onChange={e => setData("procedimiento", e.target.value)} />
                    {errors.procedimiento && <div className="text-red-500 text-xs mb-2">{errors.procedimiento}</div>}
                    
                    <label className="font-bold text-sm">Paciente</label>
                    <input className="w-full border rounded p-2 mb-3 bg-gray-100" value={data.paciente} readOnly={!esExterno} onChange={e => setData("paciente", e.target.value)} />

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
                    {renderCondicional("¿Solicita Insumos / Medicamentos?", "insumos_medicamentos")} 
                    {renderCondicional("¿Solicita Esterilización?", "esterilizar")}
                    {renderCondicional("¿Solicita Patología?", "patologico")}
                </div>

                <div className="border rounded p-4 bg-white shadow-sm">
                    <label className="font-bold text-sm block mb-2">Fecha de Cirugía</label>
                    <input
                        type="date"
                        className="w-full border rounded p-2 mb-4"
                        value={data.fecha}
                        onChange={e => {
                            setData("fecha", e.target.value);
                            setData("horarios", []);
                        }}
                    />
                    <label className="font-bold text-sm block mb-2">Selección de Horarios (Mínimo uno)</label>
                    <div className="grid grid-cols-3 gap-2">
                        {horariosLista.map(h => {
                            const full = `${data.fecha} ${h}:00`;
                            return (
                                <button
                                    key={h}
                                    type="button"
                                    onClick={() => toggleHorario(h)}
                                    className={`p-2 text-xs rounded transition-colors ${data.horarios.includes(full) ? "bg-indigo-600 text-white" : "bg-white border hover:bg-gray-50"}`}
                                > {h} </button>
                            );
                        })}
                    </div>
                    {errors.horarios && <div className="text-red-500 text-xs mt-2">{errors.horarios}</div>}
                    
                    <label className="font-bold text-sm block mt-4 mb-2">Comentarios Adicionales</label>
                    <textarea className="w-full border rounded p-2" rows={4} placeholder="Notas para el equipo médico..." value={data.comentarios} onChange={e => setData("comentarios", e.target.value)} />
                </div>
            </div>
        </FormLayout>
    );
};