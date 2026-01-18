import React, { useState } from "react";
import { useForm } from "@inertiajs/react";
import { Habitacion, HabitacionPrecio, Reservacion } from "@/types";
import { route } from "ziggy-js";

import MainLayout from "@/layouts/MainLayout";
import SelectInput from "@/components/ui/input-select";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import InputDate from "@/components/ui/input-date";

interface Ubicacion {
    ubicacion: string;
}

const generarHorarios = () => {
    const slots = [];
    let actual = new Date(); 
    actual.setHours(9, 0, 0);

    let fin = new Date();
    fin.setHours(23, 0, 0); 

    while (actual <= fin) { 
        const horaFormateada = actual.toTimeString().slice(0, 8);
        slots.push(horaFormateada);
        actual.setMinutes(actual.getMinutes() + 30);
    }
    return slots;
};

const listaHorarios = generarHorarios();

interface Props {
    reservacion?: Reservacion | null;
    limitesDinamicos: Record<string, number>;
    ocupacionActual: Record<string, number>;
    horariosSeleccionados?: string[]; 
    ubicaciones: Ubicacion[];
    habitaciones: Habitacion[];
}

const CreateReservacion: React.FC<Props> = ({
    ubicaciones = [],
    habitaciones = [],
    reservacion,
    horariosSeleccionados = []
}) => {
    const [localizacionData, localizacionSetData] = useState('');
    const [consultoriosData, consultoriosSetData] = useState<Habitacion[]>();

    const habitacionesFiltradas = habitaciones.filter(h => h.ubicacion === localizacionData);

    const localizaciones = ubicaciones.map((u)=>({value: u.ubicacion, label: u.ubicacion}));

    const isEdit = !!reservacion;
    const hoy = new Date().toISOString().split("T")[0];

    const { data, setData, post, put, processing } = useForm({
        habiacion_precios_id: [] as HabitacionPrecio[],
        fecha: reservacion?.fecha ?? hoy,
        horarios: isEdit ? horariosSeleccionados : [] as string[],
    });

    const toggleHorario = (hora: string) => {
        const yaSeleccionado = data.horarios.includes(hora);
        
        if (yaSeleccionado) {
            setData("horarios", data.horarios.filter((h) => h !== hora));
        } else {
            setData("horarios", [...data.horarios, hora]);
        }
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (data.horarios.length < 1) {
        alert("Debes seleccionar al menos un horario");
        return;
        }

        if (isEdit) {

        put(route("reservaciones.update", reservacion.id));
        } else {

        post(route("reservaciones.store"));
        }
    };

    return (
        <MainLayout pageTitle="Reservación" link="reservaciones.index">
            <FormLayout
                title={isEdit ? "Editar reservación" : "Registrar reservación"}
                onSubmit={handleSubmit}
                actions={
                <PrimaryButton type="submit" disabled={processing}>
                    {processing ? "Guardando..." : "Guardar"}
                </PrimaryButton>
                }
            >
                <div className="space-y-6">
                <SelectInput
                    label="Localización"
                    value={localizacionData}
                    onChange={(val) => localizacionSetData(val)}
                    options={localizaciones}
                />

                {localizacionData && (
                    <InputDate
                        type="date"
                        className="w-full border rounded-md px-3 py-2"
                        value={data.fecha}
                        onChange={(e) => setData("fecha", e.target.value)}
                    />
                )}

                {data.fecha && localizacionData && (
                    <div>
                        <h3 className="font-semibold text-gray-700 mb-2">Horarios disponibles</h3>
                        <ul className="grid grid-cols-3 md:grid-cols-6 gap-2">
                            {listaHorarios.map((hora)=>{
                                const claveBusqueda = `${localizacionData}|${data.fecha} ${hora}`;

                                // B. Obtenemos los datos (Usamos nombres consistentes)
                                const limite = limitesDinamicos[localizacionData] || 0; 
                                const ocupados = ocupacionActual[claveBusqueda] || 0;   

                                // C. Lógica de estado
                                const bloqueado = ocupados >= limite;           
                                const seleccionado = data.horarios.includes(hora); 
                                                            
                                return (
                                    <li key={hora}>
                                        <button
                                            type="button"
                                            disabled={bloqueado} 
                                            onClick={() => toggleHorario(hora)}
                                            className={`w-full px-3 py-2 rounded-md border text-sm transition flex flex-col items-center 
                                            ${seleccionado
                                                ? "bg-indigo-600 text-white border-indigo-600"
                                                : bloqueado
                                                    ? "bg-red-50 text-red-400 border-red-200 cursor-not-allowed"
                                                    : "bg-white hover:bg-indigo-50 border-gray-300 text-gray-700"
                                            }`}
                                        >
                                            {/* Muestra "09:00" */}
                                            <span className="font-medium">{hora.slice(0, 5)}</span>
                                            
                                            <span className="text-[10px] mt-1">
                                                {bloqueado && limite > 0 
                                                    ? 'Agotado' 
                                                    : `${ocupados} / ${limite}`
                                                }
                                            </span>
                                        </button>
                                    </li>
                                );
                            })}
                        </ul>
                    </div>
                )}
                </div>
            </FormLayout>
        </MainLayout>
    );
};

export default CreateReservacion;