import React, { useMemo, useState } from 'react';
import { useForm } from '@inertiajs/react';
import { CategoriaDieta, HojaEnfermeria, SolicitudDieta } from '@/types'; 
import { route } from 'ziggy-js';
import { Pencil } from 'lucide-react';

import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '../ui/input-text';
import { DataTable } from '../ui/data-table';


interface Props {
    hoja: HojaEnfermeria;
    categoria_dietas: CategoriaDieta[];
}

const DietaForm: React.FC<Props> = ({ hoja, categoria_dietas = [] }) => {
    
    const categoriaOptions = categoria_dietas.map((c) => ({
        value: c.id,
        label: c.categoria
    }));

    const [ categoriaData, setCategoriaData] = useState('');

    const { data, setData, post, processing, errors, reset } = useForm({
        dieta_id: '',
        observaciones: '',
    });

    const dietasDisponibles = useMemo(() => {
        if (!categoriaData) return [];

        const categoriaEncontrada = categoria_dietas.find(
            (c) => c.id === Number(categoriaData)
        );

        if (categoriaEncontrada && categoriaEncontrada.dietas) {
            return categoriaEncontrada.dietas.map((d) => ({
                value: d.id,
                label: `${d.alimento}`
            }));
        }

        return [];
    }, [categoriaData, categoria_dietas]);

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojasenfermerias.dietas.store', { hojasenfermeria: hoja.id }), {
            preserveScroll: true,
            onSuccess: () => {
                reset();
                setCategoriaData('');
            }
        });
    }

    const columnasDietas = [
        { 
            header: 'Tipo de Dieta', 
            key: 'tipo_dieta',
            render: (reg: SolicitudDieta) => (
            <div>
                <div className="font-bold text-gray-900">{reg.dieta.categoria_dieta.categoria}</div>
                <div className="text-xs text-gray-500">{}</div>
            </div>
            )
        },
        { 
            header: 'Solicitud', 
            key: 'horario_solicitud',
            render: (reg: SolicitudDieta) => (
            <div className="text-xs">
                <span className="block font-medium">Pedido: {reg.horario_solicitud}</span>
                <span className="text-gray-400">Supervisa: {reg.user_supervisa?.nombre || 'Pendiente'}</span>
            </div>
            )
        },
        { 
            header: 'Entrega', 
            key: 'horario_entrega',
            render: (reg: SolicitudDieta) => (
            <div className="text-xs">
                {reg.horario_entrega ? (
                <>
                    <span className="block text-green-600 font-medium">Entregado: {reg.horario_entrega}</span>
                    <span className="text-gray-400">ID Entrega: {reg.user_entrega_id}</span>
                </>
                ) : (
                <span className="text-amber-500 italic">En proceso...</span>
                )}
            </div>
            )
        },
        {
            header: 'Acción',
            key: 'accion',
            render: (reg: SolicitudDieta) => (
            <div className="flex gap-2">
                <button 
                onClick={() => console.log("Editar dieta:", reg.id)} 
                className="text-blue-600 hover:text-blue-900"
                title="Editar"
                >
                <Pencil size={18} />
                </button>
            </div>
            )
        }
    ];


    return (
        <div className="space-y-6">

            <div className="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <h3 className="text-lg font-semibold mb-2 text-gray-800">Indicaciones para elaboración de dietas</h3>
                <details className="p-2 border rounded-md">
                    <summary className="font-medium cursor-pointer text-sm">Sin colecitoqueneticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: calabacitas, brócoli, coles, coliflor, yema de huevo, leche, crema, quesos (manchego, americano), mantequilla, pan dulce, galletas, pasteles, leguminosas (frijoles, lentejas, etc.), embutidos (chorizo, tocino), fritos o capeados.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes celiacos (sin gluten)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: trigo, sémolas, espelta, harinas, avena, cebada, malta, centeno, triticale, pasta, pan, galletas, almidones modificados o levadura.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes diabéticos</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: gelatinas (excepto light), jugos (envasados o naturales), frutas con alto índice glucémico (plátano, papaya, melón, sandía), arroz, pasta, pan blanco, galletas, margarinas, manteca, embutidos.</p>
                </details>
                <details className="p-2 border rounded-md mt-2">
                    <summary className="font-medium cursor-pointer text-sm">Pacientes hipertensos (sin sal)</summary>
                    <p className="text-xs text-gray-600 mt-2">No ofrecer: embutidos (jamón, salchicha), enlatados, carnes ahumadas, lácteos, margarinas, mantequillas, fritos o capeados. Omitir sal en la preparación.</p>
                </details>
            </div>

            <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg shadow-md space-y-4">
                <h3 className="text-lg font-semibold mb-4">Definir la dieta (pedido)</h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <SelectInput
                        label="Tipo de dieta"
                        options={categoriaOptions}
                        value={categoriaData}
                        onChange={(value) => setCategoriaData(value)}
                    />
                    
                    <SelectInput
                        label="Opción específica"
                        options={dietasDisponibles}
                        value={data.dieta_id}
                        onChange={(value) => setData('dieta_id', value as string)}
                        error={errors.dieta_id}
                    />

                    <InputText
                        label='Observaciones'
                        id='observaciones'
                        name='observaciones'
                        value={data.observaciones}
                        onChange={value => setData('observaciones',value.target.value)}
                        error={errors.observaciones}/>
                    
                </div>

                <div className="flex justify-end pt-4">
                    <PrimaryButton type="submit" disabled={processing || !data.dieta_id}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <DataTable columns={columnasDietas} data={hoja.solicitudes_dieta} />
            </div>
        </div>
    );
}

export default DietaForm;