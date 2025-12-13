import React from "react";
import MainLayout from "@/layouts/MainLayout";
import SelectInput from "@/components/ui/input-select";
import { useForm } from "@inertiajs/react";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";
import { route } from "ziggy-js";

const LIMITE_POR_LOCALIZACION: Record<string, number> = {
  plan_ayutla: 5,
  acapantzingo: 3,
};

const localizaciones = [
  { value: "plan_ayutla", label: "Plan de Ayutla" },
  { value: "acapantzingo", label: "Diaz ordas" },
];

const generarHorarios = () => {
  const horarios: string[] = [];
  for (let h = 0; h < 24; h++) {
    for (let m = 0; m < 60; m += 30) {
      horarios.push(
        `${String(h).padStart(2, "0")}:${String(m).padStart(2, "0")}`
      );
    }
  }
  return horarios;
};

const horarios = generarHorarios();

const CreateReservacion: React.FC = () => {
  const { data, setData, post, processing } = useForm({
    localizacion: "",
    fecha: "",
    horarios: [] as string[],
  });

  const contarHorario = (hora: string) =>
    data.horarios.filter((h) => h.endsWith(hora)).length;

  const toggleHorario = (hora: string) => {
  if (!data.fecha || !data.localizacion) return;

  const horarioCompleto = `${data.fecha} ${hora}`;
  const limite = LIMITE_POR_LOCALIZACION[data.localizacion];

  const yaSeleccionado = data.horarios.includes(horarioCompleto);
  const usados = contarHorario(hora);

  // Si ya lo seleccionó → quitarlo
  if (yaSeleccionado) {
    setData(
      "horarios",
      data.horarios.filter((h) => h !== horarioCompleto)
    );
    return;
  }

  if (usados >= limite) return;

  
  setData("horarios", [...data.horarios, horarioCompleto]);
};


  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (data.horarios.length < 1) {
      alert("Debes seleccionar al menos 1 horarios");
      return;
    }

    post(route("reservaciones.store"));
  };

  return (
    <MainLayout pageTitle="Reservación" link="reservaciones.index">
      <FormLayout
        title="Registrar reservación"
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? "Guardando..." : "Guardar"}
          </PrimaryButton>
        }
      >
        <div className="space-y-6">

          {/* Localización */}
          <SelectInput
            label="Localización"
            value={data.localizacion}
            onChange={(val: string) => setData("localizacion", val)}
            options={localizaciones}
          />

          {/* Fecha */}
          {data.localizacion && (
            <input
              type="date"
              className="w-full border rounded-md px-3 py-2"
              value={data.fecha}
              onChange={(e) => setData("fecha", e.target.value)}
            />
          )}

          {/* Horarios */}
          {data.fecha && (
            <div>
              <h3 className="font-semibold text-gray-700 mb-2">
                Selecciona horarios (30 min)
              </h3>

              <ul className="grid grid-cols-3 md:grid-cols-6 gap-2">
                {horarios.map((hora) => {
                  const usados = contarHorario(hora);
                  const limite = LIMITE_POR_LOCALIZACION[data.localizacion];
                  const seleccionado = data.horarios.includes(`${data.fecha} ${hora}`);
                  const bloqueado = usados >= limite && !seleccionado;


                  return (
                    <li key={hora}>
                      <button
                        type="button"
                        disabled={bloqueado}
                        onClick={() => toggleHorario(hora)}
                        className={`w-full px-3 py-2 rounded-md border text-sm transition
                            ${
                              seleccionado
                                ? "bg-indigo-600 text-white border-indigo-600"
                                : bloqueado
                                ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                                : "bg-white hover:bg-indigo-50"
                            }`}

                      >
                        {hora}
                        <div className="text-xs mt-1">
                          {usados}/{limite}
                        </div>
                      </button>
                    </li>
                  );
                })}
              </ul>
            </div>
          )}

          {/* Resumen */}
          {data.horarios.length > 0 && (
            <div className="mt-4">
              <h4 className="font-semibold text-gray-700 mb-2">
                Horarios seleccionados ({data.horarios.length})
              </h4>
              <ul className="text-sm text-gray-600 space-y-1">
                {data.horarios.map((h, i) => (
                  <li key={i}>• {h}</li>
                ))}
              </ul>
            </div>
          )}

        </div>
      </FormLayout>
    </MainLayout>
  );
};

export default CreateReservacion;
