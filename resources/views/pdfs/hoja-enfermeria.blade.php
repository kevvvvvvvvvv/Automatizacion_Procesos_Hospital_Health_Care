<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de enfermería de servicio hospitalario</title>
    <style>
        @page {
            size: A4;
            margin-top: 5.5cm;
            margin-bottom: 1.5cm;
            margin-left: 1cm;
            margin-right: 1cm;

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

        h4 {
            margin-top: 10px;
            margin-bottom: 8px;
            padding-bottom: 3px;
            font-size: 10pt;
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

        .empty-data {
            text-align: left;
            font-style: italic;
            color: #777;
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

    </style>
</head>
<body>
    <h1>Hoja de enfermería de servicio hospitalario</h1>

    <h3>Habitus exterior</h3>
    <table>
        <thead> 
            <th></th>
        </thead>
        <tbody>
            @if ($notaData->hojaHabitusExterior->isEmpty())
                <tr>
                    <td colspan="5" class="empty-cell">
                        No se han registrado escalas de valoración.
                    </td>
                </tr>                
            @else
                @foreach ($notaData->hojaHabitusExterior as $habitus)
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>


    <h3>Escalas y valoración del dolor (localización y escala)</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 20%">Fecha/Hora</th> 
                <th style="width: 11%" class="text-center">Escala Braden</th>
                <th style="width: 11%" class="text-center">Escala Glasgow</th>
                <th style="width: 11%" class="text-center">Escala Ramsay</th>
                <th style="width: 47%" class="text-center">Escala EVA</th>
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
                        <td class="text-center align-top"> 
                            @if($valoracion->valoracionDolor->isEmpty())
                                <span class="sin-dato">-</span>
                            @else
                                <div class="flex flex-col gap-2 p-1">
                                    @foreach($valoracion->valoracionDolor as $dolor)
                                        <div class="{{ !$loop->last ? 'border-b border-gray-200 pb-1' : '' }}">
                                            <span class="font-bold {{ $dolor->escala_eva >= 7 ? 'text-red-600' : ($dolor->escala_eva >= 4 ? 'text-yellow-600' : 'text-green-600') }}">
                                                ESCALA: {{ $dolor->escala_eva }},
                                                @if($dolor->ubicacion_dolor)
                                                    UBICACIÓN: {{ $dolor->ubicacion_dolor }}
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


    <h3>Ministración de medicamentos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Medicamento</th>
                <th style="width: 10%;">Dosis</th>
                <th style="width: 10%;">Gramaje</th>
                <th style="width: 15%;">Vía administración</th>
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

    <h3>Procedimientos realizados</h3>

    <h4>Dieta</h4>
    <table>
        <thead>
            <tr>
                <th style=" width: 33%">Dieta</th>
                <th style=" width: 33%">Fecha/hora solicitud</th>
                <th style=" width: 33%">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->solicitudesDieta->isEmpty())
                <tr>
                    <td colspan="3" class="empty-cell">No se han registrado dietas solicitadas.</td>
                </tr>
            @else
                @foreach ($notaData->solicitudesDieta as $dieta)
                    <tr>
                        <td>{{$dieta->dieta->categoriaDieta->categoria}}</td>
                        <td>{{$dieta->horario_solicitud}}</td>
                        <td>{{$dieta->observaciones}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h4>Terapia intravenosa</h4>
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

    

    <h4>Control de líquidos</h4>
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

    <h4>Estudios de laboratorio y gabinetes</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 50%">Fecha/hora solicitud</th>
                <th style="width: 50%">Estudio solicitado</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->solicitudesEstudio->isEmpty())
                <tr>
                    <td class="empty-cell" colspan="2">
                        No se han órdenes de estudios.
                    </td>
                </tr>
            @else
                @foreach ($notaData->solicitudesEstudio as $solicitud)
                    @foreach ($solicitud->solicitudItems as $item)
                        <tr>
                            <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                {{ $item->catalogoEstudio->nombre ?? $item->otro_estudio ?? 'Nombre no encontrado'}}
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>

    <h4>Sondas y catéteres</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 33%">Dispositivo</th>
                <th style="width: 33%">Fecha instalación</th>
                <th style="width: 33%">Fecha caducidad</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->sondasCateteres->isEmpty())
                <tr>
                    <td colspan="3" class="empty-cell">No se han registrado escalas de valoración.</td>
                </tr>
            @else
                @foreach ($notaData->sondasCateteres as $sondas)
                    <tr>   
                        <td>{{$sondas->productoServicio->nombre_prestacion}}</td>
                        @if (!$sondas->fecha_instalacion)
                            <td class="empty-data">Sin fecha registrada</td>
                        @else
                            <td>{{$sondas->fecha_instalacion}}</td>
                        @endif

                        @if (!$sondas->fecha_caducidad)
                            <td class="empty-data">Sin fecha registrada</td>
                        @else
                            <td>{{$sondas->fecha_caducidad}}</td>
                        @endif
                        
                        
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>

    @php
        $medicamentosMap = [
            'tranquilizantes' => 'Tranquilizantes / Sedantes',
            'diureticos' => 'Diuréticos',
            'hipotensores' => 'Hipotensores (no diuréticos)',
            'antiparkinsonianos' => 'Antiparkinsonianos',
            'antidepresivos' => 'Antidepresivos',
            'otros' => 'Otros medicamentos',
            'anestesia' => 'Anestesia' 
        ];

        $deficitsMap = [
            'visuales' => 'Alteraciones visuales',
            'auditivas' => 'Alteraciones auditivas',
            'extremidades' => 'Extremidades (parálisis/paresia)'
        ];

        $estadoMentalMap = [
            'orientado' => 'Orientado',
            'confuso' => 'Confuso',
        ];

        $deambulacionMap = [
            'normal' => 'Normal',
            'segura_ayuda' => 'Segura con ayuda',
            'insegura' => 'Insegura con/sin ayuda',
            'imposible' => 'Imposible'
        ];
    @endphp

    <h3>Nivel de riesgo de caídas</h3>
    <table>
        <thead>
            <tr> 
                <th>Fecha/hora registro</th>
                <th>Caídas previas</th>
                <th>Estado mental</th>
                <th>Deambulación</th>
                <th>Mayor a 70 años</th>
                <th>Medicamentos</th>
                <th>Déficits sensitivo-motores</th>
                <th>Puntaje total</th>
            </tr>
        </thead>
        <tbody>
        @if ($notaData->hojaRiesgoCaida->isEmpty())
            <tr>
                <td colspan="8" class="empty-cell">No se han registrado escalas de valoración.</td>
            </tr>
        @else  
            @foreach ($notaData->hojaRiesgoCaida as $riesgo)  
                <tr>
                    <td>{{ $riesgo->created_at }}</td>
                    <td>{{ $riesgo->caidas_previas ? 'Sí' : 'No' }}</td>
                    <td>{{ ucfirst($riesgo->estado_mental) }}</td>
                    <td>{{ $deambulacionMap[$riesgo->deambulacion] ?? $riesgo->deambulacion }}</td>
                    <td>{{ $riesgo->edad_mayor_70 ? 'Sí' : 'No' }}</td>
                    <td>
                        @if($riesgo->medicamentos)
                            @foreach ($riesgo->medicamentos as $medicamento)
                                <div>• {{ $medicamentosMap[$medicamento] ?? $medicamento }}</div>
                            @endforeach
                        @else
                            Sin datos
                        @endif
                    </td>
                    <td>
                        @if($riesgo->deficits)
                            @foreach ($riesgo->deficits as $deficit)
                                <div>• {{ $deficitsMap[$deficit] ?? $deficit }}</div>
                            @endforeach
                        @else  
                            Sin datos
                        @endif
                    </td>
                    <td>{{ $riesgo->puntaje_total }}</td>
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
        $labels = $notaData->hojaSignos->map(function ($item) {
            return \Carbon\Carbon::parse($item->fecha_hora_registro)->format('H:i');
        })->toArray();

        $ta_sistolica = $notaData->hojaSignos->pluck('tension_arterial_sistolica')->toArray();
        $ta_diastolica = $notaData->hojaSignos->pluck('tension_arterial_diastolica')->toArray();
        $fc = $notaData->hojaSignos->pluck('frecuencia_cardiaca')->toArray();
        $fr = $notaData->hojaSignos->pluck('frecuencia_respiratoria')->toArray();
        $temp = $notaData->hojaSignos->pluck('temperatura')->toArray();
        $saturacion = $notaData->hojaSignos->pluck('saturacion_oxigeno')->toArray();
        $glucemia = $notaData->hojaSignos->pluck('glucemia_capilar')->toArray();
        $talla = $notaData->hojaSignos->pluck('talla')->toArray();
        $peso = $notaData->hojaSignos->pluck('peso')->toArray();
        
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
                        'display' => count($datasets) > 1, 
                        'position' => 'bottom'
                    ],
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => ['beginAtZero' => false] 
                        ]]
                    ],
                    'plugins' => [
                        'datalabels' => [
                            'display' => true,
                            'align' => 'top',
                            'backgroundColor' => '#eee',
                            'borderRadius' => 3
                        ]
                    ]
                ]
            ];
            
            return 'https://quickchart.io/chart?c=' . urlencode(json_encode($config));
        }
    @endphp

    <div class="graficas-container">
    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Tensión arterial (mmHg)', $labels, [
            [
                'label' => 'Sistólica',
                'data' => $ta_sistolica,
                'borderColor' => 'red',
                'fill' => false,
                'spanGaps' => true
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
        <img class="grafica-img" src="{{ getChartUrl('Frecuencia cardíaca (latidos por minuto)', $labels, [
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
        <img class="grafica-img" src="{{ getChartUrl('Saturación de oxígeno (%)', $labels, [
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
        <img class="grafica-img" src="{{ getChartUrl('Glucemia capilar (mg/dL)', $labels, [
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
        <img class="grafica-img" src="{{ getChartUrl('Frecuencia respiratoria (rpm)', $labels, [
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
        <img class="grafica-img" src="{{ getChartUrl('Talla (centímetros)', $labels, [
            [
                'label' => 'Talla',
                'data' => $talla,
                'borderColor' => '#4C2C69', // Morado
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <div class="grafica-item">
        <img class="grafica-img" src="{{ getChartUrl('Peso (Kilogramos)', $labels, [
            [
                'label' => 'Peso',
                'data' => $peso,
                'borderColor' => '#8C2929', // Terracota
                'fill' => false,
                'spanGaps' => true
            ]
        ]) }}">
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha/Hora registro</th>
                <th>Tensión arterial</th>
                <th>Frecuencia cardíaca</th>
                <th>Frecuencia respiratoria</th>
                <th>Temperatura</th>
                <th>Saturación de oxígeno</th>
                <th>Glucemia capilar (mg/dL)</th>
                <th>Peso</th>
                <th>Talla</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaSignos->isEmpty())
                <tr>
                    <th colspan="9" class="empty-cell">No se han registrado signos.</th>
                </tr>
            @else
                @foreach ($notaData->hojaSignos as $signos)
                    <tr>
                        <td>{{$signos->created_at ?? ''}}</td>
                        @if ($signos->tension_arterial_sistolica && $signos->tension_arterial_diastolica)
                            <td>{{$signos->tension_arterial_sistolica}}/{{$signos->tension_arterial_diastolica}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{$signos->frecuencia_cardiaca}}</td>
                        <td>{{$signos->frecuencia_respiratoria}}</td>
                        <td>{{$signos->temperatura}}</td>
                        <td>{{$signos->saturacion_oxigeno}}</td>
                        <td>{{$signos->glucemia_capilar}}</td>
                        <td>{{$signos->peso}}</td>
                        <td>{{$signos->talla}}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>


    @if(isset($medico))
        @if(!$medico->colaborador_responsable)
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
        @else
            <div class="signature-section">
                <div class="signature-line"></div>
                <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
                <p>{{$medico->colaborador_responsable->nombre . " " . $medico->colaborador_responsable->apellido_paterno . " " . $medico->colaborador_responsable->apellido_materno}}</p>
                @if($medico->colaborador_responsable->credenciales->isNotEmpty())
                    <div class="credentials-list">
                        @foreach($medico->colaborador_responsable->credenciales as $credencial)
                            <p>
                                <strong>Título:</strong> {{ $credencial->titulo }} | <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>

        @endif
    @endif  
    
</body>
</html>