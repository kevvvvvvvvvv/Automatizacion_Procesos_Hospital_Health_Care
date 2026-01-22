import React, { useState, useEffect } from 'react';
import { Head, useForm, router, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';
import { Doctor } from '@/types';
import BackButton from '@/components/ui/back-button';
import InputText from '@/components/ui/input-text';
import InputDate from '@/components/ui/input-date';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';

type Props = {
    doctor: {
    id: number;
    nombre: string;
    apellido_paterno: string;
    apellido_materno?: string | null;
    curp?: string;
    sexo?: string;
    fecha_nacimiento?: string;
    cargo_id?: number | string;
    colaborador_responsable_id?: number | string;
    email: string;
    professional_qualifications?: { titulo: string; cedula?: string }[];
  };
  cargos?: { id: number; nombre: string }[];
  usuarios?: { id: number; nombre_completo: string }[];

  onSubmit: ( form:any ) => void;
  submitlLabel?: string;
};

type DoctorFormData = {
  nombre: string;
  apellido_paterno: string;
  apellido_materno: string;
  curp: string;
  sexo: string;
  fecha_nacimiento: string;
  cargo_id: string;
  colaborador_responsable_id: string;
  email: string;
  password: string;
  password_confirmation: string;
  professional_qualifications: { titulo: string; cedula?: string }[];
};
export const MedicoForm = ({
    doctor,
    onSubmit,
    submitlLabel
}: Props) =>{ 
    const form = useForm ({
    nombre: doctor?.nombre || 'N/A',
    apellido_paterno: doctor?.apellido_paterno || 'N/A',
    apellido_materno: doctor?.apellido_materno || 'N/A',
    curp: doctor?.curp || 'N/A',
    sexo: doctor?.sexo || 'N/A',
    fecha_nacimiento: doctor?.fecha_nacimiento || 'N/A',
    cargo_id: doctor?.cargo_id || 'N/A',
    colaborador_responsable_id: doctor?.colaborador_responsable_id || 'N/A',
    email: doctor?.email || 'N/A',
    password: '',  // Vacío por default (opcional)
    password_confirmation: '',
    x: doctor?.professional_qualifications || 'N/A',
    professional_qualifications: doctor?.professional_qualifications || 'N/A',
});

  // Inicializa useForm con datos del doctor (password vacío)
  const { data, setData, processing, errors, setError, clearErrors } = form;

const optionsSexo = [
  { value: '', label: 'Seleccionar' },
  { value: 'Masculino', label: 'Masculino' },
  { value: 'Femenino', label: 'Femenino' },
];

const EditDoctor: React.FC<Props> = ({ doctor, cargos = [], usuarios = [] }) => {
  // DEBUG: Ver props en consola
  useEffect(() => {
    console.log('Props en EditDoctor:', { doctor, numCargos: cargos.length, numUsuarios: usuarios.length });
  }, [doctor, cargos, usuarios]);

  // Estado local para cargos (actualizable) - Simplificado, ya que el modal no se activa en el código actual
  const [localCargos, setLocalCargos] = useState(cargos);

  // Estados para professional_qualifications (precarga si existe) - Solo título y cédula
  const [qualifications, setQualifications] = useState<{ titulo: string; cedula: string }[]>(
    doctor.professional_qualifications?.map(q => ({
      titulo: q.titulo,
      cedula: q.cedula || '',
    })) || []
  );
  const [newTitulo, setNewTitulo] = useState('');
  const [newCedula, setNewCedula] = useState('');
  const [editingIndex, setEditingIndex] = useState<number | null>(null);

  // Opciones para selects
  const optionsCargos = localCargos.map(cargo => ({ value: cargo.id.toString(), label: cargo.nombre }));
  const optionsUsuarios = usuarios.map(usuario => ({ value: usuario.id.toString(), label: usuario.nombre_completo }));

  // Funciones para qualifications (solo maneja título y cédula, se envía como array a professional_qualifications)
  const handleAddOrUpdateQualification = () => {
    if (!newTitulo.trim()) {
      alert('El título es requerido para agregar/editar una calificación.');
      return;
    }

    const newQual = {
      titulo: newTitulo.trim(),
      cedula: newCedula.trim(),
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
    setData('professional_qualifications', updatedQualifications);

    setNewTitulo('');
    setNewCedula('');
  };

  const handleEditQualification = (index: number) => {
    const qual = qualifications[index];
    setNewTitulo(qual.titulo);
    setNewCedula(qual.cedula || '');
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

  // Actualiza qualifications en data cuando cambie el estado local
  useEffect(() => {
    setData('professional_qualifications', qualifications);
  }, [qualifications, setData]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!data.cargo_id) {
      alert('Debe seleccionar un cargo principal.');
      return;
    }
    if (qualifications.length === 0) {
      alert('Debe agregar al menos un título profesional.');
      return;
    }

    // Validación condicional para password (solo si se ingresa)
    if (data.password && data.password !== data.password_confirmation) {
      setError('password_confirmation', 'Las contraseñas no coinciden.');
      return;
    }
    if (data.password && data.password.length < 8) {
      setError('password', 'La contraseña debe tener al menos 8 caracteres.');
      return;
    }

    clearErrors();  // Limpia errores previos

    onSubmit(form);
  };

  return (
    <>
      <Head title={`Editar Doctor: ${data.nombre}`} />
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            
          </div>
          <h1 className="flex-1 text-center text-3xl font-bold text-black">
            Editar Doctor
          </h1>
          <div className="flex items-center space-x-2">
            <Link
              href={route('doctores.show', doctor.id)}
              className="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition"
              style={{ backgroundColor: '#1B1C38' }}
            >
              Ver Ficha
            </Link>
          </div>
        </div>

        <form onSubmit={handleSubmit} className="space-y-6 bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
          {/* Sección 1: Datos Personales */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InputText
              id="nombre"
              name="nombre"
              label="Nombre *"
              value={data.nombre}
              onChange={(e) => setData('nombre', e.target.value)}
              placeholder="Ej: Juan"
              required
              error={errors.nombre}
            />

          

            <InputText
              id="apellido_materno"
              name="apellido_materno"
              label="Apellido Materno (Opcional)"
              value={data.apellido_materno}
              onChange={(e) => setData('apellido_materno', e.target.value)}
              placeholder="Ej: García"
              error={errors.apellido_materno}
            />

            <InputText
              id="curp"
              name="curp"
              label="CURP (Opcional)"
              value={data.curp}
              onChange={(e) => setData('curp', e.target.value.toUpperCase())}
              placeholder="Ej: PEJG800101HDFR0001"
              maxLength={18}
              error={errors.curp}
            />

            <SelectInput
              label="Sexo (Opcional)"
              options={optionsSexo}
              value={data.sexo}
              onChange={(value) => setData('sexo', value)}
              error={errors.sexo}
              placeholder="Seleccionar"
            />

            <InputDate
              description="Fecha de Nacimiento *"
              id="fecha_nacimiento"
              name="fecha_nacimiento"
              value={data.fecha_nacimiento ? new Date(data.fecha_nacimiento) : null}
              onChange={(date) => setData('fecha_nacimiento', date ? date.toISOString().split('T')[0] : '')}
              error={errors.fecha_nacimiento}
              max={new Date().toISOString().split('T')[0]}
              required
            />
          </div>

          {/* Sección 2: Cargo y Responsable */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <SelectInput
                label="Cargo Principal *"
                options={[
                  { value: '', label: 'Seleccionar Cargo' },
                  ...optionsCargos,
                ]}
                value={data.cargo_id}
                onChange={(value) => setData('cargo_id', value)}
                error={errors.cargo_id}
                placeholder="Seleccionar Cargo"
                
              />
            </div>

            <div>
              <SelectInput
                label="Colaborador Responsable (Opcional)"
                options={[
                  { value: '', label: 'Ninguno' },
                  ...optionsUsuarios,
                ]}
                value={data.colaborador_responsable_id}
                onChange={(value) => setData('colaborador_responsable_id', value)}
                error={errors.colaborador_responsable_id}
                placeholder="Ninguno"
              />
            </div>
          </div>

          {/* Sección: Títulos y Cédulas Profesionales (solo título y cédula, se envía a professional_qualifications) */}
          <div className="space-y-4">
            <label className="block text-sm font-medium text-gray-700">Títulos y Cédulas Profesionales *</label>
            
            {/* Inputs para agregar/editar */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg">
              <InputText
                id="newTitulo"
                name="newTitulo"
                label="Título *"
                value={newTitulo}
                onChange={(e) => setNewTitulo(e.target.value)}
                placeholder="Ej: Licenciatura en Medicina"
                maxLength={100}
                error={null} // Errores manejados manualmente
              />
              <InputText
                id="newCedula"
                name="newCedula"
                label="Cédula (Opcional)"
                value={newCedula}
                onChange={(e) => setNewCedula(e.target.value.toUpperCase())}
                placeholder="Ej: 1234567"
                maxLength={20}
                error={null}
              />
            </div>

            {/* Botones para agregar/editar */}
            <div className="flex flex-wrap gap-2">
              <PrimaryButton
                type="button"
                onClick={handleAddOrUpdateQualification}
                disabled={!newTitulo.trim()}
                style={{ backgroundColor: '#1B1C38' }}
              >
                {editingIndex !== null ? 'Actualizar Título' : '+ Agregar Título'}
              </PrimaryButton>
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

            {/* Tabla de qualifications */}
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

          {/* Sección 3: Contacto y Seguridad */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <InputText
              id="email"
              name="email"
              label="Email *"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
              placeholder="Ej: doctor@clinic.com"
              type="email"
              required
              error={errors.email}
            />

            <div className="md:col-span-2 space-y-2">
              <label className="block text-sm font-medium text-gray-700">Nueva Contraseña (Opcional - Dejar vacío para no cambiar)</label>
              <InputText
                id="password"
                name="password"
                label="Contraseña"
                value={data.password}
                onChange={(e) => setData('password', e.target.value)}
                placeholder="Mínimo 8 caracteres"
                type="password"
                error={errors.password}
              />
              <InputText
                id="password_confirmation"
                name="password_confirmation"
                label="Confirmar Contraseña"
                value={data.password_confirmation}
                onChange={(e) => setData('password_confirmation', e.target.value)}
                placeholder="Repite la contraseña"
                type="password"
                error={errors.password_confirmation}
              />
            </div>
          </div>

          {/* Botón Submit */}
          <div className="flex justify-end space-x-4 pt-4">
            <PrimaryButton
              type="submit"
              disabled={processing}
              style={{ backgroundColor: '#1B1C38' }}
            >
              {processing ? 'Actualizando...' : 'Actualizar Doctor'}
            </PrimaryButton>
          </div>
        </form>
      </div>
    </>
  );
};

};

