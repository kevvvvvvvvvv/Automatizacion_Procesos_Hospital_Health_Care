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


export interface Estancia {
    id: number;
    folio: string;
    fecha_ingreso: string;
    fecha_egreso: string | null; 
    num_habitacion: string | null;
    tipo_estancia: 'Hospitalizacion' | 'Interconsulta';
    modalidad_ingreso: string;
}

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
    nombre_formulario: string;
    nombre_tabla_fisica: string;
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