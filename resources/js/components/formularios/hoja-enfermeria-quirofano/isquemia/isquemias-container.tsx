import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';

import PrimaryButton from '@/components/ui/primary-button';
import IsquemiaFields from './isquemias-fields';

interface Props {
    isquemiable_id: number;
    isquemiable_type: string;
    onSuccess?: () => void;
}

const IsquemiaFormContainer = ({ isquemiable_id, isquemiable_type, onSuccess }: Props) => {


    return (
        <form onSubmit={handleSubmit} className="p-4 bg-white shadow rounded-lg">
            <h3 className="text-lg font-semibold mb-4 text-gray-800">Registrar Isquemia</h3>
            
            <IsquemiaFields data={data} setData={setData} errors={errors} />

        </form>
    );
};

export default IsquemiaFormContainer;