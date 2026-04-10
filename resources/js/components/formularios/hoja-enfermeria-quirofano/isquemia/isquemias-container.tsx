import React from 'react';
import { useForm } from '@inertiajs/react';
import IsquemiaFields from './IsquemiaFields';

interface Props {
    isquemiable_id: number;
    isquemiable_type: string; // Ej: 'App\Models\Cirugia' o 'App\Models\Urgencia'
    onSuccess?: () => void;
}

const IsquemiaFormContainer = ({ isquemiable_id, isquemiable_type, onSuccess }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        isquemiable_id: isquemiable_id,
        isquemiable_type: isquemiable_type,
        sitio_anatomico: '',
        hora_inicio: '',
        hora_termino: '',
        observaciones: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('isquemias.store'), {
            onSuccess: () => {
                reset();
                if (onSuccess) onSuccess();
            },
        });
    };

    return (
        <form onSubmit={handleSubmit} className="p-4 bg-white shadow rounded-lg">
            <h3 className="text-lg font-semibold mb-4 text-gray-800">Registrar Isquemia</h3>
            
            <IsquemiaFields data={data} setData={setData} errors={errors} />

            <div className="mt-6 flex justify-end">
                <button
                    type="submit"
                    disabled={processing}
                    className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 transition-colors"
                >
                    {processing ? 'Guardando...' : 'Guardar Isquemia'}
                </button>
            </div>
        </form>
    );
};

export default IsquemiaFormContainer;