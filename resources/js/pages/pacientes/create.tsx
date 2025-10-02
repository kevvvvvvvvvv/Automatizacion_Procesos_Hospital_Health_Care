import { Head, router } from '@inertiajs/react';
import React, { useState } from "react";
import MainLayout from '@/layouts/MainLayout';
import InputField from "@/components/ui/input-text";


const initialState = {
  curp: "",
  nombre: "",
  apellido_paterno: "",
  apellido_materno: "",
  sexo: "",
  fecha_nacimiento: "",
  calle: "",
  numero_exterior: "",
  numero_interior: "",
  colonia: "",
  municipio: "",
  estado: "",
  pais: "",
  cp: "",
  telefono: "",
  estado_civil: "",
  ocupacion: "",
  lugar_origen: "",
  nombre_padre: "",
  nombre_madre: "",
};

const sexos = ["Masculino", "Femenino"];
const estadosCivil = [
  "Soltero(a)",
  "Casado(a)",
  "Divorciado(a)",
  "Viudo(a)",
  "Union libre",
];

const PacienteCreate: React.FC = () => {
  const [form, setForm] = useState(initialState);

  const handleChange = (
    e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>
  ) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    router.post('/pacientes', form);
  };

  return (
    <MainLayout>
        <form className="max-w-4xl mx-auto p-6 bg-text-white rounded-lg shadow-lg text-black space-y-8" onSubmit={handleSubmit}>
        <h1 className="text-2xl font-bold mb-6 text-center">Registrar Paciente</h1>
        
        {/* Datos Personales */}
        <fieldset className="border border-gray-600 rounded-md p-4">
            <legend className="text-lg font-semibold mb-4">Datos Personales</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="curp"
                label="CURP"
                name="curp"
                value={form.curp}
                onChange={handleChange}
                required
                maxLength={18}
            />
            <InputField
                id="nombre"
                label="Nombre"
                name="nombre"
                value={form.nombre}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="apellido_paterno"
                label="Apellido Paterno"
                name="apellido_paterno"
                value={form.apellido_paterno}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="apellido_materno"
                label="Apellido Materno"
                name="apellido_materno"
                value={form.apellido_materno}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <div className="flex flex-col">
                <label htmlFor="sexo" className="mb-1 font-medium">Sexo</label>
                <select
                id="sexo"
                name="sexo"
                value={form.sexo}
                onChange={handleChange}
                required
                className="bg-white border border-gray-600 rounded-md px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#2a2b56]"
                >
                <option value="">Seleccione</option>
                {sexos.map((s) => (
                    <option key={s} value={s}>{s}</option>
                ))}
                </select>
            </div>
            <InputField
                id="fecha_nacimiento"
                label="Fecha de Nacimiento"
                name="fecha_nacimiento"
                value={form.fecha_nacimiento}
                onChange={handleChange}
                required
                type="date"
            />
            </div>
        </fieldset>

        {/* Dirección */}
        <fieldset className="border border-gray-600 rounded-md p-4">
            <legend className="text-lg font-semibold mb-4">Dirección</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="calle"
                label="Calle"
                name="calle"
                value={form.calle}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="numero_exterior"
                label="Número Exterior"
                name="numero_exterior"
                value={form.numero_exterior}
                onChange={handleChange}
                required
                maxLength={50}
            />
            <InputField
                id="numero_interior"
                label="Número Interior"
                name="numero_interior"
                value={form.numero_interior}
                onChange={handleChange}
                maxLength={50}
            />
            <InputField
                id="colonia"
                label="Colonia"
                name="colonia"
                value={form.colonia}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="municipio"
                label="Municipio"
                name="municipio"
                value={form.municipio}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="estado"
                label="Estado"
                name="estado"
                value={form.estado}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="pais"
                label="País"
                name="pais"
                value={form.pais}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="cp"
                label="Código Postal"
                name="cp"
                value={form.cp}
                onChange={handleChange}
                required
                maxLength={10}
            />
            </div>
        </fieldset>

        {/* Contacto y Estado Civil */}
        <fieldset className="border border-gray-600 rounded-md p-4">
            <legend className="text-lg font-semibold mb-4">Contacto y Estado Civil</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="telefono"
                label="Teléfono"
                name="telefono"
                value={form.telefono}
                onChange={handleChange}
                required
                maxLength={20}
            />
            <div className="flex flex-col">
                <label htmlFor="estado_civil" className="mb-1 font-medium">Estado Civil</label>
                <select
                id="estado_civil"
                name="estado_civil"
                value={form.estado_civil}
                onChange={handleChange}
                required
                className="bg-white border border-gray-600 rounded-md px-3 py-2 text-gray-900    focus:outline-none focus:ring-2 focus:ring-[#2a2b56]"
                >
                <option value="">Seleccione</option>
                {estadosCivil.map((e) => (
                    <option key={e} value={e}>{e}</option>
                ))}
                </select>
            </div>
            <InputField 
                id="ocupacion"
                label="Ocupación"
                name="ocupacion"
                value={form.ocupacion}
                onChange={handleChange}
                required
                maxLength={100}
            />
            </div>
        </fieldset>

        {/* Otros Datos */}
        <fieldset className="border border-gray-600 rounded-md p-4">
            <legend className="text-lg font-semibold mb-4">Otros Datos</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="lugar_origen"
                label="Lugar de Origen"
                name="lugar_origen"
                value={form.lugar_origen}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="nombre_padre"
                label="Nombre del Padre"
                name="nombre_padre"
                value={form.nombre_padre}
                onChange={handleChange}
                maxLength={100}
            />
            <InputField
                id="nombre_madre"
                label="Nombre de la Madre"
                name="nombre_madre"
                value={form.nombre_madre}
                onChange={handleChange}
                maxLength={100}
            />
            </div>
        </fieldset>

        <div className="text-center">
            <button
            type="submit"
            className="bg-[#2a2b56] hover:bg-[#3b3c7a] text-white font-semibold py-2 px-6 rounded-md transition"
            >
            Registrar Paciente
            </button>
        </div>
        </form>
    </MainLayout>
  );
};

export default PacienteCreate;
