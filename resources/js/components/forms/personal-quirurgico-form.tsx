import React from 'react';
import { useForm, router } from '@inertiajs/react';
import Swal from 'sweetalert2';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';


interface AyudanteDB {
    id: number; // ID de la tabla pivote o relación
    ayudante_id: number;
    cargo: string;
    // Asumo que traes la relación del usuario para mostrar el nombre
    usuario?: { 
        nombre: string; 
        apellido_paterno: string; 
        apellido_materno: string; 
    };
}

interface Props {
    notaId: number; // ID de la nota a la que se vincularán
    ayudantesRegistrados: AyudanteDB[]; // Lista que viene de la BD
    optionsAyudantes: { value: string; label: string }[];
    optionsCargo: { value: string; label: string }[];
}

const PersonalQuirurgicoManager: React.FC<Props> = ({
    notaId,
    ayudantesRegistrados,
    optionsAyudantes,
    optionsCargo
}) => {
    
    // 1. FORMULARIO PARA CREAR (POST)
    const { data, setData, post, processing, errors, reset } = useForm({
        nota_id: notaId,
        ayudante_id: '',
        cargo: ''
    });

    const handleAgregar = (e: React.FormEvent) => {
        e.preventDefault();

        if (!data.ayudante_id || !data.cargo) {
            Swal.fire('Error', 'Selecciona personal y cargo', 'error');
            return;
        }

        // Enviar petición al servidor
        // Ajusta la ruta a la que tengas en tu web.php
        post(route('notas.ayudantes.store'), {
            preserveScroll: true,
            onSuccess: () => {
                reset('ayudante_id', 'cargo'); // Limpia solo los campos, deja el nota_id
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Personal agregado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    };

    // 2. FUNCIÓN PARA ELIMINAR (DELETE)
    const handleQuitar = (idRegistro: number) => {
        // Usamos router manual para borrar sin necesidad de otro useForm
        router.delete(route('notas.ayudantes.destroy', idRegistro), {
            preserveScroll: true,
            onBefore: () => confirm('¿Estás seguro de quitar a este personal?'),
            onSuccess: () => {
                 Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'warning',
                    title: 'Personal eliminado',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    };

    return (
        <div className="mt-6 pt-6 border-t mb-15">
            <h3 className="text-md font-semibold mb-3">Registro de equipo quirúrgico (Guardado inmediato)</h3>
            
            {/* Formulario de Ingreso */}
            <form onSubmit={handleAgregar} className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <SelectInput
                    label="Personal encargado"
                    options={optionsAyudantes}
                    value={data.ayudante_id}
                    onChange={(val) => setData('ayudante_id', val as string)}
                    error={errors.ayudante_id}
                />
                <SelectInput
                    label='Cargo'
                    options={optionsCargo}
                    value={data.cargo}
                    onChange={(val) => setData('cargo', val as string)}
                    error={errors.cargo}
                />
                <div className="mb-1">
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : 'Agregar'}
                    </PrimaryButton>
                </div>
            </form>

            {/* Tabla de Resultados (Viene de BD) */}
            <h5 className="text-sm font-semibold mt-6 mb-2">Personal registrado en base de datos</h5>
            <div className="overflow-x-auto border rounded-lg mt-2">
                <table className="min-w-full">
                    <thead className="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                        <tr>
                            <th className="px-4 py-2">Personal</th>
                            <th className="px-4 py-2">Cargo</th>
                            <th className="px-4 py-2">Acción</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {ayudantesRegistrados.length === 0 ? (
                            <tr>
                                <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                    No hay personal registrado aún.
                                </td>
                            </tr>
                        ) : (
                            ayudantesRegistrados.map((item) => (
                                <tr key={item.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">
                                        {/* Intentamos mostrar nombre de la relación user, o buscamos en las opciones como fallback */}
                                        {item.usuario 
                                            ? `${item.usuario.nombre} ${item.usuario.apellido_paterno}`
                                            : optionsAyudantes.find(o => o.value == item.ayudante_id.toString())?.label
                                        }
                                    </td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{item.cargo}</td>
                                    <td className="px-4 py-4 text-sm">
                                        <button
                                            type="button"
                                            onClick={() => handleQuitar(item.id)}
                                            className="text-red-600 hover:text-red-900 font-medium"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default PersonalQuirurgicoManager;