<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Interconsulta / Evolución</title>
    <style>
        /* Estilos copiados y adaptados de la Historia Clínica */
        @page {
            size: A4;
            margin-top: 5cm; /* Margen superior para el headerView */
            margin-bottom: 1.5cm;
            margin-left: 1.2cm;
            margin-right: 1.2cm;

            @bottom-right {
                content: "Página " counter(page) " de " counter(pages);
                font-family: Calibri, Arial, sans-serif;
                font-size: 9pt;
                color: #888;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, Arial, sans-serif; 
            margin: 0; 
            font-size: 10.5pt; 
            color: #333;
            line-height: 1.4;
        }

        h1 {
            text-align: center;
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 12pt;
            page-break-after: avoid;
        }

        p {
            margin: 0 0 8px 0;
        }

        .section-content {
            padding-left: 5px;
        }

        .signature-section {
            text-align: center;
            margin-top: 60px; 
            page-break-inside: avoid; 
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 280px; 
            margin: 0 auto 5px auto; 
        }
        .signature-section p {
            margin: 0;
            line-height: 1.4;
        }
        .credentials-list {
            font-size: 8pt; 
            color: #555;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <main>
        <h1>Nota de Interconsulta / Evolución</h1>

        {{-- SECCIÓN 1: RESUMEN CLÍNICO --}}
        <h3>Resumen Clínico</h3>
        <div class="section-content">
            <p><strong>Motivo de la Atención o Interconsulta:</strong> {{ $notaData['motivo_de_la_atencion_o_interconsulta'] ?? 'Sin datos.' }}</p>
            <p><strong>Resumen del Interrogatorio:</strong> {{ $notaData['resumen_del_interrogatorio'] ?? 'Sin datos.' }}</p>
        </div>

        {{-- SECCIÓN 2: EXPLORACIÓN FÍSICA Y SIGNOS VITALES --}}
        <h3>Exploración Física</h3>
        <div class="section-content">
            <p>{{ $notaData['exploracion_fisica'] ?? 'Sin datos.' }}</p>
            <p>
                <strong>Signos Vitales:</strong> 
                T.A.: <strong>{{ $notaData['ta'] ?? 'N/A' }}</strong> mm Hg | 
                F.C.: <strong>{{ $notaData['fc'] ?? 'N/A' }}</strong> x min | 
                F.R.: <strong>{{ $notaData['fr'] ?? 'N/A' }}</strong> x min | 
                Temp: <strong>{{ $notaData['temp'] ?? 'N/A' }}</strong> °C | 
                Peso: <strong>{{ $notaData['peso'] ?? 'N/A' }}</strong> kg | 
                Talla: <strong>{{ $notaData['talla'] ?? 'N/A' }}</strong> cm
            </p>
            <p><strong>Estado Mental:</strong> {{ $notaData['estado_mental'] ?? 'Sin datos.' }}</p>
        </div>

        {{-- SECCIÓN 3: ANÁLISIS Y DIAGNÓSTICO --}}
        <h3>Análisis y Diagnóstico</h3>
        <div class="section-content">
            <p><strong>Resultados Relevantes de Estudios:</strong> {{ $notaData['resultados_relevantes_del_estudio_diagnostico'] ?? 'Sin datos.' }}</p>
            <p><strong>Diagnóstico o Problemas Clínicos:</strong> {{ $notaData['diagnostico_o_problemas_clinicos'] ?? 'Sin datos.' }}</p>
            <p><strong>Criterio Diagnóstico:</strong> {{ $notaData['criterio_diagnostico'] ?? 'Sin datos.' }}</p>
        </div>

        {{-- SECCIÓN 4: PLAN Y PRONÓSTICO --}}
        <h3>Plan y Pronóstico</h3>
        <div class="section-content">
            <p><strong>Plan de Estudio:</strong> {{ $notaData['plan_de_estudio'] ?? 'Sin datos.' }}</p>
            <p><strong>Sugerencia Diagnóstica y/o Terapéutica:</strong> {{ $notaData['sugerencia_diagnostica'] ?? 'Sin datos.' }}</p>
            <p><strong>Tratamiento y Pronóstico:</strong> {{ $notaData['tratamiento_y_pronostico'] ?? 'Sin datos.' }}</p>
        </div>

        {{-- SECCIÓN DE FIRMA --}}
        @if(isset($medico))
            <div class="signature-section">
                <div class="signature-line"></div>
                <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
                <p style="font-size: 9pt; color: #555;">Nombre y Firma del Médico</p>

                @if($medico->credenciales->isNotEmpty())
                    <div class="credentials-list">
                        @foreach($medico->credenciales as $credencial)
                            <p>
                                <strong>Título:</strong> {{ $credencial->titulo }} | <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
       
    </main>
</body>
</html>

