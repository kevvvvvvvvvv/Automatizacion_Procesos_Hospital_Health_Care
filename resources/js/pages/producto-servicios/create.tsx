import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { useForm } from '@inertiajs/react';
import SelectInput from '@/components/ui/input-select';
import { route } from 'ziggy-js';
import PrimaryButton from '@/components/ui/primary-button';
import InputText from '@/components/ui/input-text';
import FormLayout from '@/components/form-layout';
import { Insumos, Medicamento, ProductoServicio } from '@/types';
import medicamentos from '@/routes/medicamentos';
// Interface del modelo que te manda Laravel por props


interface Props {
  productoServicio?: ProductoServicio | null; 
  medicamentos?: Medicamento;
  insumos?: Insumos;
  viasCatalogo: { id: number, via_administracion: string }[]; // Nueva Prop
  viaActualId?: number;
}

interface FormularioFormData {
  tipo: string;
  subtipo: string;
  codigo_prestacion: string;
  nombre_prestacion: string;
  importe: number | string | null;
  cantidad: number | string | null;
  iva: number | string | null;
  // Campos de Medicamentos
  excipiente_activo_gramaje?: string| null;
  volumen_total?: string | number| null;
  nombre_comercial?: string | null;
  gramaje?: string | null;
  fraccion?: string | null;
  via_administracion: string[];
  // Campos de Insumos
  categoria?: string | null;
  especificacion?: string | null;
  categoria_unitaria?: string | null;
}

