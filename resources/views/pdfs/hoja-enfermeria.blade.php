<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de enfermería</title>
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
        
        table {
            width: 100%;
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 9.5pt;
        }

        thead th {
            background-color: #f0f0f0;
            color: #222;
            border-bottom: 2px solid #444;
            text-align: left;
            padding: 8px;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
        }


        tbody td {
            padding: 8px 6px; 
            border-bottom: 1px solid #ddd; 
            vertical-align: top; 
            color: #444;
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

        .fecha-item {
            display: block;
            margin-bottom: 2px;
            font-size: 8.5pt;
        }


        .col-fecha { width: 15%; }
        .col-dato { width: 21%; } 
        
        .dato-valor {
            font-weight: bold;
            font-size: 10pt;
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
            font-size: 20px; 
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
            font-size: 9pt; 
        }
        table td p {
            margin: 0;
            padding: 0;
        }

        .graficas-container {
            display: table; 
            width: 100%;
            margin-top: 20px;
        }
        .grafica-item {
            display: inline-block;
            width: 48%; 
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

    </style>
</head>
<body>
    <h1>Hoja de enfermería</h1>
    <h3>Ministración de medicamentos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Medicamento</th>
                <th style="width: 10%;">Dosis</th>
                <th style="width: 10%;">Gramaje</th>
                <th style="width: 15%;">Vía Admin.</th>
                <th style="width: 10%;">Duración</th>
                <th style="width: 10%;">Unidad</th>
                <th style="width: 20%;">Fecha/Hora Aplicación</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaMedicamentos->isEmpty())
                <tr>
                    <td colspan="7" class="empty-cell">
                        No se han registrado medicamentos administrados.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojaMedicamentos as $medicamento)
                    <tr>
                        <td><strong>{{ $medicamento->productoServicio->nombre_prestacion }}</strong></td>
                        <td>{{ $medicamento->dosis }}</td>
                        <td>{{ $medicamento->gramaje }}</td>
                        <td>{{ $medicamento->via_administracion }}</td>
                        <td>{{ $medicamento->duracion_tratamiento }}</td>
                        <td>{{ $medicamento->unidad }}</td>
                        <td>
                            <span class="fecha-item">{{ $medicamento->fecha_hora_inicio }}</span>
                            @if (!$medicamento->aplicaciones->isEmpty())
                                @foreach ($medicamento->aplicaciones as $aplicacion)
                                    <span class="fecha-item" style="color: #666;">
                                        {{ $aplicacion->fecha_aplicacion }}
                                    </span>
                                @endforeach
                            @endif
                        </td> 
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <h3>Terapia intravenosa</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%">Solución</th>
                <th style="width: 25%">Cantidad (ml)</th>
                <th style="width: 25%">Duración</th>
                <th style="width: 25%">Flujo (ml/hora)</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojasTerapiaIV->isEmpty())
                <tr>
                    <td colspan="4" class="empty-cell">
                        No se han registrado terapias intravenosas.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojasTerapiaIV as $terapia)
                    <tr>
                        <td>{{$terapia->detalleSoluciones->nombre_prestacion}}</td>
                        <td>{{$terapia->cantidad}}</td>
                        <td>{{$terapia->duracion}}</td>
                        <td>{{$terapia->flujo_ml_hora}}</td>
                    </tr>
                @endforeach

            @endif

        </tbody>
    </table>

    <h3>Escalas de valoración</h3>
    <table>
        <thead>
            <tr>
                <th class="w-20">Fecha/Hora</th> 
                <th class="w-20 text-center">Escala Braden</th>
                <th class="w-20 text-center">Escala Glasgow</th>
                <th class="w-20 text-center">Escala Ramsay</th>
                <th class="w-20 text-center">Escala EVA</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaEscalaValoraciones->isEmpty())
                <tr>
                    <td colspan="5" class="empty-cell">
                        No se han registrado escalas de valoración.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojaEscalaValoraciones as $valoracion)
                    <tr>
                        <td>{{ $valoracion->fecha_hora_registro }}</td>

                        <td class="text-center">
                            @if($valoracion->escala_braden !== null)
                                <span class="score-valor">{{ $valoracion->escala_braden }}</span>
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($valoracion->escala_glasgow !== null)
                                <span class="score-valor">{{ $valoracion->escala_glasgow }}</span>
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($valoracion->escala_ramsey !== null)
                                <span class="score-valor">{{ $valoracion->escala_ramsey }}</span>
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($valoracion->escala_eva !== null)
                                <span class="score-valor">{{ $valoracion->escala_eva }}</span>
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Control de líquidos</h3>
    <table>
        <thead>
            <tr>
                <th class="col-fecha">Fecha/Hora registro</th>
                <th class="col-dato">Uresis</th>
                <th class="col-dato">Evacuaciones</th>
                <th class="col-dato">Emesis</th>
                <th class="col-dato">Drenes</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaControlLiquidos->isEmpty())
                <tr>
                    <td class="empty-cell" colspan="5"> 
                        No se han registrado controles de líquidos.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojaControlLiquidos as $liquidos)
                    <tr>
                        <td>{{ $liquidos->fecha_hora_registro }}</td>
                        <td>
                            @if($liquidos->uresis)
                                <span class="dato-valor">{{ $liquidos->uresis }} ml</span>
                                @if($liquidos->uresis_descripcion)
                                    <span class="dato-desc">{{ $liquidos->uresis_descripcion }}</span>
                                @endif
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>
                        <td>
                            @if($liquidos->evacuaciones)
                                <span class="dato-valor">{{ $liquidos->evacuaciones }} ml</span>
                                @if($liquidos->evacuaciones_descripcion)
                                    <span class="dato-desc">{{ $liquidos->evacuaciones_descripcion }}</span>
                                @endif
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>
                        <td>
                            @if($liquidos->emesis)
                                <span class="dato-valor">{{ $liquidos->emesis }} ml</span>
                                @if($liquidos->emesis_descripcion)
                                    <span class="dato-desc">{{ $liquidos->emesis_descripcion }}</span>
                                @endif
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>
                        <td>
                            @if($liquidos->drenes)
                                <span class="dato-valor">{{ $liquidos->drenes }} ml</span>
                                @if($liquidos->drenes_descripcion)
                                    <span class="dato-desc">{{ $liquidos->drenes_descripcion }}</span>
                                @endif
                            @else
                                <span class="sin-dato">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Observaciones</h3>
    @empty($notaData->observaciones)
        <p>Sin nada que reportar.</p>
    @else
        <p>{!! nl2br(e($notaData->observaciones)) !!}</p>
    @endempty
    
    <h3>Gráficas de signos vitales</h3>
    @php
        // 1. Extraemos las etiquetas (Hora)
        $labels = $notaData->hojaSignos->map(function ($item) {
            // Formato corto: solo hora y minuto
            return \Carbon\Carbon::parse($item->fecha_hora_registro)->format('H:i');
        })->toArray();

        // 2. Extraemos los datos numéricos (Manejando los nulls)
        $ta_sistolica = $notaData->hojaSignos->pluck('tension_arterial_sistolica')->toArray();
        $ta_diastolica = $notaData->hojaSignos->pluck('tension_arterial_diastolica')->toArray();
        $fc = $notaData->hojaSignos->pluck('frecuencia_cardiaca')->toArray();
        $fr = $notaData->hojaSignos->pluck('frecuencia_respiratoria')->toArray();
        $temp = $notaData->hojaSignos->pluck('temperatura')->toArray();
        $saturacion = $notaData->hojaSignos->pluck('saturacion_oxigeno')->toArray();
        $glucemia = $notaData->hojaSignos->pluck('glucemia_capilar')->toArray();
        
        // Función auxiliar para generar la URL del gráfico
        function getChartUrl($titulo, $labels, $datasets) {
            $config = [
                'type' => 'line',
                'data' => [
                    'labels' => $labels,
                    'datasets' => $datasets
                ],
                'options' => [
                    'title' => [
                        'display' => true,
                        'text' => $titulo,
                        'fontSize' => 14
                    ],
                    'legend' => [
                        'display' => count($datasets) > 1, // Solo mostrar leyenda si hay más de 1 linea (TA)
                        'position' => 'bottom'
                    ],
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => ['beginAtZero' => false] // Para que la gráfica no se aplane si los valores son altos
                        ]]
                    ],
                    'plugins' => [
                        'datalabels' => [ // Muestra el numerito en cada punto
                            'display' => true,
                            'align' => 'top',
                            'backgroundColor' => '#eee',
                            'borderRadius' => 3
                        ]
                    ]
                ]
            ];
            
            // Codificar a JSON y luego a URL
            return 'https://quickchart.io/chart?c=' . urlencode(json_encode($config));
        }
    @endphp

    @php
        // Mapa de valores según la lógica médica estándar (5 = Mejor, 1 = Peor)
        $valoresConciencia = [
            'Alerta' => 5,
            'Letárgico' => 4,
            'Obnubilado' => 3,
            'Estuporoso' => 2,
            'Coma' => 1,
        ];

        // Transformamos la colección: Si dice "Alerta" guarda un 5, si dice "Coma" guarda un 1
        $dataConciencia = $notaData->hojaSignos->map(function ($item) use ($valoresConciencia) {
            // El operador ?? null evita errores si el campo viene vacío o con un texto raro
            return $valoresConciencia[$item->estado_conciencia] ?? null; 
        })->toArray();
    @endphp

    <div class="graficas-container">
    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Tensión Arterial (mmHg)', $labels, [
            [
                'label' => 'Sistólica',
                'data' => $ta_sistolica,
                'borderColor' => 'red',
                'fill' => false,
                'spanGaps' => true // Importante: Si hay nulls, conecta los puntos existentes
            ],
            [
                'label' => 'Diastólica',
                'data' => $ta_diastolica,
                'borderColor' => 'blue',
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Frecuencia Cardíaca (lpm)', $labels, [
            [
                'label' => 'FC',
                'data' => $fc,
                'borderColor' => '#e74c3c', // Rojo
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Temperatura (°C)', $labels, [
            [
                'label' => 'Temp',
                'data' => $temp,
                'borderColor' => '#e67e22', // Naranja
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Saturación O2 (%)', $labels, [
            [
                'label' => 'SatO2',
                'data' => $saturacion,
                'borderColor' => '#3498db', // Azul
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Glucemia (mg/dL)', $labels, [
            [
                'label' => 'Glucosa',
                'data' => $glucemia,
                'borderColor' => '#9b59b6', // Morado
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Frecuencia Respiratoria (rpm)', $labels, [
            [
                'label' => 'FR',
                'data' => $fr,
                'borderColor' => '#2ecc71', // Verde
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Estado de Conciencia', $labels, [
            [
                'label' => 'Nivel (5=Alerta, 1=Coma)',
                'data' => $dataConciencia,
                'borderColor' => '#8e44ad', // Morado oscuro
                'backgroundColor' => 'rgba(142, 68, 173, 0.2)',
                'fill' => false,
                'steppedLine' => true, // IMPORTANTE: Hace que la línea se vea como escalones
                'spanGaps' => true
            ]
        ]) }}">
        
        {{-- Leyenda explicativa pequeña para el PDF --}}
        <div style="font-size: 8pt; color: #666; margin-top: 5px; text-align: center;">
            Escala: 5-Alerta | 4-Letárgico | 3-Obnubilado | 2-Estuporoso | 1-Coma
        </div>
    </div>

    @if(isset($medico))
        <div class="signature-section">
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
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
    
</body>
</html>