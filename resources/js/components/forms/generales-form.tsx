import React, { useEffect, useRef } from 'react';
import { router, useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import Swal from 'sweetalert2';

import PrimaryButton from '@/components/ui/primary-button';
import ContadorTiempo from '@/components/counter-time'; 
import Checkbox from '../ui/input-checkbox';
import { HojaEnfermeriaQuirofano } from '@/types';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
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

interface Props {
    hoja: HojaEnfermeriaQuirofano;
}

const TiemposQuirofanoForm: React.FC<Props> = ({ hoja }) => {

    const { data, setData, put} = useForm({
        anestesia: {
            general: hoja.anestesia?.general ?? false,
            local: hoja.anestesia?.local ?? false,
            sedacion: hoja.anestesia?.sedacion ?? false,

            regional: {
                neuroaxial: {
                    bsa: hoja.anestesia?.regional?.neuroaxial?.bsa ?? false,
                    epidural: hoja.anestesia?.regional?.neuroaxial?.epidural ?? false,
                    mixto: hoja.anestesia?.regional?.neuroaxial?.mixto ?? false,
                },
                periferico: {
                    plexo_braquial: hoja.anestesia?.regional?.periferico?.plexo_braquial ?? false,
                    otros: hoja.anestesia?.regional?.periferico?.otros ?? false,
                }
            }
        }
    });

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
            <div className={`flex flex-col items-center p-4 border rounded-lg transition-colors ${colorActual} bg-white`}>
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
                                        <div className="text-xs text-green-600 font-bold mt-1">¡Registro completado!</div>
                                    </div>
                                )}

                            </div>
                        )}
                    </>
                )}
            </div>
        );
    };

    const isMounted = useRef(false);

    useEffect(()=>{
        if(!isMounted.current) {
            isMounted.current = true;
            return;
        }

        put(route('hojasenfermeriasquirofanos.update',{hojasenfermeriasquirofano: hoja.id}),{
            preserveScroll: true,
            preserveState: true,
        });
    },[data.anestesia]);

    const handleCheckboxChange = (field: string, value: boolean) => {
        const nuevaAnestesia = JSON.parse(JSON.stringify(data.anestesia));
        const keys = field.split('.');
        let actual: any = nuevaAnestesia; 
        
        for (let i = 0; i < keys.length - 1; i++) {
            actual = actual[keys[i]];
        }
        actual[keys[keys.length - 1]] = value;
        
        setData('anestesia', nuevaAnestesia);
    };


    return (
        <>
            <form onSubmit={(e) => e.preventDefault()} className='border shadow-sm rounded-lg p-6 mb-4'>
                <h3 className="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">
                    Anestesia
                </h3>

                {/* 1. Tipos Generales / Básicos */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <Checkbox
                        id="general"
                        label="Anestesia General"
                        checked={data.anestesia.general}
                        onChange={(e) => handleCheckboxChange('general', e.target.checked)}
                    />
                    <Checkbox
                        id="local"
                        label="Anestesia Local"
                        checked={data.anestesia.local}
                        onChange={(e) => handleCheckboxChange('local', e.target.checked)}
                    />
                    <Checkbox
                        id="sedacion"
                        label="Sedación (MAC)"
                        checked={data.anestesia.sedacion}
                        onChange={(e) => handleCheckboxChange('sedacion', e.target.checked)}
                    />
                </div>

                {/* 2. Anestesia Regional (Bloqueos) */}
                <div className="bg-gray-50 p-4 rounded-md border border-gray-100">
                    <h4 className="text-md font-medium text-gray-700 mb-4">
                        Anestesia Regional (Bloqueos)
                    </h4>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {/* Columna Neuroaxial */}
                        <div className="flex flex-col gap-3">
                            <h5 className="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                Neuroaxial (Central)
                            </h5>
                            <Checkbox
                                id="bsa"
                                label="BSA (Subaracnoideo / Raquídea)"
                                checked={data.anestesia.regional.neuroaxial.bsa}
                                onChange={(e) => handleCheckboxChange('regional.neuroaxial.bsa', e.target.checked)}
                            />
                            <Checkbox
                                id="epidural"
                                label="Epidural"
                                checked={data.anestesia.regional.neuroaxial.epidural}
                                onChange={(e) => handleCheckboxChange('regional.neuroaxial.epidural', e.target.checked)}
                            />
                            <Checkbox
                                id="mixto"
                                label="Bloqueo Mixto (CSE)"
                                checked={data.anestesia.regional.neuroaxial.mixto}
                                onChange={(e) => handleCheckboxChange('regional.neuroaxial.mixto', e.target.checked)}
                            />
                        </div>

                        {/* Columna Periférico */}
                        <div className="flex flex-col gap-3">
                            <h5 className="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                Periférico
                            </h5>
                            <Checkbox
                                id="plexo_braquial"
                                label="Plexo Braquial"
                                checked={data.anestesia.regional.periferico.plexo_braquial}
                                onChange={(e) => handleCheckboxChange('regional.periferico.plexo_braquial', e.target.checked)}
                            />
                            <Checkbox
                                id="otros_perifericos"
                                label="Otros (Femoral, Ciático, etc.)"
                                checked={data.anestesia.regional.periferico.otros}
                                onChange={(e) => handleCheckboxChange('regional.periferico.otros', e.target.checked)}
                            />
                        </div>

                    </div>
                </div>
            </form>


            <div className='border shadow-sm p-6 rounded-lg'>
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
        </>
    );
};

export default TiemposQuirofanoForm;