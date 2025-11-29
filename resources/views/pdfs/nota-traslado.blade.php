<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de traslado</title>
    <style>

        @page {
            size: A4;
            margin-top: 5cm;
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
        
        .header {
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            padding-bottom: 8px;
            margin-bottom: 15px; 
        }

        .header .info-container {
            flex-basis: 45%; 
        }

        .header .logo {
            width: 150px; 
            display: block; 
            margin-bottom: 5px;
        }

        .header .hospital-info { 
             text-align: left; 
             font-size: 8pt; 
             line-height: 1.2;
        }
        .header .hospital-info p {
             margin: 0;
        }

        .identification-card {
            
            padding: 8px 12px; 
            font-size: 9pt; 
            width: 55%;
        }
        
        .identification-card h2 {
            text-align: center;
            font-size: 10pt;
            margin: 0 0 8px 0;
            font-weight: bold;
        }

        .id-row {
            display: flex;
            justify-content: space-between; 
            margin-bottom: 4px; 
            align-items: baseline; 
        }

        .id-field {
            display: flex;
            align-items: baseline;
            margin-right: 7px;
        }
        .id-field:last-child {
            margin-right: 0;
        }

        .id-label {
            font-weight: bold;
            margin-right: 5px;
            white-space: nowrap; 
        }

        .id-value {
            border-bottom: 1px solid #333;
            flex-grow: 1; 
            min-width: 50px; 
        }
        .id-value.long {
             min-width: 200px; 
        }
        .id-value.short {
             min-width: 30px; 
             flex-grow: 0; 
             width: 50px; 
        }

        h1 {
            text-align: center;
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h2 {
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
    

    <h1>Nota de traslado</h1>

    <h2>Establecimiento de salud</h2>
    <div class="section-content">
        <p><strong>Unidad médica que envía:</strong> {{ $notaData->unidad_medica_envia ?? 'Sin datos.' }}</p>
        <p><strong>Unidad médica que recibe:</strong> {{ $notaData->unidad_medica_recibe ?? 'Sin datos.' }}</p>
        
    </div>

    <h2>Resumen clínico</h2>
    <div class="section-content">
        <p><strong>Motivo de traslado:</strong> {{ $notaData->motivo_translado ?? 'Sin datos.' }}</p>
        <p><strong>Impresión diagnóstica (incluido abuso y dependencia del tabaco, del alcohol y de otras sustancias psicoactivas):</strong> {{ $notaData->impresion_diagnostica ?? 'Sin datos.' }}</p>
        <p><strong>Terapéutica empleada, si la hubo:</strong> {{ $notaData->terapeutica_empleada ?? 'Sin datos.' }}</p>
    </div>
    <br>
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
        <p><strong>Resultado de estudios de los servicios auxiliares de diagnóstico y tratamiento: </strong>{{$notaData['resultado_estudios']}}</p>
        <p><strong>Diagnóstico(s) o problemas clínicos: </strong>{{$notaData['diagnostico_o_problemas_clinicos']}}</p>
        <p><strong>Plan de estudio y/o Tratamiento (indicaciones médicas, vía, dosis, periodicidad): </strong>{{$notaData['plan_de_estudio']}}</p>
        <p><strong>Tratamiento: </strong>{{$notaData['tratamiento']}}</p>
        <p><strong>Pronóstico: </strong>{{$notaData['pronostico']}}</p>


    
    <div class="signature-section">
        @if(isset($medico))
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno }}</p>
            @if($medico->credenciales->isNotEmpty())
                <div class="credentials-list">
                    @foreach($medico->credenciales as $credencial)
                        <p>
                            <strong>Título:</strong> {{ $credencial->titulo }} | <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                        </p>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
    <div class="signature-section">
        @if(isset($familiar_responsable))
            <div class="signature-line"></div>
            <p>{{ $familiar_responsable->nombre . " " . $familiar_responsable->apellido_paterno . " " . $familiar_responsable->apellido_materno }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y Firma del Familiar Responsable</p>
        @endif
    </div>
</body>
</html>