const ProductoServicioForm = ({ productoServicio, medicamentos, insumos, viasCatalogo, viaActualId }: Props)=> {
  const isEdit = !!productoServicio;
  const { data, setData, post, put, processing, errors } = useForm<FormularioFormData>({
  
      tipo: productoServicio?.tipo ?? '',
      subtipo: productoServicio?.subtipo ?? '',
      codigo_prestacion: productoServicio?.codigo_prestacion ?? '',
      nombre_prestacion: productoServicio?.nombre_prestacion ?? '',
      importe: productoServicio?.importe ?? null,
      cantidad: productoServicio?.cantidad ?? null,
      iva: productoServicio?.iva ?? null,

      excipiente_activo_gramaje: medicamentos?.excipiente_activo_gramaje ?? '',
      volumen_total: medicamentos?.volumen_total ?? '',
      nombre_comercial: medicamentos?.nombre_comercial ?? '',
      gramaje: medicamentos?.gramaje ?? '',
      fraccion: medicamentos?.fraccion ?? '',
      via_administracion: [],

      categoria: insumos?.categoria ?? '',
      especificacion: insumos?.especificacion ?? '',
      categoria_unitaria: insumos?.categoria_unitaria ?? '',
    });

  const optionsTipo = [
    { value: 'INSUMOS', label: 'INSUMOS' },
    { value: 'SERVICIOS', label: 'SERVICIOS' },
  ];

  const optionsSubtipo = [
    { value: 'MEDICAMENTOS', label: 'MEDICAMENTOS' },
    { value: 'INSUMOS', label: 'INSUMOS' },
    { value: 'SERVICIOS', label: 'SERVICIOS' },
  ];
  const optionsFraccion = [
    { value: 'True', label: 'Si'},
    { value: 'False', label: 'No'},
  ];
  const optionsUnitario = [
    {value: 'AGUJA', label: "AGUJA"},
    {value: 'AGUJA RAQUINESTESICA', label: "AGUJA RAQUINESTESICA"},
    {value:'AMBU', label:'AMBU'},
    {value: "APOSITO", label: "APOSITO"},
    {value: "BOLSA", label: "BOLSA"},
    {value: 'CABESRILLO', label: 'CABESRILLO'},
    {value: "CANULA", label: "CANULA"},
    {value: "CATETER", label: "CATETER"},
    {value: "CEPILLO", label: "CEPILLO"},
    {value: "CINTA", label: "CINTA"},
    {value: "CIRCUITO", label: "CIRCUITO"},
    {value:"CONECTOR", label:"CONECTOR"},
    {value: "CPAP", label: "CPAP"},
    {value: "GUANTES", label: "GUANTES"},
    {value: "EQUIPO", label: "EQUIPO"},
    {value: 'GASAS', label: 'GASAS'},
    {value: "GORROS", label: "GORROS"},
    {value: "BISTURI", label: "BISTURI"},
    {value: "INSUMO", label: "INSUMO"},
    {value: "JERINGA", label: "JERINGA" },
    {value: "LLAVE", label: "LLAVE"},
    {value: 'MALLA', label: 'MALLA'},
    {value: 'MASCARILLA', label: 'MASCARILLA'},
    {value: "MEDIA", label: "MEDIA"} ,
    {value: "PENROSE", label: "PENROSE"},
    {value: "PAPEL", label: "PAPEL"},
    {value: "SUTURA", label: "SUTURA"},
    {value: "SONDA", label: "SONDA" },
    {value: "SOLUCION", label: "SOLUCION"},
    {value: 'TUBO ENDOTRAQUEAL', label: 'TUBO ENDOTRAQUEAL'},
    {value: 'VENDA', label: 'VENDA'},
  ];

  const optionsVias = viasCatalogo.map(via => ({
    value: via.id.toString(),
    label: via.via_administracion
  }));

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (isEdit && productoServicio) {
      // EDITAR
      put(route('producto-servicios.update', productoServicio.id));
    } else {
      // CREAR
      post(route('producto-servicios.store'));
    }
  };

  return (
    <FormLayout
      title={
        isEdit
          ? 'Editar Producto o Servicio'
          : 'Registrar Nuevo Producto o Servicio'
      }
      onSubmit={handleSubmit}
      actions={
        <PrimaryButton type="submit" disabled={processing}>
          {processing
            ? isEdit
              ? 'Actualizando...'
              : 'Guardando...'
            : isEdit
            ? 'Actualizar'
            : 'Guardar'}
        </PrimaryButton>
      }
    >
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <SelectInput
          label="Nombre capítulo"
          options={optionsTipo}
          placeholder="Seleccione un capítulo"
          value={data.tipo}
          onChange={(value) =>
            setData('tipo', value as FormularioFormData['tipo'])
          }
          error={errors.tipo}
        />

        <SelectInput
          label="Nombre subcapítulo"
          options={optionsSubtipo}
          placeholder="Seleccione un subcapítulo"
          value={data.subtipo}
          onChange={(value) =>
            setData('subtipo', value as FormularioFormData['subtipo'])
          }
          error={errors.subtipo}
        />

        <InputText
          id="codigo_prestacion"
          name="codigo_prestacion"
          label="Código de prestación"
          value={data.codigo_prestacion}
          onChange={(e) => setData('codigo_prestacion', e.target.value)}
          placeholder="Escriba el código de prestación"
          error={errors.codigo_prestacion}
        />

        <InputText
          id="nombre_prestacion"
          name="nombre_prestacion"
          label="Nombre de prestación"
          value={data.nombre_prestacion}
          onChange={(e) => setData('nombre_prestacion', e.target.value)}
          placeholder="Escriba el nombre de la prestación"
          error={errors.nombre_prestacion}
        />

        <InputText
          id="importe"
          name="importe"
          label="Importe del producto o servicio"
          value={(data.importe ?? '').toString()}
          onChange={(e) => setData('importe', e.target.value)}
          placeholder="Escriba la cantidad del importe"
          error={errors.importe}
        />
        <InputText
          id="iva"
          name="iva"
          label="IVA en producto o servicio"
          value={(data.iva ?? '').toString()}
          onChange={(e) => setData('iva', e.target.value)}
          placeholder="Escriba la cantidad del IVA"
          error={errors.iva}
        />

        {data.tipo === 'INSUMOS' && (
          <InputText
            id="cantidad"
            name="cantidad"
            label="Cantidad"
            value={(data.cantidad ?? '').toString()}
            onChange={(e) => setData('cantidad', e.target.value)}
            placeholder="Escriba la cantidad del producto disponible"
            error={errors.cantidad}
          />
          
        )}
        {data.subtipo === 'MEDICAMENTOS' && (
          <>
            <InputText
            id = 'excipiente_activo_gramaje'
            name='excipiente_activo_gramaje'
            label = 'Excipiente activo'
            value={data.excipiente_activo_gramaje ?? ''}
            onChange={e => setData('excipiente_activo_gramaje', e.target.value)}
            placeholder='Escriba el excipiente activo con framaje'
            error={errors.excipiente_activo_gramaje}
            />
            <InputText
            id = 'nombre_comercial'
            name = 'nombre_comercial' 
            label="Nombre Comercial" 
            value={data.nombre_comercial ?? ''} 
            onChange={e => setData('nombre_comercial', e.target.value)}
            placeholder='Escriba el nombre comercial del producto'
            error={errors.nombre_comercial}
            />
            <InputText
            id = 'volumen_total'
            name = 'volumen_total'
            label = 'Volumen total de la presentaciòn'
            value={(data.volumen_total ?? '').toString()}
            onChange={(e) =>  setData('volumen_total', e.target.value)}
            placeholder='Ingresel el volumen total del producto'
            />
            <InputText
            id= 'gramaje'
            name= 'gramaje'
            label='Gramaje'
            value = {data.gramaje ?? ''}
            onChange={e  => setData ('gramaje', e.target.value)}
            placeholder='Escriba el gramaje de su producto'
            />
             <SelectInput
              label="Es fraccionable"
              options={optionsFraccion}
              placeholder="Seleeccion una opción"
              value={data.fraccion ?? ''}
              onChange={(value) =>
                setData('fraccion', value as FormularioFormData['fraccion'])
              }
              error={errors.tipo}
            />
            <SelectInput
            label="Vías de administración"
            isMulti={true} 
            options={optionsVias}
            value={data.via_administracion} 
            onChange={(values) => setData('via_administracion', values)}
            error={errors.via_administracion}
          />
        </>
        )}
        {data.subtipo === 'INSUMOS' && (
          <>
              <InputText 
              id = 'categoria'
              name='categoria'
              label="Categoría"
              value={data.categoria ?? ''} 
              onChange={e => setData('categoria', e.target.value)} />
              
              <InputText
              id= 'especificacion'
              name= 'especificacion'
              label='Especificación'
              value={data.especificacion ?? ''}
              onChange={e => setData('especificacion', e.target.value)}

              />
              <SelectInput
              label='Categoria unitaria'
              options={optionsUnitario}
              value={data.categoria_unitaria ?? ''}
              onChange={(value) =>
                setData('categoria_unitaria', value as FormularioFormData['categoria_unitaria'])
              }
              error={errors.tipo}
              />
              
          </>
        )}
      </div>
    </FormLayout>
  );
};

ProductoServicioForm.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle='Registrar producto o servicio' children={page} link='producto-servicios.index'/>
    )
}

export default ProductoServicioForm;
