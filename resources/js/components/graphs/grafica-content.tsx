// components/SeccionGraficas.tsx
import React from 'react';
import GraficaTensionArterial from './grafica-tension-arterial';
import GraficaSignoVitalSimple from './grafica-signos-simple'; 
import { HojaSignosGraficas } from '@/types';


interface Props {
    historialSignos: HojaSignosGraficas[];
}

export default function SeccionGraficas({ historialSignos }: Props) {
    return (
        <div>
            <h2 className="text-lg font-medium text-gray-900 mb-4">
                Gráficas de signos vitales
            </h2>
            
            <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución de la tensión arterial (mmHg)</h3>
                    <GraficaTensionArterial data={historialSignos} />
                </div>

                {/* 2. Gráfica de Temperatura */}
                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución de la temperatura (°C)</h3>
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
                    <h3 className="font-medium text-gray-700 mb-3">Evolución de la frecuencia cardíaca (lpm)</h3>
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
                    <h3 className="font-medium text-gray-700 mb-3"> Evolución de la frecuencia respiratoria (rpm)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="frecuencia_respiratoria"
                        label="Frec. Respiratoria"
                        unit="rpm"
                        borderColor="rgb(20, 184, 166)" 
                    />
                </div>

                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución de la saturación de oxígeno (SpO2)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="saturacion_oxigeno"
                        label="Saturación de oxígeno"
                        unit="%"
                        borderColor="rgb(37, 99, 235)" 
                    />
                </div>

                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3"> Evolución de la glucemia capilar (mg/dL)</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="glucemia_capilar"
                        label="Glucemia capilar"
                        unit="mg/dL"
                        borderColor="rgb(107, 114, 128)" 
                    />
                </div>

                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución del peso</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="peso"
                        label="Peso"
                        unit="Kilogramos"
                        borderColor="rgb(218, 146, 160)" 
                    />
                </div>

                <div className="p-4 border rounded-lg shadow-sm bg-gray-50/50">
                    <h3 className="font-medium text-gray-700 mb-3">Evolución de la talla</h3>
                    <GraficaSignoVitalSimple 
                        data={historialSignos}
                        dataKey="talla"
                        label="Talla"
                        unit="Centímetros"
                        borderColor="rgb(118, 246, 200)" 
                    />
                </div>
            </div>
        </div>
    );
}