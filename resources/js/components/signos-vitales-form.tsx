import React from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria, HojaSignos } from '@/types'; 
import { route } from 'ziggy-js';

import InputText from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select'; 
import PrimaryButton from '@/components/ui/primary-button';

const opcionesEstadoConciencia = [
    { value: 'Alerta', label: 'Alerta' },
    { value: 'Letárgico', label: 'Letárgico' },
    { value: 'Obnubilado', label: 'Obnubilado' },
    { value: 'Estuporoso', label: 'Estuporoso' },
    { value: 'Coma', label: 'Coma' },
];

interface Props {
    hoja: HojaEnfermeria;
}

const SignosVitalesForm: React.FC<Props> = ({ hoja }) => {

    const { data, setData, post, processing, errors, wasSuccessful } = useForm({
        fecha_hora_registro: new Date().toISOString().slice(0, 16), 
        tension_arterial_sistolica: '',
        tension_arterial_diastolica: '',
        frecuencia_cardiaca: '',
        frecuencia_respiratoria: '',
        temperatura: '',
        saturacion_oxigeno: '',
        glucemia_capilar: '',
        peso: '',
        talla: '',
        uresis: '',
        uresis_descripcion: '',
        evacuaciones: '',
        evacuaciones_descripcion: '',
        emesis: '',
        emesis_descripcion: '',
        drenes: '',
        drenes_descripcion: '',
        estado_conciencia: '',
        escala_braden: '',
        escala_glasgow: '',
        escala_eva: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasenfermerias.signos.store', { hojaenfermeria: hoja.id }), {
            preserveScroll: true,
        });
    }

    return (
        <>
        <form onSubmit={handleSubmit}>
            {wasSuccessful && <div className="mb-4 text-sm font-medium text-green-600">Signos vitales guardados con éxito.</div>}

            <div className="grid grid-cols-2 md:grid-cols-3 gap-6">
            
                <InputText 
                    id="tension_arterial_sistolica" 
                    name="tension_arterial_sistolica" 
                    label="Tensión arterial (sistólica)" 
                    type="number"
                    value={data.tension_arterial_sistolica} 
                    onChange={(e) => setData('tension_arterial_sistolica', e.target.value)} 
                    error={errors.tension_arterial_sistolica} 
                />

                <InputText 
                    id="tension_arterial_diastolica" 
                    name="tension_arterial_diastolica" 
                    label="Tensión arterial (diastólica)" 
                    type="number"
                    value={data.tension_arterial_diastolica} 
                    onChange={(e) => setData('tension_arterial_diastolica', e.target.value)} 
                    error={errors.tension_arterial_diastolica} 
                />

                <InputText 
                    id="frecuencia_cardiaca" 
                    name="frecuencia_cardiaca" 
                    label="Frecuencia Cardíaca (por minuto)" 
                    type="number" 
                    value={data.frecuencia_cardiaca} 
                    onChange={(e) => setData('frecuencia_cardiaca', e.target.value)} 
                    error={errors.frecuencia_cardiaca} 
                />
                
                <InputText 
                    id="frecuencia_respiratoria" 
                    name="frecuencia_respiratoria" 
                    label="Frecuencia Respiratoria (por minuto)" 
                    type="number" 
                    value={data.frecuencia_respiratoria} 
                    onChange={(e) => setData('frecuencia_respiratoria', e.target.value)} 
                    error={errors.frecuencia_respiratoria} 
                />
                <InputText 
                    id="temperatura" 
                    name="temperatura" 
                    label="Temperatura (Celsius)" 
                    type="number"
                    value={data.temperatura} 
                    onChange={(e) => setData('temperatura', e.target.value)} 
                    error={errors.temperatura} 
                />
                <InputText 
                    id="saturacion_oxigeno" 
                    name="saturacion_oxigeno" 
                    label="Saturación de Oxígeno (%)" 
                    type="number" 
                    value={data.saturacion_oxigeno} 
                    onChange={(e) => setData('saturacion_oxigeno', e.target.value)} 
                    error={errors.saturacion_oxigeno} 
                />
                <InputText 
                    id="glucemia_capilar" 
                    name="glucemia_capilar" 
                    label="Glucemia Capilar (mg/dL)" 
                    type="number" 
                    value={data.glucemia_capilar} 
                    onChange={(e) => setData('glucemia_capilar', e.target.value)} 
                    error={errors.glucemia_capilar} 
                />
                <InputText 
                    id="peso" 
                    name="peso" 
                    label="Peso (kg)" 
                    type="number"
                    value={data.peso} 
                    onChange={(e) => setData('peso', e.target.value)} 
                    error={errors.peso} 
                />
                <InputText 
                    id="talla" 
                    name="talla" 
                    label="Talla (cm)" 
                    type="number" 
                    value={data.talla} 
                    onChange={(e) => setData('talla', e.target.value)} 
                    error={errors.talla} 
                />
                
                <InputText 
                    id="uresis" 
                    name="uresis" 
                    label="Uresis (cantidad)" 
                    type="number" 
                    value={data.uresis} 
                    onChange={(e) => setData('uresis', e.target.value)} 
                    error={errors.uresis} 
                />
                <InputText 
                    id="uresis_descripcion" 
                    name="uresis_descripcion" 
                    label="Uresis (descripción)" 
                    value={data.uresis_descripcion} 
                    onChange={(e) => setData('uresis_descripcion', e.target.value)} 
                    error={errors.uresis_descripcion} 
                />
                
                <InputText 
                    id="evacuaciones" 
                    name="evacuaciones" 
                    label="Evacuaciones (cantidad)" 
                    type="number" 
                    value={data.evacuaciones} 
                    onChange={(e) => setData('evacuaciones', e.target.value)} 
                    error={errors.evacuaciones} 
                />
                <InputText 
                    id="evacuaciones_descripcion" 
                    name="evacuaciones_descripcion" 
                    label="Evacuaciones (descripción)" 
                    value={data.evacuaciones_descripcion} 
                    onChange={(e) => setData('evacuaciones_descripcion', e.target.value)} 
                    error={errors.evacuaciones_descripcion} 
                />

                <InputText 
                    id="emesis" 
                    name="emesis" 
                    label="Emesis (cantidad)" 
                    type="number" 
                    value={data.emesis} 
                    onChange={(e) => setData('emesis', e.target.value)} 
                    error={errors.emesis} 
                />
                <InputText 
                    id="emesis_descripcion" 
                    name="emesis_descripcion" 
                    label="Emesis (descripción)" 
                    value={data.emesis_descripcion} 
                    onChange={(e) => setData('emesis_descripcion', e.target.value)} 
                    error={errors.emesis_descripcion} 
                />

                <InputText 
                    id="drenes" 
                    name="drenes" 
                    label="Drenes (cantidad)" 
                    type="number" 
                    value={data.drenes} 
                    onChange={(e) => setData('drenes', e.target.value)} 
                    error={errors.drenes} 
                />
                <InputText 
                    id="drenes_descripcion" 
                    name="drenes_descripcion" 
                    label="Drenes (descripción)" 
                    value={data.drenes_descripcion} 
                    onChange={(e) => setData('drenes_descripcion', e.target.value)} 
                    error={errors.drenes_descripcion} 
                />
                
                <SelectInput
                    label="Estado de Conciencia"
                    options={opcionesEstadoConciencia}
                    value={data.estado_conciencia}
                    onChange={(value) => setData('estado_conciencia', value as string)}
                    error={errors.estado_conciencia}
                />

                <InputText 
                    id="escala_glasgow" 
                    name="escala_glasgow" 
                    label="Escala Glasgow" 
                    value={data.escala_glasgow} 
                    onChange={(e) => setData('escala_glasgow', e.target.value)} 
                    error={errors.escala_glasgow} 
                />
                
                <InputText 
                    id="escala_braden" 
                    name="escala_braden" 
                    label="Escala Braden" 
                    value={data.escala_braden} 
                    onChange={(e) => setData('escala_braden', e.target.value)} 
                    error={errors.escala_braden} 
                />

                <InputText 
                    id="escala_eva" 
                    name="escala_eva" 
                    label="Escala EVA (Dolor)" 
                    value={data.escala_eva} 
                    onChange={(e) => setData('escala_eva', e.target.value)} 
                    error={errors.escala_eva} 
                />
            </div>

            <div className="flex justify-end mt-6">
                <PrimaryButton type="submit" disabled={processing}>
                    {processing ? 'Guardando...' : 'Guardar Signos Vitales'}
                </PrimaryButton>
            </div>
        </form>
        <div className="mt-12">
                <h3 className="text-lg font-semibold mb-2">Historial de Signos Vitales</h3>
                <div className="overflow-x-auto border rounded-lg">
                    <table className="min-w-full divide-y divide-gray-200">
                        <thead className="bg-gray-50">
                            <tr>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha/Hora</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">T.A.</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">F.C.</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">F.R.</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp</th>
                                <th className="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                            </tr>
                        </thead>
                        <tbody className="bg-white divide-y divide-gray-200">

                            {(hoja.hoja_signos ?? []).length === 0 ? (
                                <tr>
                                    <td colSpan={6} className="px-4 py-4 text-sm text-gray-500 text-center">
                                        No hay registros de signos guardados.
                                    </td>
                                </tr>
                            ) : (
                                (hoja.hoja_signos ?? []).map((registro: HojaSignos) => (
                                    <tr key={registro.id}>
                                        <td className="px-4 py-4 text-sm text-gray-900">{registro.fecha_hora_registro}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">
                                            {registro.tension_arterial_sistolica} / {registro.tension_arterial_diastolica}
                                        </td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{registro.frecuencia_cardiaca}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{registro.frecuencia_respiratoria}</td>
                                        <td className="px-4 py-4 text-sm text-gray-500">{registro.temperatura}</td>
                                        <td className="px-4 py-4 text-sm">
                                            <button
                                                type="button"
                                                // onClick={() => handleRemove(registro.id)}
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
        </>
    );
}

export default SignosVitalesForm;