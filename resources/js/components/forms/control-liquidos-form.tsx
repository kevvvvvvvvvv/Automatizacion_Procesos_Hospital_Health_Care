import { HojaEnfermeria, ControlLiquidos } from '@/types';
import React from 'react';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/react';
import { Pencil } from 'lucide-react'; 

import PrimaryButton from '../ui/primary-button'
import InputText from '../ui/input-text';
import {DataTable} from '../ui/data-table';

interface Props {
    hoja: HojaEnfermeria;
}

const ControlLiquidosForm = ({hoja}: Props) => {

    const {data, setData, errors, post, processing, reset} = useForm({
        uresis: '',
        uresis_descripcion: '',
        evacuaciones: '',
        evacuaciones_descripcion: '',
        emesis: '',
        emesis_descripcion: '',
        drenes: '',
        drenes_descripcion: '',
    })

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojas-control-liquidos.store',{ hojasenfermeria: hoja.id}),{
            preserveScroll: true,
            onSuccess: ()=>{
                reset();
            }
        });
    }

    const columnasControlLiquidos = [
        { 
            header: 'Fecha/Hora', 
            key: 'fecha_hora_registro' 
        },
        { 
            header: 'Uresis', 
            key: 'uresis', 
            render: (reg: ControlLiquidos) => (
            <div>
                <div className="font-medium">{reg.uresis} ml</div>
                {reg.uresis_descripcion && (
                <div className="text-xs text-gray-400 italic">{reg.uresis_descripcion}</div>
                )}
            </div>
            )
        },
        { 
            header: 'Evacuaciones', 
            key: 'evacuaciones', 
            render: (reg: ControlLiquidos) => (
            <div>
                <div className="font-medium">{reg.evacuaciones}</div>
                {reg.evacuaciones_descripcion && (
                <div className="text-xs text-gray-400 italic">{reg.evacuaciones_descripcion}</div>
                )}
            </div>
            )
        },
        { 
            header: 'Emesis', 
            key: 'emesis', 
            render: (reg: ControlLiquidos) => (
            <div>
                <div className="font-medium">{reg.emesis} ml</div>
                {reg.emesis_descripcion && (
                <div className="text-xs text-gray-400 italic">{reg.emesis_descripcion}</div>
                )}
            </div>
            )
        },
        { 
            header: 'Drenes', 
            key: 'drenes', 
            render: (reg: ControlLiquidos) => (
            <div>
                <div className="font-medium">{reg.drenes} ml</div>
                {reg.drenes_descripcion && (
                <div className="text-xs text-gray-400 italic">{reg.drenes_descripcion}</div>
                )}
            </div>
            )
        },
        {
            header: 'Acción',
            key: 'accion',
            render: (reg: ControlLiquidos) => (
            <button 
                onClick={() => console.log("Editar control:", reg.id)} 
                className="text-blue-600 hover:text-blue-900"
            >
                <Pencil size={18} />
            </button>
            )
        }
    ];


    return (
        <>
            <form onSubmit={handleSubmit}>
                <h2 className='mb-5 font-bold text-xl mt-5'>Control de liquidos</h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <InputText 
                        id="uresis" 
                        name="uresis" 
                        label="Uresis (ml)" 
                        type="number" 
                        value={data.uresis} 
                        onChange={(e) => setData('uresis', e.target.value)} 
                        error={errors.uresis} 
                    />
                    <InputText 
                        id="uresis_descripcion" 
                        name="uresis_descripcion" 
                        label="Uresis (descripción)" 
                        value={data.uresis_descripcion} 
                        onChange={(e) => setData('uresis_descripcion', e.target.value)} 
                        error={errors.uresis_descripcion} 
                    />
                    
                    <InputText 
                        id="evacuaciones" 
                        name="evacuaciones" 
                        label="Evacuaciones (ml)" 
                        type="number" 
                        value={data.evacuaciones} 
                        onChange={(e) => setData('evacuaciones', e.target.value)} 
                        error={errors.evacuaciones} 
                    />
                    <InputText 
                        id="evacuaciones_descripcion" 
                        name="evacuaciones_descripcion" 
                        label="Evacuaciones (descripción)" 
                        value={data.evacuaciones_descripcion} 
                        onChange={(e) => setData('evacuaciones_descripcion', e.target.value)} 
                        error={errors.evacuaciones_descripcion} 
                    />

                    <InputText 
                        id="emesis" 
                        name="emesis" 
                        label="Emesis (ml)" 
                        type="number" 
                        value={data.emesis} 
                        onChange={(e) => setData('emesis', e.target.value)} 
                        error={errors.emesis} 
                    />
                    <InputText 
                        id="emesis_descripcion" 
                        name="emesis_descripcion" 
                        label="Emesis (descripción)" 
                        value={data.emesis_descripcion} 
                        onChange={(e) => setData('emesis_descripcion', e.target.value)} 
                        error={errors.emesis_descripcion} 
                    />

                    <InputText 
                        id="drenes" 
                        name="drenes" 
                        label="Drenes (ml)" 
                        type="number" 
                        value={data.drenes} 
                        onChange={(e) => setData('drenes', e.target.value)} 
                        error={errors.drenes} 
                    />
                    <InputText 
                        id="drenes_descripcion" 
                        name="drenes_descripcion" 
                        label="Drenes (descripción)" 
                        value={data.drenes_descripcion} 
                        onChange={(e) => setData('drenes_descripcion', e.target.value)} 
                        error={errors.drenes_descripcion} 
                    />
                </div>
                <PrimaryButton disabled={processing} type='submit'>
                    {processing ? 'Guardando...' : 'Guardar'}
                </PrimaryButton>
            </form>
            <div className="mt-12">
                <DataTable columns={columnasControlLiquidos} data={hoja.hoja_control_liquidos} />
            </div>
        </>
        
    );
}

export default ControlLiquidosForm;