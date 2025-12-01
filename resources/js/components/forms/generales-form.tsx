import React from 'react';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

// Componentes UI
import PrimaryButton from '@/components/ui/primary-button';
// IMPORTAMOS TU COMPONENTE EXISTENTE
import ContadorTiempo from '@/components/counter-time'; 

// Define la interfaz de la hoja para estos campos
interface HojaQuirofano {
    id: number;
    hora_ingreso_quirofano?: string | null;
    hora_inicio_anestesia?: string | null;
    hora_inicio_cirugia?: string | null;
}

interface Props {
    hoja: HojaQuirofano;
}

const TiemposQuirofanoForm: React.FC<Props> = ({ hoja }) => {

    // Función para registrar el tiempo actual (PATCH inmediato)
    const handleRegistrarTiempo = (campo: string, etiqueta: string) => {
        
        const now_iso = new Date().toISOString();

        router.patch(route('hojasquirofano.update', { hoja: hoja.id }), {
            [campo]: now_iso
        }, {
            preserveScroll: true,
            onSuccess: () => {
                // Opcional: Feedback visual sutil
            },
            onError: (errors) => {
                Swal.fire('Error', `No se pudo registrar ${etiqueta}: ` + JSON.stringify(errors), 'error');
            }
        });
    };

    // Función para reiniciar/borrar el tiempo (en caso de error)
    const handleResetTiempo = (campo: string) => {
        Swal.fire({
            title: '¿Reiniciar tiempo?',
            text: "Se borrará la hora registrada y el cronómetro se detendrá.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, borrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                router.patch(route('hojasquirofano.update', { hoja: hoja.id }), {
                    [campo]: null // Enviamos null para borrar
                }, { preserveScroll: true });
            }
        });
    }

    // Función auxiliar para mostrar la hora estática (ej: 14:30)
    const formatTimeStatic = (isoString: string) => {
        return new Date(isoString).toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
    };

    return (
        <div className="bg-white p-6 rounded-lg shadow-sm border mb-6">
            <h3 className="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                Control de Tiempos Quirúrgicos
            </h3>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {/* --- 1. TARJETA: INGRESO A QUIRÓFANO --- */}
                <div className={`flex flex-col items-center p-4 border rounded-lg transition-colors ${hoja.hora_ingreso_quirofano ? 'bg-blue-50 border-blue-200' : 'bg-gray-50'}`}>
                    <h4 className="font-bold text-gray-700 mb-3">Ingreso a Quirófano</h4>
                    
                    {hoja.hora_ingreso_quirofano ? (
                        <div className="flex flex-col items-center gap-2 w-full animate-fade-in">
                            {/* Hora estática */}
                            <div className="text-sm text-gray-600">
                                Hora registro: <strong>{formatTimeStatic(hoja.hora_ingreso_quirofano)}</strong>
                            </div>
                            
                            {/* TU COMPONENTE DE CONTADOR */}
                            <div className="text-2xl my-2">
                                <ContadorTiempo 
                                    fechaInicioISO={hoja.hora_ingreso_quirofano} 
                                    fechaFinISO={null} // Null para que siga contando "en vivo"
                                />
                            </div>

                             <button 
                                type="button"
                                onClick={() => handleResetTiempo('hora_ingreso_quirofano')}
                                className="text-xs text-red-400 hover:text-red-600 underline mt-1"
                            >
                                Corregir / Reiniciar
                            </button>
                        </div>
                    ) : (
                        <PrimaryButton 
                            type="button"
                            onClick={() => handleRegistrarTiempo('hora_ingreso_quirofano', 'Ingreso a Quirófano')}
                            className="w-full justify-center py-4 text-lg"
                        >
                            Registrar Ingreso
                        </PrimaryButton>
                    )}
                </div>

                {/* --- 2. TARJETA: INICIO DE ANESTESIA --- */}
                <div className={`flex flex-col items-center p-4 border rounded-lg transition-colors ${hoja.hora_inicio_anestesia ? 'bg-green-50 border-green-200' : 'bg-gray-50'}`}>
                    <h4 className="font-bold text-gray-700 mb-3">Inicio de Anestesia</h4>
                    
                    {hoja.hora_inicio_anestesia ? (
                        <div className="flex flex-col items-center gap-2 w-full animate-fade-in">
                            <div className="text-sm text-gray-600">
                                Hora registro: <strong>{formatTimeStatic(hoja.hora_inicio_anestesia)}</strong>
                            </div>
                            
                            <div className="text-2xl my-2">
                                <ContadorTiempo 
                                    fechaInicioISO={hoja.hora_inicio_anestesia} 
                                    fechaFinISO={null} 
                                />
                            </div>

                            <button 
                                type="button"
                                onClick={() => handleResetTiempo('hora_inicio_anestesia')}
                                className="text-xs text-red-400 hover:text-red-600 underline mt-1"
                            >
                                Corregir / Reiniciar
                            </button>
                        </div>
                    ) : (
                        <div className="w-full">
                            <PrimaryButton 
                                type="button"
                                onClick={() => handleRegistrarTiempo('hora_inicio_anestesia', 'Inicio de Anestesia')}
                                // Opcional: Deshabilitar si no hay ingreso previo
                                disabled={!hoja.hora_ingreso_quirofano} 
                                className="w-full justify-center py-4 text-lg bg-green-600 hover:bg-green-700 disabled:bg-gray-300"
                            >
                                Iniciar Anestesia
                            </PrimaryButton>
                            {!hoja.hora_ingreso_quirofano && (
                                <p className="text-xs text-center text-gray-400 mt-2">Requiere ingreso previo</p>
                            )}
                        </div>
                    )}
                </div>

                {/* --- 3. TARJETA: INICIO DE CIRUGÍA --- */}
                <div className={`flex flex-col items-center p-4 border rounded-lg transition-colors ${hoja.hora_inicio_cirugia ? 'bg-red-50 border-red-200' : 'bg-gray-50'}`}>
                    <h4 className="font-bold text-gray-700 mb-3">Inicio de Cirugía</h4>
                    
                    {hoja.hora_inicio_cirugia ? (
                        <div className="flex flex-col items-center gap-2 w-full animate-fade-in">
                            <div className="text-sm text-gray-600">
                                Hora registro: <strong>{formatTimeStatic(hoja.hora_inicio_cirugia)}</strong>
                            </div>
                            
                            <div className="text-2xl my-2">
                                <ContadorTiempo 
                                    fechaInicioISO={hoja.hora_inicio_cirugia} 
                                    fechaFinISO={null} 
                                />
                            </div>

                            <button 
                                type="button"
                                onClick={() => handleResetTiempo('hora_inicio_cirugia')}
                                className="text-xs text-red-400 hover:text-red-600 underline mt-1"
                            >
                                Corregir / Reiniciar
                            </button>
                        </div>
                    ) : (
                        <div className="w-full">
                            <PrimaryButton 
                                type="button"
                                onClick={() => handleRegistrarTiempo('hora_inicio_cirugia', 'Inicio de Cirugía')}
                                disabled={!hoja.hora_inicio_anestesia}
                                className="w-full justify-center py-4 text-lg bg-red-600 hover:bg-red-700 disabled:bg-gray-300"
                            >
                                Iniciar Cirugía
                            </PrimaryButton>
                            {!hoja.hora_inicio_anestesia && (
                                <p className="text-xs text-center text-gray-400 mt-2">Requiere anestesia previa</p>
                            )}
                        </div>
                    )}
                </div>

            </div>
        </div>
    );
};

export default TiemposQuirofanoForm;