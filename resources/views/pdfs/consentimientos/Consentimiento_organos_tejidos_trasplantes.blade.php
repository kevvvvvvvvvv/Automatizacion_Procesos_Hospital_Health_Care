<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Informado Donación de órganos, tejidos y trasplantes</title>
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
        <h1>Consentimiento informado Donación de órganos, tejidos y trasplantes</h1> 

        {{-- Sección del cuerpo del consentimiento--}}
       {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>Yo {{ $paciente->nombre ?? 'Sin datos.' }}, de {{ $paciente->edad ?? 'Sin datos.' }} años de edad, de sexo {{ $paciente->sexo ?? 'Sin datos.' }}, con fecha de nacimiento {{ $paciente->fecha_nacimiento ?? 'Sin datos.' }} con diagnóstico {{ $paciente->diagnostico ?? 'Sin datos.' }}, por medio de presente documento ACEPTO VOLUNTARIAMENTE Y AUTORIZÓ AL DR. o DRA. {{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }}, que se encuentra debidamente acreditado y presta sus servicios en Hospitalidad Health Care, en la ciudad de Cuernavaca, Morelos; quien me ha informado personalmente, a mi completa satisfacción y de forma enteramente comprensible para mi, incluso con apoyo gráfico e incluso se me ha permitido realizar preguntas y se me han aclarado mis dudas, por lo que manifiesto sentirme satisfecha(o) con la información recibida referente a la Transfusión Sanguínea Hospitalaria.</p>
            <p>Este procedimiento consiste en suministrar por vía endovenosa sangre o cualquiera de sus componentes como glóbulos rojos, plaquetas, plasma fresco congelado y/o crioprecipitados a una persona. De esta forma, a través de la transfusión se busca reponer algún componente de la sangre que el organismo no produce como consecuencia de algún tratamiento o enfermedad o bien porque se está perdiendo, como en el caso de las hemorragias, por lo que se requiere evaluar la condición clínica en que me encuentro.</p>
            <p>Se me explico que los componentes sanguíneos que voy a recibir provienen de donantes, que han sido sometidos a un riguroso proceso de selección. Que la sangre obtenida por el banco de sangre se le realiza una serie de estudios como lo exige la normatividad vigente para evitar la transmisión de enfermedades por vía sanguínea como la Hepatitis B y C, Sífilis, Brucelosis, Chagas y el VIH. Que previo a la transfusión se realizan las pruebas necesarias para que el hemocomponentes elegido para mi tratamiento sea compatible con mi grupo sanguíneo.</p>
            <p>Se me ha informado sobre los beneficios, riesgos, posibles complicaciones, así como las consecuencias inherentes al procedimiento Como puede ser reacciones de tipo alérgico, fiebre, enrojecimiento de la piel, destrucción em los glóbulos rojos hasta la transmisión de enfermedades entre otros, las que son poco frecuentes casi siempre son leves sin representar en su gran mayoría un riesgo vital para la o el paciente Si se presentara algún evento adverso se me informa que se cuenta con personal necesario para atenderlo. De modo que autorizo al personal de Hospitalidad Health Care, para que se me apliquen los procedimientos o medidas terapéuticas adicionales, en caso de ocurrir una contingencia durante mi estancia dentro del hospital, estoy enterado que abre de requerir vigilancia y control médico hasta mi total recuperación. Este consentimiento informado puede ser revocado en cualquier momento antes de iniciar el proceso de Transfusión Sanguínea.</p>
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