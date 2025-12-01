import React from 'react';
import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import PrimaryButton from '@/components/ui/primary-button';
import ContadorTiempo from '@/components/counter-time'; 

interface HojaQuirofano {
    id: number;

    hora_inicio_paciente?: string | null;
    hora_inicio_anestesia?: string | null;
    hora_inicio_cirugia?: string | null;

    hora_fin_paciente?: string | null;
    hora_fin_anestesia?: string | null;
    hora_fin_cirugia?: string | null;
}

interface Props {
    hoja: HojaQuirofano;
}

const parseFechaMySQL = (fecha: string | null | undefined) => {
    if (!fecha) return null;
    return fecha.replace(' ', 'T');
};

const getLocalISOString = () => {
    const fecha = new Date();
    const fechaLocal = new Date(fecha.getTime() - (fecha.getTimezoneOffset() * 60000));
    return fechaLocal.toISOString().slice(0, 19).replace('T', ' ');
};

const formatTimeStatic = (isoString: string | null) => {
    const fecha = parseFechaMySQL(isoString);
    if (!fecha) return '--:--';
    return new Date(fecha).toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
};

interface HojaQuirofano {
    id: number;
    hora_inicio_paciente?: string | null;
    hora_fin_paciente?: string | null;
    
    hora_inicio_anestesia?: string | null;
    hora_fin_anestesia?: string | null;

    hora_inicio_cirugia?: string | null;
    hora_fin_cirugia?: string | null;
}

interface Props {
    hoja: HojaQuirofano;
}

const TiemposQuirofanoForm: React.FC<Props> = ({ hoja }) => {

const handleRegistrarTiempo = (campo: string, esInicio: boolean = true, tituloEtapa: string) => {    
    const accion = esInicio ? 'Iniciar' : 'Finalizar';
        
        Swal.fire({
            title: `¿${accion} ${tituloEtapa}?`,
            text: `Se registrará la hora exacta de ${accion.toLowerCase()}.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: esInicio ? '#16a34a' : '#1f2937',
            cancelButtonColor: '#d33',
            confirmButtonText: `Sí, ${accion.toLowerCase()}`,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const now_mysql = getLocalISOString();

                if (esInicio) {
                    router.patch(route('hojasenfermeriasquirofanos.update', { hojasenfermeriasquirofano: hoja.id }), {
                        [campo]: now_mysql
                    }, { preserveScroll: true });
                } else {
                    router.patch(route('hojasenfermeriasquirofanos.update', { 
                        hojasenfermeriasquirofano: hoja.id, 
                    }), {
                        [campo]: now_mysql
                    }, { preserveScroll: true });
                }
            }
        });
    };

    const TarjetaTiempo = ({ 
        titulo, 
        color, 
        inicio, 
        fin, 
        campoInicio, 
        campoFin, 
        habilitado = true,
        mensajeBloqueo = ''
    }: any) => {
        
        const estilos = {
            blue: 'bg-blue-50 border-blue-200 text-blue-800',
            green: 'bg-green-50 border-green-200 text-green-800',
            red: 'bg-red-50 border-red-200 text-red-800',
            gray: 'bg-gray-50 border-gray-200 text-gray-800'
        };

        const colorActual = inicio ? estilos[color as keyof typeof estilos] : estilos.gray;

        return (
            <div className={`flex flex-col items-center p-4 border rounded-lg transition-colors ${colorActual}`}>
                <h4 className="font-bold mb-3 text-center">{titulo}</h4>

                {!habilitado ? (
                     <div className="text-center py-4">
                        <p className="text-sm text-gray-400 mb-2">Esperando etapa anterior...</p>
                        <span className="text-xs text-red-400">{mensajeBloqueo}</span>
                     </div>
                ) : (
                    <>
                        {!inicio && (
                            <PrimaryButton 
                                type="button"
                                // Aquí SÍ usamos campoInicio
                                onClick={() => handleRegistrarTiempo(campoInicio, true, titulo)}
                                className={`w-full justify-center py-4 text-lg ${color === 'red' ? 'bg-red-600 hover:bg-red-700' : color === 'green' ? 'bg-green-600 hover:bg-green-700' : ''}`}
                            >
                                Iniciar
                            </PrimaryButton>
                        )}

                        {inicio && (
                            <div className="flex flex-col items-center gap-2 w-full animate-fade-in">
                                <div className="text-sm opacity-80">
                                    Inicio: <strong>{formatTimeStatic(inicio)}</strong>
                                </div>

                                <div className="text-3xl my-2 font-mono font-bold">
                                    <ContadorTiempo 
                                        fechaInicioISO={parseFechaMySQL(inicio)} 
                                        fechaFinISO={parseFechaMySQL(fin)} 
                                    />
                                </div>

                                {!fin && (
                                    <PrimaryButton 
                                        type="button"
                                        onClick={() => handleRegistrarTiempo(campoFin, false, titulo)}
                                        className="w-full justify-center py-2 bg-gray-800 hover:bg-gray-900 text-white mt-2"
                                    >
                                        Finalizar / Detener
                                    </PrimaryButton>
                                )}

                                {fin && (
                                    <div className="text-sm opacity-80 text-center">
                                        Fin: <strong>{formatTimeStatic(fin)}</strong>
                                        <div className="text-xs text-green-600 font-bold mt-1">¡Registro Completado!</div>
                                    </div>
                                )}

                            </div>
                        )}
                    </>
                )}
            </div>
        );
    };

    return (
        <div className="bg-white p-6 rounded-lg shadow-sm border mb-6">
            <h3 className="text-lg font-semibold mb-4 text-gray-800 border-b pb-2">
                Control de tiempos quirúrgicos
            </h3>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <TarjetaTiempo 
                    titulo="Paciente en quirófano"
                    color="blue"
                    inicio={hoja.hora_inicio_paciente}
                    fin={hoja.hora_fin_paciente}
                    campoInicio="hora_inicio_paciente"
                    campoFin="hora_fin_paciente"
                />

                <TarjetaTiempo 
                    titulo="Anestesia"
                    color="green"
                    inicio={hoja.hora_inicio_anestesia}
                    fin={hoja.hora_fin_anestesia}
                    campoInicio="hora_inicio_anestesia"
                    campoFin="hora_fin_anestesia"
                    habilitado={!!hoja.hora_inicio_paciente}
                    mensajeBloqueo="Requiere ingreso de paciente"
                />

                <TarjetaTiempo 
                    titulo="Cirugía"
                    color="red"
                    inicio={hoja.hora_inicio_cirugia}
                    fin={hoja.hora_fin_cirugia}
                    campoInicio="hora_inicio_cirugia"
                    campoFin="hora_fin_cirugia"
                    habilitado={!!hoja.hora_inicio_anestesia}
                    mensajeBloqueo="Requiere inicio de anestesia"
                />

            </div>
        </div>
    );
};

export default TiemposQuirofanoForm;