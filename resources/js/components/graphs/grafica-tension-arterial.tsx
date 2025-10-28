// components/grafica-tension-arterial.tsx
import React from 'react';
import { Line } from 'react-chartjs-2';
import { HojaSignosGraficas } from '@/types';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);

interface Props {
    data: HojaSignosGraficas[];
}

export default function GraficaTensionArterial({ data }: Props) {
    
    const datosOrdenados = data; 

    const labels = datosOrdenados.map(signo => 
        new Date(signo.fecha_hora_registro).toLocaleString('es-ES', {
            hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short'
        })
    );

    const datosSistolica = datosOrdenados.map(signo => signo.tension_arterial_sistolica);
    const datosDiastolica = datosOrdenados.map(signo => signo.tension_arterial_diastolica);

    const chartData = {
        labels,
        datasets: [
            {
                label: 'Sistólica',
                data: datosSistolica,
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
                spanGaps: true, 
            },
            {
                label: 'Diastólica',
                data: datosDiastolica,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                spanGaps: true,
            },
        ],
    };

    const options = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top' as const,
            },
        },
        scales: {
            y: {
                title: {
                    display: true,
                    text: 'mmHg'
                },
                suggestedMin: 40,
                suggestedMax: 200,
            }
        }
    };

    return (
        <div style={{ height: '300px' }}>
            <Line options={options} data={chartData} />
        </div>
    );
}