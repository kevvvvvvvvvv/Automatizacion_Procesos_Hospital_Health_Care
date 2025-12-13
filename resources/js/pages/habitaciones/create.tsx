import React from "react";
import MainLayout from "@/layouts/MainLayout";
import { useForm } from "@inertiajs/react";
import SelectInput from "@/components/ui/input-select";
import { route } from "ziggy-js";
import PrimaryButton from "@/components/ui/primary-button";
import InputText from "@/components/ui/input-text";
import FormLayout from "@/components/form-layout";
import { Habitacion } from "@/types";

interface Props {
  habitacion?: Habitacion | null;
}

const HabitacionCreate: React.FC<Props> = ({ habitacion }) => {
  const isEdit = !!habitacion;

  // Inicializar el formulario de forma segura (habitacion puede ser null)
  const { data, setData, post, put, processing, errors } = useForm({
    identificador: habitacion?.identificador ?? "",
    tipo: habitacion?.tipo ?? "",
    piso: habitacion?.piso ?? "",
  });

  const optionsTipo = [
    { value: "Consultorio", label: "Consultorio" },
    { value: "Habitación", label: "Habitación" },
    { value: "Quirofano", label: "Quirofano" },
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (isEdit && habitacion) {
      put(route("habitaciones.update", habitacion.id));
    } else {
      post(route("habitaciones.store"));
    }
  };

  return (
    <MainLayout pageTitle="Registrar Habitación" link="habitaciones.index">
      <FormLayout
        title={isEdit ? "Editar habitación" : "Registrar habitación"}
        onSubmit={handleSubmit}
        actions={
          <PrimaryButton type="submit" disabled={processing}>
            {processing ? (isEdit ? "Actualizando..." : "Guardando...") : isEdit ? "Actualizar" : "Guardar"}
          </PrimaryButton>
        }
      >
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <InputText
            id="identificador"
            name="identificador"
            label="Identificador"
            value={data.identificador}
            onChange={(e) => setData("identificador", e.target.value)}
            placeholder="Escriba el identificador"
            error={errors.identificador}
          />

          <SelectInput
            label="Tipo"
            options={optionsTipo}
            placeholder="Selecciona el tipo"
            value={data.tipo}
            // asumo que SelectInput pasa directamente el valor seleccionado (string)
            onChange={(value: string) => setData("tipo", value)}
            error={errors.tipo}
          />

          <InputText
            id="piso"
            name="piso"
            label="Piso"
            value={data.piso}
            onChange={(e) => setData("piso", e.target.value)}
            placeholder="Escriba el piso"
            error={errors.piso}
          />
        </div>
      </FormLayout>
    </MainLayout>
  );
};

export default HabitacionCreate;
