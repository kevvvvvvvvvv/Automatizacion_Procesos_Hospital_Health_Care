import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import SelectInput from '@/components/ui/input-select';
import PrimaryButton from '@/components/ui/primary-button';
import TextareaInput from '@/components/ui/input-text-area'; 
import { route } from 'ziggy-js';
import { Estancia, FormularioCatalogo, Paciente, ResumenMedico} from '@/types'; 
import FormLayout from '@/components/form-layout';

interface Props {
    resumen: ResumenMedico;
    paciente: Paciente;
    estancia: Estancia;
    onSubmit: (form:any) => void;
    submitLabel?: string;

}
export const ResumenForm = ({
    paciente,
    estancia,
    onSubmit, 
    resumen, 
    submitLabel = 'guardar'
}: Props) => {
    const form = useForm ({
        resumen: resumen?.resumen_medico || '',
    });
    const { data, setData, processing, errors} = form;
    const handleSubmit = (e:React.FormEvent) => {
        e.preventDefault();
        onSubmit(form);
    };
  const textAreaClasses = `w-full px-3 py-2 rounded-md shadow-sm border text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2a2b56] focus:border-[#2a2b56] transition`;
    const labelClasses = ' block text-sm font-medium text-gray-700 mb-1';
    return(
        <FormLayout 
        title='Resumen médico'
        onSubmit = {handleSubmit}
        actions={
            <PrimaryButton type='submit' disabled={processing}>
                {processing ? 'Creando...': 'Crear resumen médico'}
            </PrimaryButton>
        }>
        <div className="mb-4">
          <label htmlFor="resumen_medico" className={labelClasses}>
            Evolución y Actualización
          </label>
          <textarea
            id="resumen_medico"
            className={textAreaClasses}
            value={data.resumen}
            onChange={(e) => setData('resumen', e.target.value)}
            placeholder="Ingrese la informació"
            rows={4}
            autoComplete="off"
          />
          </div>
        </FormLayout>
    )
} 