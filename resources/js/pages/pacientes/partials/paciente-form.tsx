import React, { useState } from "react";
import { Head, router, useForm } from '@inertiajs/react';
import { Plus, Trash2 } from 'lucide-react';
import { Paciente } from '@/types';

// Componentes UI
import FormLayout from '@/components/form-layout';
import InputField from "@/components/ui/input-text";
import PrimaryButton from '@/components/ui/primary-button';
import { FaPlusMinus } from "react-icons/fa6";

interface Props {
    paciente?: Paciente; 
    onSubmit: (form: any) => void;
    submitLabel?: string;
}

export const PacienForm = ({
    paciente,
    onSubmit,
    submitLabel = 'Guardar'
}: Props) => {

    const form = useForm({
        curp: paciente?.curp || "",
        nombre: paciente?.nombre || "",
        apellido_paterno: paciente?.apellido_paterno || "",
        apellido_materno: paciente?.apellido_materno || "",
        sexo: paciente?.sexo || "",
        fecha_nacimiento: paciente?.fecha_nacimiento || "",
        calle: paciente?.calle || "",
        numero_exterior: paciente?.numero_exterior || "",
        numero_interior: paciente?.numero_interior || "",
        colonia: paciente?.colonia || "",
        municipio: paciente?.municipio || "",
        estado: paciente?.estado || "",
        pais: paciente?.pais || "México",
        cp: paciente?.cp || "",
        telefono: paciente?.telefono || "",
        estado_civil: paciente?.estado_civil || "",
        ocupacion: paciente?.ocupacion || "",
        lugar_origen: paciente?.lugar_origen || "",
        nombre_padre: paciente?.nombre_padre || "",
        nombre_madre: paciente?.nombre_madre || "",

        responsables: paciente?.familiar_responsables || []
    });

    const {data, setData, errors, processing} = form;

    const initialResponsableState = { nombre_completo: "", parentesco: "" };
    const [responsable, setResponsable] = useState(initialResponsableState);
    const [familiares, setFamiliares] = useState<any[]>([]);

    const sexos = ["Masculino", "Femenino"];
    const estadosCivil = ["Soltero(a)", "Casado(a)", "Divorciado(a)", "Viudo(a)", "Unión libre"];


    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setData(name as any, value);
    };

    const handleResponsableChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setResponsable({ ...responsable, [name]: value });
    };

    const addFamiliar = () => {
        if (!responsable.nombre_completo || !responsable.parentesco) return;
        const nuevosResponsables = [...data.responsables, responsable];
        setData('responsables', nuevosResponsables);
        setResponsable(initialResponsableState);
    };

    const removeFamiliar = (index: number) => {
        setFamiliares(familiares.filter((_, i) => i !== index));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        onSubmit(form);
    };
    return (
<FormLayout title='Registrar paciente'
        onSubmit={handleSubmit}
        actions = {
            <PrimaryButton type='submit' disabled={processing}>
                Guardar paciente
            </PrimaryButton>
        }>
        <div className="flex justify-between items-center mb-6"></div>    
        
        
        {/* Datos Personales */}
            <legend className="text-lg font-semibold mb-4">Datos Personales</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="curp"
                label="CURP"
                name="curp"
                value={data.curp}
                onChange={handleChange}
                required
                maxLength={18}
                error={errors.curp}
            />
            <InputField
                id="nombre"
                label="Nombre"
                name="nombre"
                value={data.nombre}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.nombre}
            />
            <InputField
                id="apellido_paterno"
                label="Apellido Paterno"
                name="apellido_paterno"
                value={data.apellido_paterno}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.apellido_paterno}
            />
            <InputField
                id="apellido_materno"
                label="Apellido Materno"
                name="apellido_materno"
                value={data.apellido_materno}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.apellido_materno}
            />
            <div className="flex flex-col">
                <label htmlFor="sexo" className="mb-1 font-medium">Sexo</label>
                <select
                id="sexo"
                name="sexo"
                value={data.sexo}
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
                value={data.fecha_nacimiento}
                onChange={handleChange}
                required
                type="date"
                error={errors.fecha_nacimiento}
            />
            </div>
       

        {/* Dirección */}
           <legend className="text-lg font-semibold mb-4">Dirección</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="calle"
                label="Calle"
                name="calle"
                value={data.calle}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.calle}
            />
            <InputField
                id="numero_exterior"
                label="Número Exterior"
                name="numero_exterior"
                value={data.numero_exterior}
                onChange={handleChange}
                required
                maxLength={50}
                error={errors.numero_exterior}
            />
            <InputField
                id="numero_interior"
                label="Número Interior"
                name="numero_interior"
                value={data.numero_interior}
                onChange={handleChange}
                maxLength={50}
                error={errors.numero_interior}
            />
            <InputField
                id="colonia"
                label="Colonia"
                name="colonia"
                value={data.colonia}
                onChange={handleChange}
                required
                maxLength={100}
            />
            <InputField
                id="municipio"
                label="Municipio"
                name="municipio"
                value={data.municipio}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.municipio}
            />
            <InputField
                id="estado"
                label="Estado"
                name="estado"
                value={data.estado}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.estado}
            />
            <InputField
                id="pais"
                label="País"
                name="pais"
                value={data.pais}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.pais}
            />
            <InputField
                id="cp"
                label="Código Postal"
                name="cp"
                value={data.cp}
                onChange={handleChange}
                required
                maxLength={10}
                error={errors.cp}
            />
            </div>
        

        {/* Contacto y Estado Civil */}
            <legend className="text-lg font-semibold mb-4">Contacto y Estado Civil</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="telefono"
                label="Teléfono"
                name="telefono"
                value={data.telefono}
                onChange={handleChange}
                required
                maxLength={20}
                error={errors.estado_civil}
            />
            <div className="flex flex-col">
                <label htmlFor="estado_civil" className="mb-1 font-medium">Estado Civil</label>
                <select
                id="estado_civil"
                name="estado_civil"
                value={data.estado_civil}
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
                value={data.ocupacion}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.ocupacion}
            />
            </div>
        
        {/* Otros Datos */}
        
            <legend className="text-lg font-semibold mb-4">Otros Datos</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <InputField
                id="lugar_origen"
                label="Lugar de Origen"
                name="lugar_origen"
                value={data.lugar_origen}
                onChange={handleChange}
                required
                maxLength={100}
                error={errors.lugar_origen}
            />
            <InputField
                id="nombre_padre"
                label="Nombre del Padre"
                name="nombre_padre"
                value={data.nombre_padre}
                onChange={handleChange}
                maxLength={100}
                error={errors.nombre_padre}
            />
            <InputField
                id="nombre_madre"
                label="Nombre de la Madre"
                name="nombre_madre"
                value={data.nombre_madre}
                onChange={handleChange}
                maxLength={100}
                error={errors.nombre_madre}
            />
            
            </div>
         {/* Familiar Responsable */}
                <legend className="text-lg font-semibold mb-4">Familiar Responsable</legend>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg border">
                    <InputField
                        id="nombre_completo"
                        label="Nombre del Familiar"
                        name="nombre_completo"
                        value={responsable.nombre_completo}
                        onChange={handleResponsableChange}
                    />
                    <InputField
                        id="parentesco"
                        label="Parentesco"
                        name="parentesco"
                        value={responsable.parentesco}
                       onChange={handleResponsableChange}
                    />
                    <button
                        type="button"
                        onClick={addFamiliar}
                        className="flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition h-[42px]"
                    >
                        <Plus size={18} /> Agregar a la lista
                    </button>
                </div>

                {/* TABLA DE FAMILIARES */}
{/* TABLA DE FAMILIARES */}
<div className="mt-6">
    <table className="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-sm border border-gray-200">
        <thead className="bg-gray-100">
            <tr>
                <th className="px-4 py-2 text-left text-sm font-bold text-gray-700 border-b">Nombre Completo</th>
                <th className="px-4 py-2 text-left text-sm font-bold text-gray-700 border-b">Parentesco</th>
                <th className="px-4 py-2 text-center text-sm font-bold text-gray-700 border-b w-20">Acción</th>
            </tr>
        </thead>
        <tbody>
            {/* CAMBIO AQUÍ: Usamos data.responsables */}
            {data.responsables.length > 0 ? (
                data.responsables.map((f: any, index: number) => (
                    <tr key={index} className="border-b hover:bg-gray-50">
                        <td className="px-4 py-2 text-sm">{f.nombre_completo}</td>
                        <td className="px-4 py-2 text-sm">{f.parentesco}</td>
                        <td className="px-4 py-2 text-center">
                            <button
                                type="button"
                                // Asegúrate que removeFamiliar use setData('responsables', ...)
                                onClick={() => removeFamiliar(index)} 
                                className="text-red-500 hover:text-red-700"
                            >
                                <Trash2 size={18} />
                            </button>
                        </td>
                    </tr>
                ))
            ) : (
                <tr>
                    <td colSpan={3} className="px-4 py-4 text-center text-gray-400 text-sm italic">
                        No se han agregado familiares responsables aún.
                    </td>
                </tr>
            )}
        </tbody>
    </table>
</div>
            </FormLayout>
    );
};