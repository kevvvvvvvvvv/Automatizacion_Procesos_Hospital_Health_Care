import React, { useMemo } from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria, SolicitudDieta, User } from '@/types'; 
import { route } from 'ziggy-js';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import InputDateTime from '@/components/ui/input-date-time';

const opcionesDeDieta = {
    'Dieta de Líquidos Claros': [
        { value: 'Opción 1', label: 'Gelatina, Té, Jugo de Manzana diluido' },
    ],
    'Dieta Blanda - Desayuno': [
        { value: 'Opción 1', label: 'Omelette de espinacas con queso panela' },
        { value: 'Opción 2', label: 'Waffles de avena con miel y fruta' },
        { value: 'Opción 3', label: 'Huevo a la mexicana sin picante' },
        { value: 'Opción 4', label: 'Huevo revuelto con jamón de pavo' },
        { value: 'Opción 5', label: 'Caldito de verduras con pollo deshebrado' }, 
    ],
    'Dieta Blanda - Comida': [
        { value: 'Opción 1', label: 'Pechuga asada con verduras al vapor' },
        { value: 'Opción 2', label: 'Caldito de verduras con pollo deshebrado' },
        { value: 'Opción 3', label: 'Fajitas de pollo con morrón y queso panela' },
        { value: 'Opción 4', label: 'Rollitos de pechuga rellenos' },
        { value: 'Opción 5', label: 'Consomé (PX Bichectomía)' },
    ],
    'Dieta Blanda - Cena': [
        { value: 'Opción 1', label: 'Huevo revuelto con jamón de pavo' },
        { value: 'Opción 2', label: 'Waffles de avena con miel y fruta' },
        { value: 'Opción 3', label: '2 quesadillas de queso panela' },
        { value: 'Opción 4', label: 'Sándwich de jamón de pavo (pan integral)' },
        { value: 'Opción 5', label: 'Huevo a la mexicana sin picante' },
    ],
};

interface Props {
    hoja: HojaEnfermeria;
    usuarios: User[];
}

const DietaForm: React.FC<Props> = ({ hoja, usuarios }) => {
    
    const optionsUsuarios = usuarios.map(u => ({
        value: u.id.toString(),
        label: u.nombre, 
    }));
    
    const tiposDeDietaOptions = Object.keys(opcionesDeDieta).map(tipo => ({
        value: tipo,
        label: tipo,
    }));

    const { data, setData, post, processing, errors, reset, wasSuccessful } = useForm({
        tipo_dieta: '',
        opcion_seleccionada: '',
        horario_solicitud: new Date().toISOString().slice(0, 16),
        user_supervisa_id: '',
        horario_entrega: '',
        user_entrega_id: '',
    });

    const opcionesDeComida = useMemo(() => {
        if (!data.tipo_dieta) return [];
        return opcionesDeDieta[data.tipo_dieta] || [];
    }, [data.tipo_dieta]);

    const handleTipoDietaChange = (value: string) => {
        setData(currentData => ({
            ...currentData,
            tipo_dieta: value,
            opcion_seleccionada: '', 
        }));
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('dietas.store', { hojaenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }

    return (
        <div className="space-y-6">

            <div className="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <h3 className="text-lg font-semibold mb-2 text-gray-800">Indicaciones para Elaboración de Dietas</h3>
                <details className="p-2 border rounded-md">
                    <summary className="font-medium cursor-pointer text-sm">Sin Colecitoqueneticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: calabacitas, brócoli, coles, coliflor, yema de huevo, leche, crema, quesos (manchego, americano), mantequilla, pan dulce, galletas, pasteles, leguminosas (frijoles, lentejas, etc.), embutidos (chorizo, tocino), fritos o capeados.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">PX Celiacos (Sin Gluten)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: trigo, sémolas, espelta, harinas, avena, cebada, malta, centeno, triticale, pasta, pan, galletas, almidones modificados o levadura.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">PX Diabéticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: gelatinas (excepto light), jugos (envasados o naturales), frutas con alto índice glucémico (plátano, papaya, melón, sandía), arroz, pasta, pan blanco, galletas, margarinas, manteca, embutidos.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">PX Hipertensos (Sin Sal)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: embutidos (jamón, salchicha), enlatados, carnes ahumadas, lácteos, margarinas, mantequillas, fritos o capeados. Omitir sal en la preparación.</p>
                </details>
            </div>

            <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg shadow-md space-y-4">
                <h3 className="text-lg font-semibold mb-4">Definir la Dieta (Pedido)</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Pedido de dieta guardado.</div>}

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <SelectInput
                        label="Tipo de Dieta"
                        options={tiposDeDietaOptions}
                        value={data.tipo_dieta}
                        onChange={(value) => handleTipoDietaChange(value as string)}
                        error={errors.tipo_dieta}
                    />
                    
                    <SelectInput
                        label="Opción Específica"
                        options={opcionesDeComida}
                        value={data.opcion_seleccionada}
                        onChange={(value) => setData('opcion_seleccionada', value as string)}
                        error={errors.opcion_seleccionada}
                        //disabled={!data.tipo_dieta} // Deshabilitado hasta que se elija un tipo
                    />

                    <InputDateTime
                        id='horario_soliciud'
                        name='horario_soliciud'
                        label="Horario de Solicitud"
                        value={data.horario_solicitud}
                        onChange={(val) => setData('horario_solicitud', val as string)}
                        error={errors.horario_solicitud}
                    />
                    
                    <SelectInput
                        label="Quién Supervisó"
                        options={optionsUsuarios}
                        value={data.user_supervisa_id}
                        onChange={(value) => setData('user_supervisa_id', value as string)}
                        error={errors.user_supervisa_id}
                    />

                    <InputDateTime
                        id='horario_entrega'
                        name='horario_entrega'
                        label="Horario de Entrega (Opcional)"
                        value={data.horario_entrega}
                        onChange={(val) => setData('horario_entrega', val as string)}
                        error={errors.horario_entrega}
                    />

                    <SelectInput
                        label="Quién Entrega (Opcional)"
                        options={optionsUsuarios}
                        value={data.user_entrega_id}
                        onChange={(value) => setData('user_entrega_id', value as string)}
                        error={errors.user_entrega_id}
                    />
                </div>

                <div className="flex justify-end pt-4">
                    <PrimaryButton type="submit" disabled={processing || !data.opcion_seleccionada}>
                        {processing ? 'Guardando...' : 'Guardar Pedido de Dieta'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Dietas Solicitadas</h3>
                <div className="overflow-x-auto border rounded-lg bg-white shadow-sm">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr className='text-left text-xs font-medium text-gray-500 uppercase'>
                                <th className="px-4 py-3">Tipo de Dieta</th>
                                <th className="px-4 py-3">Opción</th>
                                <th className="px-4 py-3">Solicitó</th>
                                <th className="px-4 py-3">Hora Solicitud</th>
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