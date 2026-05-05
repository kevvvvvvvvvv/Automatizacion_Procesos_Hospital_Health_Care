import MainLayout from "@/layouts/MainLayout";
import { Head, useForm} from '@inertiajs/react';
import { useEffect } from "react";
import PacienteCard from "@/components/paciente-card";
import BooleanInput from "@/components/ui/input-boolean";
import InputText from "@/components/ui/input-text";
import { CirugiaSegura, Estancia, FormularioInstancia, Paciente } from "@/types";
import { route } from "ziggy-js";
import FormLayout from "@/components/form-layout";
import PrimaryButton from "@/components/ui/primary-button";

interface Props {
    paciente: Paciente;
    estancia: Estancia;
    cirugia: CirugiaSegura;
    formulario: FormularioInstancia;
    submitLabel?: string;
}

const Create = ({ submitLabel = "Guardar", paciente, estancia, cirugia }: Props) => {
    const form = useForm({
        servicio_procedencia: cirugia?.servicio_procedencia || '',
        cirugia_programada: cirugia?.cirugia_programada || '',
        cirugia_realizada: cirugia?.cirugia_realizada || '',
        grupo_rh: cirugia?.grupo_rh || '',
        confirmar_indentidad: cirugia?.confirmar_indentidad ?? false,
        sitio_quirurgico: cirugia?.sitio_quirurgico ?? false,
        funcionamiento_aparatos: cirugia?.funcionamiento_aparatos ?? false,
        oximetro: cirugia?.oximetro ?? false,
        alergias: cirugia?.alergias || '',
        via_aerea: cirugia?.via_aerea ?? false,
        riesgo_hemorragia: cirugia?.riesgo_hemorragia ?? false,
        hemoderivados: cirugia?.hemoderivados ?? false,
        profilaxis: cirugia?.profilaxis ?? false,
        miembros_equipo: cirugia?.miembros_equipo ?? false,
        indentidad_paciente: cirugia?.indentidad_paciente ?? false,
        pasos_criticos: cirugia?.pasos_criticos || '',
        tiempo_aproximado: cirugia?.tiempo_aproximado || null,
        perdida_sanguinea: cirugia?.perdida_sanguinea || '',
        revision_anestesiologo: cirugia?.revision_anestesiologo ?? false,
        esterilizacion: cirugia?.esterilizacion ?? false,
        dudas_problemas: cirugia?.dudas_problemas ?? false,
        imagenes_diagnosticas: cirugia?.imagenes_diagnosticas ?? false,
        nombre_procedimiento: cirugia?.nombre_procedimiento ?? false,
        recuento_instrumentos: cirugia?.recuento_instrumentos ?? false,
        faltantes: cirugia?.faltantes ?? false,
        observaciones: cirugia?.observaciones || '',
        etiquetado_muestras: cirugia?.etiquetado_muestras ?? false,
        aspectos_criticos: cirugia?.aspectos_criticos || ''
    });
    

    const { data, setData, post, processing, errors } = form;
    useEffect(() => {
    if (Object.keys(errors).length > 0) {
        console.log("Errores de validación detectados:", errors);
    }
}, [errors]);
    const handleSubmit = (e: React.FormEvent) => {
        // Asegúrate de poner el nombre de tu ruta aquí, ej: 'cirugia.store'
        
        e.preventDefault();
        post(route('pacientes.estancias.cirugiasegura.store', {
            paciente: paciente.id,
            estancia: estancia.id
        }));
    }

    return (
        <MainLayout
            pageTitle={"Lista de verificación de cirugía segura"}
            link="estancias.show"
            linkParams={estancia.id}>
            
            <Head title="Cirugía Segura" />
            
            <PacienteCard paciente={paciente} estancia={estancia} />

            <FormLayout
                title="Formulario de Verificación"
                onSubmit={handleSubmit}
                actions={
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : submitLabel}
                    </PrimaryButton>
                }>
                
                {/* SECCIÓN 1: DATOS GENERALES */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-6">
                    <InputText
                        id="servicio_procedencia"
                        name="servicio_procedencia"
                        label="Servicio de procedencia"
                        value={data.servicio_procedencia ?? ''}
                        onChange={(e) => setData('servicio_procedencia', e.target.value)}
                        error={errors.servicio_procedencia}
                    />
                    <InputText
                        id="grupo_rh"
                        name="grupo_rh"
                        label="Grupo sanguíneo y RH"
                        value={data.grupo_rh  ?? ''}
                        onChange={(e) => setData('grupo_rh', e.target.value)}
                        error={errors.grupo_rh}
                    />
                    <InputText
                        id="cirugia_programada"
                        name="cirugia_programada"
                        label="Cirugía programada"
                        value={data.cirugia_programada ?? ''}
                        onChange={(e) => setData('cirugia_programada', e.target.value)}
                        error={errors.cirugia_programada}
                    />
                    <InputText
                        id="cirugia_realizada"
                        name="cirugia_realizada"
                        label="Cirugía realizada"
                        value={data.cirugia_realizada ?? ''}
                        onChange={(e) => setData('cirugia_realizada', e.target.value)}
                        error={errors.cirugia_realizada}
                    />
                </div>

                {/* SECCIÓN 2: ENTRADA (Antes de la inducción de la anestesia) */}
                <h3 className="text-lg font-bold text-black-700 mt-6 mb-4">Al ingresar paciente a sala, antes (Personal de enfermería, anestesiólogo y cirujano)</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <BooleanInput
                        label="¿En presencia del paciente se ha cofirmado su indentidad, sitio quirúrgico, procedumiento y ayuno?"
                        value={data.confirmar_indentidad ?? ''}
                        onChange={(val) => setData('confirmar_indentidad', val)}
                        error={errors.confirmar_indentidad}
                    />
                    <BooleanInput
                        label="¿Se marco el sitio quirúrgico?"
                        value={data.sitio_quirurgico ?? ''}
                        onChange={(val) => setData('sitio_quirurgico', val)}
                        error={errors.sitio_quirurgico}
                    />
                    <BooleanInput
                        label="¿Se ha comprado el funcionamiento de los aparatos de anestesia y medicamentos existentes?"
                        value={data.funcionamiento_aparatos ?? ''}
                        onChange={(val) => setData('funcionamiento_aparatos', val)}
                        error={errors.funcionamiento_aparatos}
                    />
                    <BooleanInput
                        label="¿Se ha colocado el oximetro de pulso al paciente y funciona?"
                        value={data.oximetro ?? ''}
                        onChange={(val) => setData('oximetro', val)}
                        error={errors.oximetro}
                    />
                    {/* alergias */} 
                    <div className="mt-6">
                        <InputText
                            id="alergias"
                            name="alergias"
                            label="¿Tiene el paciente alergias conocidas?"
                            value={data.alergias ?? ''}
                            onChange={(e) => setData('alergias', e.target.value)}
                            error={errors.alergias}
                       />
                    </div>

                    <BooleanInput
                        label="¿Vía aérea dificil y/o riesgo de aspiración? (Se cuenta con material, equipo y ayuda disponible)"
                        value={data.via_aerea ?? ''} // Ajusta el label según tu necesidad
                        onChange={(val) => setData('via_aerea', val)}
                        error={errors.via_aerea}
                    />
                    <BooleanInput
                        label="¿Riesgo de hemorragia en adulto >500ml. (niños > 7 ml/kg)? (Se ha previsto la disponibilidad de liquidos y dos vías centrales)"
                        value={data.riesgo_hemorragia ?? ''}
                        onChange={(val) => setData('riesgo_hemorragia', val)}
                        error={errors.riesgo_hemorragia}
                    />
                    <BooleanInput
                        label="¿Posible necesidad de Hemoderivados y soluciones disponibles? (Se ha realizado el cruce de sangre previamente)"
                        value={data.hemoderivados ?? ''}
                        onChange={(val) => setData('hemoderivados', val)}
                        error={errors.hemoderivados}
                    />
                    <BooleanInput
                        label="¿Se ha administrado profilaxis antibiótica (últimos 60 min)?"
                        value={data.profilaxis ?? ''}
                        onChange={(val) => setData('profilaxis', val)}
                        error={errors.profilaxis}
                    />
                </div>

                {/* SECCIÓN 3: PAUSA QUIRÚRGICA (Antes de la incisión cutánea) */}
                <h3 className="text-lg font-bold text-black-00 mt-8 mb-4">Antes de incidir piel (Personal de enfermeria, anestesiologo y cirujano)</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <BooleanInput
                        label="Se han presentado todos los miembros del equipo por su nombre y funcion"
                        value={data.miembros_equipo ?? ''}
                        onChange={(val) => setData('miembros_equipo', val)}
                        error={errors.miembros_equipo}
                    />
                    <BooleanInput
                        label="¿Confirmar identidad del paciente, sitio y procedimiento?"
                        value={data.indentidad_paciente ?? ''}
                        onChange={(val) => setData('indentidad_paciente', val)}
                        error={errors.indentidad_paciente}
                    />
                   
                   
                </div>
                
                <div className="mt-4">
                    <InputText
                        id="pasos_criticos"
                        name="pasos_criticos"
                        label="¿Cúales serán los pasos criticos o no sistematizados?"
                        value={data.pasos_criticos ?? ''}
                        onChange={(e) => setData('pasos_criticos', e.target.value)}
                        error={errors.pasos_criticos}
                    />
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <InputText
                        id = "tiempo_aproximado"
                        name="tiempo_aproximado"
                        type="number"
                        label="Tiempo aproximado de cirugía (min)"
                        value={data.tiempo_aproximado ?? ''}
                        onChange={(e) => setData('tiempo_aproximado', e.target.value)}
                        error={errors.tiempo_aproximado}
                    />
                    <InputText
                        id = "perdida_sanguinea"
                        name="perdida_sanguinea"
                        type="number"
                        label="Perdida sanguínea prevista (ml)"
                        value={data.perdida_sanguinea ?? ''}
                        onChange={(e) => setData('perdida_sanguinea', e.target.value)}
                        error={errors.perdida_sanguinea}
                    />
                    <BooleanInput
                        label="¿Anestesiólogo revisa si el paciente presenta alguna morbilidad?"
                        value={data.revision_anestesiologo ?? ''}
                        onChange={(val) => setData('revision_anestesiologo', val)}
                        error={errors.revision_anestesiologo}
                    />
                    <BooleanInput
                        label="¿Equipo de enfermería ha confirmado la esterilización del instrumental, ropa quirúrgica y consumibles?"
                        value={data.esterilizacion ?? ''}
                        onChange={(val) => setData('esterilizacion', val)}
                        error={errors.esterilizacion}
                    />
                    
                    <BooleanInput
                        label="¿Existen dudas o problemas relacionados con el instrumental y los equipos?"
                        value={data.dudas_problemas ?? ''}
                        onChange={(val) => setData('dudas_problemas', val)}
                        error={errors.dudas_problemas}
                    />
                    <BooleanInput
                        label="¿Se pueden visualizar las imagenes diagnosticas esenciales?"
                        value={data.imagenes_diagnosticas ?? ''}
                        onChange={(val) => setData('imagenes_diagnosticas', val)}
                        error={errors.imagenes_diagnosticas}
                    />
                    </div>

                </div>

                {/* SECCIÓN 4: SALIDA (Antes de que el paciente salga del quirófano) */}
                <h3 className="text-lg font-bold text-black-700 mt-8 mb-4">Antes de que el paciente salga de la sala quirúrgica (Personal de enfermería, anestesiólogo y cirujano)</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8">
                    <BooleanInput
                        label="El personal de enfermería confirma verbalmente nombre del procedimiento realizado"
                        value={data.nombre_procedimiento ?? ''}
                        onChange={(val) => setData('nombre_procedimiento', val)}
                        error={errors.nombre_procedimiento}
                    />
                    <BooleanInput
                        label="Se realizó el recuento de instrumentos, agujas y textiles completos"
                        value={data.recuento_instrumentos ?? ''}
                        onChange={(val) => setData('recuento_instrumentos', val)}
                        error={errors.recuento_instrumentos}
                    />
                    <BooleanInput
                        label="¿Existen faltantes de instrumentos y/o textiles?"
                        value={data.faltantes}
                        onChange={(val) => setData('faltantes', val)}
                        error={errors.faltantes} // <--- AÑADE ESTO
                    />
                    <div className="mt-6">
                        <InputText
                            id="observaciones"
                            name="observaciones"
                            label="Observaciones"
                            value={data.observaciones ?? ''}
                            onChange={(e) => setData('observaciones', e.target.value)}
                            error={errors.observaciones}
                        />
                    </div>
                    <BooleanInput
                        label="Se efectuó el etiquetado de muestras con lectura en voz alta, incluyendo el nombre del paciente, cirujano, anestesiólogo y personal de enfermería"
                        value={data.etiquetado_muestras ?? ''}
                        onChange={(val) => setData('etiquetado_muestras', val)}
                        error={errors.etiquetado_muestras}
                    />
                    <div className="mt-6">
                        <InputText
                            id="aspectos_criticos"
                            name="aspectos_criticos"
                            label="¿Cuáles son los aspectos críticos de la recuperación y el tratamiento del paciente en el posoperatorio inmediato?"
                            value={data.aspectos_criticos ?? ''}
                            onChange={(e) => setData('aspectos_criticos', e.target.value)}
                            error={errors.aspectos_criticos}
                        />
                    </div>

                </div>

               

            </FormLayout>
        </MainLayout>
    );
}

export default Create;