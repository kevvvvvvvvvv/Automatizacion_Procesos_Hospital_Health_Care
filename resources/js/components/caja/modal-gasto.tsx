import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import SelectInput from '@/components/ui/input-select';
import TextInput from '@/components/ui/input-text';
import { MetodoPago, SesionCaja } from '@/types';
import Swal from 'sweetalert2';

interface Props {
    onClose: () => void;
    metodos_pagos: MetodoPago[];
    sesion: SesionCaja;
    fondo: SesionCaja;
}

const tipoMovimientoOptions = [
    { value: 'egreso', label: 'Egreso' },
    { value: 'ingreso', label: 'Ingreso'}
]

export const conceptosPorArea = {
    CAJA: {
        ingresos: [
        { value: 'inicial', label: 'Inicial' }
        ],
        egresos: [
        { value: 'corte_caja', label: 'Corte de caja' },
        { value: 'retiro_efectivo', label: 'Retiro de efectivo' },
        { value: 'honorarios_diversos', label: 'Honorarios diversos' }
        ]
    },
    CAFETERIA: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' },
        { value: 'cortesia', label: 'Cortesía' },
        { value: 'cortesia_px', label: 'Cortesía PX' },
        { value: 'deudor', label: 'Deudor' }
        ],
        egresos: [
        { value: 'pollo', label: 'Pollo' },
        { value: 'pan', label: 'Pan' },
        { value: 'garrafones_agua', label: 'Garrafones de agua' },
        { value: 'lechuga', label: 'Lechuga' },
        { value: 'yogurt', label: 'Yogurt' },
        { value: 'refresco', label: 'Refresco' },
        { value: 'bacalao', label: 'Bacalao' },
        { value: 'compras_diversas', label: 'Compras diversas' },
        { value: 'compras_mantenimiento', label: 'Compras de mantenimiento' },
        { value: 'tortillas', label: 'Tortillas' },
        { value: 'fondo', label: 'Fondo' }
        ]
    },
    CONSULTA: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' }
        ],
        egresos: [
        { value: 'honorarios_consulta', label: 'Honorarios consulta' }
        ]
    },
    RAYOS_X: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' },
        { value: 'liga', label: 'Liga' },
        { value: 'preoperatorio', label: 'Preoperatorio' },
        { value: 'en_piso', label: 'En piso' },
        { value: 'en_cirugia', label: 'En cirugía' },
        { value: 'promocion', label: 'Promoción' }
        ],
        egresos: [] 
    },
    ESTUDIOS: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' }
        ],
        egresos: [
        { value: 'comision', label: 'Comisión' },
        { value: 'patologia', label: 'Patología' }
        ]
    },
    ULTRASONIDO: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' }
        ],
        egresos: [
        { value: 'comision', label: 'Comisión' }
        ]
    },
    CIRUGIA: {
        ingresos: [
        { value: 'corta_estancia', label: 'Corta estancia' },
        ],
        egresos: [
        { value: 'cirujano', label: 'Cirujano' },
        { value: 'anestesiologo', label: 'Anestesiólogo' },
        { value: 'ayudante', label: 'Ayudante' },
        { value: 'instrumentista', label: 'Instrumentista' },
        { value: 'farmacia', label: 'Farmacia' },
        { value: 'pediatra', label: 'Pediatra' },
        { value: 'devolucion_cancelacion', label: 'Devolución y cancelación' },
        { value: 'retiro_efectivo', label: 'Retiro de efectivo' },
        { value: 'apartado', label: 'Apartado' },
        { value: 'cafeteria', label: 'Cafetería' },
        { value: 'dieta', label: 'Dieta' }
        ]
    },
    ANTICIPO_CIRUGIA: {
        ingresos: [
        { value: 'efectivo', label: 'Efectivo' },
        { value: 'tarjeta', label: 'Tarjeta' },
        { value: 'transferencia', label: 'Transferencia' }
        ],
        egresos: [
        { value: 'devolucion_cancelacion', label: 'Devolución y cancelación' }
        ]
    },
    PRESTAMO: {
        ingresos: [
        { value: 'josue', label: 'Josué' }
        ],
        egresos: [
        { value: 'pago_prestamo_conta', label: 'Pago préstamo Conta' },
        { value: 'pago_prestamo_josue', label: 'Pago préstamo Josué' },
        { value: 'fondo', label: 'Fondo' }
        ]
    },
    FONDO_COMPRAS_MERCADO: {
        ingresos: [],
        egresos: [
        { value: 'fondo_luis', label: 'Fondo Luis' }
        ]
    },
    LIGA: {
        ingresos: [],
        egresos: [
        { value: 'retiro_efectivo', label: 'Retiro de efectivo' }
        ]
    }
};

