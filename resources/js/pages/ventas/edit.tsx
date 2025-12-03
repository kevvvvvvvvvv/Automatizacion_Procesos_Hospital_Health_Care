import React, { useMemo } from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import InfoField from '@/components/ui/info-field';
import FormLayout from '@/components/form-layout';
import { route } from 'ziggy-js';
import { Venta, Paciente, Estancia } from '@/types';

interface EditVentaProps {
  venta: Venta;

  paciente?: { id: number };
  estancia?: { id: number };
}

const EditVenta = ({ venta }: EditVentaProps) => {
  // Inicializamos el formulario con:
  // - descuento: si antes hay descuento lo mostramos como monto por defecto
  // - descuento_tipo: 'monto' o 'porcentaje' (por defecto 'monto')
  const { data, setData, put, processing, errors } = useForm({
    descuento: venta.descuento ?? 0,
    descuento_tipo: 'monto' as 'monto' | 'porcentaje',
  });

  // Calcula en vivo el monto del descuento y el total mostrado
  const { descuentoMonto, totalCalculado, porcentaje } = useMemo(() => {
    if (data.descuento_tipo === 'porcentaje') {
      const pct = Number(data.descuento) || 0;
      const monto = Number((venta.subtotal * (pct / 100)).toFixed(2));
      const total = Number((venta.subtotal - monto).toFixed(2));
      return { descuentoMonto: monto, totalCalculado: total, porcentaje: pct };
    } else {
      const monto = Number(data.descuento) || 0;
      const total = Number((venta.subtotal - monto).toFixed(2));
      // porcentaje calculado solo informativo
      const pct = venta.subtotal > 0 ? Number(((monto / venta.subtotal) * 100).toFixed(2)) : 0;
      return { descuentoMonto: monto, totalCalculado: total, porcentaje: pct };
    }
  }, [data.descuento, data.descuento_tipo, venta.subtotal]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    // Enviamos lo que el backend necesita: tipo y valor.
    // Si el tipo es 'porcentaje' se enviará 'descuento' como porcentaje (ej: 10)
    // Si el tipo es 'monto' se enviará 'descuento' como monto en moneda (ej: 50.00)
    put(route('ventas.update', { venta: venta.id }), {
      preserveState: true,
      data: {
        descuento: data.descuento,
        descuento_tipo: data.descuento_tipo,
      },
    });
  };

  return (
    <FormLayout
      title="Edición de venta"
      onSubmit={handleSubmit}
      actions={
        <PrimaryButton type="submit" disabled={processing}>
          {processing ? 'Actualizando...' : 'Guardar Descuento'}
        </PrimaryButton>
      }
    >
      <Head title="Editar Descuento - Venta" />

      <div className="grid grid-cols-1 gap-4 max-w-lg">
        <InfoField label="Subtotal" value={`$ ${venta.subtotal}`} />

        <div>
          <label className="block text-sm font-medium text-gray-700 mb-1">Tipo de descuento</label>
          <div className="flex items-center space-x-4">
            <label className="flex items-center space-x-2">
              <input
                type="radio"
                name="descuento_tipo"
                value="monto"
                checked={data.descuento_tipo === 'monto'}
                onChange={() => setData('descuento_tipo', 'monto')}
                className="form-radio"
              />
              <span>Monto</span>
            </label>

            <label className="flex items-center space-x-2">
              <input
                type="radio"
                name="descuento_tipo"
                value="porcentaje"
                checked={data.descuento_tipo === 'porcentaje'}
                onChange={() => setData('descuento_tipo', 'porcentaje')}
                className="form-radio"
              />
              <span>Porcentaje</span>
            </label>
          </div>
        </div>

        <div>
          <label htmlFor="descuento" className="block text-sm font-medium text-gray-700 mb-1">
            {data.descuento_tipo === 'porcentaje' ? 'Porcentaje (%)' : 'Descuento (monto)'}
          </label>

          <InputText
            id="descuento"
            name="descuento"
            label = "Descuento" 
            type="number"
            value={String(data.descuento ?? '')}
            onChange={(e) =>
              // permite dejar vacío o setear número
              setData('descuento', e.target.value === '' ? '' : Number(e.target.value))
            }
            placeholder={data.descuento_tipo === 'porcentaje' ? 'Ej. 10 para 10%' : 'Ej. 50.00'}
          />
          {errors.descuento && <p className="text-sm text-red-600 mt-1">{errors.descuento}</p>}
          {errors.descuento_tipo && <p className="text-sm text-red-600 mt-1">{errors.descuento_tipo}</p>}
        </div>

        <div>
          <InfoField label="Descuento aplicado (monto)" value={`$ ${descuentoMonto.toFixed(2)}`} />
          <div className="text-sm text-gray-600 mt-1">Equivalente: {porcentaje}%</div>
        </div>

        <div>
          <InfoField label="Total calculado" value={`$ ${totalCalculado.toFixed(2)}`} />
        </div>
      </div>
    </FormLayout>
  );
};

EditVenta.layout = (page: React.ReactElement) => {
  const { estancia, paciente } = page.props as EditVentaProps;

  return (
    <MainLayout
      pageTitle="Edición de ventas"
      link="pacientes.estancias.ventas.index"      
      linkParams={{ paciente: paciente?.id, estancia: estancia?.id }}
    >
      {page}
    </MainLayout>
  );
};


export default EditVenta;
