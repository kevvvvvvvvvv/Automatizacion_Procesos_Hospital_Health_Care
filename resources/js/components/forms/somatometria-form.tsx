import React from 'react';
import { useForm } from '@inertiajs/react';
import { HojaEnfermeria, RecienNacido, Somatometrias } from '@/types'; 
import { route } from 'ziggy-js';
import { Pencil } from 'lucide-react';  
import Swal from 'sweetalert2';

import InputText from '@/components/ui/input-text';
import PrimaryButton from '@/components/ui/primary-button';
import { DataTable } from '../ui/data-table';

interface Props {
    hoja:  RecienNacido;
}

const SomatometriaForm: React.FC<Props> = ({ hoja }) => {
    // Definimos el formulario con los campos de tu migración
    const { data, setData, post, processing, errors, reset } = useForm({
        fecha_hora_registro: new Date().toISOString().slice(0, 16),
        perimetro_cefalico: '',
        perimetro_toracico: '',
        perimetro_abdominal: '',
        pie: '',
        segmento_inferior: '',
        capurro: '',
        apgar: '',
        silverman: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        Swal.fire({
            title: '¿Confirmar registro?',
            text: "Se guardarán los datos de somatometría capturados.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Asegúrate de que esta ruta exista en tu web.php
                post(route('somatometrias.store', { reciennacido: hoja.id }), {
                    preserveScroll: true,
                    onSuccess: () => {
                        reset();
                    }
                });
            } if (!hoja?.id) {
                    Swal.fire('Error', 'No se encontró el ID del recién nacido', 'error');
                    return;
                }
        });
    }

    const columnasSomatometria = [
        {
            header: 'Fecha/Hora',
            key: 'fecha_hora_registro',
            render: (reg: Somatometrias) => {
                const fecha = reg.created_at || reg.created_at;
                return fecha ? new Date(fecha).toLocaleString() : '---';
            }
        },
        {
            header: 'P. Cefálico',
            key: 'perimetro_cefalico',
            render: (reg: Somatometrias) => reg.perimetro_cefalico ? `${reg.perimetro_cefalico} cm` : '---'
        },
        {
            header: 'P. Torácico',
            key: 'perimetro_toracico',
            render: (reg: Somatometrias) => reg.perimetro_toracico ? `${reg.perimetro_toracico} cm` : '---'
        },
        {
            header: 'P. Abdominal',
            key: 'perimetro_abdominal',
            render: (reg: Somatometrias) => reg.perimetro_abdominal ? `${reg.perimetro_abdominal} cm` : '---'
        },
        {
            header: 'Pie',
            key: 'pie',
            render: (reg: Somatometrias) => reg.pie ? `${reg.pie} cm` : '---'
        },
        {
            header: 'Capurro',
            key: 'capurro',
            render: (reg: Somatometrias) => reg.capurro ? `${reg.capurro} sem` : '---'
        },
        {
            header: 'APGAR',
            key: 'apgar',
            render: (reg: Somatometrias) => reg.apgar ? reg.apgar : '---'
        },
        {
            header: 'Silverman',
            key: 'silverman',
            render: (reg: Somatometrias) => reg.silverman !== null ? reg.silverman : '---'
        },
        {
            header: 'Acción',
            key: 'accion',
            render: (reg: Somatometrias) => (
                <button
                    onClick={() => console.log('Editar registro', reg.id)}
                    className='text-blue-600 hover:text-blue-900'>
                    <Pencil size={18} />
                </button>
            )
        }
    ];

    return (
        <>
            <form onSubmit={handleSubmit} className="space-y-6">
                <h2 className='mb-5 font-bold text-xl text-black-700 border-b pb-2'>Somatometría y Escalas Neonatales</h2>
                
                <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <InputText
                        id="perimetro_cefalico"
                        name="perimetro_cefalico"
                        label="P. Cefálico (cm)"
                        type="number"
                        step="0.1"
                        value={data.perimetro_cefalico}
                        onChange={(e) => setData('perimetro_cefalico', e.target.value)}
                        error={errors.perimetro_cefalico}
                    />
                    <InputText
                        id="perimetro_toracico"
                        name="perimetro_toracico"
                        label="P. Torácico (cm)"
                        type="number"
                        step="0.1"
                        value={data.perimetro_toracico}
                        onChange={(e) => setData('perimetro_toracico', e.target.value)}
                        error={errors.perimetro_toracico}
                    />
                    <InputText
                        id="perimetro_abdominal"
                        name="perimetro_abdominal"
                        label="P. Abdominal (cm)"
                        type="number"
                        step="0.1"
                        value={data.perimetro_abdominal}
                        onChange={(e) => setData('perimetro_abdominal', e.target.value)}
                        error={errors.perimetro_abdominal}
                    />
                    <InputText
                        id="pie"
                        name="pie"
                        label="Pie (cm)"
                        type="number"
                        step="0.1"
                        value={data.pie}
                        onChange={(e) => setData('pie', e.target.value)}
                        error={errors.pie}
                    />
                    <InputText
                        id="segmento_inferior"
                        name="segmento_inferior"
                        label="Seg. Inferior (cm)"
                        type="number"
                        step="0.1"
                        value={data.segmento_inferior}
                        onChange={(e) => setData('segmento_inferior', e.target.value)}
                        error={errors.segmento_inferior}
                    />
                </div>

                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                    <InputText
                        id="capurro"
                        name="capurro"
                        label="Test de Capurro (Semanas)"
                        placeholder="Ej: 38.2"
                        value={data.capurro}
                        onChange={(e) => setData('capurro', e.target.value)}
                        error={errors.capurro}
                    />
                    <InputText
                        id="apgar"
                        name="apgar"
                        label="APGAR (1' / 5')"
                        placeholder="Ej: 8/9"
                        value={data.apgar}
                        onChange={(e) => setData('apgar', e.target.value)}
                        error={errors.apgar}
                    />
                    <InputText
                        id="silverman"
                        name="silverman"
                        label="Test de Silverman"
                        type="number"
                        placeholder="0-10"
                        value={data.silverman}
                        onChange={(e) => setData('silverman', e.target.value)}
                        error={errors.silverman}
                    />
                </div>

                <div className="flex justify-end">
                    <PrimaryButton type="submit" disabled={processing}>
                        {processing ? 'Guardando...' : 'Registrar Somatometría'}
                    </PrimaryButton>
                </div>
            </form>

            <div className="mt-12">
                <h3 className="font-semibold mb-4">Historial de Mediciones</h3>
                <DataTable 
                    columns={columnasSomatometria} 
                    data={hoja?.somatometrias || []} 
                />
            </div>
        </>
    );
}

export default SomatometriaForm;