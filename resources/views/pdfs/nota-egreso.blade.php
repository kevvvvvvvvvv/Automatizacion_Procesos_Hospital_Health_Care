<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de egreso</title>
    <style>
        @page {
            size: A4;
            margin-top: 5.5cm;
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

        .one-line{
            display: inline-block;
            padding-right: 10px;
        }

        .contenedor-flex {
            display: flex;
            gap: 10px;
        }

        .cosa-inicio,
        .cosa-fin {
            flex: 1;
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

        .texto-preformateado {
            white-space: pre-wrap;
            word-wrap: break-word; 
        }
    </style>
</head>
<body>
    <main>
        <h1>Nota de egreso</h1>

        <div class="section-content">
            <p><strong>Motivo del egreso: </strong> {{ $notaData->motivo_egreso ?? 'Sin datos.' }}</p>
            <p><strong>Diagnósticos finales: </strong> {{ $notaData->diagnosticos_finales ?? 'Sin datos.' }}</p>
            <p><strong>Resumen de la evolución y el estado actual: </strong> {{ $notaData->resumen_evolucion_estado_actual ?? 'Sin datos.' }}</p>
            <p><strong>Manejo durante la estancia hospitalaria: </strong> {{ $notaData->manejo_durante_estancia ?? 'Sin datos.' }}</p>
            <p><strong>Problemas clínicos pendiente: </strong>{{ $notaData->problemas_pendientes ?? 'Sin datos.' }}</p>
            <p><strong>Plan de manejo y tratamiento: </strong>{{ $notaData->plan_manejo_tratamiento  ?? 'Sin datos.' }}</p>
            <p><strong>Recomendaciones para vigilancia ambulatoria: </strong> {{ $notaData->recomendaciones ?? 'Sin datos.' }}</p>
            <p><strong>Pronóstico: </strong> {{ $notaData->pronostico ?? 'Sin datos.' }}</p>
            <p><strong>En caso de defunción, señalar las causas de la muerte acorde a la información contenida en el certificado de defunción y en su caso, si se solicitó y se llevó a cabo estudio de necropsia hospitalaria: </strong> {{ $notaData->defuncion ?? 'Sin datos.' }}</p>
        </div>

        @if(isset($medico))
            <div class="signature-section">
                <div class="signature-line"></div>
                <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
                <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
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

