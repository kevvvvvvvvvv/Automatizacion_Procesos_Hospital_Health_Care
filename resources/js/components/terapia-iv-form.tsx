import React, { useState } from 'react'; // Importar useState
import { useForm, router } from '@inertiajs/react';
import { HojaEnfermeria, ProductoServicio, RecienNacido } from '@/types';
import { route } from 'ziggy-js';
import { optionsUnidadMedida } from '@/constant/const';
import Swal from 'sweetalert2';

import SelectInput from '@/components/ui/input-select';
import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';

interface MedicamentoAgregado {
    id: string;
    nombre: string;
    dosis: number;
    unidad: string;
    es_manual:boolean;
}

interface TerapiaAgregada {
    solucion_id: string;
    nombre_solucion: string;
    duracion: number;
    cantidad: number;
    flujo: number;
    fecha_hora_inicio: string;
    medicamentos: MedicamentoAgregado[];
    es_manual: boolean;
    temp_id: string; 
}

interface Props {
    hoja: HojaEnfermeria | RecienNacido;
    soluciones: ProductoServicio[];
    medicamentos: ProductoServicio[];
}

const formatDateTime = (isoString: string | null) => {
    if (!isoString) return 'Pendiente';
    return new Date(isoString).toLocaleString('es-MX', {
        dateStyle: 'short',
        timeStyle: 'short',
    });
};

