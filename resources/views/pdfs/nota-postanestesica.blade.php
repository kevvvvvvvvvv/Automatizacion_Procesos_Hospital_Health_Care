<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota postoperatoria</title>
    <style>
        @page {
            size: A4;
            margin-top: 5.5cm;
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

        .one-line{
            display: inline-block;
            padding-right: 10px;
        }

        .contenedor-flex {
            display: flex;
            gap: 10px;
        }

        .cosa-inicio,
        .cosa-fin {
            flex: 1;
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

        .texto-preformateado {
            white-space: pre-wrap;
            word-wrap: break-word; 
        }


        .graph-section {
            margin-top: 20px;
            page-break-inside: avoid; 
        }

        .grid-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7pt; 
            table-layout: fixed; 
        }

        .grid-table th, .grid-table td {
            border: 1px solid #000;
            padding: 0;
            text-align: center;
            height: 12px; 
        }

        .col-label {
            width: 60px; 
            background-color: #f9f9f9;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        .section-header {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: left;
            padding-left: 5px !important;
        }


        .grid-cell {
        }
    </style>
</head>
<body>
    <main>
        <h1>Nota postanestésica</h1>
        <div class="graph-section">
            
            <table class="grid-table">
                <tr>
                    <td class="col-label">TA / FC</td>
                    @for($i = 0; $i < 48; $i++)
                        <td class="grid-cell"></td>
                    @endfor
                </tr>

                @for($val = 220; $val >= 0; $val -= 10)
                    <tr>
                        <td class="col-label">{{ $val }}</td>
                        @for($col = 0; $col < 48; $col++)
                            <td class="grid-cell"></td>
                        @endfor
                    </tr>
                @endfor
            </table>
        </div>
        
        <div class="graph-section">
            <table class="grid-table" style="table-layout: fixed; width: 100%;">
                
                <colgroup>
                    <col style="width: 75px;"> 
                    @for($i = 0; $i < 48; $i++)
                        <col style="width: auto;"> 
                    @endfor
                </colgroup>

                <tr>
                    <td class="section-header" colspan="49">
                        Agentes anestésicos, fármacos, soluciones
                    </td>
                </tr>

                <tr style="height: 18px;">
                    <td class="col-label" style="width: 75px; min-width: 75px; text-align: left; padding-left: 5px; font-size: 7pt;">
                        O2 (L/min)
                    </td>
                    @for($i = 0; $i < 48; $i++)
                        <td class="grid-cell"></td>
                    @endfor
                </tr>

                <tr style="height: 18px;">
                    <td class="col-label" style="width: 75px; min-width: 75px; text-align: left; padding-left: 5px; background-color: #fff; font-weight: bold; font-size: 7pt;">
                        Fármacos:
                    </td>
                    @for($i = 0; $i < 48; $i++) <td class="grid-cell"></td> @endfor
                </tr>
                
                @for($r = 0; $r < 12; $r++) 
                    <tr style="height: 18px;">
                        <td class="col-label" style="width: 75px; min-width: 75px; background-color: #fff; border-top: 1px dotted #ccc;">
                            &nbsp;
                        </td>
                        @for($i = 0; $i < 48; $i++) <td class="grid-cell"></td> @endfor
                    </tr>
                @endfor

                <tr style="height: 18px;">
                    <td class="col-label" style="width: 75px; min-width: 75px; text-align: left; padding-left: 5px; background-color: #fff; font-weight: bold; font-size: 7pt;">
                        Soluciones:
                    </td>
                    @for($i = 0; $i < 48; $i++) <td class="grid-cell"></td> @endfor
                </tr>
                
                @for($r = 0; $r < 8; $r++)
                    <tr style="height: 18px;">
                        <td class="col-label" style="width: 75px; min-width: 75px; background-color: #fff; border-top: 1px dotted #ccc;">
                            &nbsp;
                        </td>
                        @for($i = 0; $i < 48; $i++) <td class="grid-cell"></td> @endfor
                    </tr>
                @endfor
            </table>
        </div>
        <br>
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
        <p><strong>Pronóstico: </strong>{{$notaData['pronostico']}}</p>

        <p><strong>Técnica anestésica utilizada: </strong>{{$notaData['tecnica_anestesica']}}</p>
        <p><strong>Fármacos y medicamentos administrados: </strong>{{$notaData['farmacos_administrados']}}</p>
        <p><strong>Duración de la anestesia: </strong>{{$notaData['duracion_anestesia']}}</p>
        <p><strong>Contingencias, accidentes e incidentes atribuibles a la anestesia: </strong>{{$notaData['incidentes_anestesia']}}</p>
        <p><strong>Balance hídrico: </strong>{{$notaData['balance_hidrico']}}</p>
        <p><strong>Estado clínico del paciente a su egreso del quirófano</strong>{{$notaData['estado_clinico']}}</p>
        <p><strong>Plan de manejo y tratamiento inmediato, incluyendo protocolo de analgesia y control de signos y
            síntomas asociados a la anestesia: </strong> {{$notaData['plan_manejo']}}</p>

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