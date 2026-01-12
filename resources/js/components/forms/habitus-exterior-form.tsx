import React from 'react';
import { useForm } from '@inertiajs/react'
import { HojaEnfermeria } from '@/types';
import { route } from 'ziggy-js';

import InputTextArea from '@/components/ui/input-text-area';
import SelectInput from '../ui/input-select';
import PrimaryButton from '../ui/primary-button';


interface Props {
    hojasenfermeria: HojaEnfermeria
}

const condicionLlegadaOptions = [
    { value: 'ambulatorio', label: 'Ambulatorio (Caminando)' },
    { value: 'silla_ruedas', label: 'Silla de ruedas' },
    { value: 'camilla', label: 'Camilla' }, 
    { value: 'muletas_baston', label: 'Con muletas / Bastón / Andadera' },
    { value: 'apoyo_familiar', label: 'Con apoyo de terceros/familiar' },
    { value: 'brazos', label: 'En brazos (Pediátrico)' } 
];

const faciesOptions = [
    { value: 'no_caracteristica', label: 'No característica (Normal)' },
    { value: 'algica', label: 'Álgica (Expresión de dolor)' }, 
    { value: 'palida', label: 'Pálida' },
    { value: 'cianotica', label: 'Cianótica (Azulosa/Falta de aire)' },
    { value: 'icterica', label: 'Ictérica (Amarilla)' }, 
    { value: 'febril', label: 'Febril / Rubicunda (Rojiza)' },
    { value: 'ansiosa', label: 'Ansiosa / Angustiada' },
    { value: 'depresiva', label: 'Depresiva' },
    { value: 'caquetica', label: 'Caquéctica (Desnutrición severa)' },
    { value: 'edematosa', label: 'Edematosa / Renal (Hinchada)' },
    { value: 'paralisis_facial', label: 'Parálisis facial / Asimétrica' }, 

    { value: 'lupica', label: 'Lúpica (Alas de mariposa)' },
    { value: 'hipertiroidea', label: 'Hipertiroidea (Ojos saltones)' }, 
    { value: 'acromegalica', label: 'Acromegálica' } 
];

const constitucionOptions = [
    { value: 'media', label: 'Media (Eutrófico)' }, 
    { value: 'delgada', label: 'Delgada (Hipotrófico)' },
    { value: 'caquetica', label: 'Caquéctica (Desnutrición severa)' },
    { value: 'robusta', label: 'Robusta (Sobrepeso)' },
    { value: 'obesa', label: 'Obesa' }
];

const pielOptions = [
    { value: 'integra', label: 'Íntegra / Hidratada' },
    { value: 'deshidratada', label: 'Deshidratada / Seca' },
    { value: 'diaforetica', label: 'Diaforética (Sudorosa)' }, 
    { value: 'palida_fria', label: 'Pálida y fría' },
    { value: 'con_heridas', label: 'Con heridas / Lesiones' },
    { value: 'con_hematomas', label: 'Con hematomas / Equimosis (Moretones)' },
    { value: 'con_exantema', label: 'Con exantema (Erupciones/Granitos)' },
    { value: 'edematosa', label: 'Edematosa (Hinchada / Retención de líquidos)' },
    { value: 'marmorea', label: 'Marmórea (Piel veteada / Signo de choque)' },
    { value: 'cianotica_distal', label: 'Cianótica distal (Dedos azules)' }
];

const posturaOptions = [
    { value: 'libremente_escogida', label: 'Libremente escogida (Se mueve sin dolor/voluntad propia)' },
    { value: 'instintiva', label: 'Instintiva (Posición fetal / Gatillo de fusil - Para evitar dolor)' },
    { value: 'forzada', label: 'Forzada (No se puede mover por sí mismo / Inmovilizado)' },
    { value: 'pasiva', label: 'Pasiva (Coma / Sedación / Parálisis)' }
];

const estadoConciencaOptions = [
    { value: 'alerta', label: 'Alerta' },
    { value: 'agitado', label: 'Agitado / Delirio' },
    { value: 'letárgico', label: 'Letárgico' },
    { value: 'obnubilado', label: 'Obnubilado' },
    { value: 'estuporoso', label: 'Estuporoso' },
    { value: 'coma', label: 'Coma' },
];

const marchaOptions = [
    { value: 'normal', label: 'Eubásica / Normal' },
    { value: 'claudicante', label: 'Claudicante (Cojera)' },
    { value: 'ataxica', label: 'Atáxica (Tambaleante / Borracho)' },
    { value: 'espastica', label: 'Espástica (Rigidez / Arrastra pies)' },
    { value: 'parkinsoniana', label: 'Parkinsoniana (Pasos cortos y rápidos)' },
    { value: 'no_valorable', label: 'No valorable (En cama/silla)' }
];

