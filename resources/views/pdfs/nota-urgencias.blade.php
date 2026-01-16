<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de urgencia inicial</title>
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
    <main>
        <h1>Nota de urgencia inicial</h1>

        <div class="section-content">
            <p><strong>Fecha y hora en la que se otorga el servicio: </strong>{{$notaData['fecha']}}</p>
        </div>

        <h2>Signos vitales</h2>
        <div class="section-content">
            <p>
                Tensión arterial: <strong>{{ $notaData['ta'] ?? 'N/A' }}</strong> mm Hg | 
                Frecuencia cardíaca: <strong>{{ $notaData['fc'] ?? 'N/A' }}</strong> por minuto | 
                Frecuencia respiratoria: <strong>{{ $notaData['fr'] ?? 'N/A' }}</strong> por minuto | 
                Temperatura: <strong>{{ $notaData['temp'] ?? 'N/A' }}</strong> Celsius (°C) | 
                Peso: <strong>{{ $notaData['peso'] ?? 'N/A' }}</strong> kg | 
                Talla: <strong>{{ $notaData['talla'] ?? 'N/A' }}</strong> cm
            </p>
        </div>


        <div class="section-content">
            <p><strong>Motivo de la Atención:</strong> {{ $notaData['motivo_de_la_atencion_o_interconsulta'] ?? 'Sin datos.' }}</p>
            <p><strong>Resumen del Interrogatorio:</strong> {{ $notaData['resumen_del_interrogatorio'] ?? 'Sin datos.' }}</p>
            <p><strong>Exploración física: </strong>{{ $notaData['exploracion_fisica'] ?? 'Sin datos.' }}</p>
            <p><strong>Estado Mental:</strong> {{ $notaData['estado_mental'] ?? 'Sin datos.' }}</p>
        </div>

        <h3>Análisis y Diagnóstico</h3>
        <div class="section-content">
            <p><strong>Resultados Relevantes de Estudios:</strong> {{ $notaData['resultados_relevantes_del_estudio_diagnostico'] ?? 'Sin datos.' }}</p>
            <p><strong>Diagnóstico o Problemas Clínicos:</strong> {{ $notaData['diagnostico_o_problemas_clinicos'] ?? 'Sin datos.' }}</p>
        </div>

        <h3>Plan y Pronóstico</h3>
        <div class="section-content">
            <p><strong>Tratamiento y Pronóstico:</strong> {{ $notaData['tratamiento_y_pronostico'] ?? 'Sin datos.' }}</p>
        </div>

        @if(isset($medico))
            <div class="signature-section">
                <div class="signature-line"></div>
                <p>{{ $medico->name ?? 'Médico no especificado' }}</p>  
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