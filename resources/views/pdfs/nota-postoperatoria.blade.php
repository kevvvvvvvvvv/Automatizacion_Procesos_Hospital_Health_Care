<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota postoperatoria</title>
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
    </style>
</head>
<body>
    <main>
        <h1>Nota postoperatoria</h1>
        <div class="section-content contenedor-flex">
            <p class="hora-inicio"><strong>Hora inicio operación:</strong> {{ $notaData->hora_inicio_operacion ? \Carbon\Carbon::parse($notaData->hora_inicio_operacion)->format('H:i') : 'N/A' }}</p>
            <p class="hora-fin"><strong>Hora término operación:</strong> {{ $notaData->hora_termino_operacion ? \Carbon\Carbon::parse($notaData->hora_termino_operacion)->format('H:i') : 'N/A' }}</p>
        </div>

        <div class="section-content">
            <p><strong>Diagnóstico preoperatorio:</strong> {{ $notaData->diagnostico_preoperatorio ?? 'Sin datos.' }}</p>
            <p><strong>Operación planeada:</strong> {{ $notaData->operacion_planeada ?? 'Sin datos.' }}</p>
            <p><strong>Operación realizada:</strong> {{ $notaData->operacion_realizada ?? 'Sin datos.' }}</p>
            <p><strong>Diagnóstico postoperatorio:</strong> {{ $notaData->diagnostico_postoperatorio ?? 'Sin datos.' }}</p>
        </div>

        <div class="section-content">
            <p><strong>Descripción de la técnica quirúrgica:</strong></p>
            <p>{{ $notaData->descripcion_tecnica_quirurgica ?? 'Sin datos.' }}</p>
            
            <p><strong>Hallazgos transoperatorios:</strong></p>
            <p>{{ $notaData->hallazgos_transoperatorios ?? 'Sin datos.' }}</p>
            
            <p><strong>Hallazgos de importancia:</strong></p>
            <p>{{ $notaData->hallazgos_importancia ?? 'Sin datos.' }}</p>
        </div>

        <div class="section-content">
            <p><strong>Reporte de conteo (gasas, instrumental, etc.):</strong> {{ $notaData->reporte_conteo ?? 'Sin datos.' }}</p>
            <p><strong>Incidentes y accidentes:</strong> {{ $notaData->incidentes_accidentes ?? 'Sin datos.' }}</p>
            <p><strong>Cuantificación de sangrado:</strong> {{ $notaData->cuantificacion_sangrado ?? 'Sin datos.' }}</p>
            <p><strong>Estudios transoperatorios (Patología, etc.):</strong> {{ $notaData->estudios_transoperatorios ?? 'Sin datos.' }}</p>
            <p><strong>Envío de piezas:</strong> {{ $notaData->envio_piezas ?? 'Sin datos.' }}</p>
        </div>

        <div class="section-content">
            <p><strong>Estado postquirúrgico inmediato:</strong> {{ $notaData->estado_postquirurgico ?? 'Sin datos.' }}</p>
            <p><strong>Plan de manejo y tratamiento:</strong> {{ $notaData->manejo_tratamiento ?? 'Sin datos.' }}</p>
            <p><strong>Pronóstico:</strong> {{ $notaData->pronostico ?? 'Sin datos.' }}</p>
        </div>


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

