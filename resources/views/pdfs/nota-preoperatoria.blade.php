<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota preoperatoria</title>
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
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 250px;
            margin: 0 auto;
            margin-bottom: 5px;
        }
        .signature-section p {
            margin: 0;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <h1>Nota preoperatoria</h1>

    <div class="section-content">
        <p><strong>Fecha de la cirugía:</strong> {{ $notaData->fecha_cirugia ?? 'Sin datos.' }}</p>
        <p><strong>Diagnóstico:</strong> {{ $notaData->diagnostico_preoperatorio ?? 'Sin datos.' }}</p>
        <p><strong>Plan quirúrgico:</strong> {{ $notaData->plan_quirurgico ?? 'Sin datos.' }}</p>
        <p><strong>Tipo de intervención quirúrgica:</strong> {{ $notaData->tipo_intervencion_quirurgica ?? 'Sin datos.' }}</p>
        <p><strong>Riesgo quirúrgico:</strong> {{ $notaData->riesgo_quirurgico ?? 'Sin datos.' }}</p>
        <p><strong>Cuidados y plan terapéutico preoperatorios:</strong> {{ $notaData->cuidados_plan_preoperatorios ?? 'Sin datos.' }}</p>
    </div>
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
        <p><strong> Tratamiento: </strong>{{$notaData['tratamiento']}}</p>
        <p><strong>Pronóstico: </strong>{{$notaData['pronostico']}}</p>



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

</body>
</html>
