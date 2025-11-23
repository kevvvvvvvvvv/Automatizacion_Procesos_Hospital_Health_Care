import React, { useEffect, useState } from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, ProductoServicio, HojaMedicamento } from '@/types';
import { route } from 'ziggy-js';

// Componentes UI
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import PrimaryButton from '@/components/ui/primary-button';
import Swal from 'sweetalert2';                     


const opcionesViaMedicamento = [
    // --- Vías Comunes ---
    { value: 'Vía Oral', label: 'Oral' },
    { value: 'Intravenosa', label: 'Intravenosa' },
    { value: 'Intramuscular', label: 'Intramuscular' },
    { value: 'Subcutánea', label: 'Subcutánea' },
    { value: 'Sublingual', label: 'Sublingual' },
    { value: 'Rectal', label: 'Rectal' },

    // --- Vías Tópicas/Otras ---
    { value: 'Tópico', label: 'Tópico' },
    { value: 'Oftálmico', label: 'Oftálmico' },
    { value: 'Otológico', label: 'Otológico' },
    { value: 'Nasal', label: 'Nasal' },
    { value: 'Vaginal', label: 'Vaginal' },

    // --- Vías Respiratorias ---
    { value: 'Nebulizado', label: 'Nebulizado' },
];

interface MedicamentoAgregado {
    id: string;
    nombre: string;
    dosis: string;
    gramaje: string;
    unidad: string;
    via_id: string;
    via_label: string;
    duracion: string;
    inicio: string;
    temp_id: string; 
}

interface Props {
    hoja: HojaEnfermeria;
    medicamentos: ProductoServicio[]; 
}

const optionsGramaje = [
    {value: 'mililitros', label: 'Mililitros(ml)'},
    {value: 'gramos', label: 'Gramos (g)'},
    {value: 'miligramos', label: 'Miligramos (mg)'},
    {value: 'microgramos', label: 'Microgramos (mcg)'},
    {value: 'unidades internacionales', label: 'Unidades internacionales (ui)'},
    {value: 'gotas', label: 'Gotas'},
];

const optionsUnidad = [
    { value: 'horas', label: 'Horas' },
    { value: 'minutos', label: 'Minutos'},
    { value: 'dosis unica', label: 'Dosis unica'}
]

