import React, { useState } from 'react';
import { Head, useForm, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

import BackButton from '@/components/ui/back-button';

type Props = {
  cargos?: { id: number; nombre: string }[];  // Opcional con ?
  usuarios?: { id: number; nombre_completo: string }[];  // Opcional
};

const CreateDoctor: React.FC<Props> = ({ cargos = [], usuarios = [] }) => {  // ✅ DEFAULT: Array vacío si undefined
  // ✅ DEBUG: Ver props en consola (quita después de probar)
  React.useEffect(() => {
    console.log('Props recibidas en CreateDoctor:', { 
      cargos: cargos || 'UNDEFINED!', 
      numCargos: cargos?.length || 0, 
      usuarios: usuarios || 'UNDEFINED!', 
      numUsuarios: usuarios?.length || 0 
    });
  }, [cargos, usuarios]);

  // Estado local para manejar la creación de nuevo cargo
  const [showCargoModal, setShowCargoModal] = useState(false);
  const [nuevoCargoNombre, setNuevoCargoNombre] = useState('');
  const [creatingCargo, setCreatingCargo] = useState(false);

  // Función para crear un nuevo cargo (asíncrona)
  const handleCreateCargo = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!nuevoCargoNombre.trim()) return;

    setCreatingCargo(true);
    try {
      // Enviar POST a la ruta de store de cargos (asumiendo que existe en backend)
      const response = await router.post(route('cargos.store'), {
        nombre: nuevoCargoNombre.trim(),
        // Agrega otros campos si es necesario, e.g., descripcion: ''
      }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          // Actualizar la lista local de cargos con el nuevo (asumiendo que el backend retorna el nuevo cargo)
          // Nota: En Inertia, para actualizar props, idealmente recarga la página o usa un evento global.
          // Por simplicidad, aquí simulamos agregando (en producción, usa Inertia's visit o eventos).
          const nuevoCargo = { id: Date.now(), nombre: nuevoCargoNombre.trim() }; // ID temporal; backend proveerá real
          setCargos(prev => [...prev, nuevoCargo]); // Actualiza estado local (ver hook useState abajo)
          
          // Selecciona el nuevo cargo automáticamente
          setData('cargo_id', nuevoCargo.id.toString());
          
          // Cerrar modal y reset
          setShowCargoModal(false);
          setNuevoCargoNombre('');
          
          // Opcional: Recarga la página para props actualizadas: router.reload({ only: ['cargos'] });
        },
        onError: (errors) => {
          console.error('Error al crear cargo:', errors);
          // Maneja errores, e.g., muestra toast o alerta
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

  // Hook para estado local de cargos (para actualizar dinámicamente)
  const [localCargos, setCargos] = useState(cargos); // Renombrado para claridad

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
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    post(route('doctores.store'));
  };

  return (
    <>
      <Head title="Crear Doctor" />
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            {/* Opcional: Agrega BackButton aquí si lo necesitas */}
            {/* <BackButton /> */}
          </div>
          <h1 className="flex-1 text-center text-3xl font-bold text-black">
            Crear Nuevo Doctor
          </h1>
        </div>

        <form onSubmit={handleSubmit} className="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto">
          {/* Sección 1: Datos Personales */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
              <input
                type="text"
                value={data.nombre}
                onChange={(e) => setData('nombre', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Ej: Juan"
                required
              />
              {errors.nombre && <p className="text-red-500 text-sm mt-1">{errors.nombre}</p>}
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Apellido Paterno *</label>
              <input
                type="text"
                value={data.apellido_paterno}
                onChange={(e) => setData('apellido_paterno', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Ej: Pérez"
                required
              />
              {errors.apellido_paterno && <p className="text-red-500 text-sm mt-1">{errors.apellido_paterno}</p>}
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Apellido Materno (Opcional)</label>
              <input
                type="text"
                value={data.apellido_materno}
                onChange={(e) => setData('apellido_materno', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Ej: García"
              />
              {errors.apellido_materno && <p className="text-red-500 text-sm mt-1">{errors.apellido_materno}</p>}
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">CURP (Opcional)</label>
              <input
                type="text"
                value={data.curp}
                onChange={(e) => setData('curp', e.target.value.toUpperCase())}
                maxLength={18}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase"
                placeholder="Ej: PEJG800101HDFR0001"
              />
              {errors.curp && <p className="text-red-500 text-sm mt-1">{errors.curp}</p>}
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Sexo (Opcional)</label>
              <select
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

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
              <input
                type="date"
                value={data.fecha_nacimiento}
                onChange={(e) => setData('fecha_nacimiento', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                max={new Date().toISOString().split('T')[0]}  // No permite futuro
                required
              />
              {errors.fecha_nacimiento && <p className="text-red-500 text-sm mt-1">{errors.fecha_nacimiento}</p>}
            </div>
          </div>

          {/* Sección 2: Cargo y Responsable – CON FUNCIONALIDAD PARA AGREGAR CARGO */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div className="relative">
              <label className="block text-sm font-medium text-gray-700 mb-2">Cargo *</label>
              <select
                value={data.cargo_id}
                onChange={(e) => setData('cargo_id', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required
              >
                <option value="">Seleccionar Cargo</option>
                {localCargos?.length > 0 ? (  // ✅ Usa localCargos para lista actualizada
                  localCargos.map((cargo) => (
                    <option key={cargo.id} value={cargo.id}>
                      {cargo.nombre}
                    </option>
                  ))
                ) : (
                  <option disabled>No hay cargos disponibles</option>  // ✅ FALLBACK si vacío o undefined
                )}
              </select>
              {errors.cargo_id && <p className="text-red-500 text-sm mt-1">{errors.cargo_id}</p>}

              {/* Botón para agregar nuevo cargo */}
              <button
                type="button"
                onClick={() => setShowCargoModal(true)}
                className="mt-2 px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition"
                disabled={creatingCargo}
              >
                + Agregar Nuevo Cargo
              </button>
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Colaborador Responsable (Opcional)</label>
              <select
                value={data.colaborador_responsable_id}
                onChange={(e) => setData('colaborador_responsable_id', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              >
                <option value="">Ninguno</option>
                {usuarios?.length > 0 ? (  // ✅ FIX: Verifica antes de map
                  usuarios.map((usuario) => (
                    <option key={usuario.id} value={usuario.id}>
                      {usuario.nombre_completo}
                    </option>
                  ))
                ) : (
                  <option disabled>No hay usuarios disponibles</option>  // ✅ FALLBACK
                )}
              </select>
              {errors.colaborador_responsable_id && <p className="text-red-500 text-sm mt-1">{errors.colaborador_responsable_id}</p>}
            </div>
          </div>

          {/* Sección 3: Contacto y Seguridad */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Email *</label>
              <input
                type="email"
                value={data.email}
                onChange={(e) => setData('email', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Ej: doctor@clinic.com"
                required
              />
              {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Contraseña *</label>
              <input
                type="password"
                value={data.password}
                onChange={(e) => setData('password', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                minLength={8}
                required
              />
              {errors.password && <p className="text-red-500 text-sm mt-1">{errors.password}</p>}
            </div>

            <div className="md:col-span-2">
              <label className="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña *</label>
              <input
                type="password"
                value={data.password_confirmation}
                onChange={(e) => setData('password_confirmation', e.target.value)}
                className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                required
              />
              {errors.password_confirmation && <p className="text-red-500 text-sm mt-1">{errors.password_confirmation}</p>}
            </div>
          </div>

          {/* Botón Submit */}
          <div className="flex justify-end space-x-4 pt-4">
            <button
              type="submit"
              disabled={processing}
              className="px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
            >
              {processing ? 'Creando...' : 'Crear Doctor'}
            </button>
          </div>
        </form>
      </div>

      {/* Modal para Crear Nuevo Cargo */}
      {showCargoModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div className="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <h2 className="text-xl font-bold mb-4">Agregar Nuevo Cargo</h2>
            <form onSubmit={handleCreateCargo}>
              <div className="mb-4">
                <label className="block text-sm font-medium text-gray-700 mb-2">Nombre del Cargo *</label>
                <input
                  type="text"
                  value={nuevoCargoNombre}
                  onChange={(e) => setNuevoCargoNombre(e.target.value)}
                  className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Ej: Especialista en Cardiología"
                  required
                  maxLength={100}
                />
                {/* Errores del backend se manejan en onError */}
              </div>
              <div className="flex justify-end space-x-3">
                <button
                  type="button"
                  onClick={() => {
                    setShowCargoModal(false);
                    setNuevoCargoNombre('');
                  }}
                  className="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50"
                  disabled={creatingCargo}
                >
                  Cancelar
                </button>
                <button
                  type="submit"
                  disabled={creatingCargo || !nuevoCargoNombre.trim()}
                  className="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
                >
                  {creatingCargo ? 'Creando...' : 'Crear Cargo'}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
};

CreateDoctor.layout = (page: React.ReactElement) => (
  <MainLayout pageTitle="Ficha del Doctor" children={page} />
);

export default CreateDoctor;  // ✅ Exporta como CreateDoctor
