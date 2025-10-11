import React, { useState, useEffect } from 'react'; // Agregué useEffect para el console.log
import { Head, useForm, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';
import InputText from '@/components/ui/input-text';
import InputSelect from '@/components/ui/input-select';

type Props = {
  cargos?: { id: number; nombre: string }[];
  usuarios?: { id: number; nombre_completo: string }[];
};

const CreateDoctor: React.FC<Props> = ({ cargos = [], usuarios = [] }) => {

  useEffect(() => { // Movido a useEffect para evitar warnings
    console.log('Props recibidas en CreateDoctor:', { 
      cargos: cargos || 'UNDEFINED!', 
      numCargos: cargos?.length || 0, 
      usuarios: usuarios || 'UNDEFINED!', 
      numUsuarios: usuarios?.length || 0 
    });
  }, [cargos, usuarios]);

  // Estado local para manejar la creación de nuevo cargo (mantenido)
  const [showCargoModal, setShowCargoModal] = useState(false);
  const [nuevoCargoNombre, setNuevoCargoNombre] = useState('');
  const [creatingCargo, setCreatingCargo] = useState(false);

  // Función para crear un nuevo cargo (asíncrona, mantenida)
  const handleCreateCargo = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!nuevoCargoNombre.trim()) return;

    setCreatingCargo(true);
    try {
      await router.post(route('cargos.store'), {
        nombre: nuevoCargoNombre.trim(),
      }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          const nuevoCargo = { id: Date.now(), nombre: nuevoCargoNombre.trim() };
          setLocalCargos(prev => [...prev, nuevoCargo]);
          setData('cargo_id', nuevoCargo.id.toString());
          setShowCargoModal(false);
          setNuevoCargoNombre('');
        },
        onError: (errors) => {
          console.error('Error al crear cargo:', errors);
          alert('Error al crear cargo: ' + (errors.nombre || 'Inténtalo de nuevo'));
        },
      });
    } catch (error) {
      console.error('Error en creación de cargo:', error);
      alert('Error inesperado al crear cargo');
    } finally {
      setCreatingCargo(false);
    }
  };

  // Hook para estado local de cargos (mantenido)
  const [localCargos, setLocalCargos] = useState(cargos);

  // Estados para títulos y cédulas (múltiples) - Se envía como array a professional_qualifications
  const [qualifications, setQualifications] = useState<{ titulo: string; cedula: string }[]>([]);
  const [newTitulo, setNewTitulo] = useState('');
  const [newCedula, setNewCedula] = useState('');
  const [editingIndex, setEditingIndex] = useState<number | null>(null);

  // Función para agregar o actualizar una calificación
  const handleAddOrUpdateQualification = () => {
    if (!newTitulo.trim()) {
      alert('El título es requerido para agregar/editar una calificación.');
      return;
    }

    const newQual = {
      titulo: newTitulo.trim(),
      cedula: newCedula.trim() || '', // String vacío si no hay cédula (nullable en BD)
    };

    let updatedQualifications: { titulo: string; cedula: string }[];

    if (editingIndex !== null) {
      updatedQualifications = [...qualifications];
      updatedQualifications[editingIndex] = newQual;
      setQualifications(updatedQualifications);
      setEditingIndex(null);
    } else {
      updatedQualifications = [...qualifications, newQual];
      setQualifications(updatedQualifications);
    }

    // Sincronizar con el form data de Inertia (backend lo procesa para credencial_empleados)
    setData('professional_qualifications', updatedQualifications);

    // Resetear inputs
    setNewTitulo('');
    setNewCedula('');
  };

  // Función para editar una calificación (poblar inputs)
  const handleEditQualification = (index: number) => {
    const qual = qualifications[index];
    setNewTitulo(qual.titulo);
    setNewCedula(qual.cedula);
    setEditingIndex(index);
  };

  // Función para eliminar una calificación
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

  // Función para cancelar edición
  const handleCancelEdit = () => {
    setEditingIndex(null);
    setNewTitulo('');
    setNewCedula('');
  };

  const { data, setData, post, processing, errors } = useForm({
    nombre: '',
    apellido_paterno: '',
    apellido_materno: '',
    curp: '',
    sexo: '',
    fecha_nacimiento: '',
    cargo_id: '',
    colaborador_responsable_id: '',
    email: '',
    password: '',
    password_confirmation: '',
    professional_qualifications: [],  // Array de {titulo, cedula} - Backend lo guarda en credencial_empleados
  });

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
    // El array ya está en data.professional_qualifications
    post(route('doctores.store'));
  };

  return (
    <MainLayout>
      <Head title="Crear Doctor" />
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            {/* Opcional: BackButton */}
          </div>
          <h1 className="flex-1 text-center text-3xl font-bold text-black">
            Crear Nuevo Doctor
          </h1>
        </div>

        <form onSubmit={handleSubmit} className="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
          {/* Sección 1: Datos Personales */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <InputText
              id="nombre"
              label="Nombre *"
              name="nombre"
              value={data.nombre}
              onChange={(e) => setData('nombre', e.target.value)}
              placeholder="Ej: Juan"
              required
              error={errors.nombre}
            />

            <InputText
              id="apellido_paterno"
              label="Apellido Paterno *"
              name="apellido_paterno"
              value={data.apellido_paterno}
              onChange={(e) => setData('apellido_paterno', e.target.value)}
              placeholder="Ej: Pérez"
              required
              error={errors.apellido_paterno}
            />

            <InputText
              id="apellido_materno"
              label="Apellido Materno (Opcional)"
              name="apellido_materno"
              value={data.apellido_materno}
              onChange={(e) => setData('apellido_materno', e.target.value)}
              placeholder="Ej: García"
              error={errors.apellido_materno}
            />

            <InputText
              id="curp"
              label="CURP (Opcional)"
              name="curp"
              value={data.curp}
              onChange={(e) => setData('curp', e.target.value.toUpperCase())}
              placeholder="Ej: PEJG800101HDFR0001"
              maxLength={18}
              error={errors.curp}
            />

            <div className="flex flex-col">
              <label htmlFor="sexo" className="block text-sm font-medium text-gray-700 mb-2">
                Sexo (Opcional)
              </label>
              <select
                id="sexo"
                name="sexo"
                value={data.sexo}
                onChange={(e) => setData('sexo', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Seleccionar</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
              {errors.sexo && <p className="text-red-500 text-sm mt-1">{errors.sexo}</p>}
            </div>

            <InputText
              id="fecha_nacimiento"
              label="Fecha de Nacimiento *"
              name="fecha_nacimiento"
              type="date"
              value={data.fecha_nacimiento}
              onChange={(e) => setData('fecha_nacimiento', e.target.value)}
              max={new Date().toISOString().split('T')[0]}
              required
              error={errors.fecha_nacimiento}
            />
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            {/* Select Nativo para Cargo Principal */}
            <div className="flex flex-col">
              <label htmlFor="cargo_id" className="block text-sm font-medium text-gray-700 mb-2">
                Cargo Principal *
              </label>
              <select
                id="cargo_id"
                name="cargo_id"
                value={data.cargo_id}
                onChange={(e) => setData('cargo_id', e.target.value)}
                required
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Seleccionar Cargo</option>
                <option value="">Especialista</option>
                {localCargos.map((cargo) => (
                  <option key={cargo.id} value={cargo.id.toString()}>
                    {cargo.nombre}
                  </option>
                ))}
              </select>
              {errors.cargo_id && <p className="text-red-500 text-sm mt-1">{errors.cargo_id}</p>}
            </div>
        </div>
          {/* Sección 2: Cargo Principal y Colaborador Responsable */}
           <div className="flex flex-col">
              <label htmlFor="colaborador_responsable_id" className="block text-sm font-medium text-gray-700 mb-2">
                Colaborador Responsable (Opcional)
              </label>
              <select
                id="colaborador_responsable_id"
                name="colaborador_responsable_id"
                value={data.colaborador_responsable_id}
                onChange={(e) => setData('colaborador_responsable_id', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Ninguno</option>
                {usuarios.map((usuario) => (
                  <option key={usuario.id} value={usuario.id.toString()}>
                    {usuario.nombre_completo}
                  </option>
                ))}
              </select>
              {errors.colaborador_responsable_id && <p className="text-red-500 text-sm mt-1">{errors.colaborador_responsable_id}</p>}
            </div>

          {/* Sección para Títulos y Cédulas Profesionales */}
          <div className="md:col-span-2 mb-6">
            <label className="block text-sm font-medium text-gray-700 mb-4">Títulos y Cédulas Profesionales *</label>
            
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
              <InputText
                id="new_titulo"
                label="Título *"
                name="new_titulo"
                value={newTitulo}
                onChange={(e) => setNewTitulo(e.target.value)}
                placeholder="Ej: Licenciatura en Medicina"
                maxLength={100}
                error={null}
              />
              <InputText
                id="new_cedula"
                label="Cédula (Opcional)"
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
                {editingIndex !== null ? 'Actualizar Título' : '+ Agregar Título'}
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

          {/* Sección 3: Contacto y Seguridad */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <InputText
              id="email"
              label="Email *"
              type="email"
              name="email"
              value={data.email}
              onChange={(e) => setData('email', e.target.value)}
              placeholder="Ej: doctor@clinic.com"
              required
              error={errors.email}
            />

            <InputText
              id="password"
              label="Contraseña *"
              type="password"
              name="password"
              value={data.password}
              onChange={(e) => setData('password', e.target.value)}
              minLength={8}
              required
              error={errors.password}
            />

            <div className="md:col-span-2">
              <InputText
                id="password_confirmation"
                label="Confirmar Contraseña *"
                type="password"
                name="password_confirmation"
                value={data.password_confirmation}
                onChange={(e) => setData('password_confirmation', e.target.value)}
                required
                error={errors.password_confirmation}
              />
            </div>
          </div>

          <div className="flex justify-end space-x-4 pt-4">
            <button
              type="submit"
              disabled={processing}
              className="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
              style={{ backgroundColor: '#1B1C38' }}
            >
              {processing ? 'Creando...' : 'Crear Doctor'}
            </button>
          </div>
        </form>
      </div>
    </MainLayout>
  );
};

export default CreateDoctor;
