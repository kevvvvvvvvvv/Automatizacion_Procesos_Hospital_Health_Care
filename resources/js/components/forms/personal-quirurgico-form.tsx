import React from 'react';
import { useForm, router } from '@inertiajs/react';
import Swal from 'sweetalert2';
import { PersonalEmpleado, User } from '@/types';

import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';



interface Props {
    notaId: number; 
    personalEmpleados: PersonalEmpleado[]; 
    users: User[];
}

const PersonalQuirurgicoManager: React.FC<Props> = ({
    notaId,
    personalEmpleados,
    users,
}) => {
    // 1. FORMULARIO PARA CREAR (POST)
    const { data, setData, post, processing, errors, reset } = useForm({
        nota_id: notaId,
        ayudante_id: '',
        cargo: ''
    });

    const optionsCargo = [
        { value: 'ayudante', label: 'Ayudante' },
        { value: 'instrumentista', label: 'Instrumentista' },
        { value: 'anestesiologo', label: 'Anestesiólogo' },
        { value: 'circulante', label: 'Cirtulante' },
    ];
    

    const optionsUser = users.map((u) => ({
        label: `${u.nombre} ${u.apellido_paterno} ${u.apellido_materno}`, 
        value: u.id.toString() 
    }));

    const handleAgregar = (e: React.FormEvent) => {
        e.preventDefault();

        if (!data.ayudante_id || !data.cargo) {
            Swal.fire('Error', 'Selecciona personal y cargo', 'error');
            return;
        }

        post(route('notas.ayudantes.store'), {
            preserveScroll: true,
            onSuccess: () => {
                reset('ayudante_id', 'cargo'); 
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

    const handleQuitar = (idRegistro: number) => {
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
            
            <form onSubmit={handleAgregar} className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <SelectInput
                    label="Personal encargado"
                    options={optionsUser}
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
                        {personalEmpleados.length === 0 ? (
                            <tr>
                                <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                    No hay personal registrado aún.
                                </td>
                            </tr>
                        ) : (
                            personalEmpleados.map((item) => (
                                <tr key={item.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">
                                        {item.user 
                                            ? `${item.user.nombre} ${item.user.apellido_paterno}`
                                            : optionsUser.find(o => o.value == item.user_id.toString())?.label
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