import React from "react";
import { Head, useForm } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PacienteCard from "@/components/paciente-card";
import PrimaryButton from "@/components/ui/primary-button";
import { route } from "ziggy-js";
import { Paciente, Estancia } from "@/types";
import InputText from "@/components/ui/input-text";

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    limitesDinamicos: Record<string, number>;
    medicos: Array<{id: number, nombre_completo: string}>;
}

const generarHorarios = () => {
    const horarios: string[] = [];
    for (let h = 0; h < 24; h++) {
        for (let m = 0; m < 60; m += 60) {
            horarios.push(`${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`);
        }
    }
    return horarios;
};
const horariosLista = generarHorarios();

const CreateReservacion: React.FC<Props> = ({ paciente, estancia, limitesDinamicos, medicos }) => {
    console.log("Valores recibidos en Props:", { paciente, estancia, limitesDinamicos, medicos });
    const { data, setData, post, processing, errors } = useForm({
    paciente: paciente 
        ? `${paciente.nombre} ${paciente.apellido_paterno || ''}` 
        : (estancia?.paciente 
            ? `${estancia.paciente.nombre} ${estancia.paciente.apellido_paterno || ''}` 
            : ""),
        procedimiento: "",
        tratante: "",
        tiempo_estimado: "",
        medico_operacion: "",
        instrumentista: { activa: false, detalle: "" },
        anestesiologo: { activa: false, detalle: "" },
        localizacion: "",
        fecha: new Date().toISOString().split("T")[0],
        horarios: [] as string[],
        insumos_med: { activa: false, detalle: "" },
        esterilizar: { activa: false, detalle: "" },
        rayosx: { activa: false, detalle: "" },
        patologico: { activa: false, detalle: "" },
        comentarios: "",
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (data.horarios.length === 0) return alert("Debe seleccionar al menos un bloque de horario.");
        
        post(route('pacientes.estancias.quirofanos.store', { 
            paciente: paciente.id, 
            estancia: estancia.id 
        }));
    };

    const toggleHorario = (hora: string) => {
        const horarioCompleto = `${data.fecha} ${hora}:00`;
        if (data.horarios.includes(horarioCompleto)) {
            setData("horarios", data.horarios.filter((h) => h !== horarioCompleto));
        } else {
            setData("horarios", [...data.horarios, horarioCompleto]);
        }
    };

    const renderCondicional = (label: string, key: 'instrumentista'|'anestesiologo'|'insumos_med' | 'esterilizar' | 'rayosx' | 'patologico') => (
        <div className="p-3 border rounded-lg bg-gray-50 mb-3">
            <div className="flex items-center justify-between mb-2">
                <span className="text-sm font-medium">{label}</span>
                <div className="flex gap-2">
                    <button type="button" onClick={() => setData(key, { ...data[key], activa: true })} className={`px-4 py-1 rounded text-xs font-bold ${data[key].activa ? 'bg-indigo-600 text-white' : 'bg-gray-200'}`}>SÍ</button>
                    <button type="button" onClick={() => setData(key, { activa: false, detalle: "" })} className={`px-4 py-1 rounded text-xs font-bold ${!data[key].activa ? 'bg-indigo-600 text-white' : 'bg-gray-200'}`}>NO</button>
                </div>
            </div>
            {data[key].activa && (
                <textarea 
                    className="w-full text-sm border border-gray-300 rounded p-2 outline-none focus:ring-1 focus:ring-indigo-500" 
                    placeholder="Especifique..." 
                    value={data[key].detalle}
                    onChange={(e) => setData(key, { ...data[key], detalle: e.target.value })}
                />
            )}
        </div>
    );

    return (
        <MainLayout pageTitle="Programación de Quirófano" link="quirofanos.index" >
            <Head title="Reservar Quirófano" />
            
           

            <div className="mt-6">
                <FormLayout 
                    title="Detalles de la Cirugía"
                    onSubmit={handleSubmit}
                    actions={<PrimaryButton disabled={processing}>{processing ? 'Asignando...' : 'Confirmar Reservación'}</PrimaryButton>}
                >
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 col-span-full">
                        <div className="space-y-4">
                            <div className="flex flex-col">
                                <label className="text-sm font-bold mb-1">Ubicación del Quirófano</label>
                                <select 
                                    value={data.localizacion} 
                                    onChange={e => setData('localizacion', e.target.value)}
                                    className="border border-gray-300 rounded p-2 text-sm"
                                    required
                                >
                                    <option value="">Seleccione ubicación...</option>
                                    {Object.keys(limitesDinamicos).map(loc => (
                                        <option key={loc} value={loc}>{loc}</option>
                                    ))}
                                </select>
                                {errors.localizacion && <span className="text-red-500 text-xs mt-1">{errors.localizacion}</span>}
                            </div>


           
                            <input type="text" placeholder="Procedimiento Quirúrgico" className="w-full border rounded p-2 text-sm" value={data.procedimiento} onChange={e => setData('procedimiento', e.target.value)} required />
                            
                            <div className="grid grid-cols-2 gap-4">
                                {/* CAMPO PACIENTE */}
                                <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1">Paciente</label>
                                    <input 
                                        type="text" 
                                        value={data.paciente}
                                        onChange={e => setData('paciente', e.target.value)}
                                        className={`border rounded p-2 text-sm ${data.paciente ? 'bg-gray-50' : ''}`}
                                        placeholder="Escriba nombre del paciente..."
                                        // Si ya viene de una estancia, lo bloqueamos para que no se altere el registro
                                        readOnly={!!(paciente?.nombre || estancia?.paciente?.nombre)}
                                        required 
                                    />
                                </div>

                                {/* SELECT MÉDICO TRATANTE */}
                                <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1">Médico Tratante</label>
                                    <select 
                                        value={data.tratante} 
                                        onChange={e => setData('tratante', e.target.value)}
                                        className="border border-gray-300 rounded p-2 text-sm"
                                        required
                                    >
                                        <option value="">Seleccione médico...</option>
                                        {medicos.map(m => (
                                            <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>
                                        ))}
                                    </select>
                                </div>

                                {/* SELECT CIRUJANO */}
                                <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1">Cirujano (Médico Operación)</label>
                                    <select 
                                        value={data.medico_operacion} 
                                        onChange={e => setData('medico_operacion', e.target.value)}
                                        className="border border-gray-300 rounded p-2 text-sm"
                                        required
                                    >
                                        <option value="">Seleccione cirujano...</option>
                                        {medicos.map(m => (
                                            <option key={m.id} value={m.nombre_completo}>{m.nombre_completo}</option>
                                        ))}
                                    </select>
                                    </div>
                                    <div className="flex flex-col">
                                    <label className="text-sm font-bold mb-1">Tiempo estimado</label>
                                    <input 
                                        type="text" 
                                        value={data.tiempo_estimado}
                                        onChange={e => setData('tiempo_estimado', e.target.value)}
                                        className={`border rounded p-2 text-sm ${data.tiempo_estimado ? 'bg-gray-50' : ''}`}
                                        placeholder="El tiempo estimado..."
                                       
                                        required 
                                    />
                                </div>

                                </div>

                            

                            <div className="pt-2">
                                <h4 className="text-sm font-bold text-gray-700 mb-2 border-b">Requerimientos</h4>
                                {renderCondicional("¿Solicita instrumentista?", "instrumentista")}
                                {renderCondicional("¿Solicita anestesiologo?", "anestesiologo")}
                                {renderCondicional("¿Solicita Insumos/Medicamnetos especiales?", "insumos_med")}
                                {renderCondicional("¿Solicita Esterilización?", "esterilizar")}
                                {renderCondicional("¿Solicta Rayos X?", "rayosx")}
                                {renderCondicional("¿Solicita Patología?", "patologico")}
                            </div>
                        </div>

                        <div className="bg-white p-4 border rounded-xl shadow-sm h-fit">
                            <h3 className="font-bold text-gray-800 mb-4 text-center">Selección de Horario</h3>
                            <input type="date" className="w-full mb-4 border rounded px-3 py-2 text-sm" value={data.fecha} onChange={e => setData("fecha", e.target.value)} />
                            
                            <div className="grid grid-cols-3 gap-2">
                                {horariosLista.map((hora) => {
                                    const horarioCompleto = `${data.fecha} ${hora}:00`;
                                    const seleccionado = data.horarios.includes(horarioCompleto);
                                    return (
                                        <button
                                            key={hora}
                                            type="button"
                                            onClick={() => toggleHorario(hora)}
                                            className={`py-2 rounded text-xs font-medium border transition-all ${
                                                seleccionado ? "bg-indigo-600 text-white border-indigo-600" : "bg-white text-gray-600 border-gray-200 hover:border-indigo-400"
                                            }`}
                                        >
                                            {hora}
                                        </button>
                                    );
                                })}
                            </div>
                            <br></br>
                            <label className="text-sm font-bold mb-1">Comentarios</label>
                            <textarea aria-label="Comentarios" className="w-full mt-4 border rounded p-2 text-sm" placeholder="Comentarios..." value={data.comentarios} onChange={e => setData('comentarios', e.target.value)} rows={3} />
                        </div>
                    </div>
                </FormLayout>
            </div>
        </MainLayout>
    );
};

export default CreateReservacion;