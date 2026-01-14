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

    </style>
</head>
<body>
    <h1>Hoja de enfermería de servicio hospitalario</h1>

    @php
        $catalogos = [
            'sexo' => [
                'masculino' => 'Masculino',
                'femenino' => 'Femenino',
                'indeterminado' => 'Indeterminado / Ambiguo'
            ],
            'condicion_llegada' => [
                'ambulatorio' => 'Ambulatorio (Caminando)',
                'silla_ruedas' => 'Silla de ruedas',
                'camilla' => 'Camilla',
                'muletas_baston' => 'Con muletas / Bastón / Andadera',
                'apoyo_familiar' => 'Con apoyo de terceros/familiar',
                'brazos' => 'En brazos (Pediátrico)'
            ],
            'postura' => [
                'libremente_escogida' => 'Libremente escogida',
                'instintiva' => 'Instintiva',
                'forzada' => 'Forzada',
                'pasiva' => 'Pasiva'
            ],
            'facies' => [
                'no_caracteristica' => 'No característica (Normal)',
                'algica' => 'Álgica',
                'palida' => 'Pálida',
                'cianotica' => 'Cianótica',
                'icterica' => 'Ictérica',
                'febril' => 'Febril / Rubicunda',
                'ansiosa' => 'Ansiosa / Angustiada',
                'depresiva' => 'Depresiva',
                'caquetica' => 'Caquéctica',
                'edematosa' => 'Edematosa / Renal',
                'paralisis_facial' => 'Parálisis facial / Asimétrica',
                'lupica' => 'Lúpica',
                'hipertiroidea' => 'Hipertiroidea',
                'acromegalica' => 'Acromegálica'
            ],
            'constitucion' => [
                'media' => 'Media (Eutrófico)',
                'delgada' => 'Delgada (Hipotrófico)',
                'caquetica' => 'Caquéctica',
                'robusta' => 'Robusta (Sobrepeso)',
                'obesa' => 'Obesa'
            ],
            'edad_aparente' => [
                'primera_decada' => 'Cursando su primera década', 
                'segunda_decada' => 'Cursando su segunda década',
                'tercera_decada' => 'Cursando su tercera década',
                'cuarta_decada' => 'Cursando su cuarta década',
                'quinta_decada' => 'Cursando su quinta década',
                'sexta_decada' => 'Cursando su sexta década',
                'septima_decada' => 'Cursando su séptima década',
                'octava_decada' => 'Cursando su octava década',
                'novena_decada' => 'Cursando su novena década',
                'decima_mas' => 'Cursando su décima década o más',
                'igual' => 'Igual a cronológica',
                'mayor' => 'Mayor a cronológica',
                'menor' => 'Menor a cronológica'
            ],
            'marcha' => [
                'normal' => 'Eubásica / Normal',
                'claudicante' => 'Claudicante',
                'ataxica' => 'Atáxica',
                'espastica' => 'Espástica',
                'parkinsoniana' => 'Parkinsoniana',
                'no_valorable' => 'No valorable'
            ],
            'movimientos' => [
                'ninguno' => 'Ninguno',
                'temblor' => 'Temblores',
                'tics' => 'Tics',
                'convulsiones' => 'Convulsiones',
                'fasciculaciones' => 'Fasciculaciones',
                'corea' => 'Corea',
                'distonia' => 'Distonía'
            ],
            'higiene' => [
                'adecuado' => 'Limpio y adecuado',
                'desalinado' => 'Desaliñado',
                'mala_higiene' => 'Mala higiene'
            ],
            'piel' => [
                'integra' => 'Íntegra / Hidratada',
                'deshidratada' => 'Deshidratada',
                'diaforetica' => 'Diaforética',
                'palida_fria' => 'Pálida y fría',
                'con_heridas' => 'Con heridas',
                'con_hematomas' => 'Con hematomas',
                'con_exantema' => 'Con exantema',
                'edematosa' => 'Edematosa',
                'marmorea' => 'Marmórea',
                'cianotica_distal' => 'Cianótica distal'
            ],
            'orientacion' => [
                'orientado_tres_esferas' => 'Orientado (x3)',
                'desorientado_tiempo' => 'Desorientado Tiempo',
                'desorientado_lugar' => 'Desorientado Lugar',
                'desorientado_persona' => 'Desorientado Persona',
                'desorientado_global' => 'Desorientación Global'
            ],
            'estado_conciencia' => [
                'alerta' => 'Alerta',
                'agitado' => 'Agitado',
                'letárgico' => 'Letárgico',
                'obnubilado' => 'Obnubilado',
                'estuporoso' => 'Estuporoso',
                'coma' => 'Coma'
            ],
            'lenguaje' => [
                'coherente' => 'Coherente',
                'incoherente' => 'Incoherente',
                'disartria' => 'Disartria',
                'afasia_motora' => 'Afasia motora',
                'afasia_sensitiva' => 'Afasia sensitiva',
                'mutismo' => 'Mutismo',
                'verborrea' => 'Verborrea'
            ],
            'olores_ruidos' => [
                'ninguno' => 'Ninguno',
                'halitosis' => 'Halitosis',
                'aliento_etillico' => 'Aliento etílico',
                'aliento_cetonico' => 'Aliento cetónico',
                'aliento_uremico' => 'Aliento urémico',
                'fetal' => 'Fetor hepático',
                'quejido' => 'Quejido',
                'estridor' => 'Estridor',
                'sibilancias_audibles' => 'Sibilancias'
            ]
        ];
    @endphp
    <h3>1. Habitus exterior</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Datos generales</th>
                <th>Aspecto físico</th>
                <th>Neurológico y motor</th>
                <th>Otros hallazgos</th>
            </tr>
        </thead>
        <tbody>
            @if (empty($notaData->hojaHabitusExterior) || (is_object($notaData->hojaHabitusExterior) && $notaData->hojaHabitusExterior->isEmpty()))
                <tr>
                    <td colspan="5" class="empty-cell">
                        No se han registrado evaluaciones de habitus exterior.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojaHabitusExterior as $habitus)   
                    @php
                        $h = is_array($habitus) ? (object)$habitus : $habitus;
                        $fecha = is_string($h->created_at) ? \Carbon\Carbon::parse($h->created_at) : $h->created_at;
                    @endphp
                    <tr>
                        <td>
                            {{ $fecha->format('d/m/Y') }}<br>
                            <small style="color: #666;">{{ $fecha->format('H:i') }} hrs</small>
                        </td>
                        <td>
                            <strong>Condición de llegada:</strong> {{ $catalogos['condicion_llegada'][$h->condicion_llegada] ?? $h->condicion_llegada }}<br>
                            <strong>Sexo:</strong> {{ $catalogos['sexo'][$h->sexo] ?? $h->sexo }}<br>
                            <strong>Edad aparente:</strong> {{ $catalogos['edad_aparente'][$h->edad_aparente] ?? $h->edad_aparente }}
                        </td>

                        <td>
                            <strong>Somatotipo:</strong> {{ $catalogos['constitucion'][$h->constitucion] ?? $h->constitucion }}<br>
                            <strong>Facies:</strong> {{ $catalogos['facies'][$h->facies] ?? $h->facies }}<br>
                            <strong>Características de la piel:</strong> {{ $catalogos['piel'][$h->piel] ?? $h->piel }}<br>
                            <strong>Vestido y aliño:</strong> {{ $catalogos['higiene'][$h->higiene] ?? $h->higiene }}
                        </td>

                        <td>
                            <strong>Conciencia:</strong> {{ $catalogos['estado_conciencia'][$h->estado_conciencia] ?? $h->estado_conciencia }}<br>
                            <strong>Orientación:</strong> {{ $catalogos['orientacion'][$h->orientacion] ?? $h->orientacion }}<br>
                            <strong>Actitud:</strong> {{ $catalogos['postura'][$h->postura] ?? $h->postura }}<br>
                            <strong>Marcha:</strong> {{ $catalogos['marcha'][$h->marcha] ?? $h->marcha }}
                        </td>
                        
                        <td>
                            <strong>Movimientos anormales:</strong> {{ $catalogos['movimientos'][$h->movimientos] ?? $h->movimientos }}<br>
                            <strong>Lenguaje:</strong> {{ $catalogos['lenguaje'][$h->lenguaje] ?? $h->lenguaje }}<br>
                            <strong>Olores y ruidos anormales:</strong> {{ $catalogos['olores_ruidos'][$h->olores_ruidos] ?? $h->olores_ruidos }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>


    <h3>2. Escalas y valoración del dolor (localización y escala): </h3>
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


    <h3>3. Ministración de medicamentos</h3>
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

    <h3>4. Procedimientos realizados</h3>

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

    <h4>Administración de oxígeno</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Flujo (L/min)</th>
                <th style="width: 15%;">Inicio</th>
                <th style="width: 15%;">Fin</th>
                <th style="width: 10%;">Total</th>
                <th style="width: 25%;">Personal que inició</th>
                <th style="width: 25%;">Personal que finalizó</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaOxigenos->isEmpty())
                <tr>
                    {{-- IMPORTANTE: Cambié el colspan a 6 porque ahora son 6 columnas --}}
                    <td colspan="6" class="empty-cell">No se ha registrado administración de oxígeno.</td>
                </tr>
            @else
                @foreach ($notaData->hojaOxigenos as $oxigeno)
                    <tr>   
                        {{-- 1. Flujo --}}
                        <td style="text-align: center;">{{ $oxigeno->litros_minuto }}</td>

                        {{-- 2. Hora Inicio --}}
                        <td style="font-size: 0.9em;">{{ $oxigeno->hora_inicio }}</td>

                        {{-- 3. Hora Fin --}}
                        @if (!$oxigeno->hora_fin)
                            <td class="empty-data" style="font-style: italic; color: #666; font-size: 0.9em;">
                                En curso
                            </td>
                        @else
                            <td style="font-size: 0.9em;">{{ $oxigeno->hora_fin }}</td>
                        @endif

                        {{-- 4. Total Consumido (Nuevo) --}}
                        <td style="text-align: center; font-weight: bold;">
                            {{ $oxigeno->total_consumido ?? 0 }} L
                        </td>

                        {{-- 5. Personal Inicio (Nuevo) --}}
                        {{-- Accedemos a las propiedades del objeto userInicio --}}
                        <td style="font-size: 0.85em;">
                            {{ $oxigeno->userInicio->nombre ?? '' }} {{ $oxigeno->userInicio->apellido_paterno ?? '' }}
                        </td>

                        {{-- 6. Personal Fin (Nuevo) --}}
                        <td style="font-size: 0.85em;">
                            @if ($oxigeno->userFin)
                                {{ $oxigeno->userFin->nombre }} {{ $oxigeno->userFin->apellido_paterno }}
                            @else
                                <span style="color: #aaa;">-</span>
                            @endif
                        </td>
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


    @php
        $ultimoRegistro = $notaData->hojaRiesgoCaida->last();
        
        $textoRiesgo = 'Sin registro';
        $estiloSemaforo = 'background-color: #eee; color: #333;'; 

        if ($ultimoRegistro) {
            $puntos = $ultimoRegistro->puntaje_total;

            if ($puntos == 0) {
                $textoRiesgo = 'Bajo riesgo';
                $estiloSemaforo = 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;'; // Verde
            } elseif ($puntos >= 1 && $puntos <= 2) {
                $textoRiesgo = 'Riesgo mediano';
                $estiloSemaforo = 'background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;'; // Amarillo/Naranja
            } else {
                $textoRiesgo = 'Alto riesgo';
                $estiloSemaforo = 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'; // Rojo
            }
        }
    @endphp

    
    <h3>
        5. Nivel de riesgo de caídas: 
        <span style="font-size: 0.8em; padding: 4px 8px; border-radius: 4px; font-weight: normal; {{ $estiloSemaforo }}">
            {{ $textoRiesgo }} 
            @if($ultimoRegistro) ({{ $ultimoRegistro->puntaje_total }} pts) @endif
        </span>
    </h3>
    
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
    
    
    <h3>6. Observaciones</h3>
    @empty($notaData->observaciones)
        <p>Sin nada que reportar.</p>
    @else
        <p>{!! nl2br(e($notaData->observaciones)) !!}</p>
    @endempty
    
    <h3>7. Gráficas de signos vitales</h3>
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
                    <td colspan="9" class="empty-cell">No se han registrado signos.</td>
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