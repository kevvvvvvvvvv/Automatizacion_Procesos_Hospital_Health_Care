import React, { useState } from "react";
import { useForm } from '@inertiajs/react';
import { Plus, Trash2 } from 'lucide-react';
import { Paciente } from '@/types';

// Componentes UI (Asegúrate de que las rutas sean correctas en tu proyecto)
import FormLayout from '@/components/form-layout';
import InputField from "@/components/ui/input-text";
import PrimaryButton from '@/components/ui/primary-button';

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

    // 1. Configuración del Formulario de Inertia
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

    const { data, setData, errors, processing, setError, clearErrors } = form;

    // 2. Estados locales para el input de agregar responsables
    const initialResponsableState = { nombre_completo: "", parentesco: "" };
    const [responsableInput, setResponsableInput] = useState(initialResponsableState);

    const sexos = ["Masculino", "Femenino"];
    const estadosCivil = ["Soltero(a)", "Casado(a)", "Divorciado(a)", "Viudo(a)", "Unión libre"];

    // 3. Lógica para calcular si es menor de edad
    const checarMenorDeEdad = (fecha: string): boolean => {
        if (!fecha) return false;
        const hoy = new Date();
        const nacimiento = new Date(fecha);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad < 18;
    };

    const esMenor = checarMenorDeEdad(data.fecha_nacimiento);

    // 4. Manejadores de Eventos
    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setData(name as any, value);
    };

    const handleResponsableChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setResponsableInput({ ...responsableInput, [name]: value });
    };

    const addFamiliar = () => {
        if (!responsableInput.nombre_completo || !responsableInput.parentesco) {
            alert("Por favor rellena el nombre y parentesco del responsable.");
            return;
        }
        const nuevosResponsables = [...data.responsables, responsableInput];
        setData('responsables', nuevosResponsables);
        setResponsableInput(initialResponsableState);
        clearErrors('responsables' as any);
    };

    const removeFamiliar = (index: number) => {
        const filtrados = data.responsables.filter((_, i) => i !== index);
        setData('responsables', filtrados);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        // VALIDACIÓN CRÍTICA: Menor de edad debe tener responsables
        if (esMenor && data.responsables.length === 0) {
            setError('responsables' as any, "El paciente es menor de edad. Debe agregar al menos un familiar responsable.");
            return;
        }

        onSubmit(form);
    };

    return (
        <FormLayout 
            title='Registrar paciente'
            onSubmit={handleSubmit}
            actions={
                <PrimaryButton type='submit' disabled={processing}>
                    {submitLabel} Paciente
                </PrimaryButton>
            }
        >
            {/* Datos Personales */}
            <legend className="text-lg font-semibold mb-4">Datos Personales</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <InputField id="curp" label="CURP *" name="curp" value={data.curp} onChange={handleChange} required maxLength={18} error={errors.curp} />
                <InputField id="nombre" label="Nombre *" name="nombre" value={data.nombre} onChange={handleChange} required error={errors.nombre} />
                <InputField id="apellido_paterno" label="Apellido Paterno *" name="apellido_paterno" value={data.apellido_paterno} onChange={handleChange} required error={errors.apellido_paterno} />
                <InputField id="apellido_materno" label="Apellido Materno *" name="apellido_materno" value={data.apellido_materno} onChange={handleChange} required error={errors.apellido_materno} />
                
                <div className="flex flex-col">
                    <label htmlFor="sexo" className="mb-1 font-medium">Sexo *</label>
                    <select id="sexo" name="sexo" value={data.sexo} onChange={handleChange} required className="bg-white border border-gray-600 rounded-md px-3 py-2 text-gray-900 focus:ring-2 focus:ring-[#2a2b56]">
                        <option value="">Seleccione</option>
                        {sexos.map((s) => <option key={s} value={s}>{s}</option>)}
                    </select>
                </div>

                <InputField
                    id="fecha_nacimiento"
                    label="Fecha de Nacimiento *"
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
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <InputField id="calle" label="Calle *" name="calle" value={data.calle} onChange={handleChange} required />
                <InputField id="numero_exterior" label="Número Exterior *" name="numero_exterior" value={data.numero_exterior} onChange={handleChange} required />
                <InputField id="colonia" label="Colonia *" name="colonia" value={data.colonia} onChange={handleChange} required />
                <InputField id="municipio" label="Municipio *" name="municipio" value={data.municipio} onChange={handleChange} required />
                <InputField id="estado" label="Estado *" name="estado" value={data.estado} onChange={handleChange} required />
                <InputField id="cp" label="Código Postal *" name="cp" value={data.cp} onChange={handleChange} required />
            </div>

            {/* Familiar Responsable (Sección Dinámica) */}
            <legend className={`text-lg font-semibold mb-4 ${esMenor ? "text-red-600 flex items-center gap-2" : ""}`}>
                Familiar Responsable {esMenor && <span className="text-xs bg-red-600 text-white px-2 py-1 rounded-full">OBLIGATORIO PARA MENORES</span>}
            </legend>
            
            <div className={`grid grid-cols-1 md:grid-cols-3 gap-4 items-end p-4 rounded-lg border mb-4 ${esMenor ? "bg-red-50 border-red-200" : "bg-gray-50 border-gray-200"}`}>
                <InputField
                    id="nombre_completo"
                    label="Nombre del Familiar"
                    name="nombre_completo"
                    value={responsableInput.nombre_completo}
                    onChange={handleResponsableChange}
                />
                <InputField
                    id="parentesco"
                    label="Parentesco"
                    name="parentesco"
                    value={responsableInput.parentesco}
                    onChange={handleResponsableChange}
                />
                <button
                    type="button"
                    onClick={addFamiliar}
                    className="flex items-center justify-center gap-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition h-[42px]"
                >
                    <Plus size={18} /> Agregar 
                </button>
            </div>

            {/* Error específico de la lista de responsables */}
            {errors.responsables && <p className="text-red-500 text-sm mb-4 font-bold">{errors.responsables as string}</p>}

            {/* Tabla de Responsables */}
            <div className="overflow-x-auto mb-8">
                <table className="w-full border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                    <thead className="bg-gray-100">
                        <tr>
                            <th className="px-4 py-2 text-left text-sm font-bold text-gray-700 border-b">Nombre Completo</th>
                            <th className="px-4 py-2 text-left text-sm font-bold text-gray-700 border-b">Parentesco</th>
                            <th className="px-4 py-2 text-center text-sm font-bold text-gray-700 border-b w-20">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {data.responsables.length > 0 ? (
                            data.responsables.map((f: any, index: number) => (
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
    );
};