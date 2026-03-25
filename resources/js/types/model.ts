export const MORPH_MAP = {
    HOJA_ENFERMERIA: 'App\\Models\\Formulario\\HojaEnfermeria\\HojaEnfermeria',
    HOJA_ENFERMERIA_QUIROFANO: 'App\\Models\\Formulario\\HojaEnfermeriaQuirofano\\HojaEnfermeriaQuirofano',
    SOLICITUD_ESTUDIO: 'App\\Models\\SolicitudEstudio',
    PACIENTE: 'App\\Models\\Paciente',

} as const;

export type MorphType = typeof MORPH_MAP[keyof typeof MORPH_MAP];