const movimientosOptions = [
    { value: 'ninguno', label: 'Ninguno' },
    { value: 'temblor', label: 'Temblores' },
    { value: 'tics', label: 'Tics' },
    { value: 'convulsiones', label: 'Convulsiones / Crisis' },
    { value: 'fasciculaciones', label: 'Fasciculaciones (Saltos musculares)' },
    { value: 'corea', label: 'Corea (Movimientos involuntarios rápidos)' },
    { value: 'distonia', label: 'Distonía (Contracciones musculares)' }
];

const higieneOptions = [
    { value: 'adecuado', label: 'Limpio y Adecuado' },
    { value: 'desalinado', label: 'Desaliñado / Descuidado' },
    { value: 'mala_higiene', label: 'Mala higiene / Olor fétido' },
];

const edadAparenteOptions = [
    { value: 'igual', label: 'Igual a la cronológica' },
    { value: 'mayor', label: 'Mayor a la cronológica (Se ve más viejo)' },
    { value: 'menor', label: 'Menor a la cronológica (Se ve más joven)' },
];

const HabitusExteriorForm = ({hojasenfermeria}: Props) => {

    const { data, setData, post, processing, errors,reset } = useForm({
        condicion_llegada: '',
        facies:  '',
        constitucion: '',
        postura:  '',
        piel: '',
        estado_conciencia: '',
        marcha: '',
        movimientos: '',
        higiene: '',
        edad_aparente: '',
    });

    const {data: dataObservaciones, setData: setDataObservaciones, put: putObservaciones, reset: resetObservaciones, errors: errorsObservaiones } = useForm({
        observaciones: hojasenfermeria.observaciones || '',
    });

    const handleObservacionesUpdate = (e: React.FormEvent) => {
        e.preventDefault();
        putObservaciones(route('hojasenfermerias.update', { hojasenfermeria: hojasenfermeria.id }),{
            onSuccess: () =>resetObservaciones()
        });
    };

    const handleHabitusExteriorSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('hojas-habitus-exterior.store', { hojasenfermeria: hojasenfermeria.id }),{
            onSuccess: () => reset()
        });
    };

    return (
        <>
            <form onSubmit={handleObservacionesUpdate}>

                <InputTextArea
                    id='observaciones'
                    label='Observaciones'
                    value={dataObservaciones.observaciones}
                    onChange={e => setDataObservaciones('observaciones', e.target.value)}
                    error={errorsObservaiones.observaciones}
                />

                <div className="mt-4 flex justify-end">
                    <PrimaryButton type='submit' disabled={processing}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
            <form onSubmit={handleHabitusExteriorSubmit}>

                <div className='grid md:grid-cols-3 grid-cols-1 gap-2'>
                    <SelectInput
                        label='Condición de llegada'
                        options={condicionLlegadaOptions}
                        value={data.condicion_llegada}
                        onChange={(e) => setData('condicion_llegada', e)}
                        error={errors.condicion_llegada}
                    />

                    <SelectInput
                        label='Facies'
                        options={faciesOptions}
                        value={data.facies}
                        onChange={(e) => setData('facies', e)}
                        error={errors.facies}
                    />

                    <SelectInput
                        label='Constitución'
                        options={constitucionOptions}
                        value={data.constitucion}
                        onChange={(e) => setData('constitucion', e)}
                        error={errors.constitucion}
                    />

                    <SelectInput
                        label='Actitud/Postura'
                        options={posturaOptions}
                        value={data.postura}
                        onChange={(e) => setData('postura', e)}
                        error={errors.postura}
                    />

                    <SelectInput
                        label='Integridad de la piel'
                        options={pielOptions}
                        value={data.piel}
                        onChange={(e) => setData('piel', e)}
                        error={errors.piel}
                    />

                    <SelectInput
                        label='Estado de conciencia'
                        options={estadoConciencaOptions} 
                        value={data.estado_conciencia}
                        onChange={(e) => setData('estado_conciencia', e)}
                        error={errors.estado_conciencia}
                    />

                    <SelectInput
                        label='Edad Aparente'
                        options={edadAparenteOptions}
                        value={data.edad_aparente}
                        onChange={(e) => setData('edad_aparente', e)}
                        error={errors.edad_aparente}
                    />

                    <SelectInput
                        label='Marcha (Forma de caminar)'
                        options={marchaOptions}
                        value={data.marcha}
                        onChange={(e) => setData('marcha', e)}
                        error={errors.marcha}
                    />

                    <SelectInput
                        label='Movimientos Anormales'
                        options={movimientosOptions}
                        value={data.movimientos}
                        onChange={(e) => setData('movimientos', e)}
                        error={errors.movimientos}
                    />

                    <SelectInput
                        label='Vestido y Aliño'
                        options={higieneOptions}
                        value={data.higiene}
                        onChange={(e) => setData('higiene', e)}
                        error={errors.higiene}
                    />

                </div>
                <div className="mt-4 flex justify-end">
                    <PrimaryButton type='submit' disabled={processing}>
                        {processing ? 'Guardando...' : 'Guardar'}
                    </PrimaryButton>
                </div>
            </form>
        </>
    )
}

export default HabitusExteriorForm;