import React, { useState } from "react";
import { Inertia } from '@inertiajs/inertia';
import MainLayout from '@/layouts/MainLayout';
import InputField from "../../components/ui/inputs-text";

const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    Inertia.post('/pacientes', form);
};
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
        // Aquí va la lógica para enviar el formulario
        console.log(form);
    };

    return (
        <form onSubmit={handleSubmit}>
            <InputField
                label="CURP"
                name="curp"
                value={form.curp}
                onChange={handleChange}
                required
                maxLength={18}
            />
            <InputField
                label="Nombre"
                name="nombre"
                value={form.nombre}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Apellido Paterno"
                name="apellido_paterno"
                value={form.apellido_paterno}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Apellido Materno"
                name="apellido_materno"
                value={form.apellido_materno}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <label>
                Sexo
                <select
                    name="sexo"
                    value={form.sexo}
                    onChange={handleChange}
                    required
                >
                    <option value="">Seleccione</option>
                    {sexos.map((s) => (
                        <option key={s} value={s}>
                            {s}
                        </option>
                    ))}
                </select>
            </label>
            <InputField
                label="Fecha de Nacimiento"
                name="fecha_nacimiento"
                value={form.fecha_nacimiento}
                onChange={handleChange}
                required
                type="date"
            />
            <InputField
                label="Calle"
                name="calle"
                value={form.calle}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Número Exterior"
                name="numero_exterior"
                value={form.numero_exterior}
                onChange={handleChange}
                required
                maxLength={50}
            />
            <InputField
                label="Número Interior"
                name="numero_interior"
                value={form.numero_interior}
                onChange={handleChange}
                maxLength={50}
            />
            <InputField
                label="Colonia"
                name="colonia"
                value={form.colonia}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Municipio"
                name="municipio"
                value={form.municipio}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Estado"
                name="estado"
                value={form.estado}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="País"
                name="pais"
                value={form.pais}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Código Postal"
                name="cp"
                value={form.cp}
                onChange={handleChange}
                required
                maxLength={10}
            />
            <InputField
                label="Teléfono"
                name="telefono"
                value={form.telefono}
                onChange={handleChange}
                required
                maxLength={20}
            />
            <label>
                Estado Civil
                <select
                    name="estado_civil"
                    value={form.estado_civil}
                    onChange={handleChange}
                    required
                >
                    <option value="">Seleccione</option>
                    {estadosCivil.map((e) => (
                        <option key={e} value={e}>
                            {e}
                        </option>
                    ))}
                </select>
            </label>
            <InputField
                label="Ocupación"
                name="ocupacion"
                value={form.ocupacion}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Lugar de Origen"
                name="lugar_origen"
                value={form.lugar_origen}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                label="Nombre del Padre"
                name="nombre_padre"
                value={form.nombre_padre}
                onChange={handleChange}
                maxLength={100}
            />
            <InputField
                label="Nombre de la Madre"
                name="nombre_madre"
                value={form.nombre_madre}
                onChange={handleChange}
                maxLength={100}
            />
            <button type="submit">Registrar Paciente</button>
        </form>
    );
};

export default PacienteCreate;
