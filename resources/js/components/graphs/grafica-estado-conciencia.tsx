// components/GraficaEstadoConciencia.tsx
import React from 'react';
import { Line } from 'react-chartjs-2';
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

type SignoData = {
    fecha_hora_registro: string;
    estado_conciencia: string | null; 
    [key: string]: any; 
};

interface Props {
    data: SignoData[];
    label?: string; 
    borderColor?: string; 
}

const CONSCIENCE_MAP_VALUES: { [key: string]: number } = {
    'Coma': 1,
    'Estuporoso': 2,
    'Obnubilado': 3,
    'Letárgico': 4,
    'Alerta': 5,
};

const CONSCIENCE_MAP_LABELS: { [key: number]: string } = {
    1: 'Coma',
    2: 'Estuporoso',
    3: 'Obnubilado',
    4: 'Letárgico',
    5: 'Alerta',
};

const MAX_CONSCIENCE_LEVEL = Object.keys(CONSCIENCE_MAP_LABELS).length;

export default function GraficaEstadoConciencia({
    data,
    label = 'Estado de Conciencia', 
    borderColor = 'rgb(153, 102, 255)'
}: Props) {

    const labels = data.map(signo => 
        new Date(signo.fecha_hora_registro).toLocaleString('es-ES', {
            hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short'
        })
    );
    const dataset = data.map(signo => CONSCIENCE_MAP_VALUES[signo.estado_conciencia] || null);

    const chartData = {
        labels,
        datasets: [
            {
                label: label,
                data: dataset,
                borderColor: borderColor,
                backgroundColor: `${borderColor.slice(0, -1)}, 0.5)`, 
                yAxisID: 'y',
                spanGaps: true, 
                stepped: true,
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
                type: 'linear' as const,
                display: true,
                position: 'left' as const,
                title: {
                    display: true,
                    text: 'Nivel' 
                },
                ticks: {
                    callback: (value: string | number) => CONSCIENCE_MAP_LABELS[value as number] || null,
                    stepSize: 1, // Fuerza los ticks a ser enteros
                },
                min: 1, 
                max: MAX_CONSCIENCE_LEVEL, 
            }
        }
    };

    return (
        <div style={{ height: '300px' }}>
            <Line options={options} data={chartData} />
        </div>
    );
}
