import { useForm } from '@inertiajs/react';
import React from 'react';
import { route } from 'ziggy-js'
import InputText from '../ui/input-text';
import PrimaryButton from '../ui/primary-button';
import { HojaEnfermeria } from '@/types';

interface Props {
    hoja: HojaEnfermeria;
}


const EscalaValoracionForm = ({hoja}:Props) => {

    const {data, setData, errors, post, processing, reset} = useForm({        escala_braden: '',
        escala_glasgow: '',
        escala_ramsey: '',
        escala_eva: '',
    })

    const handleSubmit = (e:React.FormEvent) => {
        e.preventDefault();
        post(route('hojas-escalas-valoracion.store',{hojasenfermeria: hoja.id}),{
            preserveScroll: true,
            onSuccess: ()=>{
                reset();
            }
        });
    }
        
    return (
        <form onSubmit={handleSubmit}>
            <h2 className='mb-5 font-bold text-xl mt-5'>Escalas de valoración</h2>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <InputText 
                    id="escala_glasgow" 
                    name="escala_glasgow" 
                    label="Escala Glasgow (0-15)" 
                    type= "number"
                    value={data.escala_glasgow} 
                    onChange={(e) => setData('escala_glasgow', e.target.value)} 
                    error={errors.escala_glasgow} 
                />
                
                <InputText 
                    id="escala_braden" 
                    name="escala_braden" 
                    label="Escala Braden (1-25)" 
                    type = "number"
                    value={data.escala_braden} 
                    onChange={(e) => setData('escala_braden', e.target.value)} 
                    error={errors.escala_braden} 
                />

                <InputText 
                    id="escala_ramsey" 
                    name="escala_ramsey" 
                    label="Escala Ramsey(1-6)" 
                    type = "number"
                    value={data.escala_ramsey} 
                    onChange={(e) => setData('escala_ramsey', e.target.value)} 
                    error={errors.escala_ramsey} 
                />

                <InputText 
                    id="escala_eva" 
                    name="escala_eva" 
                    type="number"
                    label="Escala EVA (0-10)" 
                    value={data.escala_eva} 
                    onChange={(e) => setData('escala_eva', e.target.value)} 
                    error={errors.escala_eva} 
                />
            </div>
            <PrimaryButton type='submit' disabled={processing}>
                {processing ? 'Guardando...' : 'Guardar'}
            </PrimaryButton>
        </form>

    );
} 

export default EscalaValoracionForm;