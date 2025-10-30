import React, { useState } from 'react';
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, ProductoServicio, HojaMedicamento } from '@/types';
import { route } from 'ziggy-js';

// Componentes UI
import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import PrimaryButton from '@/components/ui/primary-button';

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
        via: '',
        via_label: '',
        duracion_tratamiento: '',
        fecha_hora_inicio: '',
    });

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        medicamentos_agregados: [] as MedicamentoAgregado[],
    });

    const handleDateUpdate = (medicamentoId: number, newDate: string) => {
        if (!newDate) {
            console.warn("La fecha está vacía, no se guardará.");
            return;
        }

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
        if (!localData.medicamento_id || !localData.dosis) {
            alert("Debes seleccionar un medicamento y una dosis.");
            return;
        }

        const newMed: MedicamentoAgregado = {
            id: localData.medicamento_id,
            nombre: localData.medicamento_nombre,
            dosis: localData.dosis,
            gramaje: localData.gramaje,
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

    const handleRemoveSavedMedicamento = (medicamentoId: number) => {
        if (confirm('¿Seguro que deseas eliminar este medicamento?')) {
            router.delete(route('hojasenfermerias.medicamentos.destroy', { 
                hojaenfermeria: hoja.id,
                medicamento: medicamentoId
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <SelectInput
                    label="Medicamento"
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

                <InputText 
                    id="medicamento_duracion_tratamiento"
                    name="duracion"
                    label="Duración (frecuencia en horas)" 
                    type="number"
                    value={localData.duracion_tratamiento}
                    onChange={e => setLocalData(d => ({...d, duracion_tratamiento: e.target.value}))} 
                    error={errors['medicamentos_agregados.0.duracion']}
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
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.dosis}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.gramaje}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.via_label}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.inicio}</td>
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
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.dosis}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{med.via_administracion}</td>

                                        <td className="px-2 py-1 text-sm text-gray-500" style={{ minWidth: '200px' }}>

                                            {med.fecha_hora_inicio ? (
                                                <span>{formatDateTime(med.fecha_hora_inicio)}</span>
                                            ) : (
                                                <PrimaryButton
                                                    type="button"
                                                    onClick={() => {
                                                        const now_iso = new Date().toISOString();
                                                        handleDateUpdate(med.id, now_iso);
                                                    }}
                                                >
                                                    Registrar Inicio
                                                </PrimaryButton>
                                            )}
                                        </td>


                                        <td className="px-4 py-4 text-sm space-x-2 whitespace-nowrap">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveSavedMedicamento(med.id)}
                                                className="text-red-600 hover:text-red-900"
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
        </div>
    );
};

export default MedicamentosForm;