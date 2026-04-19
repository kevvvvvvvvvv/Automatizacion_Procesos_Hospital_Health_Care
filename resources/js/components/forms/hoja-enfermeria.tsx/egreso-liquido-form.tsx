import React from 'react';
import { useForm } from '@inertiajs/react';
import { route } from 'ziggy-js';
import { HojaEnfermeriaQuirofano, EgresoLiquido } from '@/types';
import { formatDate } from '@/utils/date-utils';

import { DataTable } from '@/components/ui/data-table';
import PrimaryButton from '@/components/ui/primary-button';
import TextAreaInput from '@/components/ui/input-text-area';
import TextInput from '@/components/ui/input-text';
import SelectInput from '@/components/ui/input-select';

interface Props {
    hoja: HojaEnfermeriaQuirofano;
    tiposDisponibles: { value: string; label: string }[];
}

const EgresoLiquidoForm = ({ hoja, tiposDisponibles }: Props) => {
    const { data, setData, post, processing, errors, reset } = useForm({
        liquidable_id: hoja.id,
        liquidable_type: hoja.tipo_modelo,
        tipo: '',
        cantidad: '',
        descripcion: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('egresos-liquidos.store'), {
            onSuccess: () => {
                reset('tipo', 'cantidad', 'descripcion');
            },
        });
    };

    const egresoLiquidoTable = [
        {
            header: 'Fecha/Hora',
            key: 'created_at',
            render: (reg: EgresoLiquido) => formatDate(reg.created_at)
        },
        {
            header: 'Tipo de egreso',
            key: 'tipo'
        },
        {
            header: 'Cantidad (ml)',
            key: 'tipo',
            render: (reg: EgresoLiquido) => <span>{reg.cantidad} ml</span>
        },
        {
            header: 'Descripción',
            key: 'descripcion',
        }
    ];

    return (
        <>
        <form onSubmit={submit} className="space-y-4 p-4 border rounded-lg bg-gray-50">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">

                <SelectInput
                    label='Tipo de egreso'
                    options={tiposDisponibles}
                    value={data.tipo}
                    onChange={e => setData('tipo',e)}
                    error={errors.tipo}
                />

                <TextInput
                    id=''
                    name=''
                    label='Cantidad (ml)'
                    type="number"
                    value={data.cantidad}
                    onChange={ e => setData('cantidad', e.target.value)}
                    error={errors.cantidad}
                />

                <TextAreaInput
                    label='Descripción'
                    value={data.descripcion}
                    onChange={ e =>setData('descripcion', e.target.value)}
                    error={errors.descripcion}
                />
            </div>

            <PrimaryButton
                disabled={processing}
                type='submit'
            >
                {processing ? 'Guardando...' : 'Guardar'}
            </PrimaryButton>
        </form>
        <DataTable
            columns={egresoLiquidoTable}
            data={hoja.egreso_liquidos}
        />
        </>
    );
};

export default EgresoLiquidoForm;