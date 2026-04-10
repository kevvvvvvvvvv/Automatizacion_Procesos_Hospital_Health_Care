import React from 'react';

interface Props {
    data: any;
    setData: (key: string, value: any) => void;
    errors: any;
}

const IsquemiaFields = ({ data, setData, errors }: Props) => {
    return (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="col-span-2">
                <label className="block text-sm font-medium text-gray-700">Sitio Anatómico</label>
                <input
                    type="text"
                    value={data.sitio_anatomico}
                    onChange={e => setData('sitio_anatomico', e.target.value)}
                    className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ej. Brazo derecho, Arteria Femoral..."
                />
                {errors.sitio_anatomico && <span className="text-red-500 text-xs">{errors.sitio_anatomico}</span>}
            </div>

            <div>
                <label className="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                <input
                    type="datetime-local"
                    value={data.hora_inicio}
                    onChange={e => setData('hora_inicio', e.target.value)}
                    className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
                {errors.hora_inicio && <span className="text-red-500 text-xs">{errors.hora_inicio}</span>}
            </div>

            <div>
                <label className="block text-sm font-medium text-gray-700">Hora de Término</label>
                <input
                    type="datetime-local"
                    value={data.hora_termino}
                    onChange={e => setData('hora_termino', e.target.value)}
                    className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
                {errors.hora_termino && <span className="text-red-500 text-xs">{errors.hora_termino}</span>}
            </div>

            <div className="col-span-2">
                <label className="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea
                    value={data.observaciones}
                    onChange={e => setData('observaciones', e.target.value)}
                    rows={3}
                    className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
                {errors.observaciones && <span className="text-red-500 text-xs">{errors.observaciones}</span>}
            </div>
        </div>
    );
};

export default IsquemiaFields;