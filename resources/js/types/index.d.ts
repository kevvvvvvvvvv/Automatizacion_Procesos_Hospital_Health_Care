import { InertiaLinkProps, PageProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

/*export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; 
}*/

export interface Paciente {
    id: number;
    curp: string;
    nombre: string;
    apellido_paterno: string;
    apellido_materno: string;
    sexo: string;
    fecha_nacimiento: string;
    calle: string;
    numero_exterior: string;
    numero_interior: string | null;
    colonia: string;
    municipio: string;
    estado: string;
    pais: string;
    cp: string;
    telefono: string;
    estado_civil: string;
    ocupacion: string;
    lugar_origen: string;
    nombre_padre: string;
    nombre_madre: string;
    estancias: Estancia[];
    age: number;
}

export interface User {
  id: number;
  curp: string;
  nombre: string;
  apellido_paterno: string;
  apellido_materno: string;
  sexo: 'Masculino' | 'Femenino';
  fecha_nacimiento: string; 
  colaborador_responsable_id: number | null;
  email: string;
  created_at: string; 
  updated_at: string;
};

export interface FormularioCatalogo {
    id: number;
    nombre_formulario: string;
    nombre_tabla_fisica: string;
    route_prefix: string;
}

export interface FamiliarResponsable {
    id: number;
    parentesco: string;
    nombre_completo:string;
    paciente_id: number;
}

export interface Habitacion {
    id: number;
    identificador: string;
    piso: string,
    estado: 'Ocupado' | 'Libre',
    estancia_activa?: { 
        paciente?: {
        id: number;
        nombre: string;
        apellido_paterno: string;
        apellido_materno: string;
        };
    };
}

export interface Estancia {
    id: number;
    folio: string;
    fecha_ingreso: string;
    fecha_egreso: string | null; 
    tipo_estancia: 'Hospitalizacion' | 'Interconsulta';
    modalidad_ingreso: string;
    tipo_ingreso: string;
    
    paciente_id : number;
    habitacion_id: number | null;
    familiar_responsable_id: number | null;
    estancia_anterior_id: number | null;

    hoja_sondas_cateters: HojaSondaCateter[];

    paciente?: Paiente;

    created_at: string;
    updated_at: string | null;
    created_by: number;
    updated_by: number | null;
}

export interface FormularioInstancia {
    id: number;
    fecha_hora: string; 
    estancia_id: number;
    formulario_catalogo_id: number;
    user_id: number;
    created_at: string;
    updated_at: string;
}

export interface ProductoServicio {
    id: number;
    tipo: string;
    subtipo: string;
    codigo_prestacion: string;
    nombre_prestacion: string;
    importe: number;
    cantidad: number | null;
}

export interface HistoryEntry {
    id: number;
    action: string;
    user_name: string;
    model_name: string;
    model_id: number;
    before: Record<string, unknown> | null;
    after: Record<string, unkonwn> | null;
    created_at: string;
}

export interface PaginatedResponse<T> {
    data: T[];
    links: {
        first: string;
        last: string;
        prev: string | null;
        next: string | null;
    };

    current_page: number;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface Venta{
    id: number;
    fecha: string;
    subtotal: number;
    total: number;
    descuento: number;
    estado: string;
    estancia_id: number;
    user_id: number;
    created_at: string;
    updated_at: string;
    user: User | null;
    detalles?: DetalleVenta[];
}

export interface DetalleVenta{
    id: number;
    precio_unitario: number;
    cantidad: number;
    subtotal: number;
    descuento: number;
    estado: string;
    venta_id: number;
    producto_servicio_id: number;
    created_at: string;
    updated_at: string;
    producto_servicio?: ProductoServicio;
}

export interface HojaEnfermeria {
    id: number;
    turno: string;
    observaciones: string | null;
    estado: string;
    created_at: string;
    updated_at: string;
    hojas_terapia_i_v: HojaTerapiaIV[] | null; 
    hoja_medicamentos: HojaMedicamento[] | null;
    hoja_signos: HojaSignos[] | null;
    solicitud_dietas: SolicitudDieta[] | null;
}

export interface HojaTerapia {
    id: number;
    hoja_enfermeria_id: number;
    solucion: ProductoServicio;
    flujo_ml_hora: number;
    fecha_hora_inicio: string;
    created_at: string;
    updated_at: string;
}

export interface HojaSignos {
    id: number;
    hoja_enfermeria_id: number;
    fecha_hora_registro: string;
    tension_arterial_sistolica: number | null;
    tension_arterial_diastolica: number | null;
    frecuencia_cardiaca: number | null;
    frecuencia_respiratoria: number | null;
    temperatura: number | null;
    saturacion_oxigeno: number | null;
    glucemia_capilar: number | null;
    talla: number | null;
    peso: number | null;
    uresis: number | null;
    uresis_descripcion: string | null;
    evacuaciones: number | null;
    evacuaciones_descripcion: string | null;
    emesis: number | null;
    emesis_descripcion: string | null;
    drenes: number | null;
    drenes_descripcion: string | null;
    estado_conciencia: string | null;
    escala_braden: string | null;
    escala_glasgow: string | null;
    escala_eva: string | null;
    created_at: string;
    updated_at: string;
}

export interface HojaSignosGraficas {
    fecha_hora_registro: string;
    tension_arterial_sistolica: number | null;
    tension_arterial_diastolica: number | null;
    frecuencia_cardiaca: number | null;
    frecuencia_respiratoria: number | null;
    temperatura: number | null;
    saturacion_oxigeno: number | null;
    glucemia_capilar: number | null;
    estado_conciencia: string | null;
}

export interface HojaMedicamento {
    id: number;
    hoja_enfermeria_id: number;
    producto_servicio_id: number;
    dosis: number;
    gramaje:string;
    via_administracion: string;
    duracion_tratamiento: number;
    unidad: string;
    fecha_hora_inicio: string;
    estado: string;
    fecha_hora_solicitud: string;
    fecha_hora_surtido_farmacia: string;
    farmaceutico_id: number;
    fecha_hora_recibido_enfermeria: srting;
    producto_servicio?: ProductoServicio;
    aplicaciones: AplicacionMedicamento[];
}

export interface NotificationData {
    message: string;
    paciente_id?: number;
    paciente_nombre?: string;
    meds_count?: number;
    hoja_id?: number;
    [key: string]: any; 
}

export interface LaravelNotification {
    id: string;
    type: string;
    data: NotificationData; 
    read_at: string | null;
    created_at: string;
}

export interface SharedProps extends PageProps {
    [key: string]: unknown;
    auth: {
        user: User & {
            notifications: LaravelNotification[];
        };
    };
    ziggy: any;
    flash: {
        success?: string;
        error?: string;
    };
}

export interface HojaSondaCateter {
    id: number;
    tipo_dispositivo: string;
    calibre: string;
    fecha_instalacion: string;
    fecha_caducidad: string;
    user_id: number;
    observaciones: string;
    user: User;
    estancia: Estancia;
}

export interface Honorarios{
    id: number
    interconsulta_id: number;
    monto: number;
    descripcion: string | null;
    created_at: string;
    updated_at: string;
}
export interface Interconsulta{
    id:number;
    criterio_diagnostico:string;
    plan_de_estudio:string;
    sugerencia_diagnostica:string;
    resumen_del_interrogatorio:string;
    exploracion_fisica:string;
    estado_mental:string;
    resultados_relevantes_del_estudio_diagnostico:string;
    tratamiento_y_pronostico:string;
    motivo_de_la_atencion_o_interconsulta:string;
    diagnostico_o_problemas_clinicos:StringIterator;
    fc:number;
    fr:number;
    temp:number;
    peso:number;
    talla:number;
    ta:number;
}
export interface Traslado{
    id:number;
    unidad_medica_envia:String;
    unidad_medica_recibe:String;
    motivo_translado:String;
    impresion_diagnostica:String;
    terapeutica_empleada: string | null;
}
export interface AplicacionMedicamento {
    id: number;
    hoja_medicamento_id: number;
    fecha_aplicacion: string; 
    user_id: number | null;
    created_at: string;
}

export interface CatalogoEstudio {
    id: number;
    codigo: number;
    nombre: string;
    tipo_estudio: string;
    departamento: string | null;
    tiempo_entrega: number;
    costo: number; 
    created_at: string;
    updated_at: string;
}

export interface SolicitudItem {
    id: number;
    solicitud_estudio_id: number;
    catalogo_estudio_id: number;
    user_realiza_id: number | null;
    estado: string;
    resultados: string | null;
    created_at: string;
    updated_at: string;
    catalogo_estudio?: CatalogoEstudio;
    user_realiza?: User;
}

export interface SolicitudEstudio {
    id: number;
    user_solicita_id: number;
    user_llena_id: number;
    problemas_clinicos: string | null;
    incidentes_accidentes: string | null;
    resultado: string | null; 
    created_at: string;
    updated_at: string;
    user_solicita?: User;
    user_llena?: User;
    solicitud_items?: SolicitudItem[]; 
}

export interface SolicitudDieta {
    id: number;
    hoja_enfermeria_id: number;
    tipo_dieta: string;
    opcion_seleccionada: string;
    horario_solicitud: string;
    user_supervisa_id: number;
    horario_entrega: string;
    user_entrega_id: number;

    horario_operacion: string;
    horario_termino: string;
    horario_inicio_dieta:string;

    user_supervisa?: User; 
}

export interface Preoperatoria {
    id: number;
    
    fecha_cirugia: string;
    diagnostico_preoperatorio: string;
    plan_quirurgico: string;
    tipo_intervencion_quirurgica: string;
    riesgo_quirurgico: string | null;
    observaciones_riesgo: string|null;
    cuidados_plan_preoperatorios: string | null;
    pronostico: string | null;
    
    
}

 export interface HojaPostoperatoria {
    id: number;
    hora_inicio_operacion: string; 
    hora_termino_operacion: string; 

    diagnostico_preoperatorio: string | null; 
    operacion_planeada: string | null;
    operacion_realizada: string | null;
    diagnostico_postoperatorio: string | null;

    descripcion_tecnica_quirurgica: string | null;
    hallazgos_transoperatorios: string | null;

    reporte_conteo: string | null;
    incidentes_accidentes: string | null;
    cuantificacion_sangrado: string | null;
    estudios_transoperatorios: string | null;

    ayudantes: string | null;
    envio_piezas: string | null;
    
    estado_postquirurgico: string | null;
    manejo_tratamiento: string | null; 
    pronostico: string | null;
    hallazgos_importancia: string | null;

    created_at: string;
    updated_at: string;
}

