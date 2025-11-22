<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de Consentimiento Informado de Hospitalización</title>
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
        <h1>Carta de Consentimiento Informado de Hospitalización</h1>

        {{-- ENCABEZADO --}}
        <h3>Encabezado</h3>
        <div class="section-content">
            <p>CUERNAVACA, MORELOS. C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>

        {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>Yo {{ $paciente->nombre ?? 'Sin datos.' }} expreso mi libre voluntad para el ingreso al servicio de Hospitalización después de haberme proporcionado información completa sobre mi estado actual de salud la cual fue realizada de forma amplia, siempre utilizando un lenguaje claro y preciso, complementando sobre los beneficios, posibles riesgos, complicaciones y secuelas, derivados de la terapéutica empleada.</p>
            <p>Hago constar que el médico me informo sobre la existencia de procedimientos alternativos, el derecho a cambiar mi decisión en cualquier momento y manifestarla con el propósito de que mi atención sea adecuada, me comprometo además a proporcionar información completa y veraz, así como seguir las indicaciones médicas empleadas.</p>
            <p>Acepto y autorizo a los profesionales de la salud de Hospitalidad Health Care (Comprehensive Medical Solutions de México SA de CV), para que me apliquen los procedimientos o medidas terapéuticas adicionales, incluyendo el uso de sangre y sus derivados que sean necesarios para el mantenimiento de mi salud, en caso de que ocurriera alguna contingencia durante el procedimiento. Estoy enterado que abre de requerir vigilancia y control médico hasta mi total recuperación.</p>
            <p>Habiendo leído por mí mismo este documento, siendo su contenido perfectamente entendible para mí y enterado de que el personal de salud se compromete a la máxima diligencia en la prestación de los servicios profesionales a nivel tecnológico actual, sin que puedan por otra parte garantizar absolutamente el resultado, firmo en Cuernavaca, Morelos a ____ del mes _______ del año _________.</p>
        </div>

       
        {{-- SECCIÓN DE FIRMAS --}}
        <div class="signature-section">
            <div class="signature-line"></div>
            <p>{{ $paciente->nombre ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
            <div class="signature-line"></div>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del médico</p>
            <div class="signature-line"></div>
            <p>Nombre y firma del familiar o representante legal</p>
            <div class="signature-line"></div>
            <p>Nombre y firma de testigo</p>
        </div>

        {{-- SECCIÓN DE FIRMA DEL MÉDICO (si aplica) --}}
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
