<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de evolución</title>
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
        <h1>Nota de evolución</h1>

        <p style="line-height: 1.4; margin: 0; margin-bottom: 10px;">
            <strong>Tensión arterial:</strong> {{$notaData['ta']}} mm Hg | 
            <strong>Frecuencia cardiaca:</strong> {{$notaData['fc']}} por minuto | 
            <strong>Frecuencia respiratoria:</strong> {{$notaData['fr']}} por minuto | 
            <strong>Temperatura:</strong> {{$notaData['temp']}} Celsius (°C) | 
            <strong>Peso:</strong> {{$notaData['peso']}} kilogramos | 
            <strong>Talla:</strong> {{$notaData['talla']}} centímetros
        </p>

        <div class="section-content">
            <p><strong>Evolución y actualización del cuadro clínico (en su caso, incluir abuso y dependencia del tabaco, del alcohol y de otras sustancias psicoactivas): </strong> {{ $notaData->evolucion_actualizacion ?? 'Sin datos.' }}</p>
            <p><strong>Resumen del interrogatorio: </strong> {{ $notaData->resumen_del_interrogatorio ?? 'Sin datos.' }}</p>
            <p><strong>Exploración física: </strong> {{ $notaData->exploracion_fisica ?? 'Sin datos.' }}</p>
            <p><strong>Resultados relevantes de los estudios de los servicios auxiliares de diagnóstico y tratamiento que hayan sido solicitados previamente: </strong> {{ $notaData->resultado_estudios ?? 'Sin datos.' }}</p>
            <p><strong>Diagnóstico(s) o problemas clínicos: </strong> {{ $notaData->diagnostico_o_problemas_clinicos ?? 'Sin datos.' }}</p>
        </div>  

        <div class="section-content">
            <h3>Plan de estudio y/o tratamiento (indicaciones médicas, vía, dosis, periodicidad)</h3>
            <strong>Dieta:</strong>
            <div class="">
                {{ $notaData->manejo_dieta ?? 'Sin datos.' }}
            </div>
            <strong>Soluciones:</strong>
            <div class="">
                {{ $notaData->manejo_soluciones ?? 'Sin datos.' }}
            </div>
            <strong>Medicamentos:</strong>
            <div class="">
                {{ $notaData->manejo_medicamentos ?? 'Sin datos.' }}
            </div>
            <strong>Medidas generales:</strong>
            <div class="">
                {{ $notaData->manejo_medidas_generales ?? 'Sin datos.' }}
            </div>
            <strong>Laboratorios y gabinete:</strong>
            <div class="">
                {{ $notaData->manejo_laboratorios ?? 'Sin datos.' }}
            </div>
            <h3></h3>
        </div>

        <div class="section-content">    
            <p><strong>Pronóstico: </strong> {{ $notaData->pronostico ?? 'Sin datos.' }}</p>
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

