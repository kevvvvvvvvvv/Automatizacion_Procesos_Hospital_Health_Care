<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset ="UTF-8">
    <title>Nota de Traslado</title>
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
    <h1>Nota de Traslado</h1>

    {{-- Sección Establecimiento de salud --}}
    <h2>Establecimiento de Salud</h2>
    <div class="section-content">
        <p><strong>Unidad Médica que Envía:</strong> {{ $notaData['unidad_medica_envia'] ?? 'Sin datos.' }}</p>
        <p><strong>Unidad Médica que Recibe:</strong> {{ $notaData['unidad_medica_recibe'] ?? 'Sin datos.' }}</p>
        <p><strong>Motivo de Traslado:</strong> {{ $notaData['motivo_traslado'] ?? 'Sin datos.' }}</p>
        <p><strong>Fecha y hora de traslado:</strong> {{ $notaData['fecha_hora'] ?? 'Sin datos.' }}</p>
    </div>
    {{-- Sección Resumen Clínico --}}
    <h2>Resumen Clínico</h2>
    <div class="section-content">
        <p>{{ $notaData['resumen_clinico'] ?? 'Sin datos.' }}</p>
    </div>
    {{-- Sección de signos vitales--}}
    <h2>Signos Vitales</h2>
    <div class="section-content">
        <p>
                <strong>Signos Vitales:</strong> 
                T.A.: <strong>{{ $notaData['ta'] ?? 'N/A' }}</strong> mm Hg | 
                F.C.: <strong>{{ $notaData['fc'] ?? 'N/A' }}</strong> x min | 
                F.R.: <strong>{{ $notaData['fr'] ?? 'N/A' }}</strong> x min | 
                SAT: <strong>{{ $notaData['sat'] ?? 'N/A' }}</strong> % |
                Temp: <strong>{{ $notaData['temp'] ?? 'N/A' }}</strong> °C | 
                DXTX: <strong>{{ $notaData['dxtx'] ?? 'N/A' }}</strong>
            </p>
            <p><strong>Tratamiento Terapéutico Administrado:</strong> {{ $notaData['tratamiento_terapeutico_administrada'] ?? 'Sin datos.' }}</p>
    </div>
    <div class="signature-section">
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
    </div>
</body>
</html>