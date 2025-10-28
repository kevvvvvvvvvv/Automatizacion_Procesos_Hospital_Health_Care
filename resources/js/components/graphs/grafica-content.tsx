// components/SeccionGraficas.tsx
import React from 'react';
import GraficaTensionArterial from './grafica-tension-arterial';
import GraficaSignoVitalSimple from './grafica-signos-simple'; 
//import GraficaEstadoConciencia from './GraficaEstadoConciencia';
import { HojaSignosGraficas } from '@/types';


interface Props {
    historialSignos: HojaSignosGraficas[];
}

export default function SeccionGraficas({ historialSignos }: Props) {
    return (
        <div>
            <h2 className="text-lg font-medium text-gray-900 mb-4">
                Gráficas de Signos Vitales
            </h2>
            
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {/* 1. Gráfica de Tensión Arterial*/}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Tensión Arterial (mmHg)</h3>
                    <GraficaTensionArterial data={historialSignos} />
                </div>

                {/* 2. Gráfica de Temperatura */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Temperatura (°C)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="temperatura"
                        label="Temperatura"
                        unit="°C"
                        borderColor="rgb(234, 88, 12)" 
                    />
                </div>

                {/* 3. Gráfica de Frecuencia Cardíaca */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Frecuencia Cardíaca (lpm)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="frecuencia_cardiaca"
                        label="Frec. Cardíaca"
                        unit="lpm"
                        borderColor="rgb(217, 70, 239)" 
                    />
                </div>

                {/* 4. Gráfica de Frecuencia Respiratoria */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Frecuencia Respiratoria (rpm)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="frecuencia_respiratoria"
                        label="Frec. Respiratoria"
                        unit="rpm"
                        borderColor="rgb(20, 184, 166)" 
                    />
                </div>

                {/* 5. Gráfica de Saturación de Oxígeno (SpO2) */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Saturación de Oxígeno (SpO2)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="saturacion_oxigeno"
                        label="SpO2"
                        unit="%"
                        borderColor="rgb(37, 99, 235)" 
                    />
                </div>

                {/* 6. Gráfica de Glucemia Capilar */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Glucemia Capilar (mg/dL)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="glucemia_capilar"
                        label="Glucemia"
                        unit="mg/dL"
                        borderColor="rgb(107, 114, 128)" 
                    />
                </div>

                 {/* 7. Caso Especial: Estado de Conciencia 
                 <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución Estado de Conciencia</h3>
                    <GraficaEstadoConciencia data={historialSignos} />
                </div>*/}
            </div>
        </div>
    );
}