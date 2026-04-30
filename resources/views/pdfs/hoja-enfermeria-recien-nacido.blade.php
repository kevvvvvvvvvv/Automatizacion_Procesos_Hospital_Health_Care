<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de Enfermería Recién Nacido</title>
    <style>
        @page {
            size: A4;
            margin-top: 5.5cm;
            margin-bottom: 1.5cm;
            margin-left: 0.3cm;
            margin-right: 0.3cm;

            @bottom-right {
                content: "Página " counter(page) " de " counter(pages);
                font-family: Calibri, Arial, sans-serif;
                font-size: 8pt;
                color: #888;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, Arial, sans-serif; 
            margin: 0; 
            font-size: 7pt; 
            color: #333;
            line-height: 1.4;
        }

        h1 {
            text-align: center;
            font-size: 16pt;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 11pt;
            page-break-after: avoid;
        }

        h4 {
            margin-top: 10px;
            margin-bottom: 8px;
            padding-bottom: 3px;
            font-size: 7pt;
        }

        p {
            margin: 0 0 8px 0;
        }

        .negritas {
            font-weight: 900;
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
        
        table {
            width: 100%;
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 7pt;
        }

        thead th {
            background-color: #f0f0f0;
            color: #222;
            border-bottom: 2px solid #444;
            text-align: left;
            padding: 8px;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
        }


        tbody td {
            padding: 8px 6px; 
            border-bottom: 1px solid #ddd; 
            vertical-align: top; 
            color: #444;
            font-size: 7pt;
        }

        tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .empty-cell {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }

        .empty-data {
            text-align: left;
            font-style: italic;
            color: #777;
        }

        .fecha-item {
            display: block;
            margin-bottom: 2px;
            font-size: 7pt;
        }


        .col-fecha { width: 15%; }
        .col-dato { width: 21%; } 
        
        .dato-valor {
            font-weight: bold;
            font-size: 7pt;
            color: #000;
        }
        
        .dato-desc {
            display: block; 
            font-size: 8.5pt;
            color: #555;
            font-style: italic;
            margin-top: 2px;
        }

        .text-center { text-align: center; }
        .score-valor { font-weight: bold; color: #333; }
        .sin-dato {
            color: #ccc;
            font-size: 7pt; 
        }        
        .w-20{
            width: 20%;
        }

        tr {
            page-break-inside: avoid;
        }

        table td, 
        table th {
            padding: 2px 4px; 
            margin: 0;
            line-height: 1;
            /*font-size: 8pt;*/ 
        }
        
        table td p {
            margin: 0;
            padding: 0;
        }

        span {
            font-size: 7pt;
        }

        .graficas-container {
            display: table; 
            width: 100%;
            margin-top: 20px;
        }
        .grafica-item {
            display: inline-block;
            width: 33%; 
            margin-bottom: 5px;
            text-align: center;
            vertical-align: top;
        }
        .grafica-img {
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .text-gray-400{
            text: rgb(167, 167, 167);

        }

    </style>
</head>
<body>
    <h1>Hoja de enfermería de servicio de recien nacido</h1>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Nombre RN:</td><td>{{ $hoja->nombre_rn }}</td>
                <td class="label">Sexo:</td><td>{{ $hoja->sexo }}</td>
                <td class="label">Fecha Nac:</td><td>{{ \Carbon\Carbon::parse($hoja->fecha_rn)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Madre:</td><td>{{ $paciente->nombre_completo }}</td>
                <td class="label">Área:</td><td>{{ $hoja->area }}</td>
                <td class="label">Peso Nac:</td><td>{{ $hoja->peso }} kg</td>
            </tr>
        </table>
    </div>

    <h4>Signos Vitales</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>T.A. (mmHg)</th>
                <th>F.C. (ppm)</th>
                <th>F.R. (rpm)</th>
                <th>Temp (°C)</th>
                <th>S.O2 (%)</th>
                <th>G.C. (mg/dL)</th>
                <th>Peso (kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->hojaSignos as $s)
            <tr>
                <td>{{ \Carbon\Carbon::parse($s->fecha_hora_registro)->format('d/m H:i') }}</td>
                <td>{{ $s->tension_arterial_sistolica }}/{{ $s->tension_arterial_diastolica }}</td>
                <td>{{ $s->frecuencia_cardiaca }}</td>
                <td>{{ $s->frecuencia_respiratoria }}</td>
                <td>{{ $s->temperatura }}</td>
                <td>{{ $s->saturacion_oxigeno }}</td>
                <td>{{ $s->glucemia_capilar }}</td>
                <td>{{ $s->peso }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Somatometría y Valoración Neonatal</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>P. Cefálico</th>
                <th>P. Torácico</th>
                <th>P. Abdom.</th>
                <th>Pie</th>
                <th>Capurro</th>
                <th>APGAR</th>
                <th>Silverman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->somatometrias as $som)
            <tr>
                <td>{{ \Carbon\Carbon::parse($som->created_at)->format('d/m H:i') }}</td>
                <td>{{ $som->perimetro_cefalico }} cm</td>
                <td>{{ $som->perimetro_toracico }} cm</td>
                <td>{{ $som->perimetro_abdominal }} cm</td>
                <td>{{ $som->pie }} cm</td>
                <td>{{ $som->capurro }} sem</td>
                <td>{{ $som->apgar }}</td>
                <td>{{ $som->silverman }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Medicamentos</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th>Medicamento</th>
                <th>Dosis</th>
                <th>Vía</th>
                <th>Frecuencia</th>
                <th>Horarios de Aplicación (Fecha/Hora)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->hojamedicamentos as $med)
            <tr>
                <td>{{ $med->productoServicio->nombre_prestacion }}</td>
                <td>{{ $med->dosis }}</td>
                <td>{{ $med->via }}</td>
                <td>{{ $med->frecuencia }}</td>
                <td>
                    @foreach($med->aplicaciones as $app)
                        {{ \Carbon\Carbon::parse($app->fecha_hora_aplicacion)->format('d/m H:i') }}@if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Soluciones y Terapias IV</h4>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25%">Solución</th>
                <th style="width: 25%">Cantidad (ml)</th>
                <th style="width: 25%">Duración</th>
                <th style="width: 25%">Flujo (ml/hora)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->hojasTerapiaIV as $terapia)
            <tr>
                        <td>
                            {{$terapia->nombre_solucion}}
                            @if ($terapia->medicamentos && $terapia->medicamentos->isNotEmpty())
                                @foreach ($terapia->medicamentos as $medicamento)
                                    <div class='text-gray-400'>
                                        {{ $medicamento->nombre_medicamento }} | {{$medicamento->dosis }} {{ $medicamento->unidad_medida }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>{{$terapia->cantidad}}</td>
                        <td>{{$terapia->duracion}}</td>
                        <td>{{$terapia->flujo_ml_hora}}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Control de Líquidos (Ingresos y Egresos)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>Seno Mat.</th>
                <th>Fórmula</th>
                <th>Otros Ing.</th>
                <th>Micción</th>
                <th>Evac.</th>
                <th>Emesis</th>
                <th>Balance Parcial</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoja->ingresos_egresos as $liq)
            <tr>
                <td>{{ \Carbon\Carbon::parse($liq->created_at)->format('d/m H:i') }}</td>
                <td>{{ $liq->seno_materno ?: '-' }}</td>
                <td>{{ $liq->formula ? $liq->formula.' ml' : '-' }}</td>
                <td>{{ $liq->cantidad_ingresos ? $liq->otros_ingresos.': '.$liq->cantidad_ingresos.'ml' : '-' }}</td>
                <td>{{ $liq->miccion ?: '-' }}</td>
                <td>{{ $liq->evacuacion ?: '-' }}</td>
                <td>{{ $liq->emesis ? $liq->emesis.' ml' : '-' }}</td>
                <td class="{{ $liq->balance_total >= 0 ? 'text-green' : 'text-red' }}">
                    {{ $liq->balance_total }} ml
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($medico))
            @php
                $firmante = $medico->colaborador_responsable ?? $medico;
            @endphp

            <div class="signature-section">
                <div class="signature-line"></div>
                <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
                
                <p>
                    {{ $firmante->nombre_completo }} 
                </p>

                @if($firmante->credenciales->isNotEmpty())
                    <div class="credentials-list">
                        @foreach($firmante->credenciales as $credencial)
                            <p>
                                <strong>Título:</strong> {{ $credencial->titulo }} | 
                                <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
</body>
</html>