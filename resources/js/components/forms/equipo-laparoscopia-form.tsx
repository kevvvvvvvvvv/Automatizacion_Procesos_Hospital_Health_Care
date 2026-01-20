import React from 'react';
import Checkbox from '@/components/ui/input-checkbox';

const EquipoLaparoscopiaForm = () => {

    


    return (
        <form>
            <h3 className='pb-3 text-xl font-bold'>
                Equipo de laparoscopía
            </h3>

            <Checkbox
                id="torre"
                label="Torre"
            />

            <Checkbox
                id="armonico"
                label="Armonico"
            />    

            <Checkbox
                id="ligashure"
                label="Ligashure"
            />

            <Checkbox
                id="grapas_extras"
                label="Grapas extras"
            />   

            <Checkbox
                id="bolsa_endo"
                label="Bolsa endo"
            />
            <Checkbox
                id="arco_c"
                label="Arco en C"
            />   
        </form>
    );
}

export default EquipoLaparoscopiaForm;