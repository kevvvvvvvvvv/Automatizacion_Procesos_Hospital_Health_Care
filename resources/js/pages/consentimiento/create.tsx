// resources/js/Pages/consentimientos/Index.tsx  (o Create.tsx según tu organización)
import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';

import FormLayout from '@/components/form-layout';
import PrimaryButton from '@/components/ui/primary-button';
import InfoField from '@/components/ui/info-field';
import { route } from 'ziggy-js';
import { Estancia, Paciente, Consentimiento } from '@/types';

import PacienteCard from '@/components/paciente-card';

type Props = {
  paciente: Paciente;
  estancia: Estancia;
  consentimiento?: Consentimiento | null;
};

const CONSENTIMIENTOS = [
  'Consentimiento 1: Hospitalización',
  'Consentimiento 2: Procedimiento de círugia mayor',
  'Consentimiento 3: Procedimientos que requieren anestesia general o regional',
  'Consentimiento 4: Salpingoclasia y vasectomía',
  'Consentimiento 5: Donación de órganos, tejidos y trasplantes ',
  'Consentimiento 6: Investigación clínica en seres humanos',
  'Consentimiento 7: Necropsia hospitalaria',
  'Consentimiento 8: Procedimientos diagnósticos y terapéuticos considerados por el médico como de alto riesgo',
  'Consentimiento 9: Cualquier procedimiento que entrañe mutilación',
  'Consentimiento 10: Reanimación cardiopulmonar, intubación y maniobras de resucitación',
];

const CreateConsentimiento: React.FC<Props> = ({ paciente, estancia }) => {
  // route_pdf ahora es un array de strings
  const { data, setData, post, processing, errors } = useForm({
    diagnostico: '',
    route_pdf: [] as string[],
  });


  const toggleSelection = (key: string) => {
    const current: string[] = data.route_pdf ?? [];
    if (current.includes(key)) {
      setData('route_pdf', current.filter(k => k !== key));
    } else {
      setData('route_pdf', [...current, key]);
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    post(route('consentimientos.store', {
      paciente: paciente.id,
      estancia: estancia.id,
    }));
  };

  return (
    <MainLayout pageTitle={'Consentiminetos'} link="estancias.show" linkParams={estancia.id}>
      <PacienteCard paciente={paciente} estancia={estancia} />
      <Head title="Consentimientos" />
      <div className="p-4 md:p-8">
        <FormLayout
          title="Registro de consentimientos"
          onSubmit={handleSubmit}
          actions={
            <PrimaryButton type="submit" disabled={processing}>
              {processing ? 'Guardando...' : 'Guardar consentimiento'}
            </PrimaryButton>
          }
        >

          <div className="mt-6">
            <fieldset>
              <legend className="text-sm font-medium text-gray-700 mb-3">Seleccione una o más opciones</legend>

              <div className="grid grid-cols-1 gap-3">
                {CONSENTIMIENTOS.map((label, idx) => {
                  const key = idx === CONSENTIMIENTOS.length - 1 ? 'otro' : String(idx);
                  const selected = (data.route_pdf ?? []).includes(key);

                  return (
                    <label
                      key={key}
                      className={`flex items-start space-x-3 p-3 rounded-lg border ${selected ? 'border-blue-500 bg-blue-50' : 'border-gray-200'} cursor-pointer`}
                    >
                      <input
                        type="checkbox"
                        name="route_pdf[]"
                        value={key}
                        checked={selected}
                        onChange={() => toggleSelection(key)}
                        className="mt-1"
                      />
                      <div className="flex-1">
                        <div className="text-sm font-medium text-gray-900">{label}</div>

                        {key === 'Consentimiento 10' && selected && (
                          <div className="mt-2">
                            <textarea
                              value={data.diagnostico ?? ''}
                              onChange={(e) => setData('diagnostico', e.target.value)}
                              className="w-full border rounded-md p-2 text-sm"
                              rows={4}
                              placeholder="Especifique aquí el consentimiento..."
                            />
                            {errors.diagnostico && <p className="text-sm text-red-600 mt-1">{errors.diagnostico}</p>}
                          </div>
                        )}
                      </div>
                    </label>
                  );
                })}
              </div>

              {errors.route_pdf && <p className="text-sm text-red-600 mt-2">{errors.route_pdf}</p>}
            </fieldset>
          </div>
        </FormLayout>
      </div>
    </MainLayout>
  );
};

export default CreateConsentimiento;
