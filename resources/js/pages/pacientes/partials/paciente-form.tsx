import React, { useState, useEffect } from "react";
import { useForm } from '@inertiajs/react';
import { Plus, Trash2, AlertCircle, UserCheck } from 'lucide-react';
import { Paciente } from '@/types';
import axios from 'axios';

// Componentes UI
import FormLayout from '@/components/form-layout';
import InputField from "@/components/ui/input-text";
import PrimaryButton from '@/components/ui/primary-button';
import SelectInput from "@/components/ui/input-select";

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
  // Le decimos que será un arreglo de objetos con 'value' y 'label'
const [coloniasDisponibles, setColoniasDisponibles] = useState<{value: string, label: string}[]>([]);
    const [buscandoCP, setBuscandoCP] = useState(false);


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

    const { data, setData, errors, setError, clearErrors, processing } = form;

    const initialResponsableState = { nombre_completo: "", parentesco: "" };
    const [responsableInput, setResponsableInput] = useState(initialResponsableState);

    const calcularEdad = (fecha: string) => {
        if (!fecha) return 0;
        const hoy = new Date();
        const cumple = new Date(fecha);
        let edad = hoy.getFullYear() - cumple.getFullYear();
        const m = hoy.getMonth() - cumple.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < cumple.getDate())) {
            edad--;
        }
        return edad;
    };

    const edadActual = calcularEdad(data.fecha_nacimiento);
    const esMenorDeEdad = data.fecha_nacimiento ? edadActual < 18 : false;

    useEffect(() => {
        if (data.responsables.length > 0) {
            clearErrors('responsables' as any);
        }
    }, [data.responsables.length]);

    const sexos = [
        { value: 'Masculino', label: 'Masculino'},
        { value: 'Femenino', label: 'Femenino'},
    ]

    const estadosCivil = [
        { value:"Soltero(a)", label: 'Soltero(a)'},
        { value:"Casado(a)", label:"Casado(a)"},
        { value:"Divorciado(a)", label: "Divorciado(a)"},
        { value:"Viudo(a)", label:"Viudo(a)"},
        { value:"Unión libre", label: "Unión libre"}];

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setData(name as any, value);
    };

    const handleResponsableInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value } = e.target;
        setResponsableInput({ ...responsableInput, [name]: value });
    };

    const addFamiliar = () => {
        if (!responsableInput.nombre_completo || !responsableInput.parentesco) {
            alert("Por favor completa el nombre y parentesco del familiar.");
            return;
        }
    
        const nuevosResponsables = [...data.responsables, { ...responsableInput }];
        setData('responsables', nuevosResponsables);
        setResponsableInput(initialResponsableState);
    };

    const removeFamiliar = (index: number) => {
        const nuevos = data.responsables.filter((_: any, i: number) => i !== index);
        setData('responsables', nuevos);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if (esMenorDeEdad && data.responsables.length === 0) {
            setError('responsables' as any, 'El paciente es menor de edad. Es obligatorio agregar al menos un familiar responsable.');
            document.getElementById('seccion-familiar')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        onSubmit(form);
    };
    


    const handleZipCode = async (e) => {
        const cpValue = e.target.value;

        setData('cp', cpValue); 

        if (cpValue.length === 5) {
            setBuscandoCP(true);
            try {
                const response = await axios.get(`/api/sepomex/${cpValue}`);
                const resultados = response.data;

                if (resultados.length > 0) {
                    const municipio = resultados[0].D_mnpio;
                    const estado = resultados[0].d_estado;

                    if (resultados.length > 1) {
                        const opciones = resultados.map(r => ({
                            value: r.d_asenta,
                            label: String(r.d_asenta).toUpperCase() 
                        }));

                        setColoniasDisponibles(opciones);

                        setData(prevData => ({
                            ...prevData,
                            cp: cpValue,
                            municipio: municipio,
                            estado: estado,
                            pais: 'MÉXICO',
                            colonia: opciones[0].value 
                        }));

                    } else {
                        setColoniasDisponibles([]);
                        
                        setData(prevData => ({
                            ...prevData,
                            cp: cpValue,
                            municipio: municipio,
                            estado: estado,
                            pais: 'MÉXICO',
                            colonia: resultados[0].d_asenta 
                        }));
                    }
                } else {
                    setColoniasDisponibles([]); 
                }
            } catch (error) {
                console.error("Error consultando SEPOMEX", error);
            } finally {
                setBuscandoCP(false);
            }
        } else {
            setColoniasDisponibles([]); 
        }
    };

    return (
        <FormLayout 
            title='Registrar paciente'
            onSubmit={handleSubmit}
            actions = {
                <PrimaryButton type='submit' disabled={processing}>
                    {submitLabel} paciente
                </PrimaryButton>
            }
        >
            {/* Datos Personales */}
            <div className="flex items-center gap-2 mb-4 border-b pb-2">
                <UserCheck className="text-gray-400" size={20} />
                <legend className="text-lg font-semibold text-gray-700">Datos Personales</legend>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <InputField
                    id="curp"
                    label="CURP *"
                    name="curp"
                    value={data.curp.toUpperCase()}
                    onChange={handleChange}
                    maxLength={18}
                    error={errors.curp}
                />

                <InputField
                    id="nombre"
                    label="Nombre *"
                    name="nombre"
                    value={data.nombre.toUpperCase()}
                    onChange={handleChange}
                    maxLength={100}
                    error={errors.nombre}
                />

                <InputField
                    id="apellido_paterno"
                    label="Apellido paterno *"
                    name="apellido_paterno"
                    value={data.apellido_paterno.toUpperCase()}
                    onChange={handleChange}
                    maxLength={100}
                    error={errors.apellido_paterno}
                />

                <InputField
                    id="apellido_materno"
                    label="Apellido materno *"
                    name="apellido_materno"
                    value={data.apellido_materno.toUpperCase()}
                    onChange={handleChange}
                    maxLength={100}
                    error={errors.apellido_materno}
                />

                <SelectInput
                        label="Sexo *"
                        options={sexos}
                        value={data.sexo}
                        onChange={e => setData('sexo',e)}
                        error={errors.sexo}
                />



                <div className="flex flex-col">
                    <InputField
                        id="fecha_nacimiento"
                        label="Fecha de nacimiento *"
                        name="fecha_nacimiento"
                        value={data.fecha_nacimiento}
                        onChange={handleChange}
                        type="date"
                        error={errors.fecha_nacimiento}
                    />
                    {data.fecha_nacimiento && (
                        <div className={`text-xs font-bold mt-1 px-2 py-0.5 rounded-full inline-block w-fit ${esMenorDeEdad ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700'}`}>
                            {edadActual} años {esMenorDeEdad ? '(Menor de edad)' : '(Adulto)'}
                        </div>
                    )}
                </div>
            </div>

            {/* Dirección */}
            <legend className="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Dirección</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <InputField id="cp" label="C.P. *" name="cp" value={data.cp} onChange={handleZipCode} error={errors.cp} />
                <InputField id="calle" label="Calle *" name="calle" value={String(data.calle || '').toUpperCase()} onChange={handleChange} error={errors.calle} />
                <InputField id="numero_exterior" label="Num. Ext *" name="numero_exterior" value={data.numero_exterior} onChange={handleChange} error={errors.numero_exterior} />
                <InputField id="numero_interior" label="Num. Int" name="numero_interior" value={data.numero_interior} onChange={handleChange} />
                {coloniasDisponibles.length > 1 ? (
                <SelectInput 
                        label="Colonia *" 
                    options={coloniasDisponibles} 
                    value={data.colonia || ''} 
                    onChange={e => setData('colonia',e)}
                    error={errors.colonia} 
                />  
                ) : (
                    <InputField id="colonia" label="Colonia *" name="colonia" value={String(data.colonia || '').toUpperCase()} onChange={handleChange} error={errors.colonia} />
                )}

                <InputField id="municipio" label="Municipio *" name="municipio" value={String(data.municipio || '').toUpperCase()} onChange={handleChange} error={errors.municipio} />
                <InputField id="estado" label="Estado *" name="estado" value={String(data.estado || '').toUpperCase()} onChange={handleChange} error={errors.estado} />
                <InputField id="pais" label="País *" name="pais" value={String(data.pais || '').toUpperCase()} onChange={handleChange} error={errors.pais} />
            </div>

            {/* Contacto y Estado Civil */}
            <legend className="text-lg font-semibold mb-4 text-gray-700 border-b pb-2">Contacto y Estado Civil</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <InputField id="telefono" label="Teléfono *" name="telefono" value={data.telefono} onChange={handleChange} error={errors.telefono} />
                <SelectInput
                    label="Estado civil *"
                    value={data.estado_civil}
                    onChange={e => setData('estado_civil',e)}
                    options={estadosCivil}
                    error={errors.estado_civil}
                />
                <InputField id="ocupacion" label="Ocupación" name="ocupacion" value={data.ocupacion.toUpperCase()} onChange={handleChange} />
            </div>
            {/* Otros Datos */}
        
            <legend className="text-lg font-semibold mb-4">Otros Datos</legend>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">

            <InputField
                id="lugar_origen"
                label="Lugar de origen"
                name="lugar_origen"
                value={data.lugar_origen.toUpperCase()}
                onChange={handleChange}
                maxLength={100}
                error={errors.lugar_origen}
            />

            <InputField
                id="nombre_padre"
                label="Nombre del padre"
                name="nombre_padre"
                value={data.nombre_padre.toUpperCase()}
                onChange={handleChange}
                maxLength={100}
                error={errors.nombre_padre}
            />
            <InputField
                id="nombre_madre"
                label="Nombre de la madre"
                name="nombre_madre"
                value={data.nombre_madre.toUpperCase()}
                onChange={handleChange}
                maxLength={100}
                error={errors.nombre_madre}
            />
            
            </div>


            {/* Familiar Responsable */}
            <div id="seccion-familiar" className="scroll-mt-10">
                <legend className="text-lg font-semibold mb-2 text-gray-700 flex items-center gap-2">
                    Familiar Responsable
                    {esMenorDeEdad && <span className="text-xs bg-red-500 text-white px-2 py-0.5 rounded animate-pulse">REQUERIDO</span>}
                </legend>
                
                {errors.responsables && (
                    <div className="flex items-center gap-2 p-3 mb-4 text-sm text-red-700 bg-red-50 rounded-lg border border-red-200">
                        <AlertCircle size={18} />
                        {errors.responsables as string}
                    </div>
                )}

                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end bg-blue-50/50 p-4 rounded-lg border border-blue-100 mb-6">
                    <InputField
                        id="nombre_completo"
                        label="Nombre del familiar"
                        name="nombre_completo"
                        value={responsableInput.nombre_completo.toUpperCase()}
                        onChange={handleResponsableInputChange}
                    />
                    <InputField
                        id="parentesco"
                        label="Parentesco"
                        name="parentesco"
                        value={responsableInput.parentesco.toUpperCase()}
                        onChange={handleResponsableInputChange}
                    />
                    <button
                        type="button"
                        onClick={addFamiliar}
                        className="flex items-center justify-center gap-2 bg-[#2a2b56] text-white px-4 py-2 rounded-md hover:bg-[#1a1b36] transition h-[42px] font-medium"
                    >
                        <Plus size={18} /> Agregar Familiar
                    </button>
                </div>

                {/* TABLA DE FAMILIARES AGREGADOS */}
                <div className="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table className="w-full border-collapse bg-white">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b">Nombre completo</th>
                                <th className="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b">Parentesco</th>
                                <th className="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider border-b w-24">Acción</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-200">
                            {data.responsables.length > 0 ? (
                                data.responsables.map((f: any, index: number) => (
                                    <tr key={index} className="hover:bg-gray-50 transition-colors">
                                        <td className="px-4 py-3 text-sm text-gray-700 font-medium">{f.nombre_completo}</td>
                                        <td className="px-4 py-3 text-sm text-gray-600">{f.parentesco}</td>
                                        <td className="px-4 py-3 text-center">
                                            <button
                                                type="button"
                                                onClick={() => removeFamiliar(index)} 
                                                className="text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50 transition"
                                                title="Eliminar familiar"
                                            >
                                                <Trash2 size={18} />
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={3} className="px-4 py-8 text-center text-gray-400 text-sm italic">
                                        No se han agregado familiares responsables aún.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </FormLayout>
    );
};