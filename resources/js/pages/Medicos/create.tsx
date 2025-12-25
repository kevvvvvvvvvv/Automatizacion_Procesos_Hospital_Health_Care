import React, { useState, useEffect } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { CredencialEmpleado, Role, User } from '@/types';

import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import InputSelect from '@/components/ui/input-select';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';

type Props = {
    cargos?: Role[];
    user: User;
};

const CreateDoctor: React.FC<Props> = ({ cargos = [], user }) => {

    const sexoOptions = [
        { label: 'Feminino', value: 'Femenino' },
        { label: 'Masculino', value: 'Masculino'}
    ]

    const cargoOptions = cargos.map(m=>(
        { value:m.id, label:m.name }
    ));

    const isEditing = !!user;

    const [qualifications, setQualifications] = useState<CredencialEmpleado[]>(
        user?.credenciales || []
    );

    const [localCargos, setLocalCargos] = useState(cargos);
    const [newTitulo, setNewTitulo] = useState('');
    const [newCedula, setNewCedula] = useState('');
    const [editingIndex, setEditingIndex] = useState<number | null>(null);


    const handleAddOrUpdateQualification = () => {
        if (!newTitulo.trim()) {
            alert('El título es requerido.');
            return;
        }

        const newQual = {
            titulo: newTitulo.trim(),
            cedula: newCedula.trim() || '',
        };

        let updatedQualifications;

        if (editingIndex !== null) {
            updatedQualifications = [...qualifications];
            updatedQualifications[editingIndex] = newQual;
            setEditingIndex(null);
        } else {
            updatedQualifications = [...qualifications, newQual];
        }

        setQualifications(updatedQualifications);
        setData('professional_qualifications', updatedQualifications); // Sync con Inertia

        setNewTitulo('');
        setNewCedula('');
    };

    const handleEditQualification = (index: number) => {
        const qual = qualifications[index];
        setNewTitulo(qual.titulo);
        setNewCedula(qual.cedula_profesional);
        setEditingIndex(index);
    };

    const handleRemoveQualification = (index: number) => {
        const updatedQualifications = qualifications.filter((_, i) => i !== index);
        setQualifications(updatedQualifications);
        setData('professional_qualifications', updatedQualifications);
        if (editingIndex === index) {
        setEditingIndex(null);
        setNewTitulo('');
        setNewCedula('');
        }
    };


    const handleCancelEdit = () => {
        setEditingIndex(null);
        setNewTitulo('');
        setNewCedula('');
    };

    const { data, setData, post, put, processing, errors } = useForm({
        nombre: user?.nombre || '',
        apellido_paterno: user?.apellido_paterno || '',
        apellido_materno: user?.apellido_materno || '',
        curp: user?.curp || '',
        sexo: user?.sexo || '',
        fecha_nacimiento: user?.fecha_nacimiento || '',
        cargo_id: user?.roles || '',
        colaborador_responsable_id: user?.colaborador_responsable_id || '',
        email: user?.email || '',
        password: '',
        password_confirmation: '',
        telefono: '',
        professional_qualifications: user?.credenciales || '',  
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        
        if (isEditing && user) {
            put(route('doctores.update', user.id), {
                onSuccess: () => {
                    setData(data => ({ ...data, password: '', password_confirmation: '' }));
                }
            });
        } else {
            post(route('doctores.store'));
        }
    };

    const title = isEditing ? 'Editar colaborador' : 'Registrar colaborador';
    const btnText = processing ? 'Guardando...' : (isEditing ? 'Actualizar' : 'Registrar');

    return (
        <MainLayout link='doctores.index' pageTitle={title}>
            <Head title={title}/>
            <FormLayout title="" onSubmit={handleSubmit} actions={
                <PrimaryButton disabled={processing} type='submit'>{processing ? 'Guardando...' : btnText}</PrimaryButton>
            }>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <InputText
                    id="nombre"
                    label="Nombre"
                    name="nombre"
                    value={data.nombre}
                    onChange={(e) => setData('nombre', e.target.value)}
                    placeholder="Ej: Juan"
                    error={errors.nombre}
                />

                <InputText
                id="apellido_paterno"
                label="Apellido Paterno"
                name="apellido_paterno"
                value={data.apellido_paterno}
                onChange={(e) => setData('apellido_paterno', e.target.value)}
                placeholder="Ej: Pérez"
                error={errors.apellido_paterno}
                />

                <InputText
                id="apellido_materno"
                label="Apellido Materno"
                name="apellido_materno"
                value={data.apellido_materno}
                onChange={(e) => setData('apellido_materno', e.target.value)}
                placeholder="Ej: García"
                error={errors.apellido_materno}
                />

                <InputText
                    id="curp"
                    label="CURP"
                    name="curp"
                    value={data.curp}
                    onChange={(e) => setData('curp', e.target.value.toUpperCase())}
                    placeholder="Ej: PEJG800101HDFR0001"
                    maxLength={18}
                    error={errors.curp}
                />

                <InputSelect
                    label="Sexo"
                    options={sexoOptions}
                    value={data.sexo}
                    onChange={e=>setData('sexo',e)}
                    error={errors.sexo}
                />

                <InputText
                    id="fecha_nacimiento"
                    label="Fecha de nacimiento"
                    name="fecha_nacimiento"
                    type="date"
                    value={data.fecha_nacimiento}
                    onChange={(e) => setData('fecha_nacimiento', e.target.value)}
                    error={errors.fecha_nacimiento}
                />

                <InputSelect
                    label="Cargo principal"
                    options={cargoOptions}
                    value={data.cargo_id}
                    onChange={e=>setData('cargo_id',e)}
                    error={errors.cargo_id}
                />

                <InputText
                    id="telefono"
                    label="Teléfono"
                    name="telefono"
                    type="number"
                    value={data.telefono}
                    onChange={(e) => setData('telefono', e.target.value.toString())}
                    error={errors.telefono}
                />

            </div>
                
            <div className="md:col-span-2 mb-6">
                <label className="block text-sm font-medium text-gray-700 mb-4">Títulos y cédulas profesionales</label>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                    <InputText
                        id="new_titulo"
                        label="Título"
                        name="new_titulo"
                        value={newTitulo}
                        onChange={(e) => setNewTitulo(e.target.value)}
                        placeholder="Ej: Licenciatura en Medicina"
                        maxLength={100}
                        error={null}
                    />
                    <InputText
                        id="new_cedula"
                        label="Cédula"
                        name="new_cedula"
                        value={newCedula}
                        onChange={(e) => setNewCedula(e.target.value.toUpperCase())}
                        placeholder="Ej: 1234567"
                        maxLength={20}
                        error={null}
                    />
                    </div>

                    <div className="flex flex-wrap gap-2 mb-4">
                    <button
                        type="button"
                        onClick={handleAddOrUpdateQualification}
                        className="px-6 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition"
                        disabled={!newTitulo.trim()}
                        style={{ backgroundColor: '#1B1C38' }}
                    >
                        {editingIndex !== null ? 'Actualizar título' : '+ Agregar título'}
                    </button>
                    {editingIndex !== null && (
                        <button
                        type="button"
                        onClick={handleCancelEdit}
                        className="px-6 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition"
                        >
                        Cancelar
                        </button>
                    )}
                </div>

                {qualifications.length > 0 ? (
                <div className="overflow-x-auto">
                    <table className="w-full border-collapse border border-gray-300 bg-white rounded-lg shadow">
                        <thead className="bg-gray-100">
                            <tr>
                            <th className="border border-gray-300 px-4 py-2 text-left">Título</th>
                            <th className="border border-gray-300 px-4 py-2 text-left">Cédula</th>
                            <th className="border border-gray-300 px-4 py-2 text-left">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {qualifications.map((qual, index) => (
                            <tr key={index} className="hover:bg-gray-50">
                                <td className="border border-gray-300 px-4 py-2">{qual.titulo}</td>
                                <td className="border border-gray-300 px-4 py-2">{qual.cedula || 'N/A'}</td>
                                <td className="border border-gray-300 px-4 py-2">
                                <button
                                    type="button"
                                    onClick={() => handleEditQualification(index)}
                                    className="px-3 py-1 bg-blue-500 text-white text-xs rounded mr-1 hover:bg-blue-600 transition"
                                >
                                    Editar
                                </button>
                                <button
                                    type="button"
                                    onClick={() => handleRemoveQualification(index)}
                                    className="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition"
                                >
                                    Eliminar
                                </button>
                                </td>
                            </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                ) : (
                <p className="text-gray-500 text-sm italic">No se han agregado títulos aún.</p>
                )}
                {errors.professional_qualifications && (
                <p className="text-red-500 text-sm mt-1">{errors.professional_qualifications}</p>
                )}
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <InputText
                    id="email"
                    label="Email"
                    type="email"
                    name="email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    placeholder="Ej: doctor@clinic.com"
                    error={errors.email}
                />

                <InputText
                    id="password"
                    label="Contraseña"
                    type="password"
                    name="password"
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                    error={errors.password}
                />

                <div className="md:col-span-2">
                <InputText
                    id="password_confirmation"
                    label="Confirmar contraseña"
                    type="password"
                    name="password_confirmation"
                    value={data.password_confirmation}
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                    error={errors.password_confirmation}
                />
                </div>
            </div>
            </FormLayout>
        </MainLayout>
    );
};

export default CreateDoctor;
