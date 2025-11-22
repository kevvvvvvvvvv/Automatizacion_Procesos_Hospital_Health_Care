import React,{ useState, useMemo} from 'react';
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
    { value: 'circulante', label: 'Cirtulante' },
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
        estudios_transoperatorios: nota?.estudios_transoperatorios || '',
        ayudantes_agregados: [] as AyudanteAgregado[],
        envio_piezas: nota?.envio_piezas || '',
        estado_postquirurgico: nota?.estado_postquirurgico || '',

        manejo_dieta: nota?.manejo_dieta || '',
        manejo_soluciones: nota?.manejo_soluciones || '',
        manejo_medicamentos: nota?.manejo_medicamentos || '',
        manejo_medidas_generales: nota?.manejo_medidas_generales || '',
        manejo_laboratorios: nota?.manejo_laboratorios || '',

        pronostico: nota?.pronostico || '',
        hallazgos_importancia: nota?.hallazgos_importancia || '',
        transfusiones_agregadas: [] as TransfusionAgregada[],

        //Solicitud de pieza patologica 

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

    //MANEJO DEL TRATAMINETO POSTOPERATORIO

    const [dietaPreset, setDietaPreset] = useState<'ayuno'|'liquida'|'manual'|null>(null);
    const [horasDietaLiquida, setHorasDietaLiquida] = useState('');

    const handleSetDietaAyuno = () => {
        const texto = "Ayuno estricto.";
        setData('manejo_dieta', texto);
        setDietaPreset('ayuno');
        setHorasDietaLiquida(''); 
    };

    // Presiona "Dieta líquida"
    const handleSetDietaLiquida = () => {
        setDietaPreset('liquida');
        const horas = horasDietaLiquida || '__'; 
        const texto = `Iniciar dieta líquida progresar a blanda en cuanto tiempo ${horas} horas.`;
        setData('manejo_dieta', texto);
    };

    // Maneja el cambio en el input de "horas"
    const handleHorasChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const horas = e.target.value;
        setHorasDietaLiquida(horas);
        if (dietaPreset === 'liquida') {
            const texto = `Iniciar dieta líquida progresar a blanda en ${horas || '__'} horas.`;
            setData('manejo_dieta', texto);
        }
    };
    
    // Manual
    const handleDietaManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('manejo_dieta', e.target.value);
        setDietaPreset('manual'); 
        setHorasDietaLiquida('');
    };

    //Soluciones

    const solucionesOptions = soluciones.map(s => ({
        value: s.id.toString(),
        label: s.nombre_prestacion // Asumiendo que así se llama
    }));

    // 2. Estado local para los campos del constructor
    const [localSolucion, setLocalSolucion] = useState({
        solucion_id: '',
        solucion_nombre: '',
        cantidad: '', // ml
        duracion: '', // hrs
    });

    // 3. Cálculo de flujo en tiempo real
    const flujoCalculado = useMemo(() => {
        const cantidad = Number(localSolucion.cantidad);
        const duracion = Number(localSolucion.duracion);
        if (cantidad > 0 && duracion > 0) {
            return (cantidad / duracion).toFixed(2); // Retorna ej. "125.00"
        }
        return '0.00';
    }, [localSolucion.cantidad, localSolucion.duracion]);

    // 4. Manejador para el Select (guarda el nombre)
    const handleSolucionSelectChange = (value: string) => {
        const seleccionada = solucionesOptions.find(opt => opt.value === value);
        setLocalSolucion(d => ({
            ...d,
            solucion_id: value,
            solucion_nombre: seleccionada ? seleccionada.label : ''
        }));
    };

    // 5. Manejador para el botón "Agregar al Plan"
    const handleAddSolucion = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (!localSolucion.solucion_id || !localSolucion.cantidad || !localSolucion.duracion) {
            Swal.fire('Campos Incompletos', 'Debe seleccionar una solución, cantidad y duración.', 'error');
            return;
        }

        // Formatea la nueva línea de texto
        const nuevaLinea = `• ${localSolucion.solucion_nombre} ${localSolucion.cantidad}ml, para ${localSolucion.duracion} hrs (Flujo: ${flujoCalculado} ml/hr).`;

        // Añade la nueva línea al textarea 'manejo_soluciones'
        setData(currentData => ({
            ...currentData,
            // Añade un salto de línea si ya hay texto
            manejo_soluciones: currentData.manejo_soluciones 
                ? `${currentData.manejo_soluciones}\n${nuevaLinea}` 
                : nuevaLinea
        }));

        // Limpia el constructor
        setLocalSolucion({
            solucion_id: '',
            solucion_nombre: '',
            cantidad: '',
            duracion: '',
        });
    };

    // 6. Manejador para la escritura manual (igual que el de Dieta)
    const handleSolucionesManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('manejo_soluciones', e.target.value);
    };


    //MEDICAMNETOS

    const medicamentosOptions = medicamentos.map(m => ({
        value: m.id.toString(),
        label: m.nombre_prestacion
    }));
    
    const optionsGramaje = [
        {value: 'mililitros', label: 'Mililitros (ml)'},
        {value: 'gramos', label: 'Gramos (g)'},
        {value: 'miligramos', label: 'Miligramos (mg)'},
        {value: 'microgramos', label: 'Microgramos (mcg)'},
        {value: 'unidades internacionales', label: 'Unidades internacionales (ui)'},
        {value: 'gotas', label: 'Gotas'},
    ];

    const optionsUnidad = [
        { value: 'horas', label: 'Horas' },
        { value: 'minutos', label: 'Minutos'},
        { value: 'dosis unica', label: 'Dosis única'}
    ];
    
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

    // 2. Estado local para los campos del constructor
    const [localMedicamento, setLocalMedicamento] = useState({
        medicamento_id: '',
        medicamento_nombre: '',
        dosis: '',
        gramaje: '',
        via: '',
        via_label: '',
        duracion_tratamiento: '',
        unidad: 'horas', // Default a 'horas'
    });

    // 3. Manejadores para los Selects (para guardar el 'label')
    const handleMedicamentoSelectChange = (value: string) => {
        const sel = medicamentosOptions.find(o => o.value === value);
        setLocalMedicamento(d => ({
            ...d,
            medicamento_id: value,
            medicamento_nombre: sel ? sel.label : ''
        }));
    };

    const handleViaSelectChange = (value: string) => {
        const sel = opcionesViaMedicamento.find(o => o.value === value);
        setLocalMedicamento(d => ({
            ...d,
            via: value,
            via_label: sel ? sel.label : ''
        }));
    };

    // 4. Manejador para el botón "Agregar al Plan"
    const handleAddMedicamentoAlPlan = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        
        // Validación de campos
        const { medicamento_id, dosis, gramaje, via, unidad, duracion_tratamiento } = localMedicamento;
        if (!medicamento_id || !dosis || !gramaje || !via || !unidad) {
            Swal.fire('Campos Incompletos', 'Debe llenar todos los campos del medicamento (excepto duración si es dosis única).', 'error');
            return;
        }
        if (unidad !== 'dosis unica' && !duracion_tratamiento) {
            Swal.fire('Campos Incompletos', 'Debe especificar la duración/frecuencia.', 'error');
            return;
        }

        // Construir el texto
        let texto = `• ${localMedicamento.medicamento_nombre} ${localMedicamento.dosis} ${localMedicamento.gramaje}`;
        texto += `, ${localMedicamento.via_label}`;
        if (localMedicamento.unidad === 'dosis unica') {
            texto += ', Dosis única.';
        } else {
            texto += `, cada ${localMedicamento.duracion_tratamiento} ${localMedicamento.unidad}.`;
        }

        // Añadir al textarea principal
        setData(currentData => ({
            ...currentData,
            manejo_medicamentos: currentData.manejo_medicamentos
                ? `${currentData.manejo_medicamentos}\n${texto}`
                : texto
        }));

        // Limpiar el constructor
        setLocalMedicamento({
            medicamento_id: '',
            medicamento_nombre: '',
            dosis: '',
            gramaje: '',
            via: '',
            via_label: '',
            duracion_tratamiento: '',
            unidad: 'horas',
        });
    };

    // 5. Manejador para la escritura manual
    const handleMedicamentosManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('manejo_medicamentos', e.target.value);
    };

    //MEDIDAS GENERALES
    const [horasSignosVitales, setHorasSignosVitales] = useState('');

    const addMedidaAlPlan = (texto: string) => {
        // Añade un "• " (viñeta) al inicio de la línea
        const nuevaLinea = `• ${texto}`;

        setData(currentData => ({
            ...currentData,
            manejo_medidas_generales: currentData.manejo_medidas_generales
                ? `${currentData.manejo_medidas_generales}\n${nuevaLinea}` // Añade con salto de línea
                : nuevaLinea // Es la primera línea
        }));
    };

    // 2. Manejador para el botón "Agregar" del campo de horas
    const handleAddMedidaHoras = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        const horas = horasSignosVitales || '___'; // Usa un placeholder si está vacío
        addMedidaAlPlan(`Cuidados generales de enfermería y signos vitales cada ${horas} horas.`);
        setHorasSignosVitales(''); // Limpia el input
    };

    // 3. Manejador para la escritura manual (igual que los otros)
    const handleMedidasManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('manejo_medidas_generales', e.target.value);
    };

    // 4. Lista de presets estáticos
    const optionsMedidasGenerales = [
        'Posición semifowler.',
        'Reposo absoluto.',
        'Vigilancia de heridas quirúrgicas.',
        'Vigilancia y cuantificación de drenajes.',
        'Deambulación.',
        
    ];

    //LABORATORIOS Y GABINETES 
    const [localEstudio, setLocalEstudio] = useState({
        estudio_id: '',
        estudio_nombre: '',
    });

    const optionsEstudios = useMemo(() => {
        return estudios.map(estudio => ({
            value: estudio.id.toString(),
            label: `${estudio.nombre} (${estudio.departamento || estudio.tipo_estudio})`
        }));
    }, [estudios]);

    // 2. Manejador para el Select (guarda el nombre)
    const handleEstudioSelectChange = (value: string) => {
        const seleccionada = optionsEstudios.find(opt => opt.value === value);
        setLocalEstudio({
            estudio_id: value,
            estudio_nombre: seleccionada ? seleccionada.label : ''
        });
    };

    // 3. Manejador para el botón "Agregar al Plan"
    const handleAddEstudioAlPlan = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        if (!localEstudio.estudio_id) {
            Swal.fire('Sin selección', 'Debe seleccionar un estudio de la lista.', 'error');
            return;
        }

        const nuevaLinea = `• ${localEstudio.estudio_nombre}`;

        setData(currentData => ({
            ...currentData,
            manejo_laboratorios: currentData.manejo_laboratorios
                ? `${currentData.manejo_laboratorios}\n${nuevaLinea}`
                : nuevaLinea
        }));

        // Limpia el constructor
        setLocalEstudio({ estudio_id: '', estudio_nombre: '' });
    };

    // 4. Manejador para la escritura manual
    const handleLaboratoriosManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('manejo_laboratorios', e.target.value);
    };

    // PIEZAS PATOLOGICAS
    const [localPatologia, setLocalPatologia] = useState({
        estudio_solicitado: '',
        biopsia_pieza_quirurgica: '',
        revision_laminillas: '',
        estudios_especiales: '',
        pcr: '',
        pieza_remitida: '',
        datos_clinicos: '',
    });

    const handleAddPatologiaAlPlan = (e: React.MouseEvent<HTMLButtonElement>) => {
        e.preventDefault();
        
        const { estudio_solicitado, pieza_remitida } = localPatologia;

        if (!estudio_solicitado || !pieza_remitida ) {
            Swal.fire('Campos Incompletos', 'Debe especificar al menos "Estudio solicitado" y "Pieza remitida" .', 'error');
            return;
        }

        let texto = `• Estudio: ${estudio_solicitado}.`;
        texto += `\n  - Pieza Remitida: ${pieza_remitida}.`;

        if (localPatologia.datos_clinicos) texto += `\n - Datos clinicos: ${localPatologia.datos_clinicos}`;
        if (localPatologia.biopsia_pieza_quirurgica) texto += `\n  - Biopsia/Pieza: ${localPatologia.biopsia_pieza_quirurgica}.`;
        if (localPatologia.revision_laminillas) texto += `\n  - Revisión de laminillas: ${localPatologia.revision_laminillas}.`;
        if (localPatologia.estudios_especiales) texto += `\n  - Estudios especiales: ${localPatologia.estudios_especiales}.`;
        if (localPatologia.pcr) texto += `\n  - PCR: ${localPatologia.pcr}.`;

        setData(currentData => ({
            ...currentData,
            envio_piezas: currentData.envio_piezas 
                ? `${currentData.envio_piezas}\n\n${texto}` 
                : texto
        }));

        setLocalPatologia({
            estudio_solicitado: '',
            biopsia_pieza_quirurgica: '',
            revision_laminillas: '',
            estudios_especiales: '',
            pcr: '',
            pieza_remitida: '',
            datos_clinicos: '',
        });
    };

    const handleEnvioPiezasManualChange = (e: React.ChangeEvent<HTMLTextAreaElement>) => {
        setData('envio_piezas', e.target.value);
    };


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

                <div className="grid grid-cols-1 gap-6 mb-15 mt-15">
                    <InputTextArea
                        label="Estudios de servicios auxiliares de diagnóstico y tratamiento transoperatorios"
                        value={data.estudios_transoperatorios}
                        onChange={e => setData('estudios_transoperatorios', e.target.value)}
                        error={errors.estudios_transoperatorios}
                        rows={2}
                    />
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
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Plan de dieta
                            </label>
                            
                            <div className="flex flex-wrap gap-2 mb-2">
                                <button
                                    type="button"
                                    onClick={handleSetDietaAyuno}
                                    className={`text-xs px-3 py-1 rounded-full ${dietaPreset === 'ayuno' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                                >
                                    Ayuno estricto
                                </button>
                                <button
                                    type="button"
                                    onClick={handleSetDietaLiquida}
                                    className={`text-xs px-3 py-1 rounded-full ${dietaPreset === 'liquida' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'}`}
                                >
                                    Dieta líquida progresiva
                                </button>
                            </div>

                            {dietaPreset === 'liquida' && (
                                <div className="max-w-xs my-2">
                                    <InputText
                                        label="Iniciar en (horas)"
                                        type="number"
                                        id="horas_dieta_liquida"
                                        name="horas_dieta_liquida"
                                        value={horasDietaLiquida}
                                        onChange={handleHorasChange}
                                    />
                                </div>
                            )}

                            <InputTextArea
                                label="Descripción de la dieta (campo libre)"
                                value={data.manejo_dieta}
                                onChange={handleDietaManualChange} 
                                error={errors.manejo_dieta}
                                rows={4}
                            />
                        </div>
                    </div>
                            
                    <div>
                        <div>
                             <h4 className="text-md font-semibold mb-3 pt-4 border-t">Plan de soluciones</h4>
                            
                            {/* Constructor de soluciones */}
                            <div className="p-4 border rounded-lg bg-gray-50 space-y-4">
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                                    <SelectInput
                                        label="Solución"
                                        options={solucionesOptions}
                                        value={localSolucion.solucion_id}
                                        onChange={handleSolucionSelectChange}
                                        error={errors.manejo_soluciones} 
                                    />
                                    <InputText
                                        label="Cantidad (ml)"
                                        type="number"
                                        id="sol_cantidad"
                                        name="sol_cantidad"
                                        value={localSolucion.cantidad}
                                        onChange={e => setLocalSolucion(d => ({...d, cantidad: e.target.value}))}
                                    />
                                    <InputText
                                        label="Duración (hrs)"
                                        type="number"
                                        id="sol_duracion"
                                        name="sol_duracion"
                                        value={localSolucion.duracion}
                                        onChange={e => setLocalSolucion(d => ({...d, duracion: e.target.value}))}
                                    />
                                    <div className="flex flex-col">
                                        <label className="block text-sm font-medium text-gray-700">Flujo (calculado)</label>
                                        <span className="mt-1 p-2 border border-gray-300 rounded-md bg-gray-100 text-sm">
                                            {flujoCalculado} ml/hr
                                        </span>
                                    </div>
                                </div>
                                <div className="flex justify-end">
                                    <PrimaryButton type="button" onClick={handleAddSolucion}>
                                        + Agregar al plan
                                    </PrimaryButton>
                                </div>
                            </div>

                            <InputTextArea
                                label="Plan de soluciones (campo libre)"
                                value={data.manejo_soluciones}
                                onChange={handleSolucionesManualChange}
                                error={errors.manejo_soluciones}
                                rows={5}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <h4 className="text-md font-semibold mb-3 pt-4 border-t">Plan de medicamentos</h4>
                            
                            {/* Constructor de medicamentos */}
                            <div className="p-4 border rounded-lg bg-gray-50 space-y-4">

                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <SelectInput
                                        label="Medicamento (nombre)"
                                        options={medicamentosOptions} 
                                        value={localMedicamento.medicamento_id}
                                        onChange={handleMedicamentoSelectChange}
                                        error={errors.manejo_medicamentos}
                                    />
                                    <InputText 
                                        id="medicamento_dosis"
                                        name="dosis"
                                        label="Dosis" 
                                        type="number"
                                        value={localMedicamento.dosis} 
                                        onChange={e => setLocalMedicamento(d => ({...d, dosis: e.target.value}))} 
                                    />
                                    <SelectInput
                                        label="Gramaje"
                                        options={optionsGramaje}
                                        value={localMedicamento.gramaje}
                                        onChange={(value) => setLocalMedicamento(d => ({...d, gramaje: value as string}))}
                                    />
                                </div>
                                
                                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                    <SelectInput
                                        label="Vía de administración"
                                        options={opcionesViaMedicamento}
                                        value={localMedicamento.via}
                                        onChange={handleViaSelectChange}
                                    />

                                    {localMedicamento.unidad !== 'dosis unica' && (
                                        <InputText 
                                            id="duracion"
                                            name="duracion"
                                            label="Duración (frecuencia)" 
                                            type="number"
                                            value={localMedicamento.duracion_tratamiento}
                                            onChange={e => setLocalMedicamento(d => ({...d, duracion_tratamiento: e.target.value}))} 
                                        />
                                    )}

                                    <SelectInput
                                        label="Unidad"
                                        options={optionsUnidad}
                                        value={localMedicamento.unidad}
                                        onChange={(value) => setLocalMedicamento(d => ({...d, unidad: value as string}))}
                                    />
                                    
                                </div>
        
                                <div className="flex justify-end">
                                    <PrimaryButton type="button" onClick={handleAddMedicamentoAlPlan}>
                                        + Agregar al plan
                                    </PrimaryButton>
                                </div>
                            </div>

                            <InputTextArea
                                label="Plan de medicamentos (campo libre)"
                                value={data.manejo_medicamentos}
                                onChange={handleMedicamentosManualChange}
                                error={errors.manejo_medicamentos}
                                rows={5}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <h4 className="text-md font-semibold mb-3 pt-4 border-t">Plan de medidas generales</h4>

                            <div className="p-4 border rounded-lg bg-gray-50 space-y-4">
                                <h5 className="text-sm font-medium text-gray-700">Opciones (haga clic para agregar):</h5>

                                <div className="flex flex-wrap gap-2">
                                    {optionsMedidasGenerales.map((texto) => (
                                        <button
                                            type="button"
                                            key={texto}
                                            onClick={() => addMedidaAlPlan(texto)}
                                            className="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-800 hover:bg-gray-300"
                                        >
                                            + {texto}
                                        </button>
                                    ))}
                                </div>

                                {/* Constructor Dinámico (Horas) */}
                                <div className="flex items-end gap-2 pt-2 border-t">
                                    <div className="flex-1">
                                        <InputText
                                            label="Signos vitales cada (horas)"
                                            type="number"
                                            id="horas_signos_vitales"
                                            name="horas_signos_vitales"
                                            value={horasSignosVitales}
                                            onChange={e => setHorasSignosVitales(e.target.value)}
                                        />
                                    </div>
                                    <PrimaryButton type="button" onClick={handleAddMedidaHoras}>
                                        + Agregar
                                    </PrimaryButton>
                                </div>
                            </div>

                            <InputTextArea
                                label="Plan de medidas generales (campo libre)"
                                value={data.manejo_medidas_generales}
                                onChange={handleMedidasManualChange}
                                error={errors.manejo_medidas_generales}
                                rows={5}
                                className="mt-2"
                            />
                        </div>

                        <div className='mb-15'>
                            <h4 className="text-md font-semibold mb-3 pt-4 border-t">Plan de laboratorios y gabinetes</h4>
                            
                            <div className="p-4 border rounded-lg bg-gray-50 space-y-4">
                                <div className="flex items-end gap-2">
                                    <div className="flex-1">
                                        <SelectInput
                                            label="Seleccionar Estudio"
                                            options={optionsEstudios}
                                            value={localEstudio.estudio_id}
                                            onChange={handleEstudioSelectChange}
                                            error={errors.manejo_laboratorios}
                                        />
                                    </div>
                                    <PrimaryButton type="button" onClick={handleAddEstudioAlPlan}>
                                        + Agregar al plan
                                    </PrimaryButton>
                                </div>
                            </div>

                            <InputTextArea
                                label="Plan de laboratorios y gabinetes (campo libre)"
                                value={data.manejo_laboratorios}
                                onChange={handleLaboratoriosManualChange}
                                error={errors.manejo_laboratorios}
                                rows={5}
                                className="mt-2"
                            />
                        </div>

                    <InputTextArea
                        label="Pronóstico"
                        value={data.pronostico}
                        onChange={e => setData('pronostico', e.target.value)}
                        error={errors.pronostico}
                        rows={2}
                        className='mb-15'
                    />

                    <div className="mt-6 pt-6 border-t mb-15">
                        <h4 className="text-md font-semibold mb-3">Envío de piezas (patología)</h4>
                        
                        <div className="p-4 border rounded-lg bg-gray-50 space-y-4">                         
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <InputText
                                    label="Estudio solicitado"
                                    id='estudio_solicitado_local'
                                    name='estudio_solicitado_local'
                                    value={localPatologia.estudio_solicitado}
                                    onChange={e => setLocalPatologia(d => ({...d, estudio_solicitado: e.target.value}))}
                                    error={errors.envio_piezas}
                                />
                                <InputText
                                    label="Biopsia o pieza quirúrgica"
                                    id='biopsia_pieza_local'
                                    name='biopsia_pieza_local'
                                    value={localPatologia.biopsia_pieza_quirurgica}
                                    onChange={e => setLocalPatologia(d => ({...d, biopsia_pieza_quirurgica: e.target.value}))}
                                />
                                <InputText
                                    label="Revisión de laminillas"
                                    id='laminillas_local'
                                    name='laminillas_local'
                                    value={localPatologia.revision_laminillas}
                                    onChange={e => setLocalPatologia(d => ({...d, revision_laminillas: e.target.value}))}
                                />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <InputText
                                    label="Estudios especiales"
                                    id='estudios_especiales_local'
                                    name='estudios_especiales_local'
                                    value={localPatologia.estudios_especiales}
                                    onChange={e => setLocalPatologia(d => ({...d, estudios_especiales: e.target.value}))}
                                />
                                <InputText
                                    label="PCR"
                                    id='pcr_local'
                                    name='pcr_local'
                                    value={localPatologia.pcr}
                                    onChange={e => setLocalPatologia(d => ({...d, pcr: e.target.value}))}
                                />
                                <InputText
                                    label="Pieza remitida"
                                    id='pieza_remitida_local'
                                    name='pieza_remitida_local'
                                    value={localPatologia.pieza_remitida}
                                    onChange={e => setLocalPatologia(d => ({...d, pieza_remitida: e.target.value}))}
                                    error={errors.envio_piezas}
                                />

                                {/*
                                <InputText
                                    label='Empresa a enviar la pieza patologica'
                                    id='empresa_enviar'
                                    name='empresa_enviar'
                                    value={localPatologia.empresa_enviar}
                                    onChange={e => setLocalPatologia}
                                />
                                */}
                            </div>

                            <InputTextArea
                                label="Datos clínicos (anotar registro previo si existe)"
                                id="datos_clinicos_local"
                                name="datos_clinicos_local"
                                value={localPatologia.datos_clinicos}
                                onChange={e => setLocalPatologia(d => ({...d, datos_clinicos: e.target.value}))}
                                error={errors.envio_piezas}
                                rows={3}
                            />

                            <div className="flex justify-end">
                                <PrimaryButton type="button" onClick={handleAddPatologiaAlPlan}>
                                    + Agregar al plan de envío
                                </PrimaryButton>
                            </div>
                        </div>

                        <InputTextArea
                            label="Plan de envío de piezas"
                            value={data.envio_piezas}
                            onChange={handleEnvioPiezasManualChange}
                            error={errors.envio_piezas}
                            rows={6}
                            className="mt-2"
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
    return (
        <MainLayout pageTitle="Creación nota postoperatoria" children={page}/>
    )
}

export default NotaPostoperatoriaForm;