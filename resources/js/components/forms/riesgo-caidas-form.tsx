import React, { useEffect } from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria } from '@/types';
import PrimaryButton from '../ui/primary-button';
import SelectInput from '../ui/input-select';

import Checkbox from '../ui/input-checkbox';

interface Props {
    hoja: HojaEnfermeria;
}


const medicamentosList = [
    { id: 'tranquilizantes', label: 'Tranquilizantes / Sedantes' },
    { id: 'diureticos', label: 'Diuréticos' },
    { id: 'hipotensores', label: 'Hipotensores (no diuréticos)' },
    { id: 'antiparkinsonianos', label: 'Antiparkinsonianos' },
    { id: 'antidepresivos', label: 'Antidepresivos' },
    { id: 'otros', label: 'Otros medicamentos de riesgo' },
];

const deficitList = [
    { id: 'visuales', label: 'Alteraciones visuales' },
    { id: 'auditivas', label: 'Alteraciones auditivas' },
    { id: 'extremidades', label: 'Extremidades (parálisis/paresia)' },
];

const RiesgoCaidasForm = ({ hoja }: Props) => {
    
    // Recuperamos datos previos si existen, o inicializamos vacíos
    const initialData = hoja.riesgo_caidas_data || {};

    const { data, setData, put, processing } = useForm({
        // CAMPOS UNICOS (Select)
        caidas_previas: initialData.caidas_previas || '0', // '0' = No, '1' = Sí
        estado_mental: initialData.estado_mental || 'orientado',
        deambulacion: initialData.deambulacion || 'normal',
        edad_mayor_70: initialData.edad_mayor_70 || false, // Booleano para checkbox simple

        // CAMPOS MULTIPLES (Arrays para Checkboxes)
        medicamentos: initialData.medicamentos || [], // Ej: ['diureticos', 'sedantes']
        deficits: initialData.deficits || [],
        
        // Puntuación total (Calculada)
        score_total: initialData.score_total || 0,
    });

    // --- LÓGICA PARA CHECKBOXES DE LISTA (Medicamentos / Déficits) ---
    const handleMultiCheckboxChange = (field: 'medicamentos' | 'deficits', value: string, checked: boolean) => {
        let currentArray = [...data[field]];
        
        if (checked) {
            // Agregar si no existe
            currentArray.push(value);
        } else {
            // Quitar si existe
            currentArray = currentArray.filter(item => item !== value);
        }
        
        setData(field, currentArray);
    };

    // --- CALCULO AUTOMÁTICO DEL RIESGO (Escala Downton) ---
    // Se ejecuta cada vez que cambian los datos para mostrar el score en tiempo real
    useEffect(() => {
        let puntos = 0;

        // 1. Caídas previas (Sí = 1 punto)
        if (data.caidas_previas === '1') puntos += 1;

        // 2. Medicamentos (En Downton, se suma 1 punto por cada categoría de riesgo)
        // Nota: Algunas versiones suman 1 si toma AL MENOS UNO, otras suman por cada uno.
        // Ajusta según el protocolo de tu hospital. Aquí sumo 1 punto por cada med seleccionado.
        puntos += data.medicamentos.length; 

        // 3. Déficits (1 punto por cada uno)
        puntos += data.deficits.length;

        // 4. Estado mental (Confuso = 1 punto)
        if (data.estado_mental === 'confuso') puntos += 1;

        // 5. Deambulación (Cualquier cosa que no sea normal = 1 punto)
        if (data.deambulacion !== 'normal') puntos += 1;

        // 6. Edad (Mayor 70 = 1 punto)
        if (data.edad_mayor_70) puntos += 1;

        // Actualizamos el score en el formulario sin disparar re-render infinito
        if (data.score_total !== puntos) {
            setData('score_total', puntos);
        }

    }, [data.caidas_previas, data.medicamentos, data.deficits, data.estado_mental, data.deambulacion, data.edad_mayor_70]);


    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        put(route('hojas.update_riesgo', hoja.id));
    };

    // Determinar nivel de riesgo para mostrar color
    const getNivelRiesgo = (puntos: number) => {
        if (puntos >= 3) return { texto: 'ALTO RIESGO', color: 'text-red-600 font-bold' };
        if (puntos >= 1) return { texto: 'MEDIANO RIESGO', color: 'text-yellow-600 font-bold' };
        return { texto: 'BAJO RIESGO', color: 'text-green-600 font-bold' };
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-6">

            <SelectInput
                label='Caídas previas'
                value={data.caidas_previas}
                onChange={e => setData('caidas_previas', e)}
                options={[
                    { value: '0', label: 'No' },
                    { value: '1', label: 'Sí' },
                ]}
            />

            {/* SECCIÓN 2: MEDICAMENTOS (CHECKBOXES) */}
            <div className="border p-4 rounded bg-gray-50">
                <h3>Medicamentos</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {medicamentosList.map((med) => (
                        <div key={med.id} className="flex items-center">
                            <Checkbox
                                label='' 
                                id={`med-${med.id}`}
                                checked={data.medicamentos.includes(med.id)}
                                onChange={(e) => handleMultiCheckboxChange('medicamentos', med.id, e.target.checked)}
                            />
                            <label htmlFor={`med-${med.id}`} className="ml-2 text-sm text-gray-700">
                                {med.label}
                            </label>
                        </div>
                    ))}
                </div>
            </div>

            {/* SECCIÓN 3: DÉFICITS (CHECKBOXES) */}
            <div className="border p-4 rounded bg-gray-50">
                <h3>Déficits sensitivo-motores</h3>
                <div className="grid grid-cols-1 gap-2">
                    {deficitList.map((def) => (
                        <div key={def.id} className="flex items-center">
                            <Checkbox 
                                label=''
                                id={`def-${def.id}`}
                                checked={data.deficits.includes(def.id)}
                                onChange={(e) => handleMultiCheckboxChange('deficits', def.id, e.target.checked)}
                            />
                            <label htmlFor={`def-${def.id}`} className="ml-2 text-sm text-gray-700">
                                {def.label}
                            </label>
                        </div>
                    ))}
                </div>
            </div>

            <SelectInput
                label='Estado mental'
                value={data.estado_mental}
                onChange={e => setData('estado_mental', e)}
                options={[
                    { value: 'orientado', label: 'Orientado' },
                    { value: 'confuso', label: 'Confuso' },
                ]}
            />

            <SelectInput
                label='Deambulación'
                value={data.deambulacion}
                onChange={e => setData('deambulacion', e)}
                options={[
                    { value: 'normal', label: 'Normal' },
                    { value: 'segura_ayuda', label: 'Segura con ayuda' },
                    { value: 'insegura', label: 'Insegura con/sin ayuda' },
                    { value: 'imposible', label: 'Imposible' },
                ]}
            />

            {/* SECCIÓN 6: EDAD */}
            <div className="flex items-center mt-4">
                <Checkbox 
                    label=''
                    id="edad_70"
                    checked={data.edad_mayor_70}
                    onChange={(e) => setData('edad_mayor_70', e.target.checked)}
                />
                <label htmlFor="edad_70" className="ml-2 text-sm text-gray-700">
                    Paciente mayor de 70 años
                </label>
            </div>

            <div className="mt-6 p-4 border-2 border-blue-100 rounded-lg text-center bg-blue-50">
                <p className="text-gray-600 uppercase text-xs tracking-wider">Puntuación Total</p>
                <div className="text-3xl font-bold text-gray-800">{data.score_total} Puntos</div>
                <div className={`mt-2 ${getNivelRiesgo(data.score_total).color}`}>
                    {getNivelRiesgo(data.score_total).texto}
                </div>
            </div>

            <div className="mt-4">
                <PrimaryButton disabled={processing}>
                    Guardar Evaluación
                </PrimaryButton>
            </div>
        </form>
    );
};

export default RiesgoCaidasForm;