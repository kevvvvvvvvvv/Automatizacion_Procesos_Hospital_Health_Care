export const MORPH_MAP = {
    HOJA_ENFERMERIA: 'App\\Models\\Formulario\\HojaEnfermeria\\HojaEnfermeria',
    SOLICITUD_ESTUDIO: 'App\\Models\\SolicitudEstudio',
    PACIENTE: 'App\\Models\\Paciente',
} as const;

export type MorphType = typeof MORPH_MAP[keyof typeof MORPH_MAP];