export const areasDisponibles = [
    { value: 'CAJA', label: 'Caja' },
    { value: 'CAFETERIA', label: 'Cafetería' },
    { value: 'CONSULTA', label: 'Consulta' },
    { value: 'RAYOS_X', label: 'Rayos X' },
    { value: 'ESTUDIOS', label: 'Estudios' },
    { value: 'ULTRASONIDO', label: 'Ultrasonido' },
    { value: 'CIRUGIA', label: 'Cirugía' },
    { value: 'ANTICIPO_CIRUGIA', label: 'Anticipo de Cirugía' },
    { value: 'PRESTAMO', label: 'Préstamo' },
    { value: 'FONDO_COMPRAS_MERCADO', label: 'Fondo Compras Mercado' },
    { value: 'LIGA', label: 'Liga' }
];

const tiposCajas = [
    {value:'operativo', label: 'Caja principal'},
    {value:'fondo', label: 'Fondo'},
];



const ModalGasto = ({ 
    onClose,
    metodos_pagos = [],
    sesion,
    fondo,
}: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        tipo: 'egreso', 
        monto: '',
        area: '',
        concepto: '',
        descripcion: '',
        origen: 'operativo',
        metodo_pago_id: '',
        nombre_paciente:'',
    });

    const optionsMetodoPago = metodos_pagos.map((met) => (
        {value: met.id, label: met.nombre}
    ))

    const tipoMovimiento = data.tipo === 'ingreso' ? 'ingresos' : 'egresos';
    
    const opcionesConcepto = data.area 
        ? conceptosPorArea[data.area as keyof typeof conceptosPorArea]?.[tipoMovimiento] || [] 
        : [];

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        if(data.tipo === 'egreso' && (Number(data.monto) > sesion.monto_esperado) && data.origen===('operativo')){
            Swal.fire(
                'Advertencia',
                'Vas a enviar más dinero del disponible en caja',
                'warning',
            )
            return;
        }

        if(data.tipo === 'egreso' && (Number(data.monto) > fondo.monto_esperado) && data.origen===('fondo')){
            Swal.fire(
                'Advertencia',
                'Vas a enviar más dinero del disponible desde fondo',
                'warning',
            )
            return;
        }
        post(route('caja-movimiento'), {
            preserveScroll: true,
            onSuccess: () => {
                reset(); 
                onClose(); 
            },
        });
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-opacity-50 backdrop-blur-sm p-4">
            <div className="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl">
                
                
                <button onClick={onClose} className="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <h3 className="mb-5 text-xl font-bold text-gray-800">Registrar movimiento</h3>

                <form onSubmit={handleSubmit} className="space-y-4">
                    
                    <SelectInput
                        label='Tipo'
                        options={tipoMovimientoOptions}
                        value={data.tipo}
                        onChange={e=>setData('tipo',e)}
                        error={errors.tipo}
                    />

                    <SelectInput
                        label='Área'
                        options={areasDisponibles}
                        value={data.area}
                        onChange={e=>{
                            setData('area',e)
                            setData('concepto', '');
                        }}
                        error={errors.area}
                    />

                    <SelectInput
                        label='Concepto'
                        options={opcionesConcepto}
                        value={data.concepto}
                        onChange={e=>setData('concepto',e)}
                        error={errors.concepto}
                    />

                    <SelectInput
                        label='Método de pago'
                        options={optionsMetodoPago}
                        value={data.metodo_pago_id}
                        onChange={e=>setData('metodo_pago_id',e)}
                        error={errors.metodo_pago_id}
                    />

                    <TextInput
                        name=''
                        id=''
                        label="Descripción"
                        value={data.descripcion}
                        onChange={e=>setData('descripcion',e.target.value)}
                        error={errors.descripcion}
                    />

                    <SelectInput
                        label='Apartado que realiza el envio'
                        options={tiposCajas}
                        value={data.origen}
                        onChange={e=>setData('origen',e)}
                        error={errors.origen}
                    />

                    <TextInput
                        id=''
                        name=''
                        label='Nombre del paciente'
                        value={data.nombre_paciente}
                        onChange={e=>setData('nombre_paciente',e.target.value)}
                        error={errors.nombre_paciente}
                    />

                    <TextInput
                        id=''
                        name=''
                        label='Monto'
                        value={data.monto}
                        onChange={e=>setData('monto',e.target.value)}
                        type='number'
                        step="0.01"
                        error={errors.concepto}
                    />


                    <div className="mt-6 flex justify-end space-x-3">
                        <button 
                            type="button" 
                            onClick={onClose}
                            className="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            disabled={processing}
                            className="rounded-lg border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                        >
                            {processing ? 'Guardando...' : 'Guardar movimiento'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default ModalGasto;