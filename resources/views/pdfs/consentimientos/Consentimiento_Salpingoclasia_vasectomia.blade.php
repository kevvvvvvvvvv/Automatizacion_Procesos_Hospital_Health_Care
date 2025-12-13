<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Informado Salpingoclasia y vasectomía</title>
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
        <h1>Consentimiento informado salpingoclasía y vasectomía</h1> 

        
        {{-- Sección del cuerpo del consentimiento--}}
         {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>Yo {{ $paciente->nombre ?? 'Sin datos.' }} expreso mi libre voluntad para el ingreso al servicio de Hospitalización después de haberme proporcionado información completa sobre mi estado actual de salud la cual fue realizada de forma amplia, siempre utilizando un lenguaje claro y preciso, complementando sobre los beneficios, posibles riesgos, complicaciones y secuelas, derivados de la terapéutica empleada.</p>
            <p>Hago constar que el médico me informo sobre la existencia de procedimientos alternativos, el derecho a cambiar mi decisión en cualquier momento y manifestarla con el propósito de que mi atención sea adecuada, me comprometo además a proporcionar información completa y veraz, así como seguir las indicaciones médicas empleadas.</p>
            <p>Autorización al personal de salud para la atención de contingencias y urgencias derivadas del acto autorizado, atendiendo al principio de libertad prescriptiva. Acepto y autorizo a los profesionales de la salud de Hospitalidad Health Care (Comprehensive Medical Solutions de México SA de CV), para que me apliquen los procedimientos o medidas terapéuticas adicionales, incluyendo el uso de sangre y sus derivados que sean necesarios para el mantenimiento de mi salud, en caso de que ocurriera alguna contingencia durante el procedimiento. Estoy enterado que abre de requerir vigilancia y control médico hasta mi total recuperación.</p>
            <p>Habiendo leído por mí mismo este documento, siendo su contenido perfectamente entendible para mí, y enterado de que los médicos antes mencionados se comprometen a la máxima diligencia en la prestación de los servicios profesionales al nivel tecnológico actual, sin que puedan por otra parte, garantizar absolutamente el resultado, firmo al calce en la ciudad de Cuernavaca, Morelos,a {{ $fecha['dia'] }} del mes {{ $fecha['mes'] }} del año {{ $fecha['anio'] }}.        
        </div>
       

        {{-- CONTINUACIÓN DEL CONSENTIMIENTO --}}
        <h3>Continuación del Consentimiento</h3>
        <div class="section-content">
            <p>Con fines educativos o bien para contribuir al conocimiento científico, también acepto que se filme o se fotografíe el área anatómica tratada en el curso de este procedimiento, resguardando mi identidad.</p>
            <p>Estoy enterado que habré de requerir vigilancia y control postoperatorios hasta mi total recuperación, debiendo para ello seguir de forma precisa las indicaciones de mi médico tratante.</p>
            <p>Quedo en el entendido de que en todo momento habrá de mediar una comunicación expedita y una relación respetuosa con mi médico tratante a quien voluntariamente he acudido en busca de ayuda profesional. Autorizó al personal de salud para la atención de contingencias y urgencias derivadas del acto autorizado.</p>
            <p>La anulación o cancelación de estos consentimientos prestados, deberá constar necesariamente por escrito, firmado personalmente por mí y deberá ser personalmente recibida por los facultativos afectados antes de producirse el acto médico quirúrgico.</p>
            <p>De encontrarme en un momento dado incapacitado para consentir o modificar mi consentimiento, delego todas mis facultades en _________________________________________________________________________.</p>
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