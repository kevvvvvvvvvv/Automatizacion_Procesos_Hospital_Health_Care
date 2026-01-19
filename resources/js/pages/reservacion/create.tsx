import React from "react"; 
import { useForm, router } from "@inertiajs/react"; 
import { Reservacion } from "@/types";
import { route } from "ziggy-js";

import MainLayout from "@/layouts/MainLayout";
import SelectInput from "@/components/ui/input-select";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import InputDate from "@/components/ui/input-date";

interface Ubicacion {
    ubicacion: string;
}

interface Props {
    reservacion?: Reservacion | null;
    limitesDinamicos: Record<string, number>; 
    ocupacionActual: Record<string, number>;  
    horariosSeleccionados?: string[];         
    ubicaciones: Ubicacion[];                
    fechaSeleccionada?: string;               
}

const generarHorarios = () => {
    const slots = [];
    const actual = new Date(); 
    actual.setHours(9, 0, 0);

    const fin = new Date();
    fin.setHours(23, 0, 0); 

    while (actual <= fin) { 
        const horaFormateada = actual.toTimeString().slice(0, 8);
        slots.push(horaFormateada);
        actual.setMinutes(actual.getMinutes() + 30);
    }
    return slots;
};

const listaHorarios = generarHorarios();


const CreateReservacion: React.FC<Props> = ({ 
    reservacion, 
    limitesDinamicos, 
    ocupacionActual, 
    horariosSeleccionados = [], 
    ubicaciones = [],
    fechaSeleccionada 
}) => {
    
    const isEdit = !!reservacion;
    const fechaInicial = fechaSeleccionada || reservacion?.fecha || new Date().toISOString().split("T")[0];

    const { data, setData, post, put, processing, errors } = useForm({
        localizacion:  '', 
        fecha: fechaInicial,
        horarios: isEdit ? horariosSeleccionados : [] as string[],
    });

    const localizacionesOptions = ubicaciones.map((u)=>({value: u.ubicacion, label: u.ubicacion}));

    const handleFechaChange = (date: Date | null) => {
        if (!date) return; 

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        
        const nuevaFecha = `${year}-${month}-${day}`;
        
        setData('fecha', nuevaFecha);

        router.get(
            route(isEdit ? 'reservaciones.edit' : 'reservaciones.create', isEdit && reservacion ? reservacion.id : undefined),
            { fecha: nuevaFecha }, 
            {
                preserveState: true,
                replace: true,
                only: ['ocupacionActual', 'fechaSeleccionada'] 
            }
        );
    };


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
        
        if (!data.localizacion) {
            alert("Selecciona una localización");
            return;
        }
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
                        value={data.localizacion}
                        onChange={(val) => setData('localizacion', val)}
                        options={localizacionesOptions}
                        error={errors.localizacion} 
                    />

                    {data.localizacion && (
                        <InputDate
                            name=""
                            id=""
                            className="w-full border rounded-md px-3 py-2"
                            value={data.fecha}
                            onChange={handleFechaChange} 
                        />
                    )}

                    {data.fecha && data.localizacion && (
                        <div>
                            <h3 className="font-semibold text-gray-700 mb-2">Horarios disponibles</h3>
                            <ul className="grid grid-cols-3 md:grid-cols-6 gap-2">
                                {listaHorarios.map((hora) => {
                                    const claveBusqueda = `${data.localizacion}|${hora}`;
                                    const limite = limitesDinamicos[data.localizacion] || 0; 
                                    const ocupados = ocupacionActual[claveBusqueda] || 0;   
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