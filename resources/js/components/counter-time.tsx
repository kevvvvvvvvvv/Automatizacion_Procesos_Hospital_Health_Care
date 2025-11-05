import React, { useState, useEffect } from 'react';

function formatarDiferencia(ms: number): string {
    if (ms < 0) ms = 0; 

    let totalSegundos = Math.floor(ms / 1000);
    const dias = Math.floor(totalSegundos / (3600 * 24));
    totalSegundos %= (3600 * 24);
    const horas = Math.floor(totalSegundos / 3600);
    totalSegundos %= 3600;
    const minutos = Math.floor(totalSegundos / 60);
    const segundos = totalSegundos % 60;

    const parts: string[] = [];
    if (dias > 0) parts.push(`${dias}d`);
    if (horas > 0) parts.push(`${horas}h`);
    if (minutos > 0) parts.push(`${minutos}m`);

    if (segundos > 0 || parts.length === 0) {
        parts.push(`${segundos}s`);
    }

    return parts.join(' ');
}


interface Props {
    fechaInicioISO: string | null;
    fechaFinISO: string | null; 
}

const ContadorTiempo: React.FC<Props> = ({ fechaInicioISO, fechaFinISO }) => {
    
    const [tiempoFormateado, setTiempoFormateado] = useState('');

    useEffect(() => {

        if (!fechaInicioISO) {
            setTiempoFormateado('Pendiente');
            return; 
        }

        const fechaInicioDate = new Date(fechaInicioISO);

        if (fechaFinISO) {
            const fechaFinDate = new Date(fechaFinISO);
            const diferenciaMs = fechaFinDate.getTime() - fechaInicioDate.getTime();
            
            setTiempoFormateado(formatarDiferencia(diferenciaMs));
            return; 
        }

        const ahoraInicial = new Date();
        const diferenciaInicialMs = ahoraInicial.getTime() - fechaInicioDate.getTime();
        setTiempoFormateado(formatarDiferencia(diferenciaInicialMs));

        const intervalo = setInterval(() => {
            const ahora = new Date();
            const diferenciaMs = ahora.getTime() - fechaInicioDate.getTime();
            setTiempoFormateado(formatarDiferencia(diferenciaMs));
        }, 1000); 

        return () => {
            clearInterval(intervalo);
        };

    }, [fechaInicioISO, fechaFinISO]); 

    return (
        <span style={fechaFinISO ? { color: 'green', fontWeight: 'bold' } : {}}>
            {tiempoFormateado}
            {fechaFinISO && ' (Finalizado)'}
        </span>
    );
}

export default ContadorTiempo;