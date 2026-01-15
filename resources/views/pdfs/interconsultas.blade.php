<!DOCTYPE html>
<html lang="es">
 <head>
    <meta charset="UTF-8">
    <title>Nota de interconsulta</title>
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
        <h1>Nota interconsulta</h1>
        <div class="Section-content">
        <p style="line-height: 1.4; margin: 0; margin-bottom: 10px;">
            <strong>Tensión arterial:</strong> {{$notaData['ta']}} mm Hg | 
            <strong>Frecuencia cardiaca:</strong> {{$notaData['fc']}} por minuto | 
            <strong>Frecuencia respiratoria:</strong> {{$notaData['fr']}} por minuto | 
            <strong>Temperatura:</strong> {{$notaData['temp']}} Celsius (°C) | 
            <strong>Peso:</strong> {{$notaData['peso']}} kilogramos | 
            <strong>Talla:</strong> {{$notaData['talla']}} centímetros
        </p>

        <p><strong>Resumen del interrogatorio: </strong>{{$notaData['resumen_del_interrogatorio']}}</p>
        <p><strong>Exploración física: </strong>{{$notaData['exploracion_fisica']}}</p>   
        <p><strong>Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento: </strong>{{$notaData['resultados_relevantes_del_estudio_diagnostico']}}</p>
        <p><strong>Diagnóstico(s) o problemas clínicos: </strong>{{$notaData['diagnostico_o_problemas_clinicos']}}</p>
        <p><strong>Plan de estudio  (indicaciones médicas, vía, dosis, periodicidad): </strong>{{$notaData['plan_de_estudio']}}</p>
        <p><strong>Tratamiento: </strong>{{$notaData['tratamiento']}}</p>
        <p><strong>Pronóstico: </strong>{{$notaData['pronostico']}}</p>
        <p><strong>Motivo de la atención de la interconsulta: </strong>{{$notaData['motivo_de_la_atencion_o_interconsulta']}}</p>
        <P><strong>Criterio Diagnostico: </strong>{{$notaData['criterio:diagnostico']}}</P>
        <p><strong>Plan de estudio: </strong>{{$notaData['plan_de_estudio']}}</p>
        <p><strong>Sugerencia diagnostica: </strong>{{$notaData['sugerencia_diagnostica']}}</p>    
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
