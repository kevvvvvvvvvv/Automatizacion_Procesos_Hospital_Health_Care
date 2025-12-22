import React from "react";
import { Head, useForm } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import FormLayout from "@/components/form-layout";
import PacienteCard from "@/components/paciente-card";
import PrimaryButton from "@/components/ui/primary-button";
import { route } from "ziggy-js";
import { Paciente, Estancia } from "@/types";

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    limitesDinamicos: Record<string, number>;
}

const generarHorarios = () => {
    const horarios: string[] = [];
    for (let h = 8; h < 22; h++) {
        for (let m = 0; m < 60; m += 60) {
            horarios.push(`${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`);
        }
    }
    return horarios;
};
const horariosLista = generarHorarios();

const CreateReservacion: React.FC<Props> = ({ paciente, estancia, limitesDinamicos }) => {
    const { data, setData, post, processing, errors } = useForm({
        procedimiento: "",
        tiempo_estimado: "",
        medico_operacion: "",
        instrumentista: "",
        anestesiologo: "",
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

    const renderCondicional = (label: string, key: 'insumos_med' | 'esterilizar' | 'rayosx' | 'patologico') => (
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
                                <input type="text" placeholder="Cirujano" className="border rounded p-2 text-sm" value={data.medico_operacion} onChange={e => setData('medico_operacion', e.target.value)} required />
                                <input type="text" placeholder="Tiempo Estimado" className="border rounded p-2 text-sm" value={data.tiempo_estimado} onChange={e => setData('tiempo_estimado', e.target.value)} required />
                            </div>

                            <div className="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Instrumentista" className="border rounded p-2 text-sm" value={data.instrumentista} onChange={e => setData('instrumentista', e.target.value)} required />
                                <input type="text" placeholder="Anestesiólogo" className="border rounded p-2 text-sm" value={data.anestesiologo} onChange={e => setData('anestesiologo', e.target.value)} required />
                            </div>

                            <div className="pt-2">
                                <h4 className="text-sm font-bold text-gray-700 mb-2 border-b">Requerimientos</h4>
                                {renderCondicional("Insumos/Medicamnetos especiales", "insumos_med")}
                                {renderCondicional("Esterilización", "esterilizar")}
                                {renderCondicional("Rayos X", "rayosx")}
                                {renderCondicional("Patología", "patologico")}
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
                            <textarea className="w-full mt-4 border rounded p-2 text-sm" placeholder="Comentarios..." value={data.comentarios} onChange={e => setData('comentarios', e.target.value)} rows={3} />
                        </div>
                    </div>
                </FormLayout>
            </div>
        </MainLayout>
    );
};

export default CreateReservacion;