import React,{ useState} from 'react';
import { Head, useForm } from '@inertiajs/react';
import { HojaEnfermeria, NotaPostoperatoria, Paciente, Estancia, User, ProductoServicio, CatalogoEstudio } from '@/types';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import InputDateTime from '@/components/ui/input-date-time';
import InputTextArea from '@/components/ui/input-text-area';
import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import FormLayout from '@/components/form-layout';
import PacienteCard from '@/components/paciente-card';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';

import TratamientoDietasForm from '@/components/forms/tratamiento-dietas-form';
import TratamientoSolucionesForm from '@/components/forms/tratamiento-soluciones-form';
import TratamientoMedidasGeneralesForm from '@/components/forms/tratamiento-medidas-generales-form';
import TratamientoMedicamentosForm from '@/components/forms/tratamiento-medicamentos-form';
import TratamientoLaboratoriosForm from '@/components/forms/tratamiento-laboratorios-form';
import EnvioPieza from '@/components/forms/envio-piezas';
import Generalidades from '@/components/forms/generalidades';

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    hoja: HojaEnfermeria;
    nota?: NotaPostoperatoria;
    users: User[];
    soluciones: ProductoServicio[];
    medicamentos: ProductoServicio[];
    estudios: CatalogoEstudio[];
}

type NotaPostoperatoriaComponent = React.FC<Props> & {
    layout: (page: React.ReactElement) => React.ReactNode;
};

const optionsTipoTransfusion = [
    { value: 'plasma fresco congelado', label: 'Plasma fresco congelado' },
    { value: 'paquete globular', label: 'Paquete globular' },
    { value: 'aferesis plaquetaria', label: 'Aféresis plaquetaria' },
];

const optionsCargo = [
    { value: 'ayudante', label: 'Ayudante' },
    { value: 'instrumentista', label: 'Instrumentista' },
    { value: 'anestesiologo', label: 'Anestesiólogo' },
    { value: 'circulante', label: 'Circulante' },
];

interface TransfusionAgregada {
    tipo_transfusion: string;
    cantidad: string;
    temp_id: string;
}

interface AyudanteAgregado {
    ayudante_id: number;
    cargo: string;
    temp_id: string;
}

