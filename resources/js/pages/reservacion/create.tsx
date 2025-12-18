import React from "react";
import MainLayout from "@/layouts/MainLayout";
import SelectInput from "@/components/ui/input-select";
import { useForm } from "@inertiajs/react";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import { Reservacion } from "@/types";
import { route } from "ziggy-js";

interface Props {
  reservacion?: Reservacion | null;
  limitesDinamicos: Record<string, number>;
  ocupacionActual: Record<string, number>;
  horariosSeleccionados?: string[]; 
}

const localizaciones = [
  { value: "Plan de ayutla", label: "Plan de Ayutla" },
  { value: "Díaz Ordaz", label: "Díaz Ordaz" },
];

const generarHorarios = () => {
  const horarios: string[] = [];
  for (let h = 8; h < 22; h++) {
    for (let m = 0; m < 60; m += 30) {
      horarios.push(`${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`);
    }
  }
  return horarios;
};

const horariosLista = generarHorarios();

const CreateReservacion: React.FC<Props> = ({
  reservacion,
  limitesDinamicos,
  ocupacionActual,
  horariosSeleccionados = []
}) => {
  const isEdit = !!reservacion;
  const hoy = new Date().toISOString().split("T")[0];

  const { data, setData, post, put, processing } = useForm({
    localizacion: reservacion?.localizacion ?? "",
    fecha: reservacion?.fecha ?? hoy,
    // PASO 1: Aquí se cargan los horarios actuales de la reservación
    horarios: isEdit ? horariosSeleccionados : [] as string[],
  });

  const toggleHorario = (hora: string) => {
    if (!data.fecha || !data.localizacion) return;

    const horarioCompleto = `${data.fecha} ${hora}:00`;
    const llaveOcupacion = `${data.localizacion}|${horarioCompleto}`;

    // Ocupados por OTROS (el controlador ya restó los tuyos)
    const ocupadosEnBD = ocupacionActual[llaveOcupacion] ?? 0;
    const yaSeleccionadoEnFormulario = data.horarios.includes(horarioCompleto);
    const limite = limitesDinamicos[data.localizacion] ?? 0;

    if (yaSeleccionadoEnFormulario) {
      // PASO 2: Si haces clic en uno azul, se quita (se "deselecciona")
      setData("horarios", data.horarios.filter((h) => h !== horarioCompleto));
    } else {
      // PASO 3: Si haces clic en uno vacío, se agrega (si hay cupo)
      if (ocupadosEnBD < limite) {
        setData("horarios", [...data.horarios, horarioCompleto]);
      } else {
        alert("Este horario ya está lleno por otros usuarios.");
      }
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (data.horarios.length < 1) {
      alert("Debes seleccionar al menos un horario");
      return;
    }

    if (isEdit) {
      // Usamos PUT para actualizar
      put(route("reservaciones.update", reservacion.id));
    } else {
      // Usamos POST para crear
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
            onChange={(val: string) => setData("localizacion", val)}
            options={localizaciones}
          />

          {data.localizacion && (
            <input
              type="date"
              className="w-full border rounded-md px-3 py-2"
              value={data.fecha}
              onChange={(e) => setData("fecha", e.target.value)}
            />
          )}

          {data.fecha && data.localizacion && (
            <div>
              <h3 className="font-semibold text-gray-700 mb-2">Horarios disponibles</h3>
              <ul className="grid grid-cols-3 md:grid-cols-6 gap-2">
                {horariosLista.map((hora) => {
                  const horarioCompleto = `${data.fecha} ${hora}:00`;
                  const seleccionado = data.horarios.includes(horarioCompleto);
                  const llaveOcupacion = `${data.localizacion}|${horarioCompleto}`;
                  const ocupadosEnBD = ocupacionActual[llaveOcupacion] ?? 0;
                  
                  const limite = limitesDinamicos[data.localizacion] ?? 0;
                  const totalParaMostrar = ocupadosEnBD + (seleccionado ? 1 : 0);
                  const estaLleno = totalParaMostrar >= limite && limite > 0;
                  const bloqueado = estaLleno && !seleccionado;

                  return (
                    <li key={hora}>
                      <button
                        key={hora}
                        type="button"
                        disabled={bloqueado}
                        onClick={() => toggleHorario(hora)}
                        className={`w-full px-3 py-2 rounded-md border text-sm transition flex flex-col items-center ${
                          seleccionado
                            ? "bg-indigo-600 text-white border-indigo-600"
                            : bloqueado
                            ? "bg-red-50 text-red-400 border-red-200 cursor-not-allowed"
                            : "bg-white hover:bg-indigo-50 border-gray-300"
                        }`}
                      >
                        <span className="font-medium">{hora}</span>
                        <span className="text-[10px] mt-1">
                          {totalParaMostrar >= limite && limite > 0 ? 'No disponible' : `${totalParaMostrar}/${limite}`}
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