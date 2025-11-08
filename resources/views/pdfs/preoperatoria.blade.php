<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Traslado</title>
    <style>
        /* Estilos copiados y adaptados */
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
    {{-- Sección Detalles de la nota preoperatoria --}}
    <h2>FECHA:</h2>
    <div class="section-content">
        <p><strong>Fecha de la cirugía:</strong> {{ $nota->fecha ?? 'Sin datos.' }}</p>
    </div>
    <h2>Diagnóstico:</h2>
    <div class="section-content">
        <p><strong>Diagnóstico preoperatorio:</strong> {{ $preoperatoria->diagnostico ?? 'Sin datos.' }}</p>
        <p><strong>Plan quirúrgico:</strong> {{ $preoperatoria->plan_quirurgico ?? 'Sin datos.' }}</p>
        <p><strong>Tipo de intervención:</strong> {{ $preoperatoria->tipo_intervencion ?? 'Sin datos.' }}</p>
        <p><strong>Riesgo quirúrgico:</strong> {{ $preoperatoria->riesgo_quirurgico ?? 'Sin datos.' }}</p>
        <p><strong>Cuidado y plan preoperatorio:</strong> {{ $preoperatoria->cuidado_plan_preoperatorio ?? 'Sin datos.' }}</p>
        <p><strong>Pronóstico:</strong> {{ $preoperatoria->pronostico ?? 'Sin datos.' }}</p>
    </div>
    <div class="signature-section">
        @if(isset($medico))
            <div class="signature-line"></div>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del médico que interviene al paciente </p>

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
</body>
</html>
