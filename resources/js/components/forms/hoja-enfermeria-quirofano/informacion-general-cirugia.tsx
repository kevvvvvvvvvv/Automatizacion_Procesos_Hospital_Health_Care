import React from 'react';

import TextAreaInput from '@/components/ui/input-text-area';

const InformacionGeneralCirugia = () => {

    return (
        <>
            <TextAreaInput
                label="Nota de enfermería"
            />

            <TextAreaInput
                label="Procedimiento quirúrgico"
            />
        </>
    );
}

export default InformacionGeneralCirugia;