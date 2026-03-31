<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Médico Informado Quirúrgico</title>
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
        <h1>Consentimiento Médico Informado Quirúrgico</h1>

        {{-- CAMPOS ESPECÍFICOS --}}
        <h3>Datos de Identificación</h3>
        <div class="section-content">
            <p><strong>Paciente:</strong> {{ $paciente->nombre_completo ?? '' }}</p>
            <p><strong>Familiar Responsable y/o Representante legal:</strong> {{ $estancia->nombre_completo ?? '' }}</p>
            <p><strong>Diagnóstico:</strong> {{ $paciente->diagnostico_preoperatorio ?? '' }}</p>
            <p><strong>Procedimiento Quirúrgico:</strong> {{ $paciente->cirugia_programada ?? '' }}</p>
        </div>

        {{-- CUERPO DEL CONSENTIMIENTO BASADO EN EL PDF --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>
                Yo,  ________________________________________</strong>, 
                por medio del presente documento hago constar:
            </p>

            <p>
                Que el <strong>Dr. ________________________________________</strong>, 
                especialista en ________________________________________, 
                debidamente acreditado con cédula profesional <strong>______________________________</strong>, 
                me ha informado personalmente, a mi completa satisfacción y de forma enteramente comprensible, los motivos por los cuales ha indicado la realización del procedimiento quirúrgico consistente en: 
                <strong>________________________________________</strong>.
            </p>

            <p>
                He sido informado de los riesgos, las alternativas, las posibles complicaciones y las consecuencias inherentes a la operación. Atendiendo a la prescripción médica y en uso de mi libre voluntad, autorizo a que se me realice dicha intervención por el médico antes mencionado y su equipo quirúrgico.
            </p>

            <p>
                De igual manera, consiento que se me interne en <strong>HOSPITALIDAD HEALTH CARE</strong>. Si durante la intervención se considerase necesario aplicar procedimientos adicionales, incluyendo el uso de sangre y sus derivados por contingencias no previstas, autorizo expresamente que se realice por el bien de mi salud.
            </p>

            <p>
                Firmo el presente en la ciudad de Cuernavaca, Morelos, a <strong>{{ $fecha['dia'] }}</strong> del mes de <strong>{{ $fecha['mes'] }}</strong> del año <strong>{{ $fecha['anio'] }}</strong>.
            </p>
        </div>

        {{-- TABLA DE FIRMAS --}}
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
                        <p style="font-size: 9pt; color: #555;">Nombre y firma del médico</p>

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
                        <p style="font-size: 9pt; color: #555;">Nombre y firma del medico</p>
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
