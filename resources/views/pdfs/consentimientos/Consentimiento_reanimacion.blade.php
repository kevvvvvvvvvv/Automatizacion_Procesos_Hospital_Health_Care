<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Médico Informado para reanimación cardiopulmonar, intubación y maniobras de resucitación</title>
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
       <h1>Carta de Consentimiento Bajo Información para Reanimación Cardiopulmonar (RCP)</h1>

        {{-- CUERPO DEL CONSENTIMIENTO BASADO EN EL PDF --}}
        <h3>Cuerpo del Consentimiento</h3>

            <p>
                Por medio de este documento que al final firmamos, manifestamos que mediante una explicación amplia y en lenguaje simple, el 
                médico explicó el procedimiento a realizar y aclaró nuestras dudas; de manera que para ambos queda perfectamente entendido, 
                tomando en cuenta el estado de salud actual del paciente <strong>{{ $paciente->nombre_completo ?? '____________________' }}</strong>, decidimos:
            </p>

            <p style="text-align: center; font-weight: bold; text-decoration: underline;">
                MANIOBRAS DE REANIMACIÓN CARDIOPULMONAR E INTUBACIÓN OROTRAQUEAL
            </p>

            <p>
                Como un hecho sobresaliente debe señalarse que la descripción del médico fue lo suficientemente clara para evidenciar los 
                beneficios que el acto médico le ofrece al paciente respecto a otras opciones de manejo. Igualmente se manifiesta que tomando 
                en cuenta a las características personales del paciente, el médico describió las posibles complicaciones que la literatura médica 
                reporta específicamente para el acto médico que se propone.
            </p>
            <p>
                Conjuntamente con el paciente y/o representante legal se decide el desarrollo de la intervención médica, aceptando 
                que se conocen como posibles riesgos los siguientes: <strong>No respuesta a maniobras, muerte, perforación pulmonar y perforación cardiaca.</strong>
            </p>
        </div>

        {{-- CONTINUACIÓN DEL CONSENTIMIENTO --}}
        <h3>Declaraciones y Autorización</h3>
      
            <p>
                En forma complementaria y cumpliendo con la normatividad correspondiente, el médico también explicó la importancia de la 
                autorización del procedimiento, de tal forma que el paciente se encuentra en libertad de aceptar y no aceptar el procedimiento a realizar.
            </p>
            <p>
                El médico también explicó que el paciente cuenta con absoluta libertad de revocar el presente consentimiento en el momento 
                que así lo considere pertinente. El paciente hace constar que con la información que le ha proporcionado el médico tratante, 
                es suficiente para que de forma razonable y propia tome la decisión sobre el consentimiento solicitado.
            </p>
            <p>
                Firmo al calce en la ciudad de Cuernavaca, Morelos, a <strong>{{ $fecha['dia'] }}</strong> del mes de <strong>{{ $fecha['mes'] }}</strong> del año <strong>{{ $fecha['anio'] }}</strong>.
            </p>
        </div>

        {{-- SECCIÓN DE DECISIÓN --}}
        <div style="margin: 20px 0; border: 1px solid #000; padding: 10px;">
            <p><strong>DECISIÓN DEL PACIENTE:</strong></p>
            <p>( ) <strong>SÍ</strong> Acepto procedimiento</p>
            <p>( ) <strong>NO</strong> Acepto procedimiento</p>
        </div>

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
            <p>{{ $paciente->nombre_completo ?? '' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
        </td>

        {{-- 2. Familiar responsable --}}
        <td>
            <div class="signature-line"></div>
            <p>{{ $estancia->familiarResponsable->nombre_completo ?? '' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del familiar responsable</p>
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

                <p></p>
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
                        <div class="signature-line"></div>
        <p style="font-size: 9pt; color: #555;"></p>
            @endif
        </td>

        {{-- 6. Vacío o espacio adicional --}}
        <td>
            {{-- Aquí puedes poner algo o dejarlo vacío --}}
        </td>

    </tr>

</table>

</div>


</div>


    </main>
</body>
</html>
