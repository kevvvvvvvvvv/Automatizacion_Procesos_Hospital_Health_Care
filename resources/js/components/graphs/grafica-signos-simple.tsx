// components/GraficaSignoVitalSimple.tsx
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
    [key: string]: any; 
};


interface Props {
    data: SignoData[];
    dataKey: string;      
    label: string;       
    unit: string;         
    borderColor: string;  
}

export default function GraficaSignoVitalSimple({
    data,
    dataKey,
    label,
    unit,
    borderColor
}: Props) {
    const labels = data.map(signo => 
        new Date(signo.fecha_hora_registro).toLocaleString('es-ES', {
            hour: '2-digit', minute: '2-digit', day: 'numeric', month: 'short'
        })
    );

    const dataset = data.map(signo => signo[dataKey]);

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
                    text: unit 
                },
            }
        }
    };

    return (
        <div style={{ height: '300px' }}>
            <Line options={options} data={chartData} />
        </div>
    );
}