const NotaPostoperatoriaForm: NotaPostoperatoriaComponent= ({ paciente, estancia, nota, users, soluciones, medicamentos, estudios }) => {

    const optionsAyudantes = users.map(user => ({
        value: user.id.toString(),
        label: `${user.nombre} ${user.apellido_paterno} ${user.apellido_materno}`
    }));

    const { data, setData, post, patch, processing, errors } = useForm({

        ta: nota?.ta || '',
        fc: nota?.fc || '',
        fr: nota?.fr || '',
        temp: nota?.temp || '',
        peso: nota?.peso || '',
        talla: nota?.talla || '',
        resumen_del_interrogatorio: nota?.resumen_del_interrogatorio || '',
        exploracion_fisica: nota?.exploracion_fisica || '',
        resultado_estudios: nota?.resultado_estudios || '',
        tratamiento: nota?.tratamiento || '',
        diagnostico_o_problemas_clinicos: nota?.diagnostico_o_problemas_clinicos || '',
        plan_de_estudio: nota?.plan_de_estudio || '',
        pronostico: nota?.pronostico || '',

        hora_inicio_operacion: nota?.hora_inicio_operacion || '',
        hora_termino_operacion: nota?.hora_termino_operacion || '',
        diagnostico_preoperatorio: nota?.diagnostico_preoperatorio || '',
        operacion_planeada: nota?.operacion_planeada || '',
        operacion_realizada: nota?.operacion_realizada || '',
        diagnostico_postoperatorio: nota?.diagnostico_postoperatorio || '',
        descripcion_tecnica_quirurgica: nota?.descripcion_tecnica_quirurgica || '',
        hallazgos_transoperatorios: nota?.hallazgos_transoperatorios || '',
        reporte_conteo: nota?.reporte_conteo || '',
        cuantificacion_sangrado: nota?.cuantificacion_sangrado || '',
        incidentes_accidentes: nota?.incidentes_accidentes || '',
        ayudantes_agregados: [] as AyudanteAgregado[],
        estado_postquirurgico: nota?.estado_postquirurgico || '',

        manejo_dieta: nota?.manejo_dieta || '',
        manejo_soluciones: nota?.manejo_soluciones || '',
        manejo_medicamentos: nota?.manejo_medicamentos || '',
        manejo_medidas_generales: nota?.manejo_medidas_generales || '',
        manejo_laboratorios: nota?.manejo_laboratorios || '',

        hallazgos_importancia: nota?.hallazgos_importancia || '',
        transfusiones_agregadas: [] as TransfusionAgregada[],

        estudio_solicitado: nota?.solicitud_patologia?.estudio_solicitado || '',
        biopsia_pieza_quirurgica: nota?.solicitud_patologia?.biopsia_pieza_quirurgica || '',
        revision_laminillas: nota?.solicitud_patologia?.revision_laminillas || '',
        estudios_especiales: nota?.solicitud_patologia?.estudios_especiales || '',
        pcr: nota?.solicitud_patologia?.pcr || '',
        pieza_remitida: nota?.solicitud_patologia?.pieza_remitida || '',
        datos_clinicos: nota?.solicitud_patologia?.datos_clinicos || '',
        empresa_enviar: nota?.solicitud_patologia?.empresa_enviar || '',
    });

    const [localTransfusion, setLocalTransfusion] = useState({
        tipo_transfusion: '',
        cantidad: ''
    });

    const handleAddTransfusion = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (!localTransfusion.tipo_transfusion || !localTransfusion.cantidad) {
            Swal.fire({
                title: 'Campos Incompletos',
                text: 'Debe especificar el tipo y la cantidad de la transfusión.',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        const nuevaTransfusion: TransfusionAgregada = {
            ...localTransfusion,
            temp_id: crypto.randomUUID(),
        };
        setData('transfusiones_agregadas', [...data.transfusiones_agregadas, nuevaTransfusion]);
        setLocalTransfusion({ tipo_transfusion: '', cantidad: '' });
    }

    const handleRemoveTransfusion = (temp_id: string) => {
        setData('transfusiones_agregadas',
            data.transfusiones_agregadas.filter(t => t.temp_id !== temp_id)
        );
    }

    const [localAyudante, setLocalAyudante] = useState({
        ayudante_id: '',
        cargo: ''
    });

    const handleAddAyudante = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
       
        if(!localAyudante.ayudante_id || !localAyudante.cargo){
            Swal.fire({
                title: 'Campos Incompletos',
                text: 'Debe especificar el personal y el cargo que desempeñó.',
                icon: 'error',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        const nuevoAyudante: AyudanteAgregado = {
            ayudante_id: Number(localAyudante.ayudante_id),
            cargo: localAyudante.cargo,                  
            temp_id: crypto.randomUUID()
        }
       
        setData('ayudantes_agregados', [...data.ayudantes_agregados, nuevoAyudante]);
        setLocalAyudante({ ayudante_id: '', cargo: ''});
    }


    const handleRemoveAyudante = (temp_id: string) =>{
        setData('ayudantes_agregados',
            data.ayudantes_agregados.filter(t => t.temp_id !== temp_id)
        );
    }

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
       
        if (nota) {
            patch(route('pacientes.estancias.notaspostoperatorias.update', {
                nota: nota.id
            }), {
                preserveScroll: true,
            });
        } else {
            post(route('pacientes.estancias.notaspostoperatorias.store',{
                paciente: paciente.id,
                estancia: estancia.id
            }), {
                preserveScroll: true,
            });
        }
    }

    return (
        <>
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <Head title="Crear nota postoperatoria" />
            <FormLayout
                title='Registrar nota postoperatoria'
                onSubmit={handleSubmit}
                actions={<PrimaryButton type="submit" disabled={processing}>{processing ? 'Creando...' : 'Crear nota postoperatoria'}</PrimaryButton>}>

                <Generalidades
                    data={data}
                    setData={setData}
                    errors={errors}
                />

                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">


                    <InputDateTime
                        id='hora_inicio'
                        name='hora_inicio'
                        label="Hora de inicio de la operación"
                        value={data.hora_inicio_operacion}
                        onChange={val => setData('hora_inicio_operacion', val as string)}
                        error={errors.hora_inicio_operacion}
                    />
                    <InputDateTime
                        id='hora_termino'
                        name='hora_termino'
                        label="Hora de término de la operación"
                        value={data.hora_termino_operacion}
                        onChange={val => setData('hora_termino_operacion', val as string)}
                        error={errors.hora_termino_operacion}
                    />
                   
                    <InputTextArea
                        label="Diagnóstico preoperatorio"
                        value={data.diagnostico_preoperatorio}
                        onChange={e => setData('diagnostico_preoperatorio', e.target.value)}
                        error={errors.diagnostico_preoperatorio}
                        rows={3}
                    />

                    <InputTextArea
                        label="Operación planeada"
                        value={data.operacion_planeada}
                        onChange={e => setData('operacion_planeada', e.target.value)}
                        error={errors.operacion_planeada}
                        rows={3}
                    />

                    <InputTextArea
                        label="Operación realizada"
                        value={data.operacion_realizada}
                        onChange={e => setData('operacion_realizada', e.target.value)}
                        error={errors.operacion_realizada}
                        rows={3}
                    />

                    <InputTextArea
                        label="Diagnóstico postoperatorio"
                        value={data.diagnostico_postoperatorio}
                        onChange={e => setData('diagnostico_postoperatorio', e.target.value)}
                        error={errors.diagnostico_postoperatorio}
                        rows={3}
                    />

                    <InputTextArea
                        label="Descripción de la técnica quirúrgica"
                        value={data.descripcion_tecnica_quirurgica}
                        onChange={e => setData('descripcion_tecnica_quirurgica', e.target.value)}
                        error={errors.descripcion_tecnica_quirurgica}
                        rows={5}
                    />

                    <InputTextArea
                        label="Hallazgos transoperatorios"
                        value={data.hallazgos_transoperatorios}
                        onChange={e => setData('hallazgos_transoperatorios', e.target.value)}
                        error={errors.hallazgos_transoperatorios}
                        rows={4}
                    />

                    <InputTextArea
                        label="Reporte del conteo de gasas, compresas y de instrumental quirúrgico"
                        value={data.reporte_conteo}
                        onChange={e => setData('reporte_conteo', e.target.value)}
                        error={errors.reporte_conteo}
                        rows={3}
                    />

                    <InputTextArea
                        label="Incidentes y accidentes"
                        value={data.incidentes_accidentes}
                        onChange={e => setData('incidentes_accidentes', e.target.value)}
                        error={errors.incidentes_accidentes}
                        rows={3}
                    />

                    <InputText
                        id="cuantificacion_sangre"
                        name="cuantificacion_sangre"
                        label="Cuantificación de sangrado (ml)"
                        value={data.cuantificacion_sangrado}
                        onChange={e => setData('cuantificacion_sangrado', e.target.value)}
                        error={errors.cuantificacion_sangrado}
                        type='number'
                    />
                </div>

                {/* TRANSFUSIONES*/}
                <div className="mt-6 pt-6 border-t mb-8">
                    <h4 className="text-md font-semibold mb-3">Registro de transfusiones</h4>
                   
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <SelectInput
                            label="Tipo de transfusión"
                            options={optionsTipoTransfusion}
                            value={localTransfusion.tipo_transfusion}
                            onChange={(value) => setLocalTransfusion(d => ({ ...d, tipo_transfusion: value as string }))}
                            error={errors['transfusiones_agregadas.0.tipo_transfusion']}
                        />
                        <InputText
                            label="Cantidad (unidades de 250ml)"
                            id="cantidad_transfusion_local"
                            name='cantidad_transfusion_local'
                            value={localTransfusion.cantidad}
                            onChange={e => setLocalTransfusion(d => ({ ...d, cantidad: e.target.value }))}
                            error={errors['transfusiones_agregadas.0.cantidad']}
                        />
                    </div>
                    <PrimaryButton type="button" onClick={handleAddTransfusion}>
                        Agregar
                    </PrimaryButton>
                    <h5 className="text-sm font-semibold mt-6 mb-2">Transfusiones a registrar</h5>
                    <div className="overflow-x-auto border rounded-lg">
                        <table className="min-w-full">
                            <thead className="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                <tr>
                                    <th className="px-4 py-2">Tipo</th>
                                    <th className="px-4 py-2">Cantidad</th>
                                    <th className="px-4 py-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y">
                                {data.transfusiones_agregadas.length === 0 ? (
                                    <tr>
                                        <td colSpan={3} className="px-4 py-3 text-center text-sm text-gray-500">
                                            No se han agregado transfusiones.
                                        </td>
                                    </tr>
                                ) : (
                                    data.transfusiones_agregadas.map(t => (
                                        <tr key={t.temp_id}>
                                            <td className="px-4 py-3 text-sm">{t.tipo_transfusion}</td>
                                            <td className="px-4 py-3 text-sm">{t.cantidad}</td>
                                            <td className="px-4 py-3 text-sm">
                                                <button
                                                    type="button"
                                                    onClick={() => handleRemoveTransfusion(t.temp_id)}
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
                </div>
               
                {/* PERSONAL EMPLEADO */}
                <div className="mt-6 pt-6 border-t mb-15">
                    <h3 className="text-md font-semibold mb-3">Registro de ayudantes, instrumentistas, anestesiólogo y circulante</h3>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <SelectInput
                            label="Personal encargado"
                            options={optionsAyudantes}
                            value={localAyudante.ayudante_id}
                            onChange={(value) => setLocalAyudante(d => ({ ...d, ayudante_id: value as string }))}
                            error={errors['ayudantes_agregados.0.ayudante_id']}
                        />
                        <SelectInput
                            label='Cargo'
                            options={optionsCargo}
                            value={localAyudante.cargo}
                            onChange={(value)=> setLocalAyudante(d => ({...d, cargo: value as string}))}
                        />
                    </div>
                    <PrimaryButton type="button" onClick={handleAddAyudante}>
                        Agregar
                    </PrimaryButton>
                    <h5 className="text-sm font-semibold mt-6 mb-2">Ayudantes, instrumentistas, anestesiólogo y circulante a registrar</h5>
                    <div className="overflow-x-auto border rounded-lg">
                        <table className="min-w-full">
                            <thead className="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">
                                <tr>
                                    <th className="px-4 py-2">Personal</th>
                                    <th className="px-4 py-2">Cargo</th>
                                    <th className="px-4 py-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {data.ayudantes_agregados.length === 0 ? (
                                    <tr>
                                        <td colSpan={3} className="px-4 py-4 text-sm text-gray-500 text-center">
                                            No se han agregado ayudantes.
                                        </td>
                                    </tr>
                                ) : (
                                    data.ayudantes_agregados.map((ayudante) => (
                                        <tr key={ayudante.temp_id}>

                                            <td className="px-4 py-4 text-sm text-gray-900">
                                                {optionsAyudantes.find(opt => opt.value === ayudante.ayudante_id.toString())?.label || '...'}
                                            </td>
                                            <td className="px-4 py-4 text-sm text-gray-500">{ayudante.cargo}</td>
                                            <td className="px-4 py-4 text-sm">
                                                <button
                                                    type="button"
                                                    onClick={() => handleRemoveAyudante(ayudante.temp_id)}
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
                </div>

                <div className="grid grid-cols-1 gap-6 mb-15">
                    <InputTextArea
                        label="Estado postquirúrgico inmediato"
                        value={data.estado_postquirurgico}
                        onChange={e => setData('estado_postquirurgico', e.target.value)}
                        error={errors.estado_postquirurgico}
                        rows={3}
                    />
                </div>
                <div>
                    <h3 className="text-md font-semibold mb-3">Plan de manejo y tratamiento postoperatorio inmediato</h3>
                        <div>
                            <TratamientoDietasForm
                                value={data.manejo_dieta}
                                onChange={value=>(setData('manejo_dieta',value))}  
                            />
                        </div>
                    </div>
                           
                    <div>
                        <div>
                            <TratamientoSolucionesForm
                                value={data.manejo_soluciones}
                                onChange={value=>setData('manejo_soluciones',value)}
                                soluciones={soluciones}
                            />

                        </div>
                        <div>
                           <TratamientoMedicamentosForm
                                value={data.manejo_medicamentos}
                                onChange={value=>setData('manejo_medicamentos',value)}
                                medicamentos={medicamentos}
                           />
                        </div>
                        <div>
                            <TratamientoLaboratoriosForm
                                value={data.manejo_laboratorios}
                                onChange={value=>setData('manejo_laboratorios',value)}
                                estudios={estudios}
                            />    
                        </div>

                        <div className='mb-15'>
                            <TratamientoMedidasGeneralesForm
                                value={data.manejo_medidas_generales}
                                onChange={value=>setData('manejo_medidas_generales',value)}
                            />
                        </div>
                   

                    <div className="mt-6 pt-6 border-t mb-15">
                        <EnvioPieza
                            data={data}
                            setData={setData}
                            errors={errors}
                        />
                    </div>

                    <InputTextArea
                        label="Otros hallazgos de importancia para el paciente, relacionados con el quehacer médico"
                        value={data.hallazgos_importancia}
                        onChange={e => setData('hallazgos_importancia', e.target.value)}
                        error={errors.hallazgos_importancia}
                        rows={2}
                    />
                </div>
            </FormLayout>
        </>
    );
}

NotaPostoperatoriaForm.layout = (page: React.ReactElement) =>{
    const { estancia, paciente } = page.props as Props;

  return (
    <MainLayout
      pageTitle={`Creación de nota postoperatoria`}
      link="estancias.show"
      linkParams={estancia.id} 
    >
      {page}
    </MainLayout>
  );
}

export default NotaPostoperatoriaForm;