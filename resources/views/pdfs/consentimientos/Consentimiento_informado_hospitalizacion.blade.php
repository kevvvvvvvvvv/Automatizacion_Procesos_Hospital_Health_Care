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
        
        .headerConsentimiento {
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            padding-bottom: 8px;
            margin-bottom: 15px; 
        }

        .headerConsentimiento .info-container {
            flex-basis: 45%; 
        }

        .headerConsentimiento .logo {
            width: 150px; 
            display: block; 
            margin-bottom: 5px;
        }

        .headerConsentimiento .hospital-info { 
             text-align: left; 
             font-size: 8pt; 
             line-height: 1.2;
        }
        .headerConsentimiento .hospital-info p {
             margin: 0;
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

        {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>Yo {{ $paciente->nombre ?? 'Sin datos.' }} expreso mi libre voluntad para el ingreso al servicio de Hospitalización después de haberme proporcionado información completa sobre mi estado actual de salud la cual fue realizada de forma amplia, siempre utilizando un lenguaje claro y preciso, complementando sobre los beneficios, posibles riesgos, complicaciones y secuelas, derivados de la terapéutica empleada.</p>
            <p>Hago constar que el médico me informo sobre la existencia de procedimientos alternativos, el derecho a cambiar mi decisión en cualquier momento y manifestarla con el propósito de que mi atención sea adecuada, me comprometo además a proporcionar información completa y veraz, así como seguir las indicaciones médicas empleadas.</p>
            <p>Acepto y autorizo a los profesionales de la salud de Hospitalidad Health Care (Comprehensive Medical Solutions de México SA de CV), para que me apliquen los procedimientos o medidas terapéuticas adicionales, incluyendo el uso de sangre y sus derivados que sean necesarios para el mantenimiento de mi salud, en caso de que ocurriera alguna contingencia durante el procedimiento. Estoy enterado que abre de requerir vigilancia y control médico hasta mi total recuperación.</p>
            <p>Habiendo leído por mí mismo este documento, siendo su contenido perfectamente entendible para mí, y enterado de que los médicos antes mencionados se comprometen a la máxima diligencia en la prestación de los servicios profesionales al nivel tecnológico actual, sin que puedan por otra parte, garantizar absolutamente el resultado, firmo al calce en la ciudad de Cuernavaca, Morelos,a {{ $fecha['dia'] }} del mes {{ $fecha['mes'] }} del año {{ $fecha['anio'] }}.        </div>

       
        <style>
        .table-signatures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-signatures td {
            width: 33%;
            vertical-align: top;
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            width: 100%;
            height: 1px;
            background-color: #000;
            margin: 20px auto 5px auto;
        }
        </style>

        {{-- TABLA DE FIRMAS (2 filas, 3 columnas) --}}
        <table class="table-signatures">

            {{-- FILA 1 --}}
            <tr>

                {{-- 1. Paciente --}}
                <td>
                    <div class="signature-line"></div>
                    <p>{{ $paciente->nombre ?? 'Sin datos.' }}</p>
                    <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
                </td>

                {{-- 2. Familiar responsable --}}
                <td>
                    <div class="signature-line"></div>
                    <p>Nombre y firma del familiar responsable</p>
                    <p style="font-size: 9pt; color: #555;">
                        {{ $paciente->familiar_responsable ?? 'Sin datos.' }}
                    </p>
                </td>

                {{-- 3. Testigo 1 --}}
                <td>
                    <div class="signature-line"></div>
                    <p>Nombre y firma de testigo</p>
                </td>

            </tr>

            {{-- FILA 2 --}}
            <tr>

                {{-- 4. Testigo 2 --}}
                <td>
                    <div class="signature-line"></div>
                    <p>Nombre y firma de testigo</p>
                </td>

                {{-- 5. Médico --}}
                <td>
                    @if(isset($medico))
                        <div class="signature-line"></div>

                        <p>{{ $medico->nombre }} {{ $medico->apellido_paterno }} {{ $medico->apellido_materno }}</p>
                        <p style="font-size: 9pt; color: #555;">Nombre y Firma del Médico</p>

                        @if($medico->credenciales->isNotEmpty())
                            <div style="font-size: 10pt; margin-top: 10px;">
                                @foreach($medico->credenciales as $credencial)
                                    <p>
                                        <strong>Título:</strong> {{ $credencial->titulo }}
                                        |
                                        <strong>Cédula:</strong> {{ $credencial->cedula_profesional }}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <p style="font-size: 9pt; color: #555;">Sin datos de médico</p>
                    @endif
                </td>

                {{-- 6. Vacío o espacio adicional --}}
                <td>
                    {{-- Aquí puedes poner algo o dejarlo vacío --}}
                </td>

            </tr>

        </table>

    </main>
</body>
</html>