const formatDateTime = (isoString: string | null) => {
    if (!isoString) return 'Pendiente';
    return new Date(isoString).toLocaleString('es-MX', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
};

const MedicamentosForm: React.FC<Props> = ({ hoja, medicamentos }) => {

    const medicamentosOptions = medicamentos.map(m => ({
        value: m.id.toString(),
        label: m.nombre_prestacion
    }));

    const [localData, setLocalData] = useState({
        medicamento_id: '',
        medicamento_nombre: '',
        dosis: '',
        gramaje: '',
        unidad: '',
        via: '',
        via_label: '',
        duracion_tratamiento: '',
        fecha_hora_inicio: '',
    });

    useEffect(()=>{
        if(localData.unidad === 'dosis unica'){
            setLocalData(prevState=>({
                ...prevState,
                duracion_tratamiento:'0'
            }))
        }
    },[localData.unidad, setLocalData]);

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        medicamentos_agregados: [] as MedicamentoAgregado[],
    });

    const handleDateUpdate = (medicamentoId: number, newDate: string) => {
        router.patch(route('hojasmedicamentos.update', { 
            hojasenfermeria: hoja.id, 
            hojasmedicamento: medicamentoId 
        }), {
            fecha_hora_inicio: newDate 
        }, {
            preserveScroll: true,
            onError: (errors) => {
                alert('Error al actualizar: \n' + JSON.stringify(errors));
            }
        });
    };

    const handleAddToList = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault(); 
        if (!localData.medicamento_id || !localData.dosis || !localData.unidad || !localData.gramaje || !localData.unidad || !localData.via || !localData.duracion_tratamiento) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Debes seleccionar un medicamento, dosis, unidad, gramaje, vía y duración del tratamiento.',
                timer: 4000
            });
            return;
        }

        const newMed: MedicamentoAgregado = {
            id: localData.medicamento_id,
            nombre: localData.medicamento_nombre,
            dosis: localData.dosis,
            gramaje: localData.gramaje,
            unidad: localData.unidad,
            via_id: localData.via,
            via_label: localData.via_label,
            duracion: localData.duracion_tratamiento,
            inicio: localData.fecha_hora_inicio,
            temp_id: crypto.randomUUID(),
        };

        setData('medicamentos_agregados', [...data.medicamentos_agregados, newMed]);

        setLocalData({
            medicamento_id: '',
            medicamento_nombre: '',
            dosis: '',
            gramaje: '',
            unidad: '',
            via: '',
            via_label: '',
            duracion_tratamiento: '',
            fecha_hora_inicio: '',
        });
    }

    const handleRemoveFromList = (temp_id: string) => {
        setData('medicamentos_agregados',
            data.medicamentos_agregados.filter((med) => med.temp_id !== temp_id)
        );
    }

    const handleSubmitList = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasmedicamentos.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => reset(), 
        });
    }

    const handleStoreAplicacion = (medicamentoId: number) => {

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esto registrará una nueva aplicación del medicamento.",
            icon: 'question', 
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33', 
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            
            if (result.isConfirmed) {
                
                router.post(route('aplicaciones.store', { hoja_medicamento: medicamentoId }), {}, {
                    preserveScroll: true,
                    onError: (errors) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar',
                            text: JSON.stringify(errors)
                        });
                    },
                });
            }
        });
    };

    return (
        <div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <SelectInput
                    label="Medicamento (nombre)"
                    options={medicamentosOptions} 
                    value={localData.medicamento_id}
                    onChange={(value) => {
                        const sel = medicamentosOptions.find(o => o.value === value);
                        setLocalData(d => ({
                            ...d,
                            medicamento_id: value as string,
                            medicamento_nombre: sel ? sel.label : ''
                        }));
                    }}
                    error={errors['medicamentos_agregados.0.id']}
                />
                <InputText 
                    id="medicamento_dosis"
                    name="dosis"
                    label="Dosis" 
                    type="number"
                    value={localData.dosis} 
                    onChange={e => setLocalData(d => ({...d, dosis: e.target.value}))} 
                    error={errors['medicamentos_agregados.0.dosis']}
                />

                <SelectInput
                    label="Gramaje"
                    options={optionsGramaje}
                    value={localData.gramaje}
                    onChange={(value) => {
                        setLocalData(d => ({
                            ...d, gramaje: value as string
                        }))
                    }}
                    error={errors['medicamentos_agregados.0.gramaje']}
                />

                <SelectInput
                    label="Vía de administración"
                    options={opcionesViaMedicamento}
                    value={localData.via}
                    onChange={(value) => {
                        const sel = opcionesViaMedicamento.find(o => o.value === value);
                        setLocalData(d => ({
                            ...d,
                            via: value as string,
                            via_label: sel ? sel.label : ''
                        }));
                    }}
                    error={errors['medicamentos_agregados.0.via_id']}
                />

                {localData.unidad !== 'dosis unica' &&(
                <InputText 
                    id="duracion"
                    name="duracion"
                    label="Duración (frecuencia)" 
                    type="number"
                    value={localData.duracion_tratamiento}
                    onChange={e => setLocalData(d => ({...d, duracion_tratamiento: e.target.value}))} 
                    error={errors['medicamentos_agregados.0.duracion']}
                />
                )}
                <SelectInput
                    label="Unidad"
                    options={optionsUnidad}
                    value={localData.unidad}
                    onChange={(value) => {
                        setLocalData(d => ({
                            ...d, unidad: value as string
                        }))
                    }}
                    error={errors['medicamentos_agregados.0.unidad']}
                />

            </div>
            <div className="flex justify-end mt-4">
                <PrimaryButton type="button" onClick={handleAddToList}>
                    Agregar a la lista
                </PrimaryButton>
            </div>

            <form onSubmit={handleSubmitList} className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Medicamentos Pendientes por Guardar</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Medicamentos guardados con éxito.</div>}
                
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className='text-left'>
                                <th className="px-4 py-4 text-sm text-gray-900">Nombre del medicamento</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Dosis</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración (frecuencia)</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Via administración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.medicamentos_agregados.length === 0 ? (
                                <tr>
                                    <td colSpan={5} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        Aún no se han agregado medicamentos.
                                    </td>
                                </tr>
                            ) : (
                                data.medicamentos_agregados.map((med) => (
                                    <tr key={med.temp_id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">{med.nombre}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.dosis + ' ' + med.gramaje}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.duracion + ' ' + med.unidad}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.via_label}</td>
                                        <td className="px-4 py-4 text-sm">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveFromList(med.temp_id)}
                                                className="text-yellow-600 hover:text-yellow-900"
                                            >
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
                <div className="flex justify-end mt-4">
                    <PrimaryButton type="submit" disabled={processing || data.medicamentos_agregados.length === 0}>
                        {processing ? 'Guardando...' : 'Guardar Lista de Medicamentos'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Medicamentos Guardados</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className='text-left'>
                                <th className="px-4 py-4 text-sm text-gray-900">Nombre del medicamento</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Dosis</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración (frecuencia)</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Via administración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Fecha de aplicación</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {(hoja.hoja_medicamentos ?? []).length === 0 ? (
                                <tr>
                                    <td className="px-4 py-4 text-sm text-gray-500">No hay medicamentos</td>
                                </tr>
                            ) : (
                                (hoja.hoja_medicamentos ?? []).map((med: HojaMedicamento) => (
                                    <tr key={med.id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">
                                            {med.producto_servicio?.nombre_prestacion || '...'}
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.dosis + ' ' + med.gramaje}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.duracion_tratamiento + ' ' + med.unidad}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.via_administracion}</td>

                                        <td className="px-2 py-1 text-sm text-gray-500" style={{ minWidth: '200px' }}>
                                            {!med.fecha_hora_inicio && (
                                                <PrimaryButton
                                                    type="button"
                                                    onClick={() => {
                                                        const now_iso = new Date().toISOString();
                                                        handleDateUpdate(med.id, now_iso);
                                                    }}
                                                >
                                                    Registrar 1ra Dosis
                                                </PrimaryButton>
                                            )}

                                            {med.fecha_hora_inicio && (
                                                <div className="flex flex-col space-y-2">
                                                    

                                                    <div className="flex justify-between items-center">
                                                        <span>
                                                            1. {formatDateTime(med.fecha_hora_inicio)}
                                                        </span>
                                                    </div>

                                                    {med.aplicaciones.map((app, index) => (
                                                        <div key={app.id} className="flex justify-between items-center">
                                                            <span>
                                                                {index + 2}. {formatDateTime(app.fecha_aplicacion)}
                                                            </span>

                                                        </div>
                                                    ))}
                                                </div>
                                            )}
                                        </td>
                                        <td className="px-4 py-4 text-sm space-x-2 whitespace-nowrap">
                                            <PrimaryButton
                                                type="button"
                                                onClick={() => handleStoreAplicacion(med.id)}
                                            >
                                                + Registrar Siguiente Dosis
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};

export default MedicamentosForm;