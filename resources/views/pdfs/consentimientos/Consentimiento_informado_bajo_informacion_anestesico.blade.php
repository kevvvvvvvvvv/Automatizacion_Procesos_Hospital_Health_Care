<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Declaración de Consentimiento Bajo Información por Anestesia</title>
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
        <h1>Declaración de Consentimiento Bajo Información por Anestesia</h1>


        {{-- CAMPOS ESPECÍFICOS --}}
        <h3>Campos Específicos</h3>
        <div class="section-content">
            <p>Familiar Responsable y/o Representante legal: {{ $paciente->familiar_responsable ?? 'Sin datos.' }}</p>
            <p>Diagnóstico Preoperatorio: {{ $paciente->diagnostico_preoperatorio ?? 'Sin datos.' }}</p>
            <p>Cirugía Programada: {{ $paciente->cirugia_programada ?? 'Sin datos.' }} Carácter de la Cirugía o Procedimiento: Electiva: {{ $paciente->caracter_cirugia == 'Electiva' ? 'X' : '' }} o Urgente: {{ $paciente->caracter_cirugia == 'Urgente' ? 'X' : '' }}</p>
        </div>

        {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>De acuerdo a la Norma Oficial Mexicana NOM-168-SSA1-1998 del expediente clínico médico, publicado el Lunes 14 de Diciembre de 1998, en su capítulo 10.1.1.2.3 y la Norma Oficial Mexicana NOM-170-SSA1-1998 de la práctica de la anestesiología, publicado en el diario oficial de la federación el 14 de Diciembre de 1998, expresado en los capítulos 4.12 y 16.1.1 es presentado este documento escrito y signado por el paciente y/o representante legal, así como por dos testigos, mediante el cual, acepta bajo la debida información los riesgos y los beneficios esperados del procedimiento anestésico. Esta carta se sujetará a las disposiciones sanitarias en vigor y no obliga al médico a realizar u omitir procedimientos cuando ello entrañe un riesgo injustificado para el paciente.</p>
            <p>Por consiguiente y en Calidad de Paciente DECLARO:</p>
            <p>1. Que cuento con la información suficiente sobre los riesgos y beneficios durante mi procedimiento anestésico, y que puede cambiar de acuerdo a mis condiciones físicas y lo emocionales, o lo inherente al procedimiento quirúrgico</p>
            <p>2. Que todo acto médico implica una serie de riesgos debido a mi estado físico actual, mis antecedentes, tratamientos previos y a la causa que da origen a la intervención quirúrgica, procedimientos de diagnóstico y tratamiento o una combinación de ambos factores.</p>
            <p>3. Que existe la posibilidad de complicaciones leves hasta severas, pudiendo causar secuelas permanentes e incluso complicaciones que lleven al fallecimiento.</p>
            <p>4. Que puedo requerir de tratamientos complementarios que aumenten mi estancia hospitalaria con la participación de otros servicios o unidades médicas.</p>
            <p>5. Que existe la posibilidad de que mi procedimiento anestésico se retrase e incluso se suspenda por causas propias a la dinámica del procedimiento anestésico o causas de fuerza mayor (Urgencias).</p>
            <p>6. Que se me ha informado que el personal médico de este servicio, cuenta con amplia experiencia, con equipo médico para mi cuidado y manejo durante el procedimiento y aun así no me exime de presentar complicaciones.</p>
            <p>7. Que soy responsable de comunicar mi decisión y lo antes informado a mi familia.</p>
            <p>En virtud de lo anterior, doy mi consentimiento por escrito para que los médicos anestesiólogos de Clínica Borda SA de CV l leven los procedimientos que consideren necesarios para realizar la anestesia o procedimientos médicos al que he decidido someterme, en el entendimiento que si ocurren complicaciones en la aplicación de la técnica anestésica, no existe conducta dolosa.</p>
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
