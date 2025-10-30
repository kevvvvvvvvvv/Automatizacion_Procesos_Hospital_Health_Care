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
    fecha_hora_inicio: string;
    estado: string;
    fecha_hora_solicitud: string;
    fecha_hora_surtido_farmacia: string;
    farmaceutico_id: number;
    fecha_hora_recibido_enfermeria: srting;
    producto_servicio?: ProductoServicio;
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