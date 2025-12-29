import { HojaEnfermeria } from '@/types';
import React from 'react';
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/react';

import PrimaryButton from '../ui/primary-button'
import InputText from '../ui/input-text';

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

    return (
        <form onSubmit={handleSubmit}>
            <h2 className='mb-5 font-bold text-xl mt-5'>Control de liquidos</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <InputText 
                    id="uresis" 
                    name="uresis" 
                    label="Uresis (cantidad)" 
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
                    label="Evacuaciones (cantidad)" 
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
                    label="Emesis (cantidad)" 
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
                    label="Drenes (cantidad)" 
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
    );
}

export default ControlLiquidosForm;