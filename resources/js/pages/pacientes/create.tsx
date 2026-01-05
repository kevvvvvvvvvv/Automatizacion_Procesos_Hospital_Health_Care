import { Head, router, useForm } from '@inertiajs/react';
import React, { useState } from "react";
import MainLayout from '@/layouts/MainLayout';
import InputField from "@/components/ui/input-text";
import AddButton from '@/components/ui/add-button';
import FormLayout from '@/components/form-layout';
import Paciente from '@/types';
import { Plus, Trash2 } from 'lucide-react';

import PrimaryButton from '@/components/ui/primary-button';




const initialResponsableState = {
  nombre_completo: "",  // Cambia a nombre_completo
  parentesco: "",
};



const sexos = ["Masculino", "Femenino"];
const estadosCivil = [
  "Soltero(a)",
  "Casado(a)",
  "Divorciado(a)",
  "Viudo(a)",
  "Union libre",
];
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

const PacienteCreate: React.FC = () => {
    const {data, setData, post, processing, errors} = useForm({
       
        
    });
  const [form, setForm, ] = useState(initialState);
    const [responsable, setResponsable] = useState(initialResponsableState);
    const [familiares, setFamiliares] = useState<any[]>([]);
  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    if (name in form) {
      setForm({ ...form, [name]: value });
    } else if (name in responsable) {
      setResponsable({ ...responsable, [name]: value });
    }
  };
 // NUEVO: Función para agregar a la tabla
    const addFamiliar = () => {
        if (!responsable.nombre_completo || !responsable.parentesco) return;
        
        setFamiliares([...familiares, responsable]);
        setResponsable(initialResponsableState); // Limpiar campos del familiar
    };

    // NUEVO: Función para eliminar de la tabla
    const removeFamiliar = (index: number) => {
        setFamiliares(familiares.filter((_, i) => i !== index));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // IMPORTANTE: Enviamos 'familiares' (la lista) en lugar de un solo objeto
        router.post('/pacientes', { 
            paciente: form, 
            responsables: familiares 
        });
    

};
  return (
    <MainLayout pageTitle='Registro de paciente' link='pacientes.index'>
         
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
       

        {/* Dirección */}
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
        

        {/* Contacto y Estado Civil */}
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
        
        {/* Otros Datos */}
        
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
         {/* Familiar Responsable */}
                <legend className="text-lg font-semibold mb-4">Familiar Responsable</legend>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-gray-50 p-4 rounded-lg border">
                    <InputField
                        id="nombre_completo"
                        label="Nombre del Familiar"
                        name="nombre_completo"
                        value={responsable.nombre_completo}
                        onChange={handleChange}
                    />
                    <InputField
                        id="parentesco"
                        label="Parentesco"
                        name="parentesco"
                        value={responsable.parentesco}
                        onChange={handleChange}
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
                            {familiares.length > 0 ? (
                                familiares.map((f, index) => (
                                    <tr key={index} className="border-b hover:bg-gray-50">
                                        <td className="px-4 py-2 text-sm">{f.nombre_completo}</td>
                                        <td className="px-4 py-2 text-sm">{f.parentesco}</td>
                                        <td className="px-4 py-2 text-center">
                                            <button
                                                type="button"
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
        </MainLayout>
  );

};

export default PacienteCreate;