const TerapiaIVForm: React.FC<Props> = ({ 
    hoja, 
    soluciones = [],
    medicamentos= [],
}) => {

    const handleDateUpdate = (terapiaId: number, newDate: string) => {
    if (!newDate) return;

    router.patch(route('hojasterapiasiv.update', { 
        hojasterapiasiv: terapiaId 
    }), {
        fecha_hora_inicio: newDate 
    }, {
        preserveScroll: true,
        onSuccess: () => Swal.fire('Éxito', 'Inicio de terapia registrado', 'success')
    });
};

    const solucionesOptions = soluciones.map(s =>({
        label: s.nombre_prestacion,
        value: s.id.toString()
    }));

    const medicamentosOptions = medicamentos.map(m => ({
        label: m.nombre_prestacion,
        value: m.id.toString(),
    }))

    const [localData, setLocalData] = useState({
        solucion_id: '',
        nombre_solucion: '',
        cantidad: '',
        duracion: '',
        fecha_hora_inicio: '',
        es_manual: false,
        medicamentos_actuales: [] as MedicamentoAgregado[],

    });

    const { data, setData, post, processing, errors, reset, wasSuccessful, transform } = useForm({
        terapias_agregadas: [] as TerapiaAgregada[],
    });

    const handleAddToList = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (localData.es_manual && !localData.nombre_solucion.trim()) {
            Swal.fire('Error', 'Debe escribir el nombre de la solución manual.');
            return;
        }
        if (!localData.es_manual && !localData.solucion_id) {
            Swal.fire('Error', 'Debe seleccionar una solución del catálogo.');
            return;
        }

        const nuevaTerapia: TerapiaAgregada = {
            solucion_id: localData.solucion_id,
            nombre_solucion: localData.nombre_solucion,
            duracion: Number(localData.duracion),
            cantidad: Number(localData.cantidad),
            flujo: Number(localData.cantidad) / Number(localData.duracion),
            fecha_hora_inicio: localData.fecha_hora_inicio,
            medicamentos: localData.medicamentos_actuales,
            es_manual: localData.es_manual,
            temp_id: crypto.randomUUID(),
        };

        setData('terapias_agregadas', [...data.terapias_agregadas, nuevaTerapia]);

        
        setLocalData({
            solucion_id: '',
            nombre_solucion: '',
            cantidad: '',
            duracion: '',
            fecha_hora_inicio: '',
            es_manual: false,
            medicamentos_actuales: [], 
        });
    };

    const [tempMedicamento, setTempMedicamento] = useState({
        id: '',
        nombre: '',
        dosis: '',
        unidad: '',
        es_manual: false, 
    });

    const agregarMedicamentoALaSolucion = () => {

        if (tempMedicamento.es_manual && !tempMedicamento.nombre.trim()) {
            Swal.fire("Error","Escriba el nombre del medicamento manual.");
            return;
        }
        if (!tempMedicamento.es_manual && !tempMedicamento.id) {
            Swal.fire("Fire","Seleccione un medicamento del inventario.");
            return;
        }
        if (!tempMedicamento.dosis) return;
        
        setLocalData(prev => ({
            ...prev,
            medicamentos_actuales: [...prev.medicamentos_actuales, {
                id: tempMedicamento.id,
                nombre: tempMedicamento.nombre,
                dosis: Number(tempMedicamento.dosis),
                unidad: tempMedicamento.unidad,
                es_manual: tempMedicamento.es_manual
            }]
        }));
        
        setTempMedicamento({ 
            id: '', 
            nombre: '', 
            dosis: '', 
            unidad: '', 
            es_manual: false 
        });
    };
    
    const handleRemoveFromList = (temp_id: string) => {
        setData('terapias_agregadas', 
            data.terapias_agregadas.filter(t => t.temp_id !== temp_id)
        );
    }

    const handleSubmitList = (e: React.FormEvent) => {
    e.preventDefault();

    if (data.terapias_agregadas.length === 0) return;

    const isRecienNacido = 'nombre_rn' in hoja;

    // CORRECTO: Usamos la función transform del hook que está en el top-level
    transform((oldData) => ({
        ...oldData,
        terapiable_id: hoja.id,
        terapiable_type: isRecienNacido 
            ? 'App\\Models\\Formulario\\RecienNacido\\RecienNacido' 
            : 'App\\Models\\Formulario\\HojaEnfermeria\\HojaEnfermeria',
    }));

    // El post usará los datos transformados automáticamente
   post(route('hojasterapiasiv.store', { hojaenfermeria: hoja.id }), {
    preserveScroll: true,
    onSuccess: () => {
        reset();
        Swal.fire('Guardado', 'Terapias registradas con éxito', 'success');
    },
});
};

    const handleRemoveSavedTerapia = (terapiaId: string) => {
    if (confirm('¿Seguro que deseas eliminar esta terapia (ya guardada)?')) {
        router.delete(route('hojasterapiasiv.destroy', { // <-- Corregido aquí
            hojaenfermeria: hoja?.id,
            terapiaiv: terapiaId 
        }), {
            preserveScroll: true,
        });
    }
}   
    //console.log(errors);

    return (
        <div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <div className="flex justify-between items-center mb-1">
                        <label className="block font-medium text-sm text-gray-700">
                            Solución base
                        </label>
                        <button 
                            type="button"
                            onClick={() => setLocalData(prev => ({ ...prev, es_manual: !prev.es_manual, solucion_id: '', nombre_solucion: '' }))}
                            className="text-xs text-blue-600 hover:underline cursor-pointer"
                        >
                            {localData.es_manual ? "← Buscar en catálogo" : "Escribir manual →"}
                        </button>
                    </div>

                    {!localData.es_manual ? (
                        <SelectInput
                            label=""
                            options={solucionesOptions}
                            value={localData.solucion_id} 
                            onChange={(value) => {
                                const sel = solucionesOptions.find(o => o.value === value);
                                setLocalData(d => ({
                                    ...d, 
                                    solucion_id: value as string,
                                    nombre_solucion: sel ? sel.label : ''
                                }))
                            }}
                        />
                    ) : (
                        <InputText
                            id="solucion_manual"
                            name="solucion_manual"
                            label=""
                            placeholder="Ej. Solución Hartmann 1000ml"
                            value={localData.nombre_solucion}
                            onChange={e => setLocalData(d => ({ ...d, nombre_solucion: e.target.value }))}
                        />
                    )}
                </div>

                <InputText
                    id="cantidad"
                    name="cantidad"
                    label="Cantidad (mililitros)"
                    type="number"
                    value={localData.cantidad}
                    onChange={e => setLocalData(d => ({...d, cantidad: e.target.value}))}
                    error={errors['terapias_agregadas.0.cantidad']}
                />

                <InputText
                    id="duracion"
                    name="duracion"
                    label="Duración"
                    type="number"
                    value={localData.duracion}
                    onChange={e => setLocalData(d => ({...d, duracion: e.target.value}))}
                    error={errors['terapias_agregadas.0.duracion']}
                />
            </div>
            <hr />
            <div className="bg-gray-50 p-4 rounded-lg border">
                <h4 className="font-bold mb-2">Agregar medicamentos a la solución</h4>
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <div className="flex justify-between items-center mb-1">
                            <label className="block font-medium text-sm text-gray-700">Medicamento</label>
                            <button 
                                type="button"
                                onClick={() => setTempMedicamento(prev => ({ ...prev, es_manual: !prev.es_manual, id: '', nombre: '' }))}
                                className="text-xs text-blue-600 hover:underline cursor-pointer"
                            >
                                {tempMedicamento.es_manual ? "← Catálogo" : "Manual →"}
                            </button>
                        </div>

                        {!tempMedicamento.es_manual ? (
                            <SelectInput
                                label=""
                                options={medicamentosOptions}
                                value={tempMedicamento.id}
                                onChange={(val) => {
                                    const med = medicamentosOptions.find(o => o.value === val);
                                    setTempMedicamento(prev => ({ ...prev, id: val, nombre: med ? med.label : '' }));
                                }}
                            />
                        ) : (
                            <InputText 
                                label="" 
                                name=""
                                id="medicamento_manual"
                                placeholder="Ej. Paracetamol"
                                value={tempMedicamento.nombre}
                                onChange={e => setTempMedicamento(prev => ({ ...prev, nombre: e.target.value }))}
                            />
                        )}
                    </div>
                    <InputText 
                        label="Dosis" 
                        id="dosis"
                        name='dosis'
                        type="number" 
                        value={tempMedicamento.dosis} 
                        onChange={e => setTempMedicamento(prev => ({ ...prev, dosis: e.target.value }))}
                    />
                    <SelectInput 
                        label="Unidad" 
                        options={optionsUnidadMedida} 
                        value={tempMedicamento.unidad}
                        onChange={val => setTempMedicamento(prev => ({ ...prev, unidad: val }))}
                    />
                    <button 
                        type="button" 
                        onClick={agregarMedicamentoALaSolucion}
                        className="bg-blue-500 text-white px-4 py-2 rounded"
                    >
                        + Añadir fármaco
                    </button>
                </div>

                <ul className="mt-3">
                    {localData.medicamentos_actuales.map((m, idx) => (
                        <li key={idx} className="text-sm text-gray-600 flex justify-between border-b py-1">
                            <span>{m.nombre} - {m.dosis} {m.unidad}</span>
                            <button onClick={() => {/* logic para quitar */}} className="text-red-500">x</button>
                        </li>
                    ))}
                </ul>
            </div>

            <div className="flex justify-end mt-4">
                <PrimaryButton type="button" onClick={handleAddToList}>
                    Agregar solución 
                </PrimaryButton>
            </div>

            <form onSubmit={handleSubmitList} className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Terapias pendientes por guardar</h3>
                {wasSuccessful && <div className="mb-4 text-sm text-green-600">Terapias guardadas con éxito.</div>}
                
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className="text-left">
                                <th className="px-4 py-4 text-sm text-gray-900">Solución</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Cantidad</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Flujo</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {data.terapias_agregadas.length === 0 ? (
                                <tr>
                                    <td colSpan={4} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay terapias pendientes.
                                    </td>
                                </tr>
                            ) : (
                                data.terapias_agregadas.map((terapia) => (
                                    <tr key={terapia.temp_id}>
                                        <td className="px-4 py-4 text-sm">
                                            <div className='text-gray-900'>{terapia.nombre_solucion}</div>
                                            
                                                {terapia.medicamentos.map((medicamento)=>(
                                                    <div className='text-gray-400 text-xs'>
                                                    {medicamento.nombre} | {medicamento.dosis} {medicamento.unidad}
                                                    </div>
                                                ))}
                                            
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{terapia.cantidad}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">{terapia.duracion}</td>
                                        <td className="px-4 py-4 text-sm text-gray-900">
                                            {
                                                terapia.duracion > 0 
                                                    ? (terapia.cantidad / terapia.duracion).toFixed(2) + ' ml/hr' 
                                                    : 'N/A'
                                            }
                                        </td>
                                        <td className="px-4 py-4 text-sm">
                                            <button
                                                type="button"
                                                onClick={() => handleRemoveFromList(terapia.temp_id)}
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
                    <PrimaryButton type="submit" disabled={processing || data.terapias_agregadas.length === 0}>
                        {processing ? 'Guardando...' : 'Guardar lista de terapias'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Terapias intravenosas ya guardadas</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr className="text-left">
                                <th className="px-4 py-4 text-sm text-gray-900">Solución</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Cantidad</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Duración</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Flujo</th>
                                <th className="px-4 py-4 text-sm text-gray-900">Acciones</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">
                            {hoja?.hojas_terapia_i_v?.length === 0 ? (
                                <tr>
                                    <td colSpan={4} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay terapias registradas.
                                    </td>
                                </tr>
                            ) : (
                            hoja?.hojas_terapia_i_v?.map((terapia) => (
                                <tr key={terapia.id}>
                                    <td className="px-4 py-4 text-sm text-gray-900">
                                        {terapia.detalle_soluciones?.nombre_prestacion || '...'}
                                            {terapia.medicamentos.map((medicamento,index)=>(
                                                <div key={index} className='text-gray-400'>
                                                    {medicamento.nombre_medicamento} {medicamento.dosis} {medicamento.unidad_medida}
                                                </div>
                                            )
                                        )}
                                            
                                    </td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.cantidad}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.duracion}</td>
                                    <td className="px-4 py-4 text-sm text-gray-500">{terapia.flujo_ml_hora}</td>
                                    <td className="px-2 py-1 text-sm text-gray-500" style={{ minWidth: '200px' }}>
                                        {terapia.fecha_hora_inicio ? (
                                            <span>{formatDateTime(terapia.fecha_hora_inicio)}</span>
                                        ): (
                                            <PrimaryButton
                                                type="button"
                                                onClick={() => {
                                                    const now_iso = new Date().toISOString();
                                                    handleDateUpdate(terapia.id, now_iso);
                                                }}
                                            >
                                                Registrar inicio
                                            </PrimaryButton>
                                        )}
                                    </td>

                                    <td className="px-4 py-4 text-sm">
                                        <button
                                            type="button"
                                            onClick={() => handleRemoveSavedTerapia(terapia.id.toString())}
                                            className="text-red-600 hover:text-red-900"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            )))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default TerapiaIVForm;