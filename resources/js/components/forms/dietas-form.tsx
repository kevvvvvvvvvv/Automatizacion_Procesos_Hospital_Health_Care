import React, { useMemo } from 'react';
import { useForm } from '@inertiajs/react';
import { CategoriaDieta, HojaEnfermeria, SolicitudDieta } from '@/types'; 
import { route } from 'ziggy-js';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';

import InputText from '../ui/input-text';
import Checkbox from '../ui/input-checkbox';

const restricciones = [
    { id: 'DIABETICO', label: 'Paciente diabético' },
    { id: 'CELIACO', label: 'Paciente celiaco (sin gluten)' },
    { id: 'ONCOLÓGICO', label: 'Paciente oncológico' },
    { id: 'HIPERTENSO', label: 'Paciente hipertenso (bajo en sodio)' },
    { id: 'COLECISTO', label: 'Sin colecitoqueneticos' },
];


interface Props {
    hoja: HojaEnfermeria;
    categoria_dietas: CategoriaDieta[];
}

const DietaForm: React.FC<Props> = ({ hoja, categoria_dietas = [] }) => {
    
    const categoriaOptions = categoria_dietas.map((c) => ({
        value: c.id,
        label: c.categoria
    }));

    const { data, setData, post, processing, errors, reset } = useForm({
        tipo_dieta: '',
        opcion_seleccionada: '',
        horario_solicitud: new Date().toISOString().slice(0, 16),
        user_supervisa_id: '',
        horario_entrega: '',
        user_entrega_id: '',
        observaciones: '',

        horario_operacion: '',
        horario_termino: '',
        horario_inicio_dieta: '',
        restricciones: [] as string[],
    });

    const dietasDisponibles = useMemo(() => {
        if (!data.tipo_dieta) return [];

        const categoriaEncontrada = categoria_dietas.find(
            (c) => c.id === Number(data.tipo_dieta)
        );

        if (categoriaEncontrada && categoriaEncontrada.dietas) {
            return categoriaEncontrada.dietas.map((d) => ({
                value: d.id,
                label: `${d.alimento}`
            }));
        }

        return [];
    }, [data.tipo_dieta, categoria_dietas]);

    const handleTipoDietaChange = (value: string) => {
        setData(currentData => ({
            ...currentData,
            tipo_dieta: value,
            opcion_seleccionada: '', 
        }));
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasenfermerias.dietas.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }

    const handleRestrictionChange = (restriccionId: string, isChecked: boolean) => {
        if (isChecked) {
            setData(currentData => ({
                ...currentData,
                restricciones: [...currentData.restricciones, restriccionId]
            }));
        } else {
            setData(currentData => ({
                ...currentData,
                restricciones: currentData.restricciones.filter(r => r !== restriccionId)
            }));
        }
        setData('opcion_seleccionada', '');
    }

    return (
        <div className="space-y-6">

            <div className="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <h3 className="text-lg font-semibold mb-2 text-gray-800">Indicaciones para elaboración de dietas</h3>
                <details className="p-2 border rounded-md">
                    <summary className="font-medium cursor-pointer text-sm">Sin colecitoqueneticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: calabacitas, brócoli, coles, coliflor, yema de huevo, leche, crema, quesos (manchego, americano), mantequilla, pan dulce, galletas, pasteles, leguminosas (frijoles, lentejas, etc.), embutidos (chorizo, tocino), fritos o capeados.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes celiacos (sin gluten)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: trigo, sémolas, espelta, harinas, avena, cebada, malta, centeno, triticale, pasta, pan, galletas, almidones modificados o levadura.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes diabéticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: gelatinas (excepto light), jugos (envasados o naturales), frutas con alto índice glucémico (plátano, papaya, melón, sandía), arroz, pasta, pan blanco, galletas, margarinas, manteca, embutidos.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes hipertensos (sin sal)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: embutidos (jamón, salchicha), enlatados, carnes ahumadas, lácteos, margarinas, mantequillas, fritos o capeados. Omitir sal en la preparación.</p>
                </details>
            </div>

            <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg shadow-md space-y-4">
                {/*<h3 className="text-lg font-semibold mb-4">Datos operatorios</h3>
                <InputDateTime
                    id='horario_operacion'
                    name='horario_operacion'
                    label='Horario de operación'
                    value={data.horario_operacion}
                    onChange={e=> setData('horario_operacion', e as string)}/>

                <InputDateTime
                    id='horario_termino'
                    name='horario_termino'
                    label='Horario de termino de operación'
                    value={data.horario_termino}
                    onChange={e=> setData('horario_termino', e as string)}/>*/}

                <h3 className="text-lg font-semibold mb-4">Definir la dieta (pedido)</h3>

            <div className="bg-white p-6 rounded-lg shadow-md space-y-4">
                <h3 className="text-lg font-semibold">1. Indicar restricciones del paciente</h3>
                <p className="text-sm text-gray-600">
                    Selecciona las condiciones del paciente para filtrar las opciones de dieta.
                </p>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    {restricciones.map(restriccion => (
                        <Checkbox
                            key={restriccion.id}
                            id={`restriccion_${restriccion.id}`}
                            label={restriccion.label}
                            checked={data.restricciones.includes(restriccion.id)}
                            onChange={e => handleRestrictionChange(restriccion.id, e.target.checked)}
                        />
                    ))}
                </div>
            </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <SelectInput
                        label="Tipo de dieta"
                        options={categoriaOptions}
                        value={data.tipo_dieta}
                        onChange={(value) => handleTipoDietaChange(value as string)}
                        error={errors.tipo_dieta}
                    />
                    
                    <SelectInput
                        label="Opción específica"
                        options={dietasDisponibles}
                        value={data.opcion_seleccionada}
                        onChange={(value) => setData('opcion_seleccionada', value as string)}
                        error={errors.opcion_seleccionada}
                        //disabled={!data.tipo_dieta} // Deshabilitado hasta que se elija un tipo
                    />

                    <InputText
                        label='Observaciones'
                        id='observaciones'
                        name='observaciones'
                        value={data.observaciones}
                        onChange={value => setData('observaciones',value.target.value)}
                        error={errors.observaciones}/>
                    
                </div>

                <div className="flex justify-end pt-4">
                    <PrimaryButton type="submit" disabled={processing || !data.opcion_seleccionada}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de dietas solicitadas</h3>
                <div className="overflow-x-auto border rounded-lg bg-white shadow-sm">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Tipo de dieta</th>
                                <th className="px-4 py-3">Opción</th>
                                <th className="px-4 py-3">Solicitó</th>
                                <th className="px-4 py-3">Hora solicitud</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {(hoja.solicitud_dietas ?? []).length === 0 ? (
                                <tr>
                                    <td colSpan={4} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay dietas registradas en esta hoja.
                                    </td>
                                </tr>
                            ) : (
                                (hoja.solicitud_dietas ?? []).map((dieta: SolicitudDieta) => (
                                    <tr key={dieta.id}>
                                        <td className="px-4 py-4 text-sm font-medium text-gray-900">{dieta.tipo_dieta}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{dieta.opcion_seleccionada}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{dieta.user_supervisa?.nombre || 'N/A'}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{new Date(dieta.horario_solicitud).toLocaleString('es-MX')}</td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default DietaForm;