import React, { useEffect, useRef } from 'react'; 
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import Checkbox from '@/components/ui/input-checkbox';
import { HojaEnfermeriaQuirofano } from '@/types';
import ServiciosEspecialesForm from '@/components/forms/servicios-especiales-form';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
}

const EquipoLaparoscopiaForm = ({ hoja }: Props) => {

    const { data, setData, put, processing } = useForm({
        servicios_especiales: {
            torre: hoja.servicios_especiales?.torre ?? false,
            armonico: hoja.servicios_especiales?.armonico ?? false,
            ligashure: hoja.servicios_especiales?.ligashure ?? false,
            grapas_extras: hoja.servicios_especiales?.grapas_extras ?? false,
            bolsa_endo: hoja.servicios_especiales?.bolsa_endo ?? false,
            arco_c: hoja.servicios_especiales?.arco_c ?? false,
        }
    });

    const isMounted = useRef(false);

    useEffect(() => {
        if (!isMounted.current) {
            isMounted.current = true;
            return;
        }

        put(route('hojasenfermeriasquirofanos.update',{hojasenfermeriasquirofano: hoja.id}), {
            preserveScroll: true, 
            preserveState: true,  
        });

    }, [data.servicios_especiales]); 


    const handleCheckboxChange = (field: string, value: boolean) => {
        setData('servicios_especiales', {
            ...data.servicios_especiales,
            [field]: value
        });
    };

    return (
        <>
        <form onSubmit={(e) => e.preventDefault()} className='mb-5 p-6 rounded-lg shadow-sm border'>
            <div className="mb-4">
                <h3 className='text-xl font-bold flex items-center gap-2'>
                    Equipo de laparoscopía
                    {processing && <span className="text-xs text-gray-500 font-normal">Guardando...</span>}
                </h3>
            </div>

            <div className="space-y-3">
                <Checkbox
                    id="torre"
                    label="Torre"
                    checked={data.servicios_especiales.torre}
                    onChange={(e) => handleCheckboxChange('torre', e.target.checked)}
                />

                <Checkbox
                    id="armonico"
                    label="Armónico"
                    checked={data.servicios_especiales.armonico}
                    onChange={(e) => handleCheckboxChange('armonico', e.target.checked)}
                />    

                <Checkbox
                    id="ligashure"
                    label="Ligashure"
                    checked={data.servicios_especiales.ligashure}
                    onChange={(e) => handleCheckboxChange('ligashure', e.target.checked)}
                />

                <Checkbox
                    id="grapas_extras"
                    label="Grapas extras"
                    checked={data.servicios_especiales.grapas_extras}
                    onChange={(e) => handleCheckboxChange('grapas_extras', e.target.checked)}
                />   

                <Checkbox
                    id="bolsa_endo"
                    label="Bolsa endo"
                    checked={data.servicios_especiales.bolsa_endo}
                    onChange={(e) => handleCheckboxChange('bolsa_endo', e.target.checked)}
                />

                <Checkbox
                    id="arco_c"
                    label="Arco en C"
                    checked={data.servicios_especiales.arco_c}
                    onChange={(e) => handleCheckboxChange('arco_c', e.target.checked)}
                />   
            </div>
        </form>
            <div className='border shadow-sm rounded-lg p-6'>
                <ServiciosEspecialesForm
                    modelo={hoja}
                    tipo='App\Models\HojaEnfermeriaQuirofano'
                />
            </div>
        </>
    );
}

export default EquipoLaparoscopiaForm;