import { InertiaLinkProps } from '@inertiajs/react';